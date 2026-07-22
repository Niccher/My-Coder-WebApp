<?php

namespace App\Controllers;

class Landing extends BaseController
{
    private function viewData(string $page, string $title, string $description, array $extra = []): array
    {
        return array_merge([
            'title'       => $title,
            'description' => $description,
            'loggedIn'    => auth()->loggedIn(),
            'activeNav'   => $page,
            'canonical'   => $page === 'home' ? '' : $page,
        ], $extra);
    }

    public function index(): string
    {
        return view('landing/index', $this->viewData('home',
            'myCoder — Multi-Model AI Chat Orchestration Platform',
            'Send a single prompt to multiple AI models simultaneously — Gemini, DeepSeek, Grok, OpenAI, Kimi, MiniMax, Groq, OpenRouter — and let the Master Model synthesize the best answer.'
        ));
    }

    public function features(): string
    {
        return view('landing/features', $this->viewData('features',
            'Features — myCoder Multi-Model AI Chat Platform',
            'Explore all features: multi-model orchestration, master model evaluation, AI personas, conversation management, export options, and self-hosted privacy.'
        ));
    }

    public function howItWorks(): string
    {
        return view('landing/how_it_works', $this->viewData('how-it-works',
            'How It Works — myCoder Multi-Model AI Orchestration',
            'Learn how myCoder works: configure models, write a prompt, parallel execution across 6+ AI models, and get a synthesized answer from the Master Model.'
        ));
    }

    public function models(): string
    {
        return view('landing/models', $this->viewData('models',
            'Supported AI Models — myCoder',
            'myCoder supports 8 AI providers: Google Gemini, DeepSeek, xAI Grok, OpenAI, Moonshot Kimi, MiniMax, Groq, and OpenRouter. Mix and match across 6 slots.'
        ));
    }

    public function dockerSetup(): string
    {
        return view('landing/docker_setup', $this->viewData('docker-setup',
            'Docker Setup — Deploy myCoder with Docker Compose',
            'Deploy myCoder on your own infrastructure with Docker. Includes MySQL 8.4, phpMyAdmin, auto-migrations, and encrypted API key storage.'
        ));
    }

    public function faq(): string
    {
        return view('landing/faq', $this->viewData('faq',
            'FAQ — myCoder Multi-Model AI Chat Platform',
            'Frequently asked questions about myCoder: deployment, API keys, privacy, requirements, updates, and more.'
        ));
    }
}
