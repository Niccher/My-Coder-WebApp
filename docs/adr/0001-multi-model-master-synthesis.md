# ADR 0001: Multi-Model Parallel Inference and Master Synthesis

## Status
**Accepted**

## Context
Developers querying large language models often struggle to evaluate which provider produces the optimal code or architecture response. Querying models sequentially introduces unacceptable latency (3 models $\times$ 10s = 30s minimum wait).

## Decision
1. **Parallel Execution via `curl_multi`**:
   The application dispatches user prompts simultaneously to all configured regular model slots (Slots 1–3) using non-blocking multi-curl sockets.
2. **Master Model Synthesis (Slot 4)**:
   Once regular model responses are collected, a dedicated Master Model (e.g. Gemini 2.5 Pro / GPT-4o) evaluates all 3 responses, critiques strengths and weaknesses, and produces an authoritative synthesized code answer.

## Consequences
- **Positive**: Total latency equals the slowest single model rather than the sum of all models.
- **Positive**: Provides objective comparison and peer review across distinct AI model families.
- **Negative**: High concurrent outbound network requests; requires timeout handling per slot.
