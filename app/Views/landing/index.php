<?= $this->extend('landing/layout') ?>

<?= $this->section('content') ?>

<!-- Hero -->
<section class="hero-section">
    <div class="container-custom">
        <div class="hero-badge">
            <i class="fa-solid fa-cube me-1"></i> v1.1 Production Release — PHP 8.4 &bull; MySQL 8.4 &bull; Dozzle Log Viewer
        </div>
        <h1 class="hero-title">
            Query <span class="gradient-text">Multiple AI Models</span><br>
            One Prompt. All Answers.
        </h1>
        <p class="hero-desc">
            Send a single prompt to Gemini, DeepSeek, Grok, OpenAI, Kimi, MiniMax, Groq, and OpenRouter simultaneously.
            Synthesized by an intelligent <strong>Master Model</strong> and backed by a hardened 3-tier container architecture.
        </p>
        <div class="hero-actions">
            <?php if ($loggedIn): ?>
            <a href="<?= base_url('chat') ?>" class="btn btn-primary-landing me-2 mb-2">
                <i class="fa-solid fa-comment me-2"></i>Go to Chat
            </a>
            <?php else: ?>
            <a href="<?= base_url('register') ?>" class="btn btn-primary-landing me-2 mb-2">
                <i class="fa-solid fa-rocket me-2"></i>Get Started Free
            </a>
            <?php endif; ?>
            <a href="<?= base_url('docker-setup') ?>" class="btn btn-outline-landing me-2 mb-2">
                <i class="fa-solid fa-server me-2"></i>Docker Architecture
            </a>
            <a href="<?= base_url('features') ?>" class="btn btn-outline-landing mb-2">
                <i class="fa-solid fa-chevron-down me-2"></i>Explore Features
            </a>
        </div>
        <div class="hero-models">
            <span><i class="fa-brands fa-google me-1"></i> Gemini</span>
            <span><i class="fa-solid fa-microchip me-1"></i> DeepSeek</span>
            <span><i class="fa-brands fa-x-twitter me-1"></i> Grok</span>
            <span><i class="fa-brands fa-openai me-1"></i> OpenAI</span>
            <span><i class="fa-solid fa-brain me-1"></i> Kimi</span>
            <span><i class="fa-solid fa-bolt me-1"></i> MiniMax</span>
            <span><i class="fa-solid fa-cloud me-1"></i> Groq</span>
            <span><i class="fa-solid fa-cubes me-1"></i> OpenRouter</span>
        </div>
    </div>
</section>

