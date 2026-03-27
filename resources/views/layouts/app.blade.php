<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Skillly')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-deep:        #0f172a;
            --bg-surface:     rgba(30, 41, 59, 0.7);
            --bg-card:        rgba(30, 41, 59, 0.6);
            --border-glass:   rgba(255, 255, 255, 0.08);
            --border-glow:    rgba(99, 102, 241, 0.5);
            --text-primary:   #f8fafc;
            --text-secondary: #94a3b8;
            --accent-main:       #6366f1;
            --accent-secondary:  #a855f7;
            --accent-gradient:   linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --accent-glow:       rgba(99, 102, 241, 0.4);
            --font-sora:  'Sora', sans-serif;
            --font-inter: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-deep);
            color: var(--text-primary);
            font-family: var(--font-inter);
            min-height: 100vh;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ── Background blobs ──────────────────────────────── */
        .bg-blob {
            position: fixed;
            width: 600px;
            height: 600px;
            background: var(--accent-gradient);
            filter: blur(120px);
            opacity: 0.12;
            border-radius: 50%;
            z-index: -1;
            animation: blobFloat 25s infinite alternate;
        }
        @keyframes blobFloat {
            from { transform: translate(-10%, -10%) rotate(0deg); }
            to   { transform: translate(10%,  10%) rotate(360deg); }
        }

        /* ── Navbar ────────────────────────────────────────── */
        .navbar-skillly {
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-glass);
            padding: 0.85rem 0;
        }

        /* Logo image — the actual PNG mark */
        .brand-logo-icon {
            width: 36px;
            height: 36px;
            object-fit: contain;
            border-radius: 10px;
            /* slight glow to match the dark navbar */
            filter: drop-shadow(0 4px 10px rgba(99, 102, 241, 0.45));
            flex-shrink: 0;
        }

        .brand {
            font-family: var(--font-sora);
            font-weight: 700;
            font-size: 1.5rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.02em;
            transition: opacity 0.2s;
        }
        .brand:hover { opacity: 0.88; color: white; }

        /* ── New Analysis Button ───────────────────────────── */
        .btn-new {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px 8px 10px;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 50px;
            color: #a5b4fc;
            font-size: 0.83rem;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: 0.01em;
            transition: background 0.2s, border-color 0.2s, color 0.2s, transform 0.15s, box-shadow 0.2s;
        }
        .btn-new:hover {
            background: rgba(99, 102, 241, 0.2);
            border-color: rgba(99, 102, 241, 0.6);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.25);
        }
        .btn-new:active {
            transform: translateY(0);
        }
        .btn-new-icon {
            width: 22px;
            height: 22px;
            background: var(--accent-gradient);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.4);
        }

        /* ── Buttons ───────────────────────────────────────── */
        .btn-glow {
            background: var(--accent-gradient);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 4px 20px var(--accent-glow);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px var(--accent-glow);
            color: white;
        }
        .btn-glow:disabled {
            opacity: 0.5;
            transform: none;
            cursor: not-allowed;
        }

        .btn-outline-glass {
            background: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border-glass);
            padding: 8px 18px;
            border-radius: 10px;
            transition: all 0.25s ease;
            font-weight: 500;
            font-size: 0.85rem;
            backdrop-filter: blur(5px);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-outline-glass:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--accent-main);
            color: white;
        }

        /* ── Glass panel ───────────────────────────────────── */
        .glass-panel {
            background: var(--bg-card);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-glass);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        /* ── Typography ────────────────────────────────────── */
        h1, h2, h3, h4 {
            font-family: var(--font-sora);
            color: var(--text-primary);
        }
        .text-gradient {
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Footer ────────────────────────────────────────── */
        footer {
            border-top: 1px solid var(--border-glass);
            padding: 1.6rem 0;
            background: rgba(15, 23, 42, 0.5);
            margin-top: auto;
        }
        .footer-logo {
            width: 20px;
            height: 20px;
            object-fit: contain;
            opacity: 0.5;
            vertical-align: middle;
            margin-right: 6px;
            filter: drop-shadow(0 2px 4px rgba(99,102,241,0.3));
        }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <div class="bg-blob" style="top: -10%; left: -10%;"></div>
    <div class="bg-blob" style="bottom: -10%; right: -10%; animation-delay: -10s;"></div>

    {{-- ── Navbar ── --}}
    <nav class="navbar navbar-expand-lg navbar-skillly sticky-top">
        <div class="container">
            <a class="brand" href="{{ route('resume.index') }}">
                <img
                    src="{{ asset('skillly_icon.png') }}"
                    alt="Skillly icon"
                    class="brand-logo-icon"
                >
                Skillly
            </a>
            <div class="ms-auto d-flex align-items-center gap-3">
                <a href="{{ route('resume.index') }}" class="btn-new">
                    <i class="fa-solid fa-plus btn-new-icon"></i>
                    <span>New Analysis</span>
                </a>
            </div>
        </div>
    </nav>

    {{-- ── Main content ── --}}
    <main class="flex-grow-1 py-5 position-relative">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- ── Footer ── --}}
    <footer class="text-center">
        <div class="container">
            <p class="small text-secondary mb-0">
                <img src="{{ asset('skillly_icon.png') }}" alt="" class="footer-logo">
                &copy; {{ date('Y') }} Skillly. All rights reserved.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>