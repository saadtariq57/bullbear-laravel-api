# RichTV Backend API — Deep Reference (Next.js Contract)

This document is the **deep contract** for the RichTV Laravel backend: **every endpoint**, its auth, validation rules, request/response shape, status codes, and noteworthy side effects.

It complements:

- `docs/BACKEND_API_REFERENCE.md` (high-level inventory)
- `docs/nextjs/NEXTJS_FRONTEND_INTEGRATION_GUIDE.md` (Next.js runbook + troubleshooting)
- `docs/nextjs/api-types.ts` (TypeScript types)

---

## Base URL

- Local dev example: `http://localhost:8000`
- API prefix: `/api`

---

## Auth & CSRF (must read)

### Session auth (web routes) + CSRF cookie

These are required for “Sanctum SPA mode” (cookie/session auth):

- `GET /sanctum/csrf-cookie`
  - Sets `XSRF-TOKEN` cookie.
- `POST /login`
  - Creates Laravel session.
- `POST /logout`
  - Destroys session.

### API auth groups in `routes/api.php`

- **Public**: no auth
- **Sanctum**: `auth:sanctum` (requires session cookie or bearer token)
- **API key**: `api.key` (requires `API-Key` header)

### API key middleware details

Middleware: `app/Http/Middleware/ApiKeyAuth.php`

- Header: `API-Key: <value>`
- Compared to: `config('app.AUTOMATION_API_KEY')`
- Failure:
  - Missing header → `401` with `{ success: false, error: "API key required. Please provide API-Key header." }`
  - Wrong header → `401` with `{ success: false, error: "Invalid API key." }`

---

## Common response patterns

- Validation failures typically return `422` (Laravel validation).
- Many controllers return `{ message: string }` on success.
- Some endpoints return raw arrays or paginated objects; treat response shape as potentially additive.

---

## Endpoints (deep details)

> Source: `routes/api.php` + controller inspection.

### Auth helpers

#### `GET /api/check-login` (public)

Returns:

- `200` `{ loggedIn: boolean }`

#### `POST /api/check-username-availability` (public)

Controller: `App\Http\Controllers\Auth\RegisterController@checkUsernameAvailability`

Body validation:

- `username`: required, string, alphanumeric regex, max 255

Returns:

- `200` `{ available: boolean, requestedUsername: string }`
- Validation failure: `{ message: string, error: true }`

---

## Watchlists (`/api/watchlist/*`)

Controller: `app/Http/Controllers/WatchlistController.php`

### `GET /api/watchlist?user_id={id}` (public route, but behaves differently when authenticated)

Validation:

- `user_id`: required, integer, exists `users.id`

Behavior:

- Applies **user-level** privacy via `users.watchlists_privacy` (`Everyone` / `Followers` / `Private`)
- Further filters **individual watchlists** via `watchlist.who_can_view` (supports: Everyone, Followers, LoggedIn, Pro, OnlyMe/Private)
- If requested user has no watchlists, may fall back to **featured** watchlists (limit 3)
- Attaches `quote` + `news` onto each symbol (external APIs)

Returns:

- `200` `{ watchlistDetails: UserWatchlist[], hasUserWatchlist: boolean }`
- `403` `{ error: "Unauthorized access.", message: string }`
- `404` `{ error: "User not found." }`
- `500` `{ error: string, message: string, file: string, line: number }`

Notes:

- Quotes fetched from `env('STOCKS_API_URL') . "/api/quotes?symbols=SYM1,SYM2"`
- News fetched via WordPress tags API (`config('services.wordpresstags.api_url')`)

### `GET /api/watchlist/featured`

Returns:

- `200` `{ watchlistDetails: UserWatchlist[] }`

### `GET /api/watchlist/symbols/{watchlistId}`

Behavior:

- Loads watchlist + symbols (`getWatchListAllData`)
- Fetches quotes + news, attaches to symbol

Returns:

- `200` `UserWatchlist` (with `watchlistSymbols.symbol.quote` + `.news` attached)
- `404` `{ error: "Watchlist not found" }` or `{ error: "No symbols found in the watchlist" }`
- `503` `{ error: "Failed to fetch quotes from the API", details: {...} }`
- `500` `{ error: string, message: string, file: string, line: number }`

### `GET /api/watchlist/editWatchlistData/{watchlistId}`

Returns:

- `200` `UserWatchlist | null` (includes `watchlistSymbols.symbol`)

### `POST /api/watchlist/symbol`

Auth requirement:

- Requires an authenticated user (`Auth::user()`); otherwise `401`

Inputs (inferred from controller logic):

- `watchlist_id`: required
- Either:
  - `symbol_id`, or
  - `symbol` (ticker) which is resolved to a `Symbol` record

Returns:

- `200` updated watchlist (`getWatchListAllData(watchlist_id)`)
- `400` `{ error: "Invalid symbol" }` or `{ error: "Watchlist ID is required" }`
- `401` `{ error: "Unauthorized request" }`
- `409` `{ error: "Symbol already exists in watchlist" }`
- `500` `{ error: "Error adding symbol to watchlist: ..." }`

