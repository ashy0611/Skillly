<?php

namespace App\Services\Career;

use App\Models\CareerDomain;

class CareerRecommendationService
{
    /**
     * Recommend careers based on extracted skills from a resume.
     *
     * @param array $extractedSkills Array of extracted skills ['name' => 'Skill Name']
     * @return array Recommended careers with match percentage and missing skills
     */
public function recommend(array $extractedSkills): array
{
    $recommendations = [];

    // Normalize extracted skills
    $extractedSkillNames = collect($extractedSkills)
        ->pluck('name')
        ->map(fn($n) => strtolower(trim($n)))
        ->toArray();

    $careers = CareerDomain::with('rules.skill')->get();

    $mandatoryThreshold = 0.6;
    $mandatoryWeight = 3;
    $optionalWeight  = 1;

    foreach ($careers as $career) {

        $rules = $career->rules;

        $totalScore = 0;
        $matchedScore = 0;

        $matchedSkills = [];
        $missingSkills = [];

        foreach ($rules as $rule) {

            $skillName = strtolower(trim($rule->skill->skill_name ?? ''));
            $weight = $rule->is_mandatory ? $mandatoryWeight : $optionalWeight;

            $totalScore += $weight;

            if (in_array($skillName, $extractedSkillNames)) {
                $matchedScore += $weight;
                $matchedSkills[] = $skillName;   // ✅ Track matched skills
            } else {
                $missingSkills[] = $skillName;
            }
        }

        $matchPercentage = $totalScore > 0
            ? ($matchedScore / $totalScore) * 100
            : 0;

        // Mandatory threshold check
        $mandatorySkills = $rules
            ->filter(fn($r) => $r->is_mandatory)
            ->pluck('skill.skill_name')
            ->map(fn($s) => strtolower(trim($s)))
            ->toArray();

        $matchedMandatory = count(array_intersect($mandatorySkills, $extractedSkillNames));

        if (count($mandatorySkills) === 0 ||
            ($matchedMandatory / count($mandatorySkills)) >= $mandatoryThreshold) {

            $recommendations[] = [
                'career' => $career->career_name,
                'percentage' => round($matchPercentage, 2),
                'matched_skills' => $matchedSkills,      // ✅ ADD THIS
                'missing_skills' => $missingSkills
            ];
        }
    }

    usort($recommendations, fn($a, $b) => $b['percentage'] <=> $a['percentage']);

    return $recommendations;
}

}
