<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Skillly Career Report</title>
    <style>

        /* ── Reset & Base ────────────────────────────────── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
            background: #ffffff;
            color: #1e293b;
            font-size: 13px;
            line-height: 1.6;
        }

        /* ── Page Layout ─────────────────────────────────── */
        .page {
            width: 100%;
            max-width: 680px;
            margin: 0 auto;
            padding: 0;
        }

        /* ── Header Band ─────────────────────────────────── */
        .header-band {
            background: #4f46e5;
            padding: 36px 40px 32px;
            color: #ffffff;
        }
        .header-top {
            display: table;
            width: 100%;
            margin-bottom: 24px;
        }
        .brand {
            display: table-cell;
            vertical-align: middle;
        }
        .brand-name {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .brand-logo {
            height: 32px;
            width: auto;
            object-fit: contain;
            vertical-align: middle;
        }
        .brand-tagline {
            font-size: 10px;
            color: rgba(255,255,255,0.65);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 2px;
        }
        .header-meta {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            font-size: 10px;
            color: rgba(255,255,255,0.6);
        }

        .career-box {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 20px 24px;
        }
        .career-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1.8px;
            color: rgba(255,255,255,0.6);
            margin-bottom: 6px;
        }
        .career-name {
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }
        .career-sub {
            font-size: 11px;
            color: rgba(255,255,255,0.65);
            margin-top: 4px;
        }

        /* ── Readiness Band ──────────────────────────────── */
        .readiness-band {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 18px 40px;
        }
        .readiness-row {
            display: table;
            width: 100%;
        }
        .readiness-left {
            display: table-cell;
            vertical-align: middle;
            width: 140px;
        }
        .readiness-score-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
            margin-bottom: 2px;
        }
        .readiness-score-value {
            font-size: 28px;
            font-weight: 800;
            color: #4f46e5;
            line-height: 1;
        }
        .readiness-score-pct {
            font-size: 14px;
            font-weight: 600;
            color: #4f46e5;
        }
        .readiness-right {
            display: table-cell;
            vertical-align: middle;
        }
        .readiness-comment {
            font-size: 11.5px;
            color: #475569;
            margin-bottom: 8px;
        }
        .bar-track {
            background: #e2e8f0;
            border-radius: 99px;
            height: 8px;
            width: 100%;
        }
        .bar-fill {
            background: #4f46e5;
            height: 8px;
            border-radius: 99px;
        }
        .bar-labels {
            display: table;
            width: 100%;
            margin-top: 4px;
        }
        .bar-label-left  { display: table-cell; font-size: 9px; color: #94a3b8; }
        .bar-label-right { display: table-cell; font-size: 9px; color: #94a3b8; text-align: right; }

        /* ── Body Content ────────────────────────────────── */
        .body-content {
            padding: 32px 40px;
        }

        /* ── Two Column Grid ─────────────────────────────── */
        .two-col {
            display: table;
            width: 100%;
            border-collapse: separate;
            border-spacing: 16px 0;
            margin-left: -16px;
            width: calc(100% + 32px);
        }
        .col {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }

        /* ── Section ─────────────────────────────────────── */
        .section { margin-bottom: 28px; }
        .section-title {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.6px;
            color: #64748b;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* ── Skill Cards ─────────────────────────────────── */
        .skill-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 16px;
        }
        .skill-item {
            display: table;
            width: 100%;
            padding: 6px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .skill-item:last-child { border-bottom: none; }

        .skill-dot {
            display: table-cell;
            vertical-align: middle;
            width: 18px;
        }
        .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
        }
        .dot-green  { background: #22c55e; }
        .dot-orange { background: #f97316; }

        .skill-text {
            display: table-cell;
            vertical-align: middle;
            font-size: 12px;
            color: #334155;
            font-weight: 500;
            text-transform: capitalize;
        }

        .skill-empty {
            font-size: 11.5px;
            color: #94a3b8;
            font-style: italic;
            padding: 6px 0;
        }



        /* ── Next Steps ──────────────────────────────────── */
        .steps-list { list-style: none; padding: 0; }
        .step-item {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        .step-num {
            display: table-cell;
            vertical-align: top;
            width: 26px;
        }
        .step-num-inner {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #4f46e5;
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            text-align: center;
            line-height: 20px;
            display: inline-block;
        }
        .step-body {
            display: table-cell;
            vertical-align: top;
            font-size: 11.5px;
            color: #334155;
            padding-top: 2px;
        }
        .step-body strong { color: #1e293b; }

        /* ── Footer ──────────────────────────────────────── */
        .footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 16px 40px;
            display: table;
            width: 100%;
        }
        .footer-left {
            display: table-cell;
            vertical-align: middle;
            font-size: 10px;
            color: #94a3b8;
        }
        .footer-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            font-size: 10px;
            color: #94a3b8;
        }
        .footer-brand {
            font-weight: 700;
            color: #4f46e5;
        }

    </style>
</head>
<body>

<?php
    $careerName   = is_string($career) ? $career : ($career->career_name ?? 'Career Path Identified');
    $totalSkills  = count($matchedSkills) + count($missingSkills);
    $readiness    = $totalSkills > 0 ? round((count($matchedSkills) / $totalSkills) * 100) : 0;

    if ($readiness >= 80)      { $readinessComment = "You're in great shape — just a few finishing touches needed."; }
    elseif ($readiness >= 60)  { $readinessComment = "Solid progress. Bridging a couple of gaps will make a real difference."; }
    elseif ($readiness >= 40)  { $readinessComment = "Good foundation. Focusing on the top missing skills is your best next step."; }
    else                       { $readinessComment = "Room to grow — but every expert started as a beginner. Keep building."; }
?>

<div class="page">

    {{-- ── Header Band ── --}}
    <div class="header-band">
        <div class="header-top">
            <div class="brand">
                <div class="brand-name">
                    <img src="{{ public_path('skillly_icon.png') }}" alt="Skillly" class="brand-logo"> Skillly
                </div>
                <div class="brand-tagline">Skillly Career Guidance</div>
            </div>
            <div class="header-meta">
                Career Guidance Report<br>
                {{ now()->format('F d, Y') }}
            </div>
        </div>

        <div class="career-box">
            <div class="career-label">Recommended Career Path</div>
            <div class="career-name">{{ $careerName }}</div>
            <div class="career-sub">Best match based on your extracted skills and experience</div>
        </div>
    </div>

    {{-- ── Readiness Band ── --}}
    <div class="readiness-band">
        <div class="readiness-row">
            <div class="readiness-left">
                <div class="readiness-score-label">Readiness Score</div>
                <div class="readiness-score-value">{{ $readiness }}<span class="readiness-score-pct">%</span></div>
            </div>
            <div class="readiness-right">
                <div class="readiness-comment">{{ $readinessComment }}</div>
                <div class="bar-track">
                    <div class="bar-fill" style="width: {{ $readiness }}%;"></div>
                </div>
                <div class="bar-labels">
                    <span class="bar-label-left">0%</span>
                    <span class="bar-label-right">100%</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Body ── --}}
    <div class="body-content">

        {{-- ── Skills Two Column ── --}}
        <div class="two-col">

            {{-- Matched Skills --}}
            <div class="col">
                <div class="section">
                    <div class="section-title">Strong Skills ({{ count($matchedSkills) }})</div>
                    <div class="skill-card">
                        @forelse($matchedSkills as $skill)
                            <div class="skill-item">
                                <div class="skill-dot"><span class="dot dot-green"></span></div>
                                <div class="skill-text">{{ ucwords($skill) }}</div>
                            </div>
                        @empty
                            <div class="skill-empty">No matched skills detected.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Missing Skills --}}
            <div class="col">
                <div class="section">
                    <div class="section-title">Skills to Develop ({{ count($missingSkills) }})</div>
                    <div class="skill-card">
                        @forelse($missingSkills as $skill)
                            <div class="skill-item">
                                <div class="skill-dot"><span class="dot dot-orange"></span></div>
                                <div class="skill-text">{{ ucwords($skill) }}</div>
                            </div>
                        @empty
                            <div class="skill-empty">No critical gaps detected.</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        {{-- ── Suggested Next Steps ── --}}
        <div class="section">
            <div class="section-title">Suggested Next Steps</div>
            <ul class="steps-list">
                @if(!empty($missingSkills))
                    <li class="step-item">
                        <div class="step-num"><div class="step-num-inner">1</div></div>
                        <div class="step-body">
                            <strong>Start with {{ ucwords($missingSkills[0]) }}.</strong>
                            Build a small hands-on project or follow a structured tutorial. Document it on GitHub or your portfolio.
                        </div>
                    </li>
                    @if(isset($missingSkills[1]))
                    <li class="step-item">
                        <div class="step-num"><div class="step-num-inner">2</div></div>
                        <div class="step-body">
                            <strong>Move on to {{ ucwords($missingSkills[1]) }}.</strong>
                            Once you have a working example, add this skill to your resume — even a learning project counts.
                        </div>
                    </li>
                    @endif
                    <li class="step-item">
                        <div class="step-num"><div class="step-num-inner">{{ isset($missingSkills[1]) ? 3 : 2 }}</div></div>
                        <div class="step-body">
                            <strong>Update your resume.</strong>
                            Make sure your strong skills — {{ collect($matchedSkills)->take(3)->map('ucwords')->implode(', ') }} — are clearly highlighted with specific examples and metrics.
                        </div>
                    </li>
                @else
                    <li class="step-item">
                        <div class="step-num"><div class="step-num-inner">1</div></div>
                        <div class="step-body">
                            <strong>Build real-world projects.</strong> You're well-aligned with {{ $careerName }}. The best way to stand out now is shipping projects that demonstrate your skills.
                        </div>
                    </li>
                    <li class="step-item">
                        <div class="step-num"><div class="step-num-inner">2</div></div>
                        <div class="step-body">
                            <strong>Deepen your strongest skills.</strong> Advanced mastery of {{ collect($matchedSkills)->take(2)->map('ucwords')->implode(' and ') }} will set you apart from other candidates.
                        </div>
                    </li>
                @endif
            </ul>
        </div>



    </div>{{-- /body-content --}}

    {{-- ── Footer ── --}}
    <div class="footer">
        <div class="footer-left">
            Confidential &mdash; Generated for personal career use only
        </div>
        <div class="footer-right">
            Powered by <span class="footer-brand">Skillly</span> &bull; {{ now()->format('Y') }}
        </div>
    </div>

</div>{{-- /page --}}

</body>
</html>