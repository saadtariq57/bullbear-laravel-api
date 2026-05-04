# RichTV Backend API Reference (for Next.js frontend)

This repository is the **Laravel backend API** for RichTV. The new Next.js frontend will be built separately, and should use this document as the primary reference for API integration.

## Conventions

- **Base path**: all endpoints below are under `{{BACKEND_URL}}/api/...`
- **Response type**: JSON unless otherwise noted
- **Auth types**:
  - **Public**: no auth required
  - **Sanctum (auth:sanctum)**: requires an authenticated user
  - **API key (api.key)**: requires `API-Key` header (automation/bot integrations)

## Authentication

### Sanctum-protected endpoints (`auth:sanctum`)

This backend uses **Laravel Sanctum** and includes `EnsureFrontendRequestsAreStateful` in the `api` middleware group (`app/Http/Kernel.php`). In practice, there are two common ways to authenticate:

- **Cookie / session based (stateful SPA)**:
  - Requires same-site cookie setup and correct `SANCTUM_STATEFUL_DOMAINS`.
  - Next.js typically needs `credentials: 'include'` and correct CORS + cookie domain settings.
- **Bearer token**:
  - Sanctum can also authenticate via `Authorization: Bearer <token>` if tokens are issued.
  - **Note**: this codebase doesn’t currently expose a dedicated “issue token” API endpoint in `routes/api.php`. If you need token-based auth for a cross-domain Next.js frontend, you’ll likely add one.

Useful config:

- `config/sanctum.php` (stateful domains, guards, token expiry)

### Web auth + CSRF endpoints (required for Sanctum “SPA mode”)

These are **not** in `routes/api.php`, but they are required if your Next.js app will authenticate using Laravel sessions/cookies:

- `GET /sanctum/csrf-cookie`
  - Sets the `XSRF-TOKEN` cookie (used for CSRF protection)
- `POST /login`
  - Laravel built-in login route (session-based)
- `POST /logout`
  - Laravel built-in logout route

If Next.js is running cross-origin (e.g. `http://localhost:3000` calling `http://localhost:8000`), ensure CORS applies to **`login`/`logout`**, not just `api/*`. See `config/cors.php`.

### API-key-protected endpoints (`api.key`)

Automation endpoints require a header:

- **Header**: `API-Key: <value>`
- **Validation**: compares header value to `config('app.AUTOMATION_API_KEY')`
- **Middleware**: `app/Http/Middleware/ApiKeyAuth.php`

Error responses:

- Missing key: `401` with `{ "success": false, "error": "API key required. Please provide API-Key header." }`
- Invalid key: `401` with `{ "success": false, "error": "Invalid API key." }`

### “Am I logged in?”

- `GET /api/check-login`
  - Returns `{ loggedIn: true|false }` depending on session auth.

## Rate limiting / throttling

The `api` middleware group includes Laravel throttling: `ThrottleRequests:api` (`app/Http/Kernel.php`). Exact limits depend on `RouteServiceProvider` / default Laravel config.

## External services (integration dependencies)

Configured in `config/services.php`:

