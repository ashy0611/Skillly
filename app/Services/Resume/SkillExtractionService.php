<?php

namespace App\Services\Resume;

use App\Models\Skill;

class SkillExtractionService
{
    public function extractSkills(string $text): array
    {
        // 1️⃣ Normalize resume text
        $text = strtolower($text);
        $text = html_entity_decode($text);
        $text = str_replace(['-', '/'], ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        $matchedSkills = [];
        $skills = Skill::all();

        $keywordMap = [];

        // 2️⃣ Build keyword map
        foreach ($skills as $skill) {
            $keywords = explode(',', strtolower($skill->keywords));

            foreach ($keywords as $keyword) {
                $keyword = trim($keyword);
                if (empty($keyword)) continue;

                $keywordMap[] = [
                    'keyword' => $keyword,
                    'name' => $skill->skill_name,
                    'type' => $skill->skill_type
                ];
            }
        }

        // 3️⃣ Sort keywords by length (longest first)
        usort($keywordMap, function ($a, $b) {
            return strlen($b['keyword']) <=> strlen($a['keyword']);
        });

        // 4️⃣ Perform matching
        foreach ($keywordMap as $item) {

            $keyword = $item['keyword'];
            $escaped = preg_quote($keyword, '/');

            /*
             |--------------------------------------------------------------------------
             | CASE 1: Single letter skills (like C, R)
             |--------------------------------------------------------------------------
             | Must match EXACT standalone word only.
             | Must NOT match inside other words or inside C++
             */
            if (strlen($keyword) === 1) {
                $pattern = '/(?<!\w)' . $escaped . '(?![\w\+])/i';
            }

            /*
             |--------------------------------------------------------------------------
             | CASE 2: Skills with special characters (C++, Node.js)
             |--------------------------------------------------------------------------
             */
            elseif (preg_match('/[^\w\s]/', $keyword)) {
                $pattern = '/' . $escaped . '/i';
            }

            /*
             |--------------------------------------------------------------------------
             | CASE 3: Normal multi-word or single-word skills
             |--------------------------------------------------------------------------
             */
            else {
                $pattern = '/\b' . $escaped . '\b/i';
            }

            if (preg_match($pattern, $text)) {
                $matchedSkills[] = [
                    'name' => $item['name'],
                    'type' => $item['type']
                ];
            }
        }

        // 5️⃣ Remove duplicates
        return array_values(array_unique($matchedSkills, SORT_REGULAR));
    }
}
