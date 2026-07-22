<?= $this->extend('landing/layout') ?>

<?= $this->section('content') ?>

<!-- Hero -->
<section class="hero-section">
    <div class="container-custom">
        <div class="hero-badge">
            <i class="fa-solid fa-bolt"></i> v1.0 — Self-Hosted AI Orchestration
        </div>
        <h1 class="hero-title">
            Query <span class="gradient-text">Multiple AI Models</span><br>
            One Prompt. All Answers.
        </h1>
        <p class="hero-desc">
            Send a single prompt to Gemini, DeepSeek, Grok, OpenAI, Kimi, MiniMax, Groq, and OpenRouter simultaneously.
            Let the <strong>Master Model</strong> evaluate and synthesize the best answer — all in one place.
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

<!-- Quick Highlights -->
<section class="section-dark">
    <div class="container-custom text-center">
        <h2 class="section-title">Why myCoder?</h2>
        <p class="section-subtitle">Stop switching between AI tabs. Get every model's take in one place.</p>
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
