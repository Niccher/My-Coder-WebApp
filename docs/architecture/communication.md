# Architecture: Communication & Sequence Flows

## 1. Inter-Service Communication Table

| Source | Destination | Protocol / Transport | Authentication | Base URL / Address | Purpose |
|---|---|---|---|---|---|
| **Browser Client** | `my-coder-webapp` | HTTP/1.1 (JSON / AJAX) | Shield Session Cookie + `X-CSRF-TOKEN` | `http://<host>/api/v1/` | Chat prompts, settings, conversation retrieval |
| **Browser Client** | `shared-dozzle` | HTTP/1.1 (WebSockets / SSE) | None (LAN access) | `http://<host>:8080/` | Container log streaming |
| `my-coder-webapp` | `shared-mysql` | TCP (MySQL Wire Protocol) | Native MySQL credentials (`root`) | `mysql:3306` | Relational data persistence & migrations |
| `my-coder-webapp` | **Google Gemini** | HTTPS REST | Query Parameter API Key | `https://generativelanguage.googleapis.com` | Model inference & reasoning |
| `my-coder-webapp` | **OpenAI** | HTTPS REST | `Bearer <API_KEY>` Header | `https://api.openai.com/v1/` | Model inference |
| `my-coder-webapp` | **DeepSeek** | HTTPS REST | `Bearer <API_KEY>` Header | `https://api.deepseek.com/v1/` | Model inference & reasoning |
| `my-coder-webapp` | **xAI Grok** | HTTPS REST | `Bearer <API_KEY>` Header | `https://api.x.ai/v1/` | Model inference |

---

## 2. Multi-Model Chat Execution Sequence

The core flow of `POST /api/v1/chat` illustrates how user prompts fan out in parallel and get synthesized:

```mermaid
sequenceDiagram
    autonumber
    actor User as Browser User
    participant App as ChatController (:80)
    participant DB as MySQL (:3306)
    participant Slot1 as Gemini (Slot 1)
    participant Slot2 as DeepSeek (Slot 2)
    participant Slot3 as Grok (Slot 3)
    participant Master as Master Model (Slot 7)

    User->>App: POST /api/v1/chat { prompt, conversation_id?, persona_id?, file_context? }
    App->>DB: Verify Shield Auth & retrieve user's encrypted slots
    App->>DB: Decrypt API keys in memory (AES-256-CTR)
    App->>DB: Insert User Message into `messages` table

    Note over App,Slot3: Parallel Fan-Out via PHP curl_multi
    par Query Slot 1
        App->>Slot1: POST generateContent (Prompt + History + System Prompt)
        Slot1-->>App: Return Gemini response
    and Query Slot 2
        App->>Slot2: POST chat/completions (Prompt + History)
        Slot2-->>App: Return DeepSeek response
    and Query Slot 3
        App->>Slot3: POST chat/completions (Prompt + History)
        Slot3-->>App: Return Grok response
    end

    App->>DB: Persist 3 raw AI responses into `messages` table

    Note over App,Master: Sequential Synthesis
    App->>Master: POST chat/completions (All 3 responses + synthesis rubric)
    Master-->>App: Return master evaluation & ranked ranking
    App->>DB: Persist Master Model evaluation into `messages` table

    App-->>User: 200 OK JSON { conversation_id, messages: [...] }
    User->>User: Marked.js + Prism renders side-by-side tabs + Master evaluation
```
