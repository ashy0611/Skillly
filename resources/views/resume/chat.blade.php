@extends('layouts.app')

@section('title', 'Career Chat')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">

        {{-- ── Score Card ── --}}
        <div id="score-card" class="score-card mb-4" style="display:none;">
            <div class="sc-left">
                <div class="sc-career-label">Best Match</div>
                <div class="sc-career-name" id="sc-career-name">—</div>
            </div>
            <div class="sc-right">
                <svg class="sc-ring" viewBox="0 0 80 80">
                    <circle class="sc-ring-bg" cx="40" cy="40" r="34"/>
                    <circle class="sc-ring-fill" id="sc-ring-fill" cx="40" cy="40" r="34"
                        stroke-dasharray="213.6"
                        stroke-dashoffset="213.6"/>
                </svg>
                <div class="sc-pct-wrap">
                    <span class="sc-pct" id="sc-pct">0%</span>
                    <span class="sc-pct-label">Ready</span>
                </div>
            </div>
            <div class="sc-chips" id="sc-chips"></div>
        </div>

        {{-- ── Chat Panel ── --}}
        <div class="chat-panel glass-panel d-flex flex-column">

            {{-- Header --}}
            <div class="chat-top border-bottom" style="border-color:var(--border-glass)!important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="chat-logo-wrap">
                        <img src="{{ asset('skillly_logo.png') }}" alt="Skillly" class="chat-logo">
                        <span class="live-dot"></span>
                    </div>
                </div>
                <a href="{{ route('resume.index') }}" class="btn btn-outline-glass btn-sm">
                    <i class="fa-solid fa-arrow-rotate-left me-1"></i> New
                </a>
            </div>

            {{-- Messages --}}
            <div id="chat-box" class="chat-body chat-scroll"></div>

            {{-- Quick replies --}}
            <div id="qr-tray" class="qr-tray"></div>

            {{-- Input bar --}}
            <div class="chat-input-bar">
                <input
                    type="text"
                    id="chat-input"
                    class="chat-input"
                    placeholder="Ask me anything about your results…"
                    autocomplete="off"
                    maxlength="300"
                >
                <button id="send-btn" class="send-btn" title="Send">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>