- **Stripe**: payments/subscriptions (`STRIPE_KEY`, `STRIPE_SECRET`)
- **WordPress**: content fetch/posting (`WORDPRESS_API_URL`, credentials)
- **Mboum**: market data (`X_MBOUM_BASE_URL`, `MBOUM_Key`)
- **Financial Modeling Prep**: market data (`FINANCIAL_MODEL_API_URL`, `FINANCIAL_MODEL_API_KEY`)
- **Google OAuth**: (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`)
- **Chatbot microservice**: `RICHTV_CHATBOT_API_URL` (default `http://127.0.0.1:8101`)

## API Endpoints (from `routes/api.php`)

### Public endpoints (no auth)

#### Performance / trading reports

- `GET /api/categories-with-reports`
  - Controller: `TradingReportController@getCategoriesWithReports`
- `GET /api/report-profits/{reportId}`
  - Controller: `TradingReportController@getReportProfits`

#### Auth / registration helpers

- `POST /api/check-username-availability`
  - Controller: `App\Http\Controllers\Auth\RegisterController@checkUsernameAvailability`
  - Body:
    - `username` (required, string, alphanumeric, max 255)
  - Response:
    - `{ available: boolean, requestedUsername: string }`

#### Ably (requires Sanctum even though placed in “public” section)

- `GET /api/ably/authenticate` (auth:sanctum)
- `POST /api/ably/authenticate` (auth:sanctum)
  - Controller: `AblyController@authenticate`

#### Home helpers

- `GET /api/color-options` → `HomeController@colorOptions`
- `GET /api/fetch-link-data` → `HomeController@fetchLinkData`

#### Posts (some are duplicated in the auth group too)

- `POST /api/create-post` → `PostController@createPost`
- `GET /api/user-feed` → `PostController@getUserFeed`
- `GET /api/singlePost/{singlePostID}` → `PostController@getSinglePost`
- `POST /api/submit-comment` → `PostController@submitComment`
- `POST /api/edit-comment` → `PostController@editComment`
- `POST /api/delete-comment` → `PostController@deleteComment`
- `GET /api/reaction-types` → `PostController@getReactionTypes`
- `POST /api/add-or-update-reaction` → `PostController@addOrUpdateReaction`
- `POST /api/remove-reaction` → `PostController@removeReaction`
- `GET /api/posts/{postId}/comments` → `PostController@fetchPostComments`
- `POST /api/add-vote` → `PostController@addVote`
- `POST /api/remove-vote` → `PostController@removeVote`

**Create post validation (high-signal)**  
`PostController@createPost` validates:

- `user_id` (required)
- `post_type` (required)
- `post_privacy` (required)
- `comments_status` (required)
- conditional fields:
  - `post_text` required if `post_type` is `text` or `color`
  - `colored_post_id` required if `post_type` is `color` and must exist in `colored_posts`
  - `multi_image` + `images[]` required if `post_type` is `photo`
  - `post_link` + `post_link_title` required if `post_type` is `link`
  - `question` + `options[]` + `duration` required if `post_type` is `poll`

#### User profile media (public access in routes)

- `POST /api/uploadCover` → `UserController@updateCoverPhoto`
- `POST /api/removeCover` → `UserController@removeCoverPhoto`
- `POST /api/profileImage` → `UserController@updateProfilePhoto`

#### Watchlists

Prefix: `/api/watchlist/...`

- `GET /api/watchlist/` → `WatchlistController@getWatchLists`
- `GET /api/watchlist/featured` → `WatchlistController@getFeaturedWatchlists`
- `GET /api/watchlist/managewatchlists` → `WatchlistController@getWatchLists`
- `GET /api/watchlist/symbols/{watchlistId}` → `WatchlistController@getSymbols`
- `GET /api/watchlist/editWatchlistData/{watchlistId}` → `WatchlistController@getWatchListAllData`
- `POST /api/watchlist/symbol` → `WatchlistController@storeWatchListSymbol`
- `POST /api/watchlist/copyWatchlist` → `WatchlistController@copyWatchlist`
- `PUT /api/watchlist/update/{watchlist}` → `WatchlistController@UserUpdate`
- `GET /api/watchlist/store` → `WatchlistController@UserStore`
- `PUT /api/watchlist/update-positions` → `WatchlistController@updatePositions`
- `PUT /api/watchlist/update-privacy` → `WatchlistController@updatePrivacy`
- `DELETE /api/watchlist/symbol` → `WatchlistController@deleteWatchListSymbol`
- `DELETE /api/watchlist/deletewatchlist` → `WatchlistController@deleteWatchList`

#### Subscriptions (public access)

- `GET /api/subscriptionStatus` → `SubscriptionStatusController@getStatus`
- `GET /api/pricingPlans` → `SubscriptionPlanController@userIndex`
- `GET /api/subscription-plans/{id}` → `SubscriptionPlanController@showSubscriptionPlan`

#### Education content

- `GET /api/videos` → `EducationController@getVideosByPlaylist`
- `GET /api/ebooks` → `EducationController@index`
- `GET /api/ebooks/recommended` → `EducationController@getRecommendedEbooks`
- `GET /api/ebooks/download/{id}` → `EducationController@download`

#### Symbols

- `GET /api/symbol/search` → `SymbolController@search`
- `GET /api/unique-symbols` → `SymbolController@getUniqueSymbols`
- `GET /api/exclude-unique-symbols` → `SymbolController@getAllExcludingUniqueSymbols`
- `GET /api/searchSymbol/default` → `SymbolController@defaultSymbol`

#### Groups / members search

- `GET /api/suggested-chats` → `GroupController@suggestedChats`
- `GET /api/searchGroups` → `GroupController@siteGroupSearch`
- `GET /api/searchGroups/default` → `GroupController@defaultGroups`
- `GET /api/searchMembers` → `UserController@siteUserSearch`
- `GET /api/searchMembers/default` → `UserController@defaultMembers`

#### Widgets / market data

- `GET /api/getWidget` → `WidgetController@getWidgetsByCategory`
- `GET /api/quotes/{symbol}` → `WidgetController@getQuote`
- `GET /api/getquotes/{symbols}` → `WidgetController@getQuotes`
- `GET /api/market-collections/{type}` → `WidgetController@getCollection`
- `GET /api/crypto-collections/{type}` → `WidgetController@getCryptoCollection`
- `GET /api/calendar/{type}` → `WidgetController@getCalendar`
- `GET /api/widget/{id}` → `WidgetController@show`
- `GET /api/fund-ownership/{symbol}` → `WidgetController@getFundOwnership`
- `GET /api/options/{symbol}` → `WidgetController@getOptions`
- `GET /api/ohlc-data/intraday/{symbol}` → `WidgetController@fetchIntradayOHLCData`
- `GET /api/ohlc-data/daily/{symbol}` → `WidgetController@fetchDailyOHLCData`
- `GET /api/getGroups` → `WidgetController@getActiveGroups`
- `GET /api/searchGroups` → `WidgetController@searchGroups` (note: overlaps name with GroupController route)

#### WordPress / external news

- `GET /api/fetch-wordpress-posts` → `WidgetController@fetchPostWordpress`
- `GET /api/fetch-author-posts` → `WidgetController@fetchAuthorPosts`
- `GET /api/fetch-comments` → `WidgetController@fetchComments`
- `POST /api/post-comment` → `WidgetController@postComment`
- `GET /api/fetch-prioritized-internal-news` → `WidgetController@fetchPrioritizedInternalNews`
- `GET /api/fetch-prioritized-technical-analysis` → `WidgetController@fetchPrioritizedTechnicalAnalysis`
- `GET /api/external-news/{symbol}` → `WidgetController@fetchExternalNews`

#### RichTV picks

- `GET /api/richTvPicks` → `RichTvPicksController@getPicks`

#### Live / webinars

- `GET /api/richtv-live` → `LiveController@getEmbeddedCode`
- `GET /api/webinars` → `LiveController@getWebinars`

#### Exams (public list)

- `GET /api/exams` → `ExamController@getAllExams`

#### Contact / email collector

- `POST /api/contact` → `ContactController@submit`
- `POST /api/email-collector` → `EmailCollectorController@collect`

---

### Authenticated endpoints (Sanctum, `auth:sanctum`)

> These routes are defined twice in `routes/api.php` (two `auth:sanctum` groups). Treat them as **auth-required** for Next.js.

#### Ably

- `GET /api/ably/authenticate`
- `POST /api/ably/authenticate`

#### Home

- `GET /api/color-options`
- `GET /api/fetch-link-data`

#### Posts (authenticated variants + extra actions)

- `POST /api/create-post`
- `POST /api/update-post`
- `DELETE /api/delete-post/{id}`
- `GET /api/user-feed`
- `GET /api/user-profile/{userName?}`
- `GET /api/user-group/{groupId}`
- (and the same comment/reaction/vote endpoints as public section)

#### Profile media + cover position

- `POST /api/uploadCover`
- `POST /api/update-cover-position`
- `POST /api/removeCover`
- `POST /api/profileImage`

#### Groups

- `GET /api/joined-chats`
- `GET /api/joined-chats-share`
- `POST /api/groups/join/{groupId}`
- `POST /api/groups/{groupId}/leave`
- `GET /api/groups/{id}`
- `POST /api/group-cover-position`
- `POST /api/uploadGroupCover`
- `POST /api/removeGroupCover`
- `POST /api/profileGroupImage`
- `GET /api/groups/{groupId}/members`
- `GET /api/groups/{groupId}/check`
- `POST /api/groups/{groupId}/update-member`
- `POST /api/groups/{groupId}/remove-member`

#### Messages

- `GET /api/{groupId}/messages`
- `POST /api/groups/{groupId}/send-message`
- `PUT /api/groups/{groupId}/messages/{messageId}`
- `DELETE /api/groups/{messageId}/delete`

#### User data / follow / notifications / exams

- `GET /api/userdata`
- `POST /api/user/update`
- `POST /api/user/update-social-links`
- `POST /api/profileData/{userName}`
- `POST /api/users/{user}/follow`
- `DELETE /api/users/{user}/unfollow`
- `GET /api/suggested-followers`
- `GET /api/{userId}/notifications`
- `POST /api/notifications/{notification}/read`
- `DELETE /api/notifications/{notification}`
- `POST /api/notifications/{notification}/mute-type`
- `POST /api/notifications/mute-type`
- `POST /api/notifications/unmute-type/{type}`
- `GET /api/notifications/muted-types`
- `GET /api/exams/initiate/{examId}`
- `GET /api/exams/{examId}/questions`
- `POST /api/exams/submit/{examId}`
- `GET /api/exams/result/{examResultId}`
- `GET /api/exams/results`
- `GET /api/exams/recommended`
- `GET /api/exams/past-performance`

#### Account settings

- `POST /api/update-password`
- `POST /api/privacy-settings`

#### User feed filters

Prefix: `/api/userposts/...`

- `GET /api/userposts/all`
- `GET /api/userposts/text`
- `GET /api/userposts/image`
- `GET /api/userposts/video`
- `GET /api/userposts/recent`
- `GET /api/userposts/bookmarks`
- `POST /api/userposts/create`
- `POST /api/userposts/share-post`

---

### Additional protected endpoints (Sanctum, `auth:sanctum`)

#### Chatbot

- `POST /api/chatbot/query`
  - Body:
    - `prompt` (required, string, max 4000)
    - `conversation_id` (optional, string, max 100)
  - Behavior:
    - Backend injects `user_id = auth()->id()` and calls the chatbot microservice at `config('services.chatbot.url')/query`.
- `GET /api/chatbot/conversations`
  - Lists conversations for the authenticated user by calling chatbot microservice `/conversations?user_id=...`
- `GET /api/chatbot/conversations/{conversationId}/messages`
  - Calls chatbot microservice `/conversations/{conversationId}/messages?limit=50`

#### Subscriptions (billing)

- `POST /api/createUserSubscription`
- `GET /api/subscriptionInvoices`
- `POST /api/cancelSubscription/{subscriptionName}`
- `POST /api/updatePaymentMethod`

#### Personal sessions

- `GET /api/personal_sessions`
- `POST /api/personal_sessions`
- `PUT /api/personal_sessions/{id}`

#### Stock screener

- `GET /api/stock-screener`

#### Education

- `GET /api/ebooks/download/{id}` (protected duplicate)
- `GET /api/courses`

---

### API key endpoints (automation, `api.key`)

Header required: `API-Key: <AUTOMATION_API_KEY>`

- `GET /api/bots/active` → `BotController@apiActiveIndex`
- `GET /api/automation/last-personality` → `AutomationController@getLastPersonality`
- `POST /api/automation/create-post` → `AutomationController@createPost`
- `GET /api/automation/group/{symbol}` → `AutomationController@getGroupBySymbol`
- `POST /api/automation/recommend-groups` → `AutomationController@getGroupRecommendations`
- `GET /api/automation/richtv-content-apis` → `AutomationController@getRichTvContentApis`
- `POST /api/automation/engage` → `AutomationController@engage`
- `GET /api/automation/last-engagement` → `AutomationController@getLastEngagement`
- `GET /api/bots/active-engagement-bots` → `AutomationController@getActiveBotsForEngagement`
- `GET /api/automation/random-post-weighted` → `AutomationController@getRandomPostWeighted`

## Notes / known issues while generating this doc

- `php artisan route:list` currently fails in this environment due to a PHP fatal error in a vendor dependency (`mautic/api-library` PSR logger signature mismatch). This document is generated from `routes/api.php` and targeted controller inspection instead.
- A route import bug was fixed in `routes/api.php` so that the `check-username-availability` controller resolves to `App\Http\Controllers\Auth\RegisterController`.

## Local development (cross-origin) quick checklist

If your Next.js app is `http://localhost:3000` and Laravel is `http://localhost:8000`:

- **CORS**:
  - `config/cors.php` should include `api/*`, `sanctum/csrf-cookie`, `login`, `logout` (and optionally `register`) in `paths`
  - `supports_credentials` should be `true`
  - `allowed_origins` should include `http://localhost:3000`
- **Frontend**:
  - Use `withCredentials: true` / `credentials: 'include'`
  - Call `GET /sanctum/csrf-cookie` before `POST /login`
  - Do not mix `localhost` and `127.0.0.1`

