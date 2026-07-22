<?= $this->extend('landing/layout') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Supported <span class="gradient-text">AI Providers</span></h1>
    <p>Choose from 8 leading AI providers. Mix and match across slots to get the best of every world.</p>
</div>

<section>
    <div class="container-custom">
        <div class="models-grid" style="max-width: 800px; margin: 0 auto 3rem;">
            <div class="model-chip" style="font-size: 1rem; padding: 0.6rem 1.5rem;"><i class="fa-brands fa-google me-2"></i> Google Gemini</div>
            <div class="model-chip" style="font-size: 1rem; padding: 0.6rem 1.5rem;"><i class="fa-solid fa-microchip me-2"></i> DeepSeek</div>
            <div class="model-chip" style="font-size: 1rem; padding: 0.6rem 1.5rem;"><i class="fa-brands fa-x-twitter me-2"></i> xAI Grok</div>
            <div class="model-chip" style="font-size: 1rem; padding: 0.6rem 1.5rem;"><i class="fa-brands fa-openai me-2"></i> OpenAI</div>
            <div class="model-chip" style="font-size: 1rem; padding: 0.6rem 1.5rem;"><i class="fa-solid fa-brain me-2"></i> Moonshot Kimi</div>
            <div class="model-chip" style="font-size: 1rem; padding: 0.6rem 1.5rem;"><i class="fa-solid fa-bolt me-2"></i> MiniMax</div>
            <div class="model-chip" style="font-size: 1rem; padding: 0.6rem 1.5rem;"><i class="fa-solid fa-cloud me-2"></i> Groq</div>
            <div class="model-chip" style="font-size: 1rem; padding: 0.6rem 1.5rem;"><i class="fa-solid fa-cubes me-2"></i> OpenRouter</div>
        </div>

        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon blue"><i class="fa-brands fa-google"></i></div>
                <h5>Google Gemini</h5>
                <p>Access Google's latest Gemini models via the Gemini API. Supports text and multimodal prompts. Known for strong reasoning and broad knowledge across domains.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon purple"><i class="fa-solid fa-microchip"></i></div>
                <h5>DeepSeek</h5>
                <p>DeepSeek's family of models excels at mathematical reasoning, code generation, and technical problem solving with strong performance on benchmarks.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon pink"><i class="fa-brands fa-x-twitter"></i></div>
                <h5>xAI Grok</h5>
                <p>Grok by xAI delivers witty, real-time aware responses with a unique personality. Trained on web data including X (Twitter) for up-to-date knowledge.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon green"><i class="fa-brands fa-openai"></i></div>
                <h5>OpenAI</h5>
                <p>GPT-4 and GPT-4o models from OpenAI. Industry-leading performance on natural language, coding, and creative tasks. Supports function calling and structured outputs.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon orange"><i class="fa-solid fa-brain"></i></div>
                <h5>Moonshot Kimi</h5>
                <p>Kimi by Moonshot AI is optimized for long-context understanding and Chinese-language tasks, with strong performance on document analysis and summarization.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon cyan"><i class="fa-solid fa-bolt"></i></div>
                <h5>MiniMax</h5>
                <p>MiniMax provides efficient, high-performance language models with competitive latency and strong results on a variety of NLP benchmarks.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon indigo"><i class="fa-solid fa-cloud"></i></div>
                <h5>Groq</h5>
                <p>Groq offers ultra-low-latency inference via custom LPU hardware. Ideal for real-time applications with blazing fast token generation speeds.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon blue"><i class="fa-solid fa-cubes"></i></div>
                <h5>OpenRouter</h5>
                <p>OpenRouter provides a unified API to access dozens of models from multiple providers. Use it as a single endpoint for maximum model diversity.</p>
            </div>
        </div>
    </div>
</section>

<section class="section-dark text-center">
    <div class="container-custom">
        <h2 class="section-title">Slot Configuration</h2>
        <p class="section-subtitle">Up to 6 model slots + 1 optional Master Model slot.</p>
        <div style="max-width: 600px; margin: 0 auto;">
            <div style="background: var(--landing-card); border: 1px solid var(--landing-border); border-radius: 12px; padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center;" class="mb-2">
                <span><strong>Slots 1 &ndash; 6</strong> <span class="text-muted ms-2">Configure any provider per slot</span></span>
                <span class="model-chip" style="font-size: 0.8rem;">Regular Models</span>
            </div>
            <div style="background: linear-gradient(135deg, rgba(139,92,246,0.1), rgba(59,130,246,0.05)); border: 1px solid rgba(139,92,246,0.2); border-radius: 12px; padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                <span><strong>Slot 7</strong> <span class="text-muted ms-2">Receives all responses &amp; synthesizes</span></span>
                <span class="model-chip" style="font-size: 0.8rem; border-color: var(--landing-accent2);">Master Model</span>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