/* ── Score Card ───────────────────────────────────────────── */
.score-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid var(--border-glass);
    border-radius: 20px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
    animation: fadeDown 0.5s ease both;
    position: relative;
    overflow: hidden;
}
.score-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(99,102,241,0.06), rgba(168,85,247,0.04));
    pointer-events: none;
}
.sc-left { flex: 1; min-width: 140px; }
.sc-career-label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .12em;
    color: var(--text-secondary);
    margin-bottom: 4px;
}
.sc-career-name {
    font-family: var(--font-sora, 'Sora', sans-serif);
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1.2;
}
.sc-right {
    position: relative;
    width: 80px; height: 80px;
    flex-shrink: 0;
}
.sc-ring { width: 80px; height: 80px; transform: rotate(-90deg); }
.sc-ring-bg  { fill: none; stroke: rgba(255,255,255,0.07); stroke-width: 7; }
.sc-ring-fill {
    fill: none;
    stroke: url(#ringGrad);
    stroke-width: 7;
    stroke-linecap: round;
    transition: stroke-dashoffset 1.6s cubic-bezier(0.22,1,0.36,1);
}
.sc-pct-wrap {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    line-height: 1.1;
}
.sc-pct {
    font-size: 1.05rem;
    font-weight: 800;
    background: var(--accent-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.sc-pct-label {
    font-size: 0.55rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--text-secondary);
}
.sc-chips {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 4px;
}
.sc-chip {
    font-size: 0.72rem;
    font-weight: 500;
    padding: 3px 10px;
    border-radius: 99px;
    border: 1px solid;
}
.sc-chip.match {
    background: rgba(34,197,94,0.08);
    border-color: rgba(34,197,94,0.25);
    color: #86efac;
}
.sc-chip.gap {
    background: rgba(251,146,60,0.08);
    border-color: rgba(251,146,60,0.25);
    color: #fdba74;
}

/* ── Chat Panel ───────────────────────────────────────────── */
.chat-panel {
    display: flex;
    flex-direction: column;
    height: 68vh;
    max-height: 720px;
    padding: 0;
    overflow: hidden;
}

/* ── Header ───────────────────────────────────────────────── */
.chat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    flex-shrink: 0;
}
.chat-logo-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.chat-logo {
    height: 48px;
    width: auto;
    object-fit: contain;
    filter: drop-shadow(0 2px 8px rgba(99,102,241,0.4)) brightness(1.15);
}
.live-dot {
    position: absolute;
    bottom: 2px; right: -6px;
    width: 9px; height: 9px;
    background: #34d399;
    border-radius: 50%;
    border: 2px solid #0f172a;
    animation: pulse-dot 2s infinite;
}
@keyframes pulse-dot {
    0%,100% { box-shadow: 0 0 0 0 rgba(52,211,153,0.5); }
    50%      { box-shadow: 0 0 0 5px rgba(52,211,153,0); }
}
.chat-brand-label {
    font-family: var(--font-sora, 'Sora', sans-serif);
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .14em;
    color: var(--text-secondary);
}

/* ── Messages ─────────────────────────────────────────────── */
.chat-body {
    flex: 1;
    overflow-y: auto;
    padding: 20px 24px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.msg {
    max-width: 78%;
    padding: 12px 16px;
    border-radius: 18px;
    font-size: 0.9rem;
    line-height: 1.65;
    opacity: 0;
    transform: translateY(10px);
    animation: fadeUp 0.3s ease forwards;
    word-break: break-word;
}
.msg.bot {
    background: rgba(255,255,255,0.055);
    border: 1px solid var(--border-glass);
    border-bottom-left-radius: 4px;
    align-self: flex-start;
    color: var(--text-primary);
}
.msg.user {
    background: var(--accent-gradient);
    color: white;
    border-bottom-right-radius: 4px;
    align-self: flex-end;
    box-shadow: 0 4px 16px rgba(99,102,241,0.28);
}
.msg-meta {
    font-size: 0.68rem;
    color: var(--text-secondary);
    opacity: 0.5;
    margin-bottom: 2px;
    animation: fadeUp 0.3s ease forwards;
    opacity: 0;
}
.msg-meta.bot-meta { align-self: flex-start; }
.msg-meta.user-meta { align-self: flex-end; }

/* ── Typing bubble ────────────────────────────────────────── */
.typing-bubble {
    align-self: flex-start;
    background: rgba(255,255,255,0.055);
    border: 1px solid var(--border-glass);
    border-bottom-left-radius: 4px;
    border-radius: 18px;
    padding: 14px 18px;
    display: inline-flex;
    gap: 5px;
    align-items: center;
    animation: fadeUp 0.3s ease forwards;
    opacity: 0;
}
.typing-bubble span {
    width: 7px; height: 7px;
    background: var(--text-secondary);
    border-radius: 50%;
    animation: tBounce 1.2s infinite ease-in-out;
}
.typing-bubble span:nth-child(2) { animation-delay: 0.15s; }
.typing-bubble span:nth-child(3) { animation-delay: 0.3s; }
@keyframes tBounce {
    0%,60%,100% { transform: translateY(0);    opacity: 0.4; }
    30%          { transform: translateY(-6px); opacity: 1; }
}

/* ── Quick Reply Tray ─────────────────────────────────────── */
.qr-tray {
    padding: 0 24px 12px;
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    flex-shrink: 0;
    min-height: 0;
    transition: opacity 0.2s;
}
.qr {
    background: rgba(255,255,255,0.04);
    border: 1px solid var(--border-glass);
    color: var(--text-primary);
    padding: 8px 15px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.16s, border-color 0.16s, transform 0.13s, box-shadow 0.16s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
    animation: fadeUp 0.3s ease both;
}
.qr:hover {
    background: rgba(99,102,241,0.12);
    border-color: var(--accent-main);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(99,102,241,0.18);
}
.qr:active  { transform: translateY(0); }
.qr:disabled { opacity: 0.4; pointer-events: none; }
.qr.hi {
    background: var(--accent-gradient);
    border: none;
    color: white;
    box-shadow: 0 4px 12px rgba(99,102,241,0.22);
}
.qr.hi:hover { box-shadow: 0 6px 18px rgba(99,102,241,0.38); }
.qr.warn {
    border-color: rgba(239,68,68,0.3);
    color: #fca5a5;
}
.qr.warn:hover { background: rgba(239,68,68,0.08); border-color: #ef4444; color: white; }

/* ── Input Bar ────────────────────────────────────────────── */
.chat-input-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 20px;
    border-top: 1px solid var(--border-glass);
    flex-shrink: 0;
    background: rgba(255,255,255,0.015);
}
.chat-input {
    flex: 1;
    background: rgba(255,255,255,0.06);
    border: 1px solid var(--border-glass);
    border-radius: 50px;
    padding: 10px 18px;
    font-size: 0.88rem;
    color: var(--text-primary);
    outline: none;
    transition: border-color 0.2s, background 0.2s;
    font-family: var(--font-inter, 'Inter', sans-serif);
}
.chat-input::placeholder { color: var(--text-secondary); opacity: 0.6; }
.chat-input:focus {
    border-color: rgba(99,102,241,0.5);
    background: rgba(255,255,255,0.08);
}
.send-btn {
    width: 40px; height: 40px;
    background: var(--accent-gradient);
    border: none;
    border-radius: 50%;
    color: white;
    font-size: 0.85rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(99,102,241,0.3);
    transition: transform 0.15s, box-shadow 0.15s;
}
.send-btn:hover { transform: scale(1.08); box-shadow: 0 6px 16px rgba(99,102,241,0.42); }
.send-btn:active { transform: scale(0.96); }

/* ── Divider ──────────────────────────────────────────────── */
.chat-divider {
    align-self: center;
    font-size: 0.68rem;
    text-transform: uppercase;
    letter-spacing: .1em;
    color: var(--text-secondary);
    opacity: 0.4;
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    margin: 6px 0;
}
.chat-divider::before, .chat-divider::after {
    content: ''; flex: 1; height: 1px; background: var(--border-glass);
}

/* ── Download ─────────────────────────────────────────────── */
.dl-wrap {
    align-self: center;
    animation: fadeUp 0.4s ease both;
    opacity: 0;
    margin: 4px 0 8px;
}

/* ── Scroll ───────────────────────────────────────────────── */
.chat-scroll::-webkit-scrollbar { width: 4px; }
.chat-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.07); border-radius: 10px; }