### `POST /api/watchlist/copyWatchlist`

Auth requirement:

- Requires authenticated user AND `user_id` provided

Inputs:

- `watchlist_id`
- `user_id` (must be provided; used as “requested user id” check)

Returns:

- `200` `"Watchlist copied successfully"` (string body)
- `404` `"Watchlist not found"` (string body)
- `403` `{ status: "Not allowed" }`

### `PUT /api/watchlist/update-positions`

Inputs:

- `positions`: array of `{ id, position }`

Returns:

- `200` `{ message: "Positions updated successfully" }`

### `PUT /api/watchlist/update-privacy`

Inputs:

- `watchlist_id`
- `privacy_option` (stored into `who_can_view`)

Returns:

- `200` `{ message: "watchlist privacy updated", selectedPrivacy: string }`
- `200` `{ message: "Watchlist does not exist" }` (no explicit status code)

### `DELETE /api/watchlist/deletewatchlist?id={watchlistId}`

Inputs:

- `id` (watchlist id)

Returns:

- `200` `{ message: "Watchlist deleted successfully" }`
- `200` `{ message: "Error Deleting Watchlist" }` (on exception)

### `DELETE /api/watchlist/symbol?id={symbolRowId}&watchlist_id={watchlistId}`

Inputs:

- `id` (watchlist_symbols row id)
- `watchlist_id`

Returns:

- `200` updated watchlist (`getWatchListAllData(watchlist_id)`) or `false`

---

## Groups

Controller: `app/Http/Controllers/GroupController.php`

### `GET /api/searchGroups?query=...` (public)

Returns:

- `200` `Array<{ id, group_name, group_title, avatar }>` (max 10)

### `GET /api/searchGroups/default` (public)

Returns:

- `200` last 30 groups (raw `Group[]`)

### `GET /api/suggested-chats?per_page=&page=&search=` (public but includes auth-aware flags)

Query params:

- `per_page` (default 9)
- `page` (default 1)
- `search` (optional)

Returns:

- `200` `{ data, current_page, last_page, per_page, total, has_more }`
  - each `data[]` item includes computed:
    - `joined: boolean`
    - `requestPending: boolean`
    - `membersCount`

### `GET /api/joined-chats` (Sanctum)

Query params:

- `userName` (optional; if omitted uses authenticated user)
- `per_page` (default 9)
- `page` (default 1)

Returns:

- `200` `{ data, current_page, last_page, per_page, total }`
  - `data[]` items include `joined`, `requestPending`, `membersCount`
- `404` `{ error: "User not found" }`

### `GET /api/joined-chats-share` (Sanctum)

Query params:

- `userName` (optional)
- `per_page` (default 5)
- `page` (default 1)
- `search` (optional)

Returns: same envelope style as `joined-chats`.

### `POST /api/groups/join/{groupId}` (Sanctum)

Returns (public group):

- `200` `{ id, group_title, joined: true, requestPending: false, message }`

Returns (private group):

- `200` `{ id, group_title, joined: false, requestPending: true, message }`

Errors:

- `400` `{ error: true, message }`

### `POST /api/groups/{groupId}/leave` (Sanctum)

Returns:

- `200` `{ message: "You have left the group.", id: groupId }`
- `401` `{ message: "Unauthenticated." }`
- `404` `{ message: "Group not found" }`

### `GET /api/groups/{id}` (Sanctum)

Returns:

- `200` group with computed fields:
  - `isJoined: boolean`
  - `requestPending: boolean`
- `404` `{ message: "Group not found" }`

### `GET /api/groups/{groupId}/members` (Sanctum)

Returns:

- `200` `{ members: Array<{id,name,avatar}>, members_count: number }`
- `404` `{ message: "Group not found" }`

### `GET /api/groups/{groupId}/check` (Sanctum)

Returns:

- `200` `{ authorized: boolean }`

Note:

- Logic currently returns `authorized: true` when acting user is missing OR role is `'admin'` (double-check if intended).

### `POST /api/groups/{groupId}/update-member` (Sanctum)

Inputs:

- `user_id`
- `role`
- `status`

Returns:

- `200` `{ message: "Member updated successfully", group: Group(with members) }`
- `404` `{ message: "Group not found" }` / `{ message: "Member not found in the group" }`

### `POST /api/groups/{groupId}/remove-member` (Sanctum)

Inputs:

- `member_id`

Returns:

- `200` `{ message: "Cover updated successfully" }` (message text appears incorrect but is what is returned)
- `404` `{ message: "Group not found" }` / `{ message: "Member not found in the group" }`

### Cover/Profile uploads and cover position (Sanctum)

- `POST /api/group-cover-position`
  - Body: `group_id`, `cover_position`
  - Returns `200 { message }` or `404`
- `POST /api/uploadGroupCover`
  - Validation: `cover_photo` required image, jpeg/png/jpg, max 2MB
  - Returns `{ message, path }`
