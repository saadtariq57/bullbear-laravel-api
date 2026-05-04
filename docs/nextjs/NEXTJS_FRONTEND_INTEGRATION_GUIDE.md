# Next.js Frontend Integration Guide (RichTV API)

This doc is the practical “what the frontend needs” guide for integrating a **Next.js (TypeScript)** app with this Laravel backend.

Also see:

- `docs/BACKEND_API_REFERENCE.md` (endpoint inventory + auth groups)
- `docs/nextjs/api-types.ts` (TypeScript types for payloads/responses)

## 0) Choose your auth mode (important)

There are two realistic ways to authenticate from Next.js:

- **Cookie + session (Sanctum “SPA mode”)**: best if you want to reuse Laravel’s built-in `/login` + session and call `auth:sanctum` APIs via cookies.
- **Bearer token**: best if you want truly stateless auth (but this repo does not currently expose a token-issuing endpoint in `routes/api.php`).

This guide focuses on **cookie + session** because that’s what this backend already uses.

## 1) Environment variables (frontend)

Recommended frontend env keys:

- `NEXT_PUBLIC_API_BASE_URL`  
  Example: `https://richtv.io` (do **not** include `/api` here)

If you will use cookie/session auth across domains, you’ll also need:

- `NEXT_PUBLIC_APP_URL` (your Next.js origin)

## 2) Base URL and API paths

- All routes are under: `{{API_BASE_URL}}/api/*`
- Example: `GET {{API_BASE_URL}}/api/user-feed`

## 3) Authentication & credentials (Sanctum)

This backend uses **Laravel Sanctum** and includes `EnsureFrontendRequestsAreStateful` in the `api` middleware group (`app/Http/Kernel.php`).

### Option A (recommended if same-site / same parent domain): Cookie + session auth

Frontend must send cookies:

- `fetch`: `credentials: 'include'`
- `axios`: `withCredentials: true`

You must ensure:

- Backend CORS allows your Next.js origin
- Cookies are issued with correct domain/samesite/secure settings for your deployment
- `SANCTUM_STATEFUL_DOMAINS` includes your Next.js domain (see `config/sanctum.php`)

### Option B: Bearer token auth

If you want a purely stateless cross-domain Next.js frontend, you’ll typically add:

- “issue token” endpoint (login → returns `token`)
- then call APIs with `Authorization: Bearer <token>`

**Important**: this repo’s `routes/api.php` does not currently include a dedicated token-issuing endpoint.

## 4) API Key auth (automation endpoints)

Some endpoints use `api.key` middleware. Frontend generally won’t call them.

If needed, send:

- `API-Key: <AUTOMATION_API_KEY>`

## 5) Common request patterns

### JSON requests

- `Content-Type: application/json`

### FormData / file uploads

Some endpoints (ex: `POST /api/create-post` with photos) are called with `FormData` in the legacy frontend.

Notes:

- Let the browser set the multipart boundary:
  - Don’t manually set `Content-Type` when sending `FormData`.
- Keep `withCredentials: true` if route is protected by Sanctum.

## 5.5) Local development runbook (cross-origin, recommended)

This is the exact setup for:

- **Next.js**: `http://localhost:3000`
- **Laravel**: `http://localhost:8000`

### Backend checklist (Laravel)

- **CORS paths must include the web auth routes**, not just `api/*`:
  - `api/*`
  - `sanctum/csrf-cookie`
  - `login`
  - `logout`
  - (optional) `register`

This repo’s `config/cors.php` is expected to include those paths for cross-origin login.

- **CORS must allow credentials**:
  - `supports_credentials` must be `true`
  - `allowed_origins` must explicitly include `http://localhost:3000`

After any CORS/session/sanctum config changes, run:

- `php artisan config:clear`
- `php artisan cache:clear`
  - and restart `php artisan serve`

### Frontend checklist (Next.js)

#### A) Use one hostname consistently

- Use **only `localhost`** everywhere, or **only `127.0.0.1`** everywhere.
- Do **not** mix `localhost` and `127.0.0.1` between frontend and backend URLs or cookies/CSRF will behave inconsistently.

#### B) Axios setup (recommended for Sanctum SPA mode)

Axios can automatically read the `XSRF-TOKEN` cookie and send `X-XSRF-TOKEN` header.

Set once:

