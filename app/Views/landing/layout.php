<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'myCoder — Multi-Model AI Chat Orchestration') ?></title>
    <meta name="description" content="<?= esc($description ?? 'Send a single prompt to multiple AI models simultaneously — Gemini, DeepSeek, Grok, OpenAI, Kimi, MiniMax, Groq, OpenRouter — and let the Master Model synthesize the best answer.') ?>">
    <meta name="keywords" content="AI, multi-model, chat, Gemini, DeepSeek, Grok, OpenAI, LLM, orchestration, Docker, open source">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= base_url($canonical ?? '') ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= esc($ogTitle ?? $title ?? 'myCoder — Multi-Model AI Chat Orchestration Platform') ?>">
    <meta property="og:description" content="<?= esc($ogDescription ?? $description ?? 'Query multiple AI models at once and get a synthesized answer. Self-host with Docker.') ?>">
    <meta property="og:url" content="<?= base_url($canonical ?? '') ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?= base_url('favicon.png') ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= esc($ogTitle ?? $title ?? 'myCoder — Multi-Model AI Chat Orchestration') ?>">
    <meta name="twitter:description" content="<?= esc($ogDescription ?? $description ?? 'Query multiple AI models at once and get a synthesized answer.') ?>">

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "myCoder",
        "description": "Multi-model AI orchestration platform that sends prompts to multiple LLMs simultaneously and synthesizes the best answer.",
        "applicationCategory": "AI Chat",
        "operatingSystem": "Linux",
        "browserRequirements": "Modern browser with JavaScript enabled",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD"
        }
    }
    </script>

    <?= $this->renderSection('head') ?>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('favicon.png') ?>">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- App theme CSS (shared with chat & auth pages) -->
    <link rel="stylesheet" href="<?= base_url('css/chat.css') ?>">

    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            margin: 0;
        }
        a { color: var(--accent); text-decoration: none; }
        a:hover { color: color-mix(in srgb, var(--accent) 70%, white); }

        .gradient-text {
            background: linear-gradient(135deg, var(--accent), var(--accent2), #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .section-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
            max-width: 640px;
            margin: 0 auto 3rem;
        }

        .navbar-landing {
            background: color-mix(in srgb, var(--bg-dark) 85%, transparent);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
        }
        .navbar-landing .nav-link {
            color: var(--text-muted);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .navbar-landing .nav-link:hover,
        .navbar-landing .nav-link.active {
            color: var(--text-main);
            background: color-mix(in srgb, var(--text-main) 5%, transparent);
        }

        .hero-section {
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 6rem 1.5rem 4rem;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(ellipse at center, color-mix(in srgb, var(--accent) 8%, transparent) 0%, transparent 60%);
            pointer-events: none;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: color-mix(in srgb, var(--accent) 10%, transparent);
            border: 1px solid color-mix(in srgb, var(--accent) 20%, transparent);
            border-radius: 100px;
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
            color: var(--accent);
            margin-bottom: 1.5rem;
        }
        .hero-title {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }
        .hero-desc {
            font-size: 1.2rem;
            color: var(--text-muted);
            max-width: 720px;
            margin: 0 auto 2.5rem;
            line-height: 1.7;
        }
        .hero-actions .btn {
            padding: 0.85rem 2.25rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.05rem;
            transition: all 0.2s;
        }
        .btn-primary-landing {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border: none;
            color: #fff;
        }
        .btn-primary-landing:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px color-mix(in srgb, var(--accent) 35%, transparent);
            color: #fff;
        }
        .btn-outline-landing {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }
        .btn-outline-landing:hover {
            background: color-mix(in srgb, var(--text-main) 5%, transparent);
            color: var(--text-main);
        }

        .hero-models {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
            margin-top: 3rem;
        }
        .hero-models span {
            background: var(--sidebar-bg);
            border: 1px solid var(--border-color);
            border-radius: 100px;
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        section { padding: 5rem 1.5rem; }
        .section-dark { background: var(--input-bg); }

        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            text-align: center;
            padding: 8rem 1.5rem 2rem;
        }
        .page-header h1 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; }
        .page-header p { color: var(--text-muted); font-size: 1.1rem; max-width: 640px; margin: 0.5rem auto 0; }

        .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
        .feature-card {
            background: var(--sidebar-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.3s;
        }
        .feature-card:hover { border-color: var(--accent); transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.2); }
        .feature-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 1.25rem;
        }
        .feature-icon.blue { background: color-mix(in srgb, var(--accent) 15%, transparent); color: var(--accent); }
        .feature-icon.purple { background: color-mix(in srgb, var(--accent2) 15%, transparent); color: var(--accent2); }
        .feature-icon.pink { background: rgba(236,72,153,0.15); color: #ec4899; }
        .feature-icon.green { background: rgba(34,197,94,0.15); color: #22c55e; }
        .feature-icon.orange { background: rgba(249,115,22,0.15); color: #f97316; }
        .feature-icon.cyan { background: rgba(6,182,212,0.15); color: #06b6d4; }
        .feature-icon.indigo { background: rgba(99,102,241,0.15); color: #6366f1; }
        .feature-card h5 { font-weight: 600; margin-bottom: 0.75rem; }
        .feature-card p { color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin: 0; }

        .steps-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2rem; }
        .step-card { text-align: center; position: relative; }
        .step-number {
            width: 56px; height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1.3rem;
            margin: 0 auto 1.25rem;
        }
        .step-card h5 { font-weight: 600; margin-bottom: 0.5rem; }
        .step-card p { color: var(--text-muted); font-size: 0.9rem; line-height: 1.5; margin: 0; }

        .demo-illustration {
            background: linear-gradient(135deg, color-mix(in srgb, var(--accent) 5%, transparent), color-mix(in srgb, var(--accent2) 5%, transparent));
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
        }
        .demo-illustration .demo-prompt {
            background: var(--sidebar-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            text-align: left;
        }
        .demo-illustration .demo-arrow { color: var(--text-muted); font-size: 1.5rem; margin: 0.5rem 0; }
        .demo-model-response {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            text-align: left;
        }
        .demo-model-response div {
            background: var(--sidebar-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
        }
        .demo-model-response div .label { color: var(--accent); font-weight: 600; display: block; margin-bottom: 0.25rem; }

        .models-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
        }
        .model-chip {
            background: var(--sidebar-bg);
            border: 1px solid var(--border-color);
            border-radius: 100px;
            padding: 0.5rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .model-chip:hover { border-color: var(--accent); background: color-mix(in srgb, var(--accent) 10%, transparent); }

        .docker-block {
            background: #0d1117;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            overflow-x: auto;
            margin-top: 1rem;
        }
        .docker-block pre {
            margin: 0;
            color: #e6edf3;
            font-family: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', monospace;
            font-size: 0.9rem;
            line-height: 1.6;
        }
        .docker-block code { color: #7ee787; }
        .copy-btn {
            float: right;
            background: color-mix(in srgb, var(--text-main) 5%, transparent);
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            border-radius: 6px;
            padding: 0.25rem 0.75rem;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .copy-btn:hover { background: color-mix(in srgb, var(--text-main) 10%, transparent); color: var(--text-main); }

        .faq-item {
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 0;
        }
        .faq-item:first-of-type { border-top: 1px solid var(--border-color); }
        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 600;
            font-size: 1.05rem;
            user-select: none;
        }
        .faq-question i { transition: transform 0.3s; color: var(--text-muted); }
        .faq-question.open i { transform: rotate(180deg); }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease, padding 0.3s ease;
            color: var(--text-muted);
            line-height: 1.7;
        }
        .faq-answer.show {
            max-height: 400px;
            padding-top: 0.75rem;
        }
        .faq-answer p { margin: 0; }

        .footer-landing {
            border-top: 1px solid var(--border-color);
            padding: 2.5rem 1.5rem;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        .footer-landing a { color: var(--text-main); }
        .footer-landing a:hover { color: var(--accent); }

        .highlight-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 3rem; }
        .highlight-card {
            background: var(--sidebar-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 1.5rem;
            text-align: center;
        }
        .highlight-card .num { font-size: 2rem; font-weight: 800; }
        .highlight-card .num.blue { color: var(--accent); }
        .highlight-card .num.purple { color: var(--accent2); }
        .highlight-card .num.pink { color: #ec4899; }
        .highlight-card .num.green { color: #22c55e; }
        .highlight-card p { color: var(--text-muted); font-size: 0.85rem; margin: 0.25rem 0 0; }

        @media (max-width: 768px) {
            .hero-title { font-size: 2rem; }
            .hero-desc { font-size: 1rem; }
            .demo-model-response { grid-template-columns: 1fr; }
        }

        /* Supporting Container & Pipeline Components */
        .badge-service {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.65rem;
            border-radius: 6px;
            background: color-mix(in srgb, var(--accent) 12%, transparent);
            color: var(--accent);
            border: 1px solid color-mix(in srgb, var(--accent) 25%, transparent);
        }
        .arch-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .arch-card {
            background: var(--sidebar-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.75rem;
            position: relative;
            transition: all 0.3s;
        }
        .arch-card:hover {
            border-color: var(--accent);
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        }
        .arch-port {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            background: color-mix(in srgb, var(--text-main) 8%, transparent);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.25rem 0.6rem;
            font-family: monospace;
            font-size: 0.8rem;
            color: var(--accent);
            font-weight: 700;
        }
        .pipeline-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 0.85rem;
            margin-top: 1.5rem;
        }
        .pipeline-item {
            background: var(--sidebar-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 0.85rem 1.1rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            transition: border-color 0.2s;
        }
        .pipeline-item:hover {
            border-color: var(--accent);
        }
        .pipeline-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: color-mix(in srgb, var(--accent) 18%, transparent);
            color: var(--accent);
            font-weight: 700;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
    </style>
</head>
<body data-theme="dark">
    <script>
        (function() {
            var theme = localStorage.getItem('chat-theme');
            if (theme) document.body.setAttribute('data-theme', theme);
        })();
    </script>

<!-- Navigation -->
<nav class="navbar navbar-expand-md navbar-landing fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url() ?>">
            <span class="gradient-text">myCoder</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#landingNav">
            <i class="fa-solid fa-bars text-light"></i>
        </button>
        <div class="collapse navbar-collapse" id="landingNav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item"><a class="nav-link <?= $activeNav === 'features' ? 'active' : '' ?>" href="<?= base_url('features') ?>">Features</a></li>
                <li class="nav-item"><a class="nav-link <?= $activeNav === 'how-it-works' ? 'active' : '' ?>" href="<?= base_url('how-it-works') ?>">How It Works</a></li>
                <li class="nav-item"><a class="nav-link <?= $activeNav === 'models' ? 'active' : '' ?>" href="<?= base_url('models') ?>">Models</a></li>
                <li class="nav-item"><a class="nav-link <?= $activeNav === 'docker-setup' ? 'active' : '' ?>" href="<?= base_url('docker-setup') ?>">Docker</a></li>
                <li class="nav-item"><a class="nav-link <?= $activeNav === 'faq' ? 'active' : '' ?>" href="<?= base_url('faq') ?>">FAQ</a></li>
                <?php if ($loggedIn): ?>
                <li class="nav-item ms-md-2">
                    <a class="btn btn-primary-landing btn-sm px-3 py-2" href="<?= base_url('chat') ?>">
                        <i class="fa-solid fa-comment me-1"></i> Go to Chat
                    </a>
                </li>
                <?php else: ?>
                <li class="nav-item ms-md-2">
                    <a class="btn btn-primary-landing btn-sm px-3 py-2" href="<?= base_url('login') ?>">
                        <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Sign In
                    </a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-landing btn-sm px-3 py-2" href="<?= base_url('register') ?>">
                        Get Started
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<?= $this->renderSection('content') ?>

<!-- Footer -->
<footer class="footer-landing">
    <div class="container-custom">
        <div class="mb-2">
            <?php if ($loggedIn): ?>
            <a href="<?= base_url('chat') ?>" class="mx-2">Chat</a>
            <a href="<?= base_url('logout') ?>" class="mx-2">Sign Out</a>
            <?php else: ?>
            <a href="<?= base_url('login') ?>" class="mx-2">Sign In</a>
            <a href="<?= base_url('register') ?>" class="mx-2">Register</a>
            <?php endif; ?>
            <a href="<?= base_url('features') ?>" class="mx-2">Features</a>
            <a href="<?= base_url('how-it-works') ?>" class="mx-2">How It Works</a>
            <a href="<?= base_url('models') ?>" class="mx-2">Models</a>
            <a href="<?= base_url('docker-setup') ?>" class="mx-2">Docker</a>
            <a href="<?= base_url('faq') ?>" class="mx-2">FAQ</a>
        </div>
        <p class="mb-0">&copy; <?= date('Y') ?> myCoder. MIT License. Built with CodeIgniter 4 &amp; PHP 8.3.</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleFaq(el) {
    el.classList.toggle('open');
    var answer = el.nextElementSibling;
    answer.classList.toggle('show');
}

function copyCode(btn) {
    var pre = btn.parentElement.querySelector('pre');
    var text = pre ? pre.textContent : '';
    navigator.clipboard.writeText(text.trim()).then(function() {
        var original = btn.innerHTML;
        btn.innerHTML = '<i class="fa-regular fa-check me-1"></i>Copied!';
        setTimeout(function() { btn.innerHTML = original; }, 2000);
    });
}
</script>

<?= $this->renderSection('scripts') ?>

</body>
</html>
