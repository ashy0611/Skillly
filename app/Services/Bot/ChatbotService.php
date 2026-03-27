<?php

namespace App\Services\Bot;

class ChatbotService
{
    /**
     * Generate an initial structured bot conversation after resume analysis.
     */
    public function generateConversation($career, array $matchedSkills, array $missingSkills): array
    {
        $messages = [];
        $careerName = $this->resolveCareerName($career);

        // Greeting
        $messages[] = $this->bot("👋 Hi there! I've finished analyzing your resume. Here's what I found:");

        // Career match
        if ($careerName) {
            $messages[] = $this->bot("🎯 Based on your skills and experience, you're a strong match for: <strong>{$careerName}</strong>.");
        } else {
            $messages[] = $this->bot("🤔 I wasn't able to pinpoint a single career path — your profile may span multiple fields. Let's dig deeper.");
        }

        // Strengths
        if (!empty($matchedSkills)) {
            $count = count($matchedSkills);
            $skillList = $this->formatList($matchedSkills);
            $messages[] = $this->bot("✅ You have <strong>{$count} matching skill(s)</strong> for this path: {$skillList}. These are your biggest strengths right now.");
        } else {
            $messages[] = $this->bot("⚠️ I didn't detect strong skill matches for this career path. You may want to update your resume with more specific technical terms.");
        }

        // Skill gaps
        if (!empty($missingSkills)) {
            $top = array_slice($missingSkills, 0, 3);
            $gapList = $this->formatList($top);
            $remaining = count($missingSkills) - count($top);
            $suffix = $remaining > 0 ? " (and {$remaining} more)" : '';
            $messages[] = $this->bot("📚 To strengthen your profile for <strong>{$careerName}</strong>, consider learning: {$gapList}{$suffix}.");
        } else {
            $messages[] = $this->bot("🌟 Great news — you don't seem to have any major skill gaps for this career path. Focus on deepening your expertise and building real-world projects.");
        }

        // Readiness score
        $score = $this->calculateReadiness($matchedSkills, $missingSkills);
        $messages[] = $this->bot("📊 Your estimated career readiness score is: <strong>{$score}%</strong>. " . $this->readinessComment($score));

        // CTA
        $messages[] = $this->bot("💬 Feel free to ask me anything! For example: <em>\"What skills am I missing?\"</em>, <em>\"How do I improve?\"</em>, or <em>\"What jobs suit me?\"</em>. I'm here to help.");

        return $messages;
    }

    // ─────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────

    private function bot(string $message): array
    {
        return ['type' => 'bot', 'message' => $message];
    }

    private function resolveCareerName($career): ?string
    {
        if (is_string($career)) return $career;
        return $career->career_name ?? null;
    }

    private function formatList(array $items): string
    {
        $items = array_map('ucwords', $items);
        if (count($items) === 1) return $items[0];
        $last = array_pop($items);
        return implode(', ', $items) . ' and ' . $last;
    }

    private function calculateReadiness(array $matched, array $missing): int
    {
        $total = count($matched) + count($missing);
        if ($total === 0) return 0;
        return (int) round((count($matched) / $total) * 100);
    }

    private function readinessComment(int $score): string
    {
        return match (true) {
            $score >= 80 => "You're in great shape — just a few finishing touches needed! 🚀",
            $score >= 60 => "You're on a solid path. Bridging a few gaps will make a real difference.",
            $score >= 40 => "You have a foundation to build on. Focus on the top missing skills first.",
            default      => "There's room to grow, but everyone starts somewhere. Let's build from here! 💪",
        };
    }
}