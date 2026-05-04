/**
 * Next.js TypeScript types for RichTV backend integration.
 *
 * Source of truth:
 * - `routes/api.php` (endpoints + auth middleware)
 * - Current frontend JS usage under `resources/js/services/*` and `resources/js/stores/*`
 *
 * Notes:
 * - Many endpoints return Eloquent models/resources; response shapes may include extra fields.
 * - These types intentionally allow extensions via index signatures where backend shape is not strictly defined.
 */

export type ID = number | string;

export type ISODateString = string;

export type JsonPrimitive = string | number | boolean | null;
export type JsonValue = JsonPrimitive | JsonValue[] | { [k: string]: JsonValue };

/** Common Laravel-ish error payload used in some controllers. */
export type ApiError =
  | { error: string }
  | { message: string }
  | { success: false; error: string; [k: string]: JsonValue };

/** A generic API envelope seen in some feed endpoints: `{ data: T }`. */
export interface ApiDataEnvelope<T> {
  data: T;
  [k: string]: JsonValue;
}

/** Minimal user shape used throughout feed/comments. */
export interface UserLite {
  id: number | null;
  name: string;
  avatar?: string | null;
  about?: string | null;
  [k: string]: JsonValue;
}

/** Reaction types list from `GET /api/reaction-types`. */
export interface ReactionType {
  id: number;
  name: string;
  icon?: string | null;
  [k: string]: JsonValue;
}

/** Post or comment reaction returned by `/api/add-or-update-reaction`. */
export interface Reaction {
  id?: number;
  user_id: number;
  reaction_type_id: number;
  post_id?: number;
  comment_id?: number;
  reactionType?: ReactionType;
  user?: UserLite;
  [k: string]: JsonValue;
}

/**
 * Organized reactions are computed client-side in the legacy frontend.
 * Keep it flexible; Next.js can replicate the same organizer logic.
 */
export type OrganizedReactions = Record<string, unknown>;

/** Poll option and poll object as used in feed transformation. */
export interface PollOption {
  id: number;
  option_text: string;
  [k: string]: JsonValue;
}

export interface Poll {
  id: number;
  text?: string;
  time?: number | string;
  options: PollOption[];
  /** Backend provides these in some endpoints. */
  userVoted?: boolean;
  userVoteOption?: number | null;
  [k: string]: JsonValue;
}

export interface AlbumMedia {
  id: number;
  image: string;
  [k: string]: JsonValue;
}

/** A post item as used by `resources/js/services/userFeedService.js`. */
export interface FeedPost {
  id: number;
  user_id: number;
  group_id?: number | null;
  group_name?: string | null;
  shared_id?: number | null;
  post_type: 'text' | 'color' | 'photo' | 'link' | 'poll' | string;
  post_text?: string | null;
  post_link?: string | null;
  post_link_title?: string | null;
  post_link_image?: string | null;
  colored_post_id?: number | null;
  comments_status?: string | number | boolean;
  post_privacy?: string | number;

  user?: UserLite;
  photos?: AlbumMedia[];
  poll?: Poll | null;
  reactions?: Reaction[];

  /** Populated by backend for shared posts (see `PostController@createPost`). */
  originalPost?: FeedPost | null;

  /** Legacy frontend adds these client-side. */
  userReaction?: Reaction | null;
  organizedReactions?: OrganizedReactions;
  userVoted?: boolean;
  userVoteOptionId?: number | null;

  comments_count?: number;
  reactions_count?: number;
  created_at?: ISODateString;
  updated_at?: ISODateString;
  [k: string]: JsonValue;
}

/** GET feed endpoints return `{ data: FeedPost[] }` (see `userFeedService`). */
export type FeedListResponse = ApiDataEnvelope<FeedPost[]>;

/** Single post endpoint may return `{ data: FeedPost[] }` or another envelope; keep wide. */
export type FeedSingleResponse = ApiDataEnvelope<FeedPost[] | FeedPost> | FeedPost | FeedPost[];

/** Comments + replies as used by `userFeedCommentService`. */
export interface FeedComment {
  id: number;
  post_id: number;
  parent_id?: number | null;
  text: string;

  user_id?: number;
  user?: UserLite;
  reactions: Reaction[];
  replies: FeedComment[];

  /** Legacy frontend adds these client-side. */
  userReaction?: Reaction | null;
  organizedReactions?: OrganizedReactions;

  created_at?: ISODateString;
  updated_at?: ISODateString;
  [k: string]: JsonValue;
}

/** `GET /api/posts/{postId}/comments` returns an array. */
export type PostCommentsResponse = FeedComment[];

/** `POST /api/submit-comment` etc return `{ comment: FeedComment }` under `data`. */
export interface CommentMutationResponse {
  comment: FeedComment;
  [k: string]: JsonValue;
}

export interface AddOrUpdateReactionResponse {
  reaction: Reaction;
  [k: string]: JsonValue;
}

