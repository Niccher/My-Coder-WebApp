<?= $this->extend('landing/layout') ?>

<?= $this->section('head') ?>
<style>
.faq-page-hero {
    text-align: center;
    padding: 8rem 1.5rem 2rem;
}
.faq-page-hero h1 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; }
.faq-page-hero p { color: var(--landing-muted); font-size: 1.1rem; max-width: 640px; margin: 0.5rem auto 0; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="faq-page-hero">
    <h1>Frequently Asked <span class="gradient-text">Questions</span></h1>
    <p>Everything you need to know about deploying and using myCoder.</p>
</div>

<section>
    <div class="container-custom" style="max-width: 780px; margin: 0 auto;">
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>What is myCoder?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>myCoder is a self-hosted, multi-model AI orchestration platform. You send one prompt and it queries up to 6 AI models in parallel (Gemini, DeepSeek, Grok, OpenAI, Kimi, MiniMax, Groq, OpenRouter). An optional Master Model then evaluates all responses and synthesizes the best answer. It's built with PHP 8.3 and CodeIgniter 4, and runs entirely on your own infrastructure via Docker.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>How do I get API keys for the models?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>You need to register for API access at each provider directly: <a href="https://makersuite.google.com/app/apikey" target="_blank">Google AI Studio</a> (Gemini), <a href="https://platform.openai.com/api-keys" target="_blank">OpenAI</a>, <a href="https://console.groq.com/keys" target="_blank">Groq</a>, <a href="https://openrouter.ai/keys" target="_blank">OpenRouter</a>, <a href="https://console.x.ai" target="_blank">xAI Console</a> (Grok), etc. Once obtained, add them securely in the myCoder settings panel — they are encrypted at rest using AES-256-CTR.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>Is myCoder free and open source?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Yes! myCoder is released under the MIT License. You can self-host it at no cost. The only costs are the API usage fees charged by your chosen AI providers. There are no subscription fees for the platform itself.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>Do I need to use all 8 providers?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Not at all. You can configure as few or as many models as you like across the 6 regular slots. If you only want to use one model, that works too. The Master Model (slot 7) is optional — disable it if you just want to see all raw responses side by side.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>How are my API keys stored?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>API keys are encrypted at rest in the database using CodeIgniter's encryption library (OpenSSL, AES-256-CTR mode). The encryption key is configured in your <code>.env</code> file. Keys are decrypted in memory only at request time and never logged or exposed.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>What are the minimum requirements to run myCoder?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>You need a Linux server (or any host with Docker) with at least 1 GB RAM and Docker Engine 24+ with Docker Compose v2+. The application runs on PHP 8.3 with Apache inside the container. For a small team, 2 GB RAM and 2 CPU cores is recommended to handle parallel API requests smoothly.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>Can I use myCoder without Docker?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Yes. Since myCoder is a standard PHP application, you can deploy it directly on any Apache/Nginx server with PHP 8.3+ and MySQL 8.4. Clone the repo, run <code>composer install</code>, configure your <code>.env</code> file, point your web server's document root to the <code>public/</code> directory, and run <code>php spark migrate --all</code>. However, Docker is the recommended and tested deployment method.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>How do I update myCoder to the latest version?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Pull the latest changes: <code>git pull</code>, rebuild the images: <code>docker compose build --no-cache</code>, and restart: <code>docker compose up -d</code>. New database migrations run automatically via the entrypoint script.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>What happens to my data if I restart the containers?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>All persistent data (conversations, user accounts, API keys, personas, folders) is stored in MySQL with a named Docker volume (<code>mysql-data</code>). Restarting or rebuilding containers will not affect your data as long as the volume is not removed. Sessions are stored on the application container's writable directory and will reset on restart, requiring re-login.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>Can I contribute to myCoder?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Absolutely! myCoder is open source under the MIT License. Contributions are welcome. Check the <code>CONTRIBUTING.md</code> file in the repository for coding standards (PHP CS Fixer), testing (PHPUnit), and pull request guidelines.</p>
            </div>
        </div>
    </div>
</section>

<section class="section-dark text-center">
    <div class="container-custom">
        <h2 class="section-title">Still Have Questions?</h2>
        <p class="section-subtitle" style="margin-bottom: 1.5rem;">Get started and explore the app, or sign in to your account.</p>
        <?php if ($loggedIn): ?>
        <a href="<?= base_url('chat') ?>" class="btn btn-primary-landing btn-lg">
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