- `POST /api/removeGroupCover`
  - Body: `group_id`
  - Resets cover to `photos/d-cover.jpg`
- `POST /api/profileGroupImage`
  - Validation: `profile_photo` required image, jpeg/png/jpg, max 2MB

---

## Messages (group chat)

Controller: `app/Http/Controllers/MessageController.php`

### `GET /api/{groupId}/messages` (Sanctum)

Behavior:

- Paginates 20, filters `is_deleted=false`, orders latest
- Returns **mapped array** (not paginator envelope)

Returns:

- `200` `Array<MessageDTO>`

Where `MessageDTO`:

- `id`, `group_id`, `text`, `media`, `media_file_name`
- `user`: `{ id, name, avatar }`
- `is_user_message_owner`: boolean
- `reply_to_message_id`
- `created_at`

### `POST /api/groups/{groupId}/send-message` (Sanctum)

Validation:

- `text`: required string
- `userId`: required integer exists users.id
- `replyTo`: nullable integer exists messages.id

AuthZ:

- requires userId to be an **active** member in pivot (`group_members.status = active`)

Returns:

- `200` `{ message: string, data: MessageDTO }`
- `403` `{ status: 403, message: "You are not a member of this group." }`
- `404` `{ message: "Group not found" }`

### `PUT /api/groups/{groupId}/messages/{messageId}` (Sanctum)

Validation:

- `text`: required string

Returns:

- `200` `{ message: string, data: Message }` (raw model)

### `DELETE /api/groups/{messageId}/delete` (Sanctum)

Returns:

- `200` `{ message: string }`
- `404` `{ message: "Message not found" }`

---

## Subscriptions

### `GET /api/subscriptionStatus` (public; returns authenticated=false when guest)

Controller: `SubscriptionStatusController@getStatus`

Returns:

- `200` `{ authenticated: false }` when no user
- `200` when authenticated:
  - `authenticated: true`
  - `features: Record<feature_name, { enabled, limit, current_count, can_access }>`
  - `subscription: Array<{ name, stripe_status, ends_at, is_manual, subscription_type }>`

### `GET /api/subscriptionInvoices` (Sanctum)

Controller: `SubscriptionStatusController@getInvoices`

Returns:

- `200` `{ Invoices: { allUserSubscriptions, previousInvoices, paymentMethods, upcomingInvoice? } }`
- `403` `{ error: "Failed to retrieve invoices: ..." }`

### `POST /api/cancelSubscription/{subscriptionName}` (Sanctum)

Returns:

- `200` `{ message: "Subscription cancelled successfully." }`
- `403` `{ error: "Failed to cancel subscription: ..." }`

### `POST /api/updatePaymentMethod` (Sanctum)

Validation:

- `payment_method`: required string

Returns:

- `200` `{ message: "Payment method updated successfully." }`
- `403` `{ error: "Failed to update payment method: ..." }`

### `POST /api/createUserSubscription` (Sanctum)

Controller: `SubscriptionPlanController@createUserSubscription`

Inputs (as used):

- `price_Intent` (Stripe price id)
- `payment_method`
- `planName`
- `cardHolderName` (read but not used for validation here)

Behavior:

- Cancels all existing Stripe subs, deletes any manual subs, then creates new Stripe subscription.

Returns:

- `200` `{ message: "Subscription created successfully", transitioned_from_manual: boolean }`
- `500` `{ error: string }`

---

## Stock screener

### `GET /api/stock-screener` (Sanctum)

Controller: `StockScreenerController@screener`

Authorization:

- Requires feature gate:
  - `stock_screener_access` OR `advanced_stock_screener`
- If neither: `403` `{ message: "You do not have access to the stock screener." }`

Validation:

- numeric params: `marketCapMoreThan`, `marketCapLowerThan`, `priceMoreThan`, `priceLowerThan`, `volumeMoreThan`, `volumeLowerThan`
- advanced (only applied when allowed): `betaMoreThan`, `betaLowerThan`, `dividendMoreThan`, `dividendLowerThan`, booleans `isEtf`, `isFund`, `isActivelyTrading`
- strings: `sector`, `industry`, `country`, `exchange`
- `limit`: integer max 100

Behavior:

- Defaults `country` to `US,CA` if not provided
- Calls `FINANCIAL_MODEL_API_URL/stock-screener?apikey=...`

Returns:

- `200` upstream JSON from financial API
- upstream failure: `{ message, details }` with upstream status
- `500` `{ message, error }`

---

## Remaining endpoints

This file is being expanded to include the rest of `routes/api.php`:

- Posts (feed, create/update/delete, reactions, comments, votes)
- User (profile, privacy settings, password, followers, notifications)
- Widgets (quotes, calendars, ohlc, collections, wordpress integrations)
- Education (videos, ebooks, courses)
- Exams (list/initiate/questions/submit/results/recommended/past-performance)
- Trading reports, rich picks, live/webinars, contact/email-collector
- Chatbot endpoints
- Automation (API key) endpoints