/* ── Keyframes ────────────────────────────────────────────── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── SVG gradient def (inline, hidden) ───────────────────── */
.svg-defs { position: absolute; width: 0; height: 0; overflow: hidden; }
</style>
@endpush

@push('scripts')
<script>
(function () {

/* ── Data from server ─────────────────────────────────────── */
const MESSAGES      = @json($conversation);
const MISSING       = @json(session('missingSkills', []));
const MATCHED       = @json(session('matchedSkills', []));
const CAREER        = @json(session('career', ''));
const ALL_RECS      = @json(session('allRecommendations', []));

const careerName    = (typeof CAREER === 'string') ? CAREER : (CAREER?.career_name ?? 'Your Career Match');
const total         = MATCHED.length + MISSING.length;
const readiness     = total > 0 ? Math.round((MATCHED.length / total) * 100) : 0;

/* ── DOM refs ─────────────────────────────────────────────── */
const chatBox   = document.getElementById('chat-box');
const qrTray    = document.getElementById('qr-tray');
const inputEl   = document.getElementById('chat-input');
const sendBtn   = document.getElementById('send-btn');

/* ── Score card ───────────────────────────────────────────── */
function showScoreCard() {
    const card = document.getElementById('score-card');
    document.getElementById('sc-career-name').textContent = ucwords(careerName);
    card.style.display = 'flex';

    // Animate ring
    setTimeout(() => {
        const circ   = 2 * Math.PI * 34; // 213.6
        const offset = circ - (readiness / 100) * circ;
        document.getElementById('sc-ring-fill').style.strokeDashoffset = offset;
        // Count up percentage
        let cur = 0;
        const pctEl = document.getElementById('sc-pct');
        const step  = () => {
            cur = Math.min(cur + Math.ceil(readiness / 40), readiness);
            pctEl.textContent = cur + '%';
            if (cur < readiness) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    }, 300);

    // Skill chips — show top 3 matched + top 2 missing
    const chips = document.getElementById('sc-chips');
    MATCHED.slice(0, 3).forEach(s => {
        const c = document.createElement('span');
        c.className = 'sc-chip match';
        c.textContent = '✓ ' + ucwords(s);
        chips.appendChild(c);
    });
    MISSING.slice(0, 2).forEach(s => {
        const c = document.createElement('span');
        c.className = 'sc-chip gap';
        c.textContent = '+ ' + ucwords(s);
        chips.appendChild(c);
    });
}

/* ── Transcript tracker ───────────────────────────────────── */
const transcript = [];

function trackMsg(html, side) {
    // Strip HTML tags for clean storage, keep emojis
    const plain = html.replace(/<br\s*\/?>/gi, '\n').replace(/<[^>]+>/g, '');
    transcript.push({ type: side, message: plain.trim() });
}


function scrollBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}

function addMeta(text, side) {
    const d = document.createElement('div');
    d.className = `msg-meta ${side}-meta`;
    d.textContent = text;
    chatBox.appendChild(d);
    scrollBottom();
}

function addMsg(html, side, animDelay = 0) {
    const d = document.createElement('div');
    d.className = `msg ${side}`;
    d.style.animationDelay = animDelay + 'ms';
    d.innerHTML = html.replace(/\n/g, '<br>');
    chatBox.appendChild(d);
    scrollBottom();
    trackMsg(html, side);   // ← record every message
    return d;
}

function addDivider(text) {
    const d = document.createElement('div');
    d.className = 'chat-divider';
    d.textContent = text;
    chatBox.appendChild(d);
    scrollBottom();
}

let typingEl = null;
function showTyping() {
    if (typingEl) return;
    typingEl = document.createElement('div');
    typingEl.className = 'typing-bubble';
    typingEl.innerHTML = '<span></span><span></span><span></span>';
    chatBox.appendChild(typingEl);
    scrollBottom();
}
function hideTyping() {
    if (typingEl) { typingEl.remove(); typingEl = null; }
}

/* Humanised bot reply: variable delay based on message length */
function botSay(html, then, baseDelay) {
    showTyping();
    const words   = html.replace(/<[^>]+>/g, '').split(' ').length;
    const delay   = baseDelay ?? Math.min(600 + words * 38, 2200);
    setTimeout(() => {
        hideTyping();
        addMsg(html, 'bot');
        if (typeof then === 'function') setTimeout(then, 260);
    }, delay);
}

/* ── Quick replies ────────────────────────────────────────── */
function clearQR() { qrTray.innerHTML = ''; }

function setQR(buttons) {
    clearQR();
    buttons.forEach(({ label, icon, cls, fn }, i) => {
        const btn = document.createElement('button');
        btn.className = `qr ${cls || ''}`;
        btn.style.animationDelay = (i * 55) + 'ms';
        btn.innerHTML = (icon ? `<i class="${icon}"></i>` : '') + ' ' + label;
        btn.onclick = () => {
            clearQR();
            userSay((icon ? '' : '') + label);
            fn();
        };
        qrTray.appendChild(btn);
    });
}

/* ── User message (typed or button) ──────────────────────── */
function userSay(text) {
    addMsg(text, 'user');
}

/* ── Download block ───────────────────────────────────────── */
function showDownload() {
    if (document.getElementById('dl-block')) return;
    addDivider('Your report is ready');
    const wrap = document.createElement('div');
    wrap.className = 'dl-wrap';
    wrap.id = 'dl-block';
    wrap.innerHTML = `
        <form action="{{ route('download.report') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-glow">
                <i class="fa-solid fa-file-pdf me-2"></i>Download My Report
            </button>
        </form>`;
    chatBox.appendChild(wrap);
    scrollBottom();
}

/* ── Conversation stages ──────────────────────────────────── */
function stageWelcomeButtons() {
    setQR([
        { label: 'What are my strengths?',   icon: 'fa-solid fa-star',             cls: 'hi',   fn: stageStrengths   },
        { label: 'What am I missing?',        icon: 'fa-solid fa-magnifying-glass', fn: stageGaps       },
        { label: 'How do I get there?',       icon: 'fa-solid fa-road',             fn: stageRoadmap    },
        { label: 'Get my report',             icon: 'fa-solid fa-file-arrow-down',  cls: 'warn', fn: stageDownload   },
    ]);
}

function stageStrengths() {
    if (MATCHED.length > 0) {
        const list = MATCHED.map(s => `• ${ucwords(s)}`).join('<br>');
        botSay(`Here's what's already working in your favour 💪<br><br>${list}<br><br>These are the skills that made <strong>${ucwords(careerName)}</strong> your top match — make sure they're front and centre on your resume!`, () => {
            setQR([
                { label: "What am I missing?",    icon: 'fa-solid fa-magnifying-glass', cls: 'hi', fn: stageGaps    },
                { label: "How do I get there?",   icon: 'fa-solid fa-road',                        fn: stageRoadmap },
                { label: "Get my report",          icon: 'fa-solid fa-file-arrow-down',  cls: 'warn', fn: stageDownload },
            ]);
        });
    } else {
        botSay("Hmm, I didn't find many skills that map directly to this path. Try rewriting your resume with more specific technical terms — even tool names make a big difference!", () => stageWelcomeButtons());
    }
}

function stageGaps() {
    if (MISSING.length > 0) {
        const list = MISSING.map(s => `• ${ucwords(s)}`).join('<br>');
        botSay(`No worries — every gap is just a skill you haven't picked up yet. Here's what would take you to the next level for <strong>${ucwords(careerName)}</strong>:<br><br>${list}`, () => {
            setQR([
                { label: "Where do I start?",   icon: 'fa-solid fa-graduation-cap', cls: 'hi', fn: stageRoadmap  },
                { label: "Show my strengths",   icon: 'fa-solid fa-star',                       fn: stageStrengths},
                { label: "Get my report",        icon: 'fa-solid fa-file-arrow-down', cls: 'warn', fn: stageDownload },
            ]);
        });
    } else {
        botSay(`Great news — I don't see any significant gaps for <strong>${ucwords(careerName)}</strong>! 🎉 Your profile is well-aligned. Focus on deepening your expertise and building real projects.`, () => stageAfterAllDone());
    }
}

function stageRoadmap() {
    if (MISSING.length > 0) {
        const first  = ucwords(MISSING[0]);
        const second = MISSING[1] ? ` then move on to <strong>${ucwords(MISSING[1])}</strong>` : '';
        botSay(`Here's a simple plan that actually works 🗺️<br><br>1. Pick up <strong>${first}</strong>${second}.<br>2. Build something small with it — a project, even a toy one.<br>3. Add it to your resume once you've got hands-on practice.<br>4. Rinse and repeat for the next skill.<br><br><em>30 minutes a day consistently beats 5-hour weekend marathons.</em>`, () => stageAfterAllDone());
    } else {
        botSay(`You're already in great shape! 🚀 The best move now is to build real-world projects, contribute to open source, and keep your resume sharp with measurable results.`, () => stageAfterAllDone());
    }
}

function stageAfterAllDone() {
    setQR([
        { label: "Any other careers for me?", icon: 'fa-solid fa-compass',        fn: stageOtherCareers },
        { label: "Get my report",              icon: 'fa-solid fa-file-arrow-down', cls: 'hi', fn: stageDownload },
    ]);
}

function stageOtherCareers() {
    const others = ALL_RECS.filter(r => {
        const n = (typeof r.career === 'string') ? r.career : (r.career?.career_name ?? '');
        return n.toLowerCase() !== careerName.toLowerCase();
    }).slice(0, 3);

    if (others.length > 0) {
        const lines = others.map(r => {
            const n = (typeof r.career === 'string') ? r.career : (r.career?.career_name ?? 'Role');
            return `• <strong>${ucwords(n)}</strong> — ${r.percentage}% match`;
        }).join('<br>');
        botSay(`A few other paths that could suit you:<br><br>${lines}<br><br>Your full report has the complete breakdown with skill details for each one.`, () => {
            setQR([{ label: "Get my report", icon: 'fa-solid fa-file-arrow-down', cls: 'hi', fn: stageDownload }]);
        });
    } else {
        botSay(`Based on your current profile, <strong>${ucwords(careerName)}</strong> is really your strongest match. Building more skills will open up more paths over time!`, () => {
            setQR([{ label: "Get my report", icon: 'fa-solid fa-file-arrow-down', cls: 'hi', fn: stageDownload }]);
        });
    }
}

function stageDownload() {
    botSay("Your full career report is ready — it includes your skill matches, gaps, and a step-by-step plan. Download it below! 📄", () => showDownload(), 800);
}

/* ── Free-text rule-based handler ────────────────────────── */
const RULES = [
    { keys: ['hi','hello','hey','howdy','sup'],
      reply: () => `Hey! 👋 Good to have you here. I've already gone through your resume and matched you to <strong>${ucwords(careerName)}</strong>. What would you like to dig into?`,
      next: stageWelcomeButtons },

    { keys: ['thank','thanks','cheers','appreciate'],
      reply: () => `You're so welcome! 😊 Best of luck on your journey — you've got this.`,
      next: null },

    { keys: ['strength','strong','good at','skill','have','matched','already know'],
      reply: null, next: stageStrengths },

    { keys: ['miss','gap','lack','need','don\'t have','improve','weak'],
      reply: null, next: stageGaps },

    { keys: ['learn','course','study','roadmap','plan','start','how to','prepare','get ready','next step'],
      reply: null, next: stageRoadmap },

    { keys: ['career','role','job','path','match','suited','fit','recommend','best for'],
      reply: () => `Based on your resume, <strong>${ucwords(careerName)}</strong> is your best career match right now with a readiness score of <strong>${readiness}%</strong>. Want to explore what's driving that match?`,
      next: stageWelcomeButtons },

    { keys: ['other','alternative','else','different','more career','second','option'],
      reply: null, next: stageOtherCareers },

    { keys: ['score','percent','ready','readiness','how close','how prepared'],
      reply: () => readinessReply(),
      next: stageWelcomeButtons },

    { keys: ['salary','pay','earn','income','wage','money'],
      reply: () => `Salaries for <strong>${ucwords(careerName)}</strong> vary a lot by location, company size, and experience. I'd recommend checking Glassdoor or LinkedIn Salary for current numbers in your area — they'll be much more accurate than anything I can guess!`,
      next: null },

    { keys: ['resume','cv','update','fix resume','improve resume'],
      reply: () => `A few quick wins for your resume:<br><br>• Use specific tool and tech names (not just "programming")<br>• Quantify wins — "reduced load time by 30%" beats "improved performance"<br>• List skills you're actively learning — it shows initiative<br>• Keep it tight: 1–2 pages max`,
      next: null },

    { keys: ['interview','prep','question','tips'],
      reply: () => `For <strong>${ucwords(careerName)}</strong> interviews, expect questions around your strongest skills, how you handle challenges, and technical problem-solving. Practice the STAR method (Situation → Task → Action → Result) for behavioural questions — it works really well.`,
      next: null },

    { keys: ['download','report','pdf','save','export'],
      reply: null, next: stageDownload },
];

function readinessReply() {
    let comment;
    if (readiness >= 80) comment = "You're in great shape — just a few finishing touches needed! 🚀";
    else if (readiness >= 60) comment = "Solid progress! Bridging a couple of gaps will make a real difference. 👍";
    else if (readiness >= 40) comment = "Good foundation to build from. Focus on the top missing skills first. 📈";
    else comment = "Room to grow — but every expert started somewhere. Keep building! 💪";
    return `Your readiness score for <strong>${ucwords(careerName)}</strong> is <strong>${readiness}%</strong>.<br><br>${comment}`;
}

function handleTextInput(raw) {
    const msg = raw.trim();
    if (!msg) return;
    inputEl.value = '';
    userSay(msg);
    clearQR();

    const lower = msg.toLowerCase();
    for (const rule of RULES) {
        if (rule.keys.some(k => lower.includes(k))) {
            if (rule.reply) {
                botSay(rule.reply(), rule.next ? () => rule.next() : null);
            } else if (rule.next) {
                // small pause then trigger stage
                showTyping();
                setTimeout(() => { hideTyping(); rule.next(); }, 700);
            }
            return;
        }
    }

    // Fallback
    botSay(`I'm not totally sure what you mean, but I'm here to help! You can ask me about your strengths, skill gaps, how to improve, or career options. What would you like to know? 😊`, () => stageWelcomeButtons());
}

/* ── Input events ─────────────────────────────────────────── */
sendBtn.addEventListener('click', () => handleTextInput(inputEl.value));
inputEl.addEventListener('keydown', e => { if (e.key === 'Enter') handleTextInput(inputEl.value); });

/* ── Boot sequence ────────────────────────────────────────── */
let idx = 0;
function playNext() {
    if (idx < MESSAGES.length) {
        showTyping();
        const msg   = MESSAGES[idx];
        const words = msg.message.replace(/<[^>]+>/g, '').split(' ').length;
        const delay = Math.min(700 + words * 42, 2000);
        setTimeout(() => {
            hideTyping();
            addMsg(msg.message, 'bot');
            idx++;
            setTimeout(playNext, 420);
        }, delay);
    } else {
        // All initial messages done — show score card + buttons
        setTimeout(() => {
            showScoreCard();
            setTimeout(stageWelcomeButtons, 500);
        }, 400);
    }
}

/* ── Utility ──────────────────────────────────────────────── */
function ucwords(str) {
    if (!str) return '';
    return str.toString().replace(/\b\w/g, c => c.toUpperCase());
}

playNext();

})();
</script>

{{-- SVG gradient definition for the ring --}}
<svg class="svg-defs">
    <defs>
        <linearGradient id="ringGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%"   stop-color="#6366f1"/>
            <stop offset="100%" stop-color="#a855f7"/>
        </linearGradient>
    </defs>
</svg>
@endpush