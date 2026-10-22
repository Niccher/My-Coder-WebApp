<?= $this->extend('landing/layout') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>How <span class="gradient-text">It Works</span></h1>
    <p>From a single prompt to a synthesized multi-model answer in four steps.</p>
</div>

<section>
    <div class="container-custom">
        <div class="steps-grid" style="margin-bottom: 3rem;">
            <div class="step-card">
                <div class="step-number">1</div>
                <h5>Configure Models</h5>
                <p>Add your API keys for the models you want to use. Assign each to one of 6 slots, or use all 8 supported providers. Each slot stores its provider, model name, and encrypted API key.</p>
            </div>
            <div class="step-card">
                <div class="step-number">2</div>
                <h5>Write Your Prompt</h5>
                <p>Type a question or task into the chat input. Optionally attach files (text is extracted and included as context — files are never stored in the database). Choose a persona for tailored system instructions.</p>
            </div>
            <div class="step-card">
                <div class="step-number">3</div>
                <h5>Parallel Execution</h5>
                <p>Your prompt is sent to every configured model at once using PHP's <code>curl_multi_*</code> functions. Each model receives the full conversation history, filtered to only its own previous responses, ensuring clean context.</p>
            </div>
            <div class="step-card">
                <div class="step-number">4</div>
                <h5>Review &amp; Synthesize</h5>
                <p>All responses are displayed side by side. If you've enabled the Master Model (slot 7), it reviews every response, identifies inaccuracies, highlights the best answer, and provides a synthesized summary.</p>
            </div>
        </div>

        <h3 class="text-center fw-bold mb-4">See It In Action</h3>
        <div class="demo-illustration">
            <div class="demo-prompt">
                <i class="fa-solid fa-user me-2" style="color: var(--landing-accent);"></i>
                <span style="color: var(--landing-text);">"Explain quantum computing in simple terms"</span>
            </div>
            <div class="demo-arrow"><i class="fa-solid fa-arrow-down"></i></div>
            <div class="demo-model-response">
                <div><span class="label"><i class="fa-brands fa-google"></i> Gemini</span> Offers a clear analogy using coins and probability...</div>
                <div><span class="label"><i class="fa-solid fa-microchip"></i> DeepSeek</span> Provides a technical breakdown with mathematical framing...</div>
                <div><span class="label"><i class="fa-brands fa-openai"></i> OpenAI</span> Gives a balanced overview with real-world applications...</div>
                <div><span class="label"><i class="fa-brands fa-x-twitter"></i> Grok</span> Delivers a witty, accessible explanation with metaphors...</div>
            </div>
            <div class="demo-arrow"><i class="fa-solid fa-arrow-down"></i></div>
            <div style="background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2); border-radius: 12px; padding: 1rem; margin-top: 1rem;">
                <i class="fa-solid fa-gem me-2" style="color: var(--landing-accent2);"></i>
                <strong>Master Model Synthesis:</strong> Combines the clarity of Gemini with the technical depth of DeepSeek, grounded by OpenAI's practical examples and Grok's accessible metaphors.
            </div>
        </div>
    </div>
</section>

<section class="section-dark">
    <div class="container-custom">
        <h2 class="section-title text-center">Containerized Architecture &amp; Supporting Services</h2>
        <p class="section-subtitle text-center">Powered by PHP 8.4 (8.4.27) and CodeIgniter 4.6.4, orchestrated into three production-grade Docker containers.</p>
        
        <div class="arch-grid">
            <div class="arch-card">
                <span class="arch-port">:80</span>
                <div class="feature-icon blue"><i class="fa-solid fa-server"></i></div>
                <h5>myCoder WebApp</h5>
                <span class="badge-service mb-3"><i class="fa-brands fa-php"></i> PHP 8.4.27 &bull; Apache 2.4</span>
                <p>The primary application container. Serves the web interface and versioned <code>/api/v1/</code> REST API on standard port 80. Features an automated startup entrypoint that verifies database readiness, runs CodeIgniter Spark migrations (<code>php spark migrate --all</code>), and provisions <code>writable/</code> permissions for sessions, cache, logs, and uploads.</p>
            </div>

            <div class="arch-card">
                <span class="arch-port">:3306</span>
                <div class="feature-icon purple"><i class="fa-solid fa-database"></i></div>
                <h5>MySQL 8.4 LTS Relational DB</h5>
                <span class="badge-service mb-3"><i class="fa-solid fa-hard-drive"></i> MySQL 8.4 &bull; Volume: mysql-data</span>
                <p>The persistent enterprise database store exposed on standard port 3306. Stores encrypted user credentials, API keys, conversations, personas, and folders. Configured with strict SQL modes and a dual-layer TCP healthcheck (<code>mysqladmin ping -h 127.0.0.1 && SELECT 1 FROM db_my_coder</code>) ensuring zero race conditions during cold boots.</p>
            </div>

            <div class="arch-card">
                <span class="arch-port">:8080</span>
                <div class="feature-icon green"><i class="fa-solid fa-terminal"></i></div>
                <h5>Dozzle Container Log Viewer</h5>
                <span class="badge-service mb-3"><i class="fa-brands fa-docker"></i> amir20/dozzle:latest &bull; Real-time</span>
                <p>Real-time web-based log streaming and resource monitor accessible on port 8080. Connects to the host's Docker socket in read-only mode to stream Apache access/error logs, PHP exceptions, and MySQL transaction logs without performance impact or host file footprint.</p>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-custom">
        <h2 class="section-title text-center">Behind the Scenes: Technical Highlights</h2>
        <p class="section-subtitle text-center">Engineered for security, concurrency, and self-hosted privacy.</p>
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon blue"><i class="fa-solid fa-bolt"></i></div>
                <h5>Non-Blocking Multi-Model I/O</h5>
                <p>All upstream AI requests use PHP's <code>curl_multi</code> interface for asynchronous execution. Prompts reach all 6 configured models simultaneously &mdash; your total wait time is governed by the single slowest model, not the cumulative sum.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon purple"><i class="fa-solid fa-network-wired"></i></div>
                <h5>Isolated Context Memory</h5>
                <p>When continuing a thread, each model is fed only its own prior responses alongside the user's prompt. Models never cross-contaminate each other's memories, preventing compound hallucinations.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon green"><i class="fa-solid fa-lock"></i></div>
                <h5>Encrypted at Rest (AES-256-CTR)</h5>
                <p>Third-party provider API keys are encrypted in MySQL using AES-256-CTR with OpenSSL. Keys are decrypted exclusively in memory when executing outbound API requests. The secret key is stored only in your local <code>.env</code> file.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon orange"><i class="fa-solid fa-code"></i></div>
                <h5>Strict RESTful API v1</h5>
                <p>Every client action in the modern chat interface communicates over a versioned <code>/api/v1/</code> REST API with standard HTTP semantics (POST 201 Created, PUT/PATCH for folder &amp; conversation updates, DELETE for purges).</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon cyan"><i class="fa-solid fa-shield-halved"></i></div>
                <h5>Container Self-Healing &amp; Auto-Migrations</h5>
                <p>The container entrypoint dynamically resolves database health over TCP, auto-runs all pending migrations, and provisions storage permissions before launching Apache, eliminating manual configuration steps.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon pink"><i class="fa-solid fa-file-code"></i></div>
                <h5>Privacy &amp; File Context Streaming</h5>
                <p>Files uploaded in chat are parsed in memory, converted into contextual text snippets, and streamed directly to your selected models. Raw files are never stored in the database or exposed to third parties.</p>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
