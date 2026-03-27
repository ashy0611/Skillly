<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\Resume\ResumeParserService;
use App\Services\Resume\SkillExtractionService;
use App\Services\Career\CareerRecommendationService;
use App\Services\Bot\ChatbotService;

class ResumeController extends Controller
{
    protected ResumeParserService $parser;
    protected SkillExtractionService $skillExtractor;
    protected CareerRecommendationService $careerService;
    protected ChatbotService $chatbot;

    public function __construct(
        ResumeParserService $parser,
        SkillExtractionService $skillExtractor,
        CareerRecommendationService $careerService,
        ChatbotService $chatbot
    ) {
        $this->parser = $parser;
        $this->skillExtractor = $skillExtractor;
        $this->careerService = $careerService;
        $this->chatbot = $chatbot;
    }

    /**
     * Display resume upload page
     */
    public function index()
    {
        return view('resume.upload');
    }

    /**
     * Process resume upload and generate chatbot response
     */
    public function upload(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx|max:5120'
        ]);

        $file = $request->file('resume');
        $path = $file->store('resumes');
        $fullPath = storage_path('app/' . $path);
        $extension = $file->getClientOriginalExtension();

        try {
            $text = $this->parser->extractText($fullPath, $extension);
        } catch (\Throwable $e) {
            return back()
                ->withErrors('We could not read your resume. Please upload a valid PDF, DOC, or DOCX file.')
                ->withInput();
        }

        if (strlen(trim($text)) < 50) {
            return back()
                ->withErrors('We could not extract enough text from your resume. Please ensure it is not image-only.')
                ->withInput();
        }

        try {
            $skills = $this->skillExtractor->extractSkills($text);
            $recommendations = $this->careerService->recommend($skills);
            $topRecommendation = $recommendations[0] ?? null;

            if (!$topRecommendation) {
                return back()
                    ->withErrors('We could not match your resume to any career profile. Try adding more skills or experience.')
                    ->withInput();
            }

            $career        = $topRecommendation['career'] ?? null;
            $matchedSkills = $topRecommendation['matched_skills'] ?? [];
            $missingSkills = $topRecommendation['missing_skills'] ?? [];

            $conversation = $this->chatbot->generateConversation($career, $matchedSkills, $missingSkills);

            session()->put([
                'career'        => $career,
                'matchedSkills' => $matchedSkills,
                'missingSkills' => $missingSkills,
                'conversation'  => $conversation,
                'allRecommendations' => $recommendations,
            ]);
        } catch (\Throwable $e) {
            report($e);
            return back()
                ->withErrors('Something went wrong while analyzing your resume. Please try again.')
                ->withInput();
        }

        return view('resume.chat', compact('conversation'));
    }

    /**
     * Generate and download PDF report
     */
    public function downloadReport()
    {
        $career        = session('career');
        $matchedSkills = session('matchedSkills', []);
        $missingSkills = session('missingSkills', []);
        $conversation  = session('conversation', []);

        if (!$conversation) {
            return redirect()->route('resume.index')
                ->withErrors('Session expired. Please upload your resume again.');
        }

        try {
            $pdf = Pdf::loadView('resume.report', compact(
                'career', 'matchedSkills', 'missingSkills', 'conversation'
            ));
            return $pdf->download('career_guidance_report.pdf');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('resume.index')
                ->withErrors('We could not generate your report. Please try again.');
        }
    }

    /**
     * Save the full chat transcript from the browser into the session
     * so the PDF report includes every user + bot message.
     */
    public function saveChat(Request $request)
    {
        $data = $request->validate([
            'messages'          => 'required|array|min:1|max:200',
            'messages.*.type'   => 'required|in:bot,user',
            'messages.*.message'=> 'required|string|max:2000',
        ]);

        // Merge with any existing session conversation, deduplicating
        // by keeping the richer full transcript from the browser.
        session()->put('conversation', $data['messages']);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Handle interactive chat messages from the user
     */
    public function chatMessage(Request $request)
    {
        $data = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $career              = session('career');
        $matchedSkills       = session('matchedSkills', []);
        $missingSkills       = session('missingSkills', []);
        $allRecommendations  = session('allRecommendations', []);

        if (!$career) {
            return response()->json([
                'reply' => "⚠️ I don't have your resume analysis in memory. Please go back and upload your resume again.",
            ]);
        }

        $careerName  = is_string($career) ? $career : ($career->career_name ?? 'this career path');
        $userMessage = strtolower(trim($data['message']));
        $reply       = $this->resolveIntent($userMessage, $careerName, $matchedSkills, $missingSkills, $allRecommendations);

        return response()->json(['reply' => $reply]);
    }

    // ─────────────────────────────────────────────────────────────
    // Intent Detection Engine
    // ─────────────────────────────────────────────────────────────

    private function resolveIntent(
        string $msg,
        string $careerName,
        array $matchedSkills,
        array $missingSkills,
        array $allRecommendations
    ): string {

        // ── Greetings ──────────────────────────────────────────
        if ($this->matches($msg, ['hi', 'hello', 'hey', 'good morning', 'good afternoon', 'howdy'])) {
            return "👋 Hey! I'm your career assistant. I've already analyzed your resume and matched you to <strong>{$careerName}</strong>. What would you like to know?";
        }

        // ── Thank you ──────────────────────────────────────────
        if ($this->matches($msg, ['thank', 'thanks', 'appreciate', 'helpful'])) {
            return "😊 You're very welcome! Feel free to ask anything else — I'm here to help you land that role.";
        }

        // ── Skill gaps / missing skills ────────────────────────
        if ($this->matches($msg, ['gap', 'missing', 'lack', 'don\'t have', 'need to learn', 'what skills', 'which skills', 'skills needed'])) {
            if (!empty($missingSkills)) {
                $top  = array_slice($missingSkills, 0, 5);
                $list = $this->bulletList($top);
                $more = count($missingSkills) > 5 ? "\n\n…and " . (count($missingSkills) - 5) . " more." : '';
                return "📋 Here are the key skills you're currently missing for <strong>{$careerName}</strong>:\n{$list}{$more}\n\nFocusing on the top 2–3 will give you the biggest boost.";
            }
            return "🌟 You don't seem to have any major skill gaps for <strong>{$careerName}</strong>. Focus on deepening your expertise and shipping real projects!";
        }

        // ── Strengths / matched skills ─────────────────────────
        if ($this->matches($msg, ['strength', 'strong', 'good at', 'have', 'matched', 'already know', 'current skills', 'my skills'])) {
            if (!empty($matchedSkills)) {
                $list = $this->bulletList($matchedSkills);
                return "💪 Based on your resume, here are the skills that align with <strong>{$careerName}</strong>:\n{$list}\n\nThese are your strongest selling points — make sure they're prominent on your resume!";
            }
            return "🤔 I didn't detect many skills that map directly to <strong>{$careerName}</strong>. Consider updating your resume with more specific technical terms.";
        }

        // ── Career match / job / role ──────────────────────────
        if ($this->matches($msg, ['career', 'role', 'job', 'path', 'position', 'title', 'best fit', 'suited', 'recommend'])) {
            $score = $this->readinessScore($matchedSkills, $missingSkills);
            return "🎯 Based on your resume, <strong>{$careerName}</strong> is your best career match right now with an estimated readiness of <strong>{$score}%</strong>.\n\nThis is based on how well your extracted skills align with what employers typically require for that role.";
        }

        // ── Other recommended careers ──────────────────────────
        if ($this->matches($msg, ['other', 'alternative', 'options', 'else', 'different career', 'more careers', 'second'])) {
            if (count($allRecommendations) > 1) {
                $others = array_slice($allRecommendations, 1, 3);
                $lines  = array_map(fn($r) => "• {$r['career']} ({$r['percentage']}% match)", $others);
                return "🔍 Here are some other careers that also matched your profile:\n" . implode("\n", $lines) . "\n\nWant more details on any of these?";
            }
            return "🔍 Based on your current skills, <strong>{$careerName}</strong> was the only strong match. Building more skills will open up more paths!";
        }

        // ── Readiness / score / percentage ────────────────────
        if ($this->matches($msg, ['score', 'percent', 'ready', 'readiness', 'how ready', 'how close', 'how prepared'])) {
            $score = $this->readinessScore($matchedSkills, $missingSkills);
            $comment = $this->readinessComment($score);
            return "📊 Your current readiness for <strong>{$careerName}</strong> is approximately <strong>{$score}%</strong>.\n\n{$comment}";
        }

        // ── How to improve / roadmap / learning ───────────────
        if ($this->matches($msg, ['improve', 'learn', 'course', 'roadmap', 'start', 'next step', 'how to', 'study', 'practice', 'prepare', 'get ready'])) {
            if (!empty($missingSkills)) {
                $first  = ucwords($missingSkills[0]);
                $second = isset($missingSkills[1]) ? ' then move to <strong>' . ucwords($missingSkills[1]) . '</strong>' : '';
                return "🗺️ Here's a simple roadmap to improve for <strong>{$careerName}</strong>:\n\n1. Start with <strong>{$first}</strong> — build a small project or follow a hands-on tutorial.\n2. Document your work on GitHub or a portfolio{$second}.\n3. Revisit your resume to include new skills once you've practiced them.\n\nConsistency matters more than speed — even 30 minutes a day adds up fast!";
            }
            return "🚀 You're already in great shape for <strong>{$careerName}</strong>! The best next step is to build real-world projects, contribute to open source, and strengthen your portfolio.";
        }

        // ── Salary / pay ───────────────────────────────────────
        if ($this->matches($msg, ['salary', 'pay', 'earn', 'income', 'wage', 'compensation'])) {
            return "💰 Salaries for <strong>{$careerName}</strong> vary by location, experience, and company size. I'd recommend checking sites like Glassdoor, LinkedIn Salary, or levels.fyi for up-to-date figures in your area.";
        }

        // ── Resume tips ────────────────────────────────────────
        if ($this->matches($msg, ['resume', 'cv', 'update resume', 'fix resume', 'improve resume'])) {
            return "📝 A few tips to make your resume stronger for <strong>{$careerName}</strong>:\n\n• Use specific technical keywords (tools, languages, frameworks).\n• Quantify achievements where possible (e.g. \"reduced load time by 30%\").\n• List missing skills you're currently learning — it shows initiative.\n• Keep it to 1–2 pages and tailor it per application.";
        }

        // ── Interview prep ─────────────────────────────────────
        if ($this->matches($msg, ['interview', 'prepare', 'questions', 'tips for interview'])) {
            return "🎙️ For interviews in <strong>{$careerName}</strong>, expect questions around:\n\n• Your strongest skills (be ready with examples)\n• How you've handled challenges or gaps in your experience\n• Technical knowledge specific to the role\n• Problem-solving and communication skills\n\nPractice using the STAR method (Situation, Task, Action, Result) for behavioural questions.";
        }

        // ── Download / report ──────────────────────────────────
        if ($this->matches($msg, ['download', 'report', 'pdf', 'save', 'export'])) {
            return "📄 You can download your full career guidance report using the <strong>Download Report</strong> button below. It includes your skill matches, gaps, and career recommendation in a shareable PDF.";
        }

        // ── Fallback ───────────────────────────────────────────
        return "🤖 I matched you to <strong>{$careerName}</strong> based on your resume. Here are some things you can ask me:\n\n• <em>\"What skills am I missing?\"</em>\n• <em>\"What are my strengths?\"</em>\n• <em>\"How do I improve?\"</em>\n• <em>\"Are there other careers for me?\"</em>\n• <em>\"How ready am I?\"</em>";
    }

    // ─────────────────────────────────────────────────────────────
    // Utility Helpers
    // ─────────────────────────────────────────────────────────────

    /**
     * Check if message contains any of the given keywords.
     */
    private function matches(string $msg, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (str_contains($msg, $keyword)) return true;
        }
        return false;
    }

    /**
     * Format an array as a bullet list string.
     */
    private function bulletList(array $items): string
    {
        return implode("\n", array_map(fn($i) => '• ' . ucwords($i), $items));
    }

    /**
     * Calculate readiness score as a percentage.
     */
    private function readinessScore(array $matched, array $missing): int
    {
        $total = count($matched) + count($missing);
        if ($total === 0) return 0;
        return (int) round((count($matched) / $total) * 100);
    }

    /**
     * Human-friendly comment based on readiness score.
     */
    private function readinessComment(int $score): string
    {
        return match (true) {
            $score >= 80 => "🚀 You're in great shape — just a few finishing touches needed!",
            $score >= 60 => "👍 Solid progress! Bridging a couple of gaps will make a real difference.",
            $score >= 40 => "📈 You have a foundation to build on. Focus on the top missing skills first.",
            default      => "💪 There's room to grow — but everyone starts somewhere. Keep building!",
        };
    }
}