<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'myCoder | Authentication' ?></title>
    <meta name="robots" content="noindex, follow">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('favicon.png') ?>">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- App theme CSS -->
    <link rel="stylesheet" href="<?= base_url('css/chat.css') ?>">

    <style>
        html, body {
            height: auto !important;
            min-height: 100% !important;
            overflow-x: hidden !important;
            overflow-y: auto !important;
        }
        .auth-navbar {
            background: color-mix(in srgb, var(--bg-dark) 85%, transparent);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
        }
        .auth-navbar .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            background: linear-gradient(135deg, var(--accent), var(--accent2), #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .auth-navbar .nav-link {
            color: var(--text-muted);
            font-weight: 500;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            transition: all 0.2s;
            font-size: 0.9rem;
        }
        .auth-navbar .nav-link:hover {
            color: var(--text-main);
            background: color-mix(in srgb, var(--text-main) 5%, transparent);
        }
        .auth-navbar .btn-outline-landing {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 0.4rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .auth-navbar .btn-outline-landing:hover {
            background: color-mix(in srgb, var(--text-main) 5%, transparent);
        }

        .auth-page {
            min-height: calc(100vh - 116px);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-dark);
            padding: 3rem 1.5rem;
        }

        .auth-card {
            width: 100%;
            max-width: 460px;
            background-color: var(--sidebar-bg);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.4s ease-out;
            overflow: hidden;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-card-header {
            padding: 2rem 2rem 0.5rem;
            text-align: center;
        }
        .auth-card-header .logo-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
            margin-bottom: 0.75rem;
        }
        .auth-card-header h4 {
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: var(--text-main);
        }
        .auth-card-header p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin: 0;
        }

        .auth-card-body {
            padding: 1.25rem 2rem 2rem;
        }

        .auth-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            border-radius: 10px;
            padding: 0.7rem 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-size: 0.9rem;
        }
        .auth-input:focus {
            background-color: var(--input-bg);
            color: var(--text-main);
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem color-mix(in srgb, var(--accent) 25%, transparent);
            outline: none;
        }
        .auth-input::placeholder { color: var(--text-muted); opacity: 0.6; }
        .auth-input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px var(--input-bg) inset !important;
            -webkit-text-fill-color: var(--text-main) !important;
        }

        .auth-btn {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-weight: 600;
            font-size: 0.95rem;
            width: 100%;
            transition: all 0.2s;
        }
        .auth-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px color-mix(in srgb, var(--accent) 35%, transparent);
            color: #fff;
        }
        .auth-btn:active { transform: translateY(0); }

        .auth-link {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .auth-link:hover { color: color-mix(in srgb, var(--accent) 70%, white); text-decoration: underline; }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-muted);
            font-size: 0.8rem;
            margin: 1.25rem 0;
        }
        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        .auth-footer {
            border-top: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
            background: var(--input-bg);
        }
        .auth-footer a { color: var(--text-muted); }
        .auth-footer a:hover { color: var(--accent); }

        .alert-custom {
            border-radius: 10px;
            border: none;
            font-size: 0.85rem;
            padding: 0.6rem 1rem;
        }

        .form-label-custom {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.35rem;
        }

        .input-group-custom .input-group-text {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-right: none;
            color: var(--text-muted);
            border-radius: 10px 0 0 10px;
            padding: 0.7rem 0.9rem;
        }
        .input-group-custom .auth-input {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        script#theme-init { display: none; }
    </style>
</head>
<body data-theme="dark">
    <script id="theme-init">
        (function() {
            var theme = localStorage.getItem('chat-theme');
            if (theme) document.body.setAttribute('data-theme', theme);
        })();
    </script>

    <nav class="navbar navbar-expand-sm auth-navbar">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fa-solid fa-bolt me-1" style="-webkit-text-fill-color: initial; color: var(--accent);"></i> myCoder
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="<?= base_url() ?>" class="nav-link d-none d-sm-inline"><i class="fa-solid fa-house me-1"></i>Home</a>
                <a href="<?= base_url('features') ?>" class="nav-link d-none d-sm-inline">Features</a>
                <a href="<?= base_url('faq') ?>" class="nav-link d-none d-sm-inline">FAQ</a>
                <?php if (service('uri')->getPath() !== 'login'): ?>
                <a href="<?= base_url('login') ?>" class="btn-outline-landing btn-sm px-3 py-1">
                    <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Sign In
                </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-card-header">
                <?= $this->renderSection('card-header') ?>
            </div>
            <div class="auth-card-body">
                <?= $this->renderSection('main') ?>
            </div>
        </div>
    </div>

    <div class="auth-footer">
        <div class="container">
            <span>&copy; <?= date('Y') ?> myCoder &mdash; MIT License &bull; Built with CodeIgniter 4 &amp; PHP 8.3</span>
            <span class="d-none d-sm-inline"> &bull; </span>
            <a href="<?= base_url() ?>" class="d-none d-sm-inline">Home</a>
            <span class="d-none d-sm-inline"> &bull; </span>
            <a href="<?= base_url('features') ?>" class="d-none d-sm-inline">Features</a>
            <span class="d-none d-sm-inline"> &bull; </span>
            <a href="<?= base_url('faq') ?>" class="d-none d-sm-inline">FAQ</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
