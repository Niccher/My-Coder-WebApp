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
        <h2 class="section-title text-center">Behind the Scenes</h2>
        <p class="section-subtitle text-center">Built with PHP 8.3 and CodeIgniter 4, designed for performance and reliability.</p>
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon blue"><i class="fa-solid fa-bolt"></i></div>
                <h5>Non-Blocking I/O</h5>
                <p>All upstream AI requests use <code>curl_multi</code> for parallel execution. Your prompt reaches every model simultaneously — total latency is the slowest single model, not the sum of all.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon purple"><i class="fa-solid fa-database"></i></div>
                <h5>Immutable Message History</h5>
                <p>Messages are stored with a strict <code>role</code> field (user/ai) and are never modified after creation. Each AI response is tagged with its source model name for full provenance.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon green"><i class="fa-solid fa-lock"></i></div>
                <h5>Encrypted at Rest</h5>
                <p>API keys are encrypted in the database using AES-256-CTR via CodeIgniter's encryption library. Decrypted only in memory at request time. The encryption key lives in your <code>.env</code> file only.</p>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