- `baseURL = "http://localhost:8000"`
- `withCredentials = true`
- `xsrfCookieName = "XSRF-TOKEN"`
- `xsrfHeaderName = "X-XSRF-TOKEN"`

#### C) Request sequence (prevents “CSRF token mismatch” / 419)

1. `GET http://localhost:8000/sanctum/csrf-cookie`
2. `POST http://localhost:8000/login` (email/password)
3. Call protected endpoints like `GET http://localhost:8000/api/userdata`

If you skip step (1), your first POST typically fails with **419 CSRF token mismatch**.

#### D) If you use `fetch`

You must include credentials, and you’ll typically need to manually forward `X-XSRF-TOKEN`. Using axios for auth requests is much simpler.

## 6) Error handling expectations

This backend is not fully uniform in error shapes. You should normalize errors client-side.

Common patterns observed:

- `{ error: string }` (example: chatbot failures)
- `{ success: false, message?: string }` (login JSON failures)
- Laravel validation errors with status `422`:
  - sometimes `{ message: string }`
  - sometimes Laravel default validation structure (depends on controller)

Frontend recommendation:

- Treat any non-2xx as failure
- Prefer displaying:
  - `err.response.data.error` (if exists)
  - else `err.response.data.message` (if exists)
  - else fallback `"Something went wrong"`

## 7) “What data shapes should I use in TypeScript?”

Use the shared typings file:

- `docs/nextjs/api-types.ts`

It includes:

- `FeedPost`, `FeedComment`, `Reaction`, `Poll`, `Watchlist`, `Chatbot*` types
- A high-signal `ApiEndpoints` map you can use to build a typed API client

## 8) Frontend feature map → endpoints

### Feed (home/profile/group)

- `GET /api/user-feed`
- `GET /api/user-profile/{userName?}`
- `GET /api/user-group/{groupId}`
- `GET /api/singlePost/{singlePostID}`

### Reactions (post + comment)

- `GET /api/reaction-types`
- `POST /api/add-or-update-reaction` (post or comment)
- `POST /api/remove-reaction` (post or comment)

### Comments

- `GET /api/posts/{postId}/comments`
- `POST /api/submit-comment`
- `POST /api/edit-comment`
- `POST /api/delete-comment`

### Watchlists

- `GET /api/watchlist/?user_id=...`
- `GET /api/watchlist/featured`
- `GET /api/watchlist/symbols/{watchlistId}`
- `GET /api/watchlist/editWatchlistData/{watchlistId}`
- `POST /api/watchlist/symbol`
- `PUT /api/watchlist/update/{watchlistId}`
- `PUT /api/watchlist/update-positions`
- `PUT /api/watchlist/update-privacy`
- `DELETE /api/watchlist/symbol?id=...&watchlist_id=...`
- `DELETE /api/watchlist/deletewatchlist?id=...`
- `POST /api/watchlist/copyWatchlist`

### Chatbot

- `GET /api/chatbot/conversations`
- `GET /api/chatbot/conversations/{conversationId}/messages`
- `POST /api/chatbot/query`

## 9) One recommended Next.js API client setup (shape, not codebase)

Implement:

- `api.get(path, { params })`
- `api.post(path, body)`
- `api.upload(path, formData)`

And ensure:

- `baseURL = NEXT_PUBLIC_API_BASE_URL`
- `withCredentials = true` (if using cookie/session)

## 10) Troubleshooting (copy/paste symptoms)

### “No 'Access-Control-Allow-Origin' header … /login”

Cause: CORS middleware isn’t being applied to `/login` because `config/cors.php` `paths` does not include it.

Fix: add `login` (and `logout`) to `paths`, then `php artisan config:clear` and restart server.

### “CSRF token mismatch.” (419)

Cause: You didn’t call `/sanctum/csrf-cookie` first, or you aren’t sending cookies (`withCredentials` / `credentials: 'include'`), or you mixed `localhost` with `127.0.0.1`.

Fix:

- Call `GET /sanctum/csrf-cookie` before login
- Ensure cookies are being stored for `http://localhost:8000`
- Use axios XSRF settings (or manually forward `X-XSRF-TOKEN` with fetch)
- Use `localhost` consistently

### “Invalid request (Unsupported SSL request)” in `php artisan serve`

Cause: Something is trying to speak **HTTPS** to a plain **HTTP** server (for example `https://localhost:8000`).

Fix: use `http://localhost:8000` for the local backend unless you’ve set up local TLS termination.

