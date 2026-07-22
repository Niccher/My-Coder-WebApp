<?= $this->extend('landing/layout') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Everything <span class="gradient-text">You Need</span></h1>
    <p>Compare, evaluate, and synthesize responses from the leading AI models — all through a single interface you control.</p>
</div>

<section>
    <div class="container-custom">
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon blue"><i class="fa-solid fa-layer-group"></i></div>
                <h5>Multi-Model Orchestration</h5>
                <p>Configure up to 6 AI models in parallel. Every prompt is sent to all configured models simultaneously using PHP's <code>curl_multi</code> for non-blocking HTTP requests. No sequential waiting — all models respond in parallel.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon purple"><i class="fa-solid fa-gem"></i></div>
                <h5>Master Model Evaluation</h5>
                <p>Designate a 7th slot as the Master Model. It reviews all responses, identifies inaccuracies, highlights the best answer, and provides a synthesized summary. System instructions prevent internal reasoning leakage.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon pink"><i class="fa-solid fa-people-group"></i></div>
                <h5>AI Personas</h5>
                <p>Create custom system instructions as reusable personas. Each conversation can be assigned a persona that shapes how the models respond. Perfect for role-specific interactions like &ldquo;code reviewer&rdquo; or &ldquo;technical writer.&rdquo;</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon green"><i class="fa-solid fa-folder-tree"></i></div>
                <h5>Conversation Management</h5>
                <p>Organize chats into folders, branch (fork) any message to explore alternative paths, and search your entire conversation history. Full CRUD operations via the REST API.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon orange"><i class="fa-solid fa-download"></i></div>
                <h5>Export &amp; Share</h5>
                <p>Export conversations in JSON, XML, YAML, or PDF. Share insights with your team or archive them for compliance. All exports preserve the full model response context.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon cyan"><i class="fa-solid fa-shield-halved"></i></div>
                <h5>Self-Hosted &amp; Private</h5>
                <p>Run on your own infrastructure via Docker. API keys are encrypted at rest using AES-256-CTR. Full data control — no third-party servers ever see your prompts or model responses.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon indigo"><i class="fa-solid fa-palette"></i></div>
                <h5>Three Visual Themes</h5>
                <p>Choose between Dark (default), Solarized, or White themes. Persisted in localStorage. The entire UI adapts seamlessly, including chat bubbles, sidebar, and settings modals.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon blue"><i class="fa-solid fa-code"></i></div>
                <h5>Syntax Highlighting</h5>
                <p>Code blocks in responses are highlighted using Prism.js with support for Python, JavaScript, PHP, CSS, and more. Markdown rendering via Marked.js for rich formatted output.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon purple"><i class="fa-solid fa-rotate-left"></i></div>
                <h5>Conversation Branching</h5>
                <p>Fork any message in a conversation to create an alternative thread. Each branch carries the full history up to that point, with all model responses re-evaluated in the new context.</p>
            </div>
        </div>
    </div>
</section>

<section class="section-dark text-center">
    <div class="container-custom">
        <h2 class="section-title">Ready to Try It?</h2>
        <p class="section-subtitle" style="margin-bottom: 1.5rem;">Spin up your own instance in minutes with Docker.</p>
        <a href="<?= base_url('docker-setup') ?>" class="btn btn-primary-landing btn-lg me-2 mb-2">
            <i class="fa-solid fa-server me-2"></i>View Docker Setup
        </a>
        <a href="<?= base_url('register') ?>" class="btn btn-outline-landing btn-lg mb-2">
            <i class="fa-solid fa-rocket me-2"></i>Get Started
        </a>
    </div>
</section>

<?= $this->endSection() ?>