export interface AddVoteResponse {
  vote: {
    id?: number;
    poll_id: number;
    option_id: number;
    user_id?: number;
    [k: string]: JsonValue;
  };
  [k: string]: JsonValue;
}

/** Watchlist types inferred from `watchlistStore` + `watchlistService`. */
export interface WatchlistSymbol {
  id: number;
  symbol: string;
  name?: string | null;
  position?: number | null;
  [k: string]: JsonValue;
}

export interface Watchlist {
  id: number;
  title: string;
  privacy_option?: string | null;
  watchlist_symbols?: WatchlistSymbol[];
  [k: string]: JsonValue;
}

export interface WatchlistIndexResponse {
  hasUserWatchlist?: boolean;
  watchlistDetails?: Watchlist[];
  [k: string]: JsonValue;
}

/** Chatbot types inferred from `AiChat.vue` + `ChatbotController`. */
export type ChatbotRole = 'user' | 'assistant' | 'system' | string;

export interface ChatbotConversation {
  id: string;
  title?: string | null;
  created_at?: ISODateString;
  updated_at?: ISODateString;
  [k: string]: JsonValue;
}

export interface ChatbotMessage {
  role: ChatbotRole;
  content: string;
  created_at?: ISODateString;
  [k: string]: JsonValue;
}

export interface ChatbotQueryRequest {
  prompt: string;
  conversation_id?: string | null;
}

export interface ChatbotQueryResponse {
  answer: string;
  conversation_id?: string | null;
  [k: string]: JsonValue;
}

/** Misc endpoints */
export interface CheckLoginResponse {
  loggedIn: boolean;
}

export interface UsernameAvailabilityRequest {
  username: string;
}

export interface UsernameAvailabilityResponse {
  available: boolean;
  requestedUsername: string;
}

/**
 * Endpoint typings (high-signal map).
 * This is handy for generating typed API clients in Next.js.
 */
export interface ApiEndpoints {
  // auth helpers
  'GET /api/check-login': { res: CheckLoginResponse };
  'POST /api/check-username-availability': {
    req: UsernameAvailabilityRequest;
    res: UsernameAvailabilityResponse;
  };

  // feed
  'GET /api/user-feed': { res: FeedListResponse };
  'GET /api/user-profile/:userName?': { res: FeedListResponse };
  'GET /api/user-group/:groupId': { res: FeedListResponse };
  'GET /api/singlePost/:singlePostID': { res: FeedSingleResponse };
  'GET /api/reaction-types': { res: ReactionType[] };
  'POST /api/add-or-update-reaction': {
    req:
      | { post_id: number; reaction_type_id: number }
      | { comment_id: number; reaction_type_id: number };
    res: AddOrUpdateReactionResponse;
  };
  'POST /api/remove-reaction': {
    req: { post_id?: number; comment_id?: number };
    res: JsonValue;
  };
  'POST /api/add-vote': { req: { poll_id: number; option_id: number }; res: AddVoteResponse };
  'POST /api/remove-vote': { req: { poll_id: number }; res: JsonValue };
  'GET /api/posts/:postId/comments': { res: PostCommentsResponse };
  'POST /api/submit-comment': {
    req: { post_id: number; parent_id?: number | null; text: string };
    res: ApiDataEnvelope<CommentMutationResponse> | CommentMutationResponse;
  };
  'POST /api/edit-comment': {
    req: { id: number; parent_id?: number | null; text: string };
    res: ApiDataEnvelope<CommentMutationResponse> | CommentMutationResponse;
  };
  'POST /api/delete-comment': { req: { id: number }; res: JsonValue };

  // watchlists
  'GET /api/watchlist': { res: WatchlistIndexResponse };
  'GET /api/watchlist/featured': { res: WatchlistIndexResponse | Watchlist[] | JsonValue };
  'GET /api/watchlist/symbols/:watchlistId': { res: WatchlistSymbol[] | JsonValue };
  'GET /api/watchlist/editWatchlistData/:watchlistId': { res: Watchlist | JsonValue };
  'POST /api/watchlist/symbol': { req: JsonValue; res: JsonValue };
  'PUT /api/watchlist/update/:watchlistId': { req: JsonValue; res: JsonValue };
  'PUT /api/watchlist/update-positions': { req: JsonValue; res: JsonValue };
  'PUT /api/watchlist/update-privacy': { req: JsonValue; res: JsonValue };
  'DELETE /api/watchlist/symbol': { res: JsonValue };
  'DELETE /api/watchlist/deletewatchlist': { res: JsonValue };
  'POST /api/watchlist/copyWatchlist': { req: JsonValue; res: JsonValue };

  // chatbot
  'GET /api/chatbot/conversations': { res: ChatbotConversation[] };
  'GET /api/chatbot/conversations/:conversationId/messages': { res: ChatbotMessage[] };
  'POST /api/chatbot/query': { req: ChatbotQueryRequest; res: ChatbotQueryResponse };
}