<!-- 3-Tier Container Architecture Highlights -->
<section class="section-dark">
    <div class="container-custom">
        <div class="text-center mb-5">
            <h2 class="section-title">Production-Grade 3-Tier Architecture</h2>
            <p class="section-subtitle">Orchestrated with Docker Compose on an isolated bridge network, automated by a 13-stage deployment pipeline.</p>
        </div>
        <div class="arch-grid">
            <div class="arch-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge-service bg-web"><i class="fa-solid fa-server me-1"></i> Web Tier</span>
                    <span class="arch-port">:80 / HTTP</span>
                </div>
                <h4 style="font-weight: 700; margin-bottom: 0.5rem;">my-coder-webapp</h4>
                <p style="color: var(--landing-muted); font-size: 0.95rem; line-height: 1.6;">
                    PHP 8.4.27 runtime with Apache and CodeIgniter 4.6.4. Executes concurrent AI API requests via <code>curl_multi</code>, manages sessions, and delivers reactive chat views.
                </p>
                <div style="font-size: 0.85rem; color: #38bdf8;">
                    <i class="fa-solid fa-check-circle me-1"></i> Auto-migrating entrypoint &bull; Strict writable permissions
                </div>
            </div>
            <div class="arch-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge-service bg-db"><i class="fa-solid fa-database me-1"></i> Database</span>
                    <span class="arch-port">:3306 / TCP</span>
                </div>
                <h4 style="font-weight: 700; margin-bottom: 0.5rem;">shared-mysql</h4>
                <p style="color: var(--landing-muted); font-size: 0.95rem; line-height: 1.6;">
                    Official MySQL 8.4 LTS container with persistent named volume storage (<code>mysql-data</code>), utf8mb4 collation, and built-in TCP socket healthcheck probes.
                </p>
                <div style="font-size: 0.85rem; color: #4ade80;">
                    <i class="fa-solid fa-shield-halved me-1"></i> AES-256 encrypted API keys &bull; Isolated bridge network
                </div>
            </div>
            <div class="arch-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge-service bg-log"><i class="fa-solid fa-chart-line me-1"></i> Observability</span>
                    <span class="arch-port">:8080 / HTTP</span>
                </div>
                <h4 style="font-weight: 700; margin-bottom: 0.5rem;">shared-dozzle</h4>
                <p style="color: var(--landing-muted); font-size: 0.95rem; line-height: 1.6;">
                    Real-time container log viewer connected to <code>/var/run/docker.sock</code> (read-only). Stream WebApp access logs, PHP stack traces, and MySQL queries from any browser.
                </p>
                <div style="font-size: 0.85rem; color: #fbbf24;">
                    <i class="fa-solid fa-bolt me-1"></i> Zero-config log tailing &bull; CPU & memory stats
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Highlights -->
<section>
    <div class="container-custom text-center">
        <h2 class="section-title">Why myCoder?</h2>
        <p class="section-subtitle">Stop switching between AI tabs. Get every model's take in one unified dashboard.</p>
        <div class="highlight-grid">
            <div class="highlight-card">
                <div class="num blue">6</div>
                <p>Parallel model slots</p>
            </div>
            <div class="highlight-card">
                <div class="num purple">+1</div>
                <p>Master evaluator slot</p>
            </div>
            <div class="highlight-card">
                <div class="num pink">8</div>
                <p>Supported AI providers</p>
            </div>
            <div class="highlight-card">
                <div class="num green">100%</div>
                <p>Self-hosted & private</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="<?= base_url('features') ?>" class="btn btn-outline-landing">View All Features <i class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>

<!-- Brief How It Works -->
<section>
    <div class="container-custom">
        <h2 class="section-title text-center">How It Works</h2>
        <p class="section-subtitle text-center">From prompt to synthesis in four simple steps.</p>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h5>Configure Models</h5>
                <p>Add your API keys for the models you want to use. Assign each to one of 6 slots.</p>
            </div>
            <div class="step-card">
                <div class="step-number">2</div>
                <h5>Write Your Prompt</h5>
                <p>Type a question or task. Optionally attach files and choose a persona.</p>
            </div>
            <div class="step-card">
                <div class="step-number">3</div>
                <h5>Parallel Execution</h5>
                <p>Your prompt is sent to every configured model at once using non-blocking HTTP.</p>
            </div>
            <div class="step-card">
                <div class="step-number">4</div>
                <h5>Get the Best Answer</h5>
                <p>The Master Model reviews all outputs, flags inaccuracies, and synthesizes.</p>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="<?= base_url('how-it-works') ?>" class="btn btn-outline-landing">See Detailed Walkthrough <i class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section-dark text-center">
    <div class="container-custom">
        <h2 class="section-title">Ready to Get Started?</h2>
        <p class="section-subtitle" style="margin-bottom: 1.5rem;">Deploy with Docker in minutes and take control of your AI workflows.</p>
        <?php if ($loggedIn): ?>
        <a href="<?= base_url('chat') ?>" class="btn btn-primary-landing btn-lg me-2 mb-2">
            <i class="fa-solid fa-comment me-2"></i>Go to Chat
        </a>
        <?php else: ?>
        <a href="<?= base_url('register') ?>" class="btn btn-primary-landing btn-lg me-2 mb-2">
            <i class="fa-solid fa-rocket me-2"></i>Create Free Account
        </a>
        <a href="<?= base_url('login') ?>" class="btn btn-outline-landing btn-lg mb-2">
            <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Sign In
        </a>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>
