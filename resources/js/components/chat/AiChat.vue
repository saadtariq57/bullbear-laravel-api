<template>
  <section class="ai-chat" :class="{ 'ai-chat--sidebar-open': sidebarOpen }">

    <!-- Mobile overlay -->
    <div
      v-if="sidebarOpen"
      class="ai-chat__overlay d-xl-none"
      @click="sidebarOpen = false"
    ></div>

    <!-- ═══ Sidebar ═══ -->
    <aside class="ai-chat__sidebar">
      <div class="ai-chat__sidebar-top">
        <button type="button" class="ai-chat__new-btn" @click="startNewChat">
          <i class="bi bi-plus-lg"></i>
          <span>New chat</span>
        </button>
        <button
          type="button"
          class="ai-chat__sidebar-close d-xl-none"
          @click="sidebarOpen = false"
          aria-label="Close sidebar"
        >
          <i class="bi bi-x-lg"></i>
        </button>
      </div>

      <div class="ai-chat__sidebar-body">
        <p class="ai-chat__sidebar-label">Conversations</p>

        <!-- Loading shimmer -->
        <template v-if="loadingConversations">
          <div v-for="n in 4" :key="n" class="ai-chat__conv-shimmer"></div>
        </template>

        <p v-else-if="conversations.length === 0" class="ai-chat__sidebar-empty">
          No conversations yet
        </p>

        <button
          v-for="conv in conversations"
          :key="conv.id"
          type="button"
          class="ai-chat__conv-item"
          :class="{ 'ai-chat__conv-item--active': activeConversationId === conv.id }"
          @click="selectConversation(conv)"
        >
          <i class="bi bi-chat-left-text ai-chat__conv-icon"></i>
          <div class="ai-chat__conv-meta">
            <span class="ai-chat__conv-title">{{ conv.title || 'New conversation' }}</span>
            <span class="ai-chat__conv-date">{{ formatDate(conv.updated_at) }}</span>
          </div>
        </button>
      </div>

      <div class="ai-chat__sidebar-foot">
        <i class="bi bi-robot"></i>
        <span>RichTV AI</span>
      </div>
    </aside>

    <!-- ═══ Main panel ═══ -->
    <div class="ai-chat__main">

      <!-- Mobile-only top bar: sidebar toggle + new chat -->
      <div class="ai-chat__mobile-bar d-xl-none">
        <button
          type="button"
          class="ai-chat__menu-toggle"
          @click="sidebarOpen = true"
          aria-label="Open sidebar"
        >
          <i class="bi bi-layout-sidebar"></i>
        </button>
        <button
          v-if="messages.length > 0 || activeConversationId"
          type="button"
          class="ai-chat__new-chat-btn"
          @click="startNewChat"
        >
          <i class="bi bi-plus-lg me-1"></i>New chat
        </button>
      </div>

      <!-- Messages area -->
      <div ref="messagesContainer" class="ai-chat__messages">

        <!-- Loading history -->
        <div v-if="loadingMessages" class="ai-chat__center">
          <div class="ai-chat__spinner"></div>
          <p class="ai-chat__center-text">Loading conversation…</p>
        </div>

        <!-- Empty / welcome state -->
        <div v-else-if="messages.length === 0 && !isLoading" class="ai-chat__empty">
          <div class="ai-chat__empty-icon">
            <i class="bi bi-chat-square-text"></i>
          </div>
          <h2 class="ai-chat__empty-title">How can I help you today?</h2>
          <p class="ai-chat__empty-text">
            Ask about stocks, market data, or financial fundamentals. Your conversation is saved automatically.
          </p>
          <div class="ai-chat__suggestions">
            <button
              v-for="s in suggestions"
              :key="s"
              type="button"
              class="ai-chat__pill"
              @click="sendSuggestion(s)"
            >
              {{ s }}
            </button>
          </div>
        </div>

        <!-- Message list -->
        <div v-else class="ai-chat__message-list">
          <div
            v-for="(msg, i) in messages"
            :key="i"
            class="ai-chat__message"
            :class="{
              'ai-chat__message--user': msg.role === 'user',
              'ai-chat__message--assistant': msg.role === 'assistant',
            }"
          >
            <div
              class="ai-chat__avatar"
              :class="msg.role === 'user' ? 'ai-chat__avatar--user' : 'ai-chat__avatar--ai'"
              aria-hidden="true"
            >
              <i :class="msg.role === 'user' ? 'bi bi-person-fill' : 'bi bi-robot'"></i>
            </div>
            <div class="ai-chat__bubble" :class="'ai-chat__bubble--' + msg.role">
              <!-- User messages: plain text. Assistant: rendered markdown -->
              <p v-if="msg.role === 'user'" class="ai-chat__bubble-text">{{ msg.content }}</p>
              <div v-else class="ai-chat__bubble-text ai-chat__markdown" v-html="renderMarkdown(msg.content)"></div>
            </div>
          </div>

          <!-- Typing indicator -->
          <div v-if="isLoading" class="ai-chat__message ai-chat__message--assistant">
            <div class="ai-chat__avatar ai-chat__avatar--ai" aria-hidden="true">
              <i class="bi bi-robot"></i>
            </div>
            <div class="ai-chat__bubble ai-chat__bubble--assistant ai-chat__bubble--typing">
              <span class="ai-chat__dot"></span>
              <span class="ai-chat__dot"></span>
              <span class="ai-chat__dot"></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Error banner -->
      <div v-if="errorMessage" class="ai-chat__error" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>
        {{ errorMessage }}
        <button type="button" class="ai-chat__error-close" @click="errorMessage = null" aria-label="Dismiss">
          <i class="bi bi-x"></i>
        </button>
      </div>

      <!-- Input -->
      <footer class="ai-chat__footer">
        <form class="ai-chat__form" @submit.prevent="sendMessage">
          <div class="ai-chat__input-row">
            <textarea
              ref="inputEl"
              v-model="inputText"
              class="ai-chat__input"
              placeholder="Ask about markets, stocks, or fundamentals…"
              rows="1"
              :disabled="isLoading || loadingMessages"
              @keydown.enter.exact.prevent="sendMessage"
              @input="resizeInput"
            />
            <button
              type="submit"
              class="ai-chat__send"
              :disabled="!canSend || isLoading || loadingMessages"
              aria-label="Send message"
            >
              <i class="bi bi-send-fill"></i>
            </button>
          </div>
          <p class="ai-chat__hint">Enter to send &nbsp;·&nbsp; Shift+Enter for new line</p>
        </form>
      </footer>

    </div><!-- /.ai-chat__main -->
  </section>
</template>

<script>
import MarkdownIt from 'markdown-it';
import DOMPurify from 'dompurify';

const md = new MarkdownIt({ linkify: true, breaks: true });

export default {
  name: 'AiChat',

  data() {
    return {
      messages: [],
      inputText: '',
      isLoading: false,
      conversationId: null,
      activeConversationId: null,
      conversations: [],
      loadingConversations: false,
      loadingMessages: false,
      errorMessage: null,
      sidebarOpen: false,
      suggestions: [
        'What are the top gainers today?',
        'Explain P/E ratio in simple terms',
        "How is NVDA performing this week?",
      ],
    };
  },

  computed: {
    canSend() {
      return this.inputText.trim().length > 0;
    },
  },

  mounted() {
    this.resizeInput();
    this.fetchConversations();
  },

  methods: {
    /* ── textarea auto-resize ── */
    resizeInput() {
      this.$nextTick(() => {
        const el = this.$refs.inputEl;
        if (!el) return;
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight, 120) + 'px';
      });
    },

    scrollToBottom() {
      this.$nextTick(() => {
        const c = this.$refs.messagesContainer;
        if (c) c.scrollTop = c.scrollHeight;
      });
    },

    formatDate(iso) {
      if (!iso) return '';
      const d = new Date(iso);
      const diffDays = Math.floor((Date.now() - d) / 86_400_000);
      if (diffDays === 0) return 'Today';
      if (diffDays === 1) return 'Yesterday';
      return d.toLocaleDateString(undefined, { month: 'short', day: 'numeric' });
    },

    /* ── sidebar actions ── */
    sendSuggestion(text) {
      this.inputText = text;
      this.sendMessage();
    },

    startNewChat() {
      this.messages = [];
      this.conversationId = null;
      this.activeConversationId = null;
      this.inputText = '';
      this.errorMessage = null;
      this.sidebarOpen = false;
      this.resizeInput();
    },

    async fetchConversations() {
      this.loadingConversations = true;
      try {
        const res = await window.axios.get('/api/chatbot/conversations');
        this.conversations = res.data ?? [];
      } catch {
        // Sidebar stays empty; non-critical failure
      } finally {
        this.loadingConversations = false;
      }
    },

    async selectConversation(conv) {
      if (this.activeConversationId === conv.id) {
        this.sidebarOpen = false;
        return;
      }
      this.activeConversationId = conv.id;
      this.conversationId = conv.id;
      this.messages = [];
      this.loadingMessages = true;
      this.errorMessage = null;
      this.sidebarOpen = false;

      try {
        const res = await window.axios.get(
          `/api/chatbot/conversations/${conv.id}/messages`,
          { params: { limit: 50 } }
        );
        this.messages = (res.data ?? []).map((m) => ({
          role: m.role,
          content: m.content,
        }));
        this.scrollToBottom();
      } catch {
        this.errorMessage = 'Failed to load conversation. Please try again.';
      } finally {
        this.loadingMessages = false;
      }
    },

    /* ── markdown renderer ── */
    renderMarkdown(content) {
      if (!content) return '';
      let normalized = content.replace(/\r\n/g, '\n');
      // Collapse blank lines → single \n (see below). Skip fenced ``` blocks so code isn't broken.
      normalized = normalized.split(/(```[\s\S]*?```)/g).map((chunk, i) => {
        if (chunk.startsWith('```')) return chunk;
        return chunk.replace(/\n{2,}/g, '\n');
      }).join('');
      let html = md.render(normalized);
      html = html.replace(/<p>\s*<\/p>/gi, '');
      html = html.replace(/<p>\s*<br\s*\/?>\s*<\/p>/gi, '');
      return DOMPurify.sanitize(html);
    },

    /* ── send message ── */
    async sendMessage() {
      const text = this.inputText.trim();
      if (!text || this.isLoading) return;

      this.messages.push({ role: 'user', content: text });
      this.inputText = '';
      this.resizeInput();
      this.scrollToBottom();
      this.errorMessage = null;
      this.isLoading = true;

      try {
        const payload = { prompt: text };
        if (this.conversationId) payload.conversation_id = this.conversationId;

        const res = await window.axios.post('/api/chatbot/query', payload);
        const { answer, conversation_id } = res.data;

        this.messages.push({ role: 'assistant', content: answer });

        if (conversation_id) {
          const isNewConversation = !this.conversationId;
          this.conversationId = conversation_id;
          this.activeConversationId = conversation_id;
          if (isNewConversation) this.fetchConversations();
        }
      } catch (err) {
        this.messages.pop(); // remove the optimistic user message
        this.errorMessage =
          err?.response?.data?.error ?? 'Something went wrong. Please try again.';
      } finally {
        this.isLoading = false;
        this.scrollToBottom();
      }
    },
  },
};
</script>

<style scoped>
/* ─── Design tokens ─────────────────────────────── */
.ai-chat {
  --c-sidebar-bg: #0f2235;
  --c-sidebar-hover: #183B56;
  --c-sidebar-active: #1f4a6b;
  --c-sidebar-border: rgba(255, 255, 255, 0.07);
  --c-sidebar-text: rgba(255, 255, 255, 0.85);
  --c-sidebar-muted: rgba(255, 255, 255, 0.45);
  --c-sidebar-gold: #EDB043;
  --c-sidebar-width: 260px;

  --c-bg: #f5f6f8;
  --c-surface: #fff;
  --c-border: #e8eaed;
  --c-text: #1a1a2e;
  --c-muted: #6b7280;
  --c-blue: #183B56;
  --c-blue-dark: #0d2137;
  --c-user-bubble: #183B56;
  --c-ai-bubble: #fff;

  --c-radius: 14px;
  --c-radius-sm: 8px;
  --c-shadow: 0 1px 3px rgba(0, 0, 0, .06);
  --c-shadow-lg: 0 4px 18px rgba(0, 0, 0, .1);

  /* Layout — locked to viewport */
  display: flex;
  flex-direction: row;
  position: relative;
  height: calc(100dvh - 140px);
  overflow: hidden;
  background: var(--c-bg);
  font-family: var(--primary-font), sans-serif;
}

/* Mobile: subtract app bottom nav (~64px) */
@media (max-width: 1199px) {
  .ai-chat {
    height: calc(100dvh - 140px - 64px);
  }
}

/* ─── Overlay (mobile sidebar backdrop) ─────────── */
.ai-chat__overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, .45);
  z-index: 15;
}

/* ─── Sidebar ─────────────────────────────────────── */
.ai-chat__sidebar {
  display: flex;
  flex-direction: column;
  width: var(--c-sidebar-width);
  height: 100%;
  background: var(--c-sidebar-bg);
  flex-shrink: 0;
  overflow: hidden;
  transition: none;
}

/* On mobile: sidebar slides in as an absolute overlay */
@media (max-width: 1199px) {
  .ai-chat__sidebar {
    position: absolute;
    top: 0;
    left: calc(-1 * var(--c-sidebar-width));
    height: 100%;
    z-index: 20;
    transition: left 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 4px 0 20px rgba(0, 0, 0, .3);
  }
  .ai-chat--sidebar-open .ai-chat__sidebar {
    left: 0;
  }
}

.ai-chat__sidebar-top {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 1rem;
  border-bottom: 1px solid var(--c-sidebar-border);
  flex-shrink: 0;
}

.ai-chat__new-btn {
  flex: 1;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.6rem 0.875rem;
  border-radius: var(--c-radius-sm);
  border: 1px solid var(--c-sidebar-border);
  background: transparent;
  color: var(--c-sidebar-text);
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.15s, border-color 0.15s;
  font-family: var(--primary-font), sans-serif;
}
.ai-chat__new-btn:hover {
  background: var(--c-sidebar-hover);
  border-color: rgba(255, 255, 255, 0.15);
}

.ai-chat__sidebar-close {
  width: 36px;
  height: 36px;
  border-radius: var(--c-radius-sm);
  border: 1px solid var(--c-sidebar-border);
  background: transparent;
  color: var(--c-sidebar-muted);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  flex-shrink: 0;
  font-size: 1rem;
}
.ai-chat__sidebar-close:hover {
  background: var(--c-sidebar-hover);
  color: var(--c-sidebar-text);
}

.ai-chat__sidebar-body {
  flex: 1;
  overflow-y: auto;
  padding: 0.75rem 0.75rem 0;
}
.ai-chat__sidebar-body::-webkit-scrollbar { width: 4px; }
.ai-chat__sidebar-body::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 4px; }

.ai-chat__sidebar-label {
  font-size: 0.6875rem;
  font-weight: 600;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--c-sidebar-muted);
  margin: 0 0.25rem 0.5rem;
}

.ai-chat__conv-shimmer {
  height: 48px;
  border-radius: var(--c-radius-sm);
  background: linear-gradient(
    90deg,
    rgba(255,255,255,.05) 25%,
    rgba(255,255,255,.1) 50%,
    rgba(255,255,255,.05) 75%
  );
  background-size: 200% 100%;
  animation: shimmer 1.6s infinite;
  margin-bottom: 6px;
}
@keyframes shimmer {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

.ai-chat__sidebar-empty {
  font-size: 0.8125rem;
  color: var(--c-sidebar-muted);
  padding: 0.5rem 0.25rem;
  margin: 0;
}

.ai-chat__conv-item {
  width: 100%;
  display: flex;
  align-items: center;
  gap: 0.625rem;
  padding: 0.625rem 0.75rem;
  border-radius: var(--c-radius-sm);
  border: none;
  background: transparent;
  color: var(--c-sidebar-text);
  cursor: pointer;
  text-align: left;
  margin-bottom: 2px;
  transition: background 0.15s;
}
.ai-chat__conv-item:hover { background: var(--c-sidebar-hover); }
.ai-chat__conv-item--active { background: var(--c-sidebar-active); }

.ai-chat__conv-icon {
  font-size: 0.875rem;
  color: var(--c-sidebar-muted);
  flex-shrink: 0;
}

.ai-chat__conv-meta {
  display: flex;
  flex-direction: column;
  overflow: hidden;
  min-width: 0;
}

.ai-chat__conv-title {
  font-size: 0.8125rem;
  font-weight: 500;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  font-family: var(--primary-font), sans-serif;
}

.ai-chat__conv-date {
  font-size: 0.6875rem;
  color: var(--c-sidebar-muted);
  font-family: var(--primary-font), sans-serif;
}

.ai-chat__sidebar-foot {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 1rem;
  border-top: 1px solid var(--c-sidebar-border);
  color: var(--c-sidebar-muted);
  font-size: 0.8125rem;
  font-weight: 600;
  flex-shrink: 0;
  font-family: var(--primary-font), sans-serif;
}

/* ─── Main panel ─────────────────────────────────── */
.ai-chat__main {
  flex: 1;
  display: flex;
  flex-direction: column;
  min-width: 0;
  height: 100%;
  overflow: hidden;
}

/* Mobile-only top bar */
.ai-chat__mobile-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.75rem;
  padding: 0.625rem 1rem;
  border-bottom: 1px solid var(--c-border);
  background: var(--c-surface);
  flex-shrink: 0;
}

.ai-chat__menu-toggle {
  width: 38px;
  height: 38px;
  border-radius: var(--c-radius-sm);
  border: 1px solid var(--c-border);
  background: transparent;
  color: var(--c-text);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.1rem;
  cursor: pointer;
  flex-shrink: 0;
}
.ai-chat__menu-toggle:hover { background: var(--c-bg); }

.ai-chat__new-chat-btn {
  padding: 0.5rem 0.875rem;
  border-radius: var(--c-radius-sm);
  border: 1px solid var(--c-border);
  background: transparent;
  color: var(--c-text);
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  white-space: nowrap;
  transition: background 0.15s, border-color 0.15s;
  font-family: var(--primary-font), sans-serif;
}
.ai-chat__new-chat-btn:hover { background: var(--c-bg); border-color: #d1d5db; }

/* Messages */
.ai-chat__messages {
  flex: 1;
  min-height: 0;    /* critical: allows flex child to shrink and scroll */
  overflow-y: auto;
  padding: 1.5rem 1.25rem;
  overscroll-behavior: contain;
  -webkit-overflow-scrolling: touch;
}
.ai-chat__messages::-webkit-scrollbar { width: 5px; }
.ai-chat__messages::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

/* Center states */
.ai-chat__center {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  gap: 0.75rem;
}
.ai-chat__center-text {
  font-size: 0.9375rem;
  color: var(--c-muted);
  margin: 0;
  font-family: var(--primary-font), sans-serif;
}
.ai-chat__spinner {
  width: 36px;
  height: 36px;
  border: 3px solid var(--c-border);
  border-top-color: var(--c-blue);
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Empty state */
.ai-chat__empty {
  text-align: center;
  max-width: 440px;
  margin: auto;
  padding: 2rem 1rem;
}
.ai-chat__empty-icon {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: #e9ecef;
  color: var(--c-muted);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.75rem;
  margin: 0 auto 1.25rem;
}
.ai-chat__empty-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: var(--c-text);
  margin: 0 0 0.625rem;
  font-family: var(--primary-font), sans-serif;
}
.ai-chat__empty-text {
  font-size: 0.9375rem;
  color: var(--c-muted);
  line-height: 1.55;
  margin: 0 0 1.5rem;
  font-family: var(--primary-font), sans-serif;
}
.ai-chat__suggestions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  justify-content: center;
}
.ai-chat__pill {
  font-size: 0.8125rem;
  padding: 0.5rem 1rem;
  border-radius: 999px;
  border: 1px solid var(--c-border);
  background: var(--c-surface);
  color: var(--c-text);
  cursor: pointer;
  transition: background 0.15s, border-color 0.15s;
  font-family: var(--primary-font), sans-serif;
}
.ai-chat__pill:hover { background: var(--c-bg); border-color: #d1d5db; }

/* Message list */
.ai-chat__message-list {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
  max-width: 720px;
  margin: 0 auto;
  width: 100%;
}

.ai-chat__message {
  display: flex;
  gap: 0.75rem;
  align-items: flex-end;
  max-width: 88%;
}
.ai-chat__message--user {
  align-self: flex-end;
  flex-direction: row-reverse;
}
.ai-chat__message--assistant {
  align-self: flex-start;
}

.ai-chat__avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.875rem;
  flex-shrink: 0;
}
.ai-chat__avatar--ai {
  background: #e9ecef;
  color: var(--c-muted);
}
.ai-chat__avatar--user {
  background: var(--c-blue);
  color: #fff;
}

.ai-chat__bubble {
  padding: 0.75rem 1rem;
  border-radius: var(--c-radius);
  max-width: 100%;
  box-shadow: var(--c-shadow);
}
.ai-chat__bubble--user {
  background: var(--c-user-bubble);
  color: #fff;
  border-bottom-right-radius: 4px;
}
.ai-chat__bubble--assistant {
  background: var(--c-ai-bubble);
  color: var(--c-text);
  border: 1px solid var(--c-border);
  border-bottom-left-radius: 4px;
}
.ai-chat__bubble-text {
  margin: 0;
  font-size: 0.9375rem;
  line-height: 1.55;
  white-space: pre-wrap;
  word-break: break-word;
  font-family: var(--primary-font), sans-serif;
}
.ai-chat__bubble--typing {
  display: flex;
  gap: 0.375rem;
  align-items: center;
  padding: 1rem 1.25rem;
}
.ai-chat__dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: var(--c-muted);
  animation: typing 1.4s ease-in-out infinite both;
}
.ai-chat__dot:nth-child(2) { animation-delay: 0.2s; }
.ai-chat__dot:nth-child(3) { animation-delay: 0.4s; }
@keyframes typing {
  0%, 80%, 100% { transform: scale(0.75); opacity: 0.45; }
  40% { transform: scale(1); opacity: 1; }
}

/* Error banner */
.ai-chat__error {
  display: flex;
  align-items: center;
  margin: 0 1.25rem;
  padding: 0.625rem 0.875rem;
  border-radius: var(--c-radius-sm);
  background: #fff3cd;
  border: 1px solid #ffc107;
  color: #856404;
  font-size: 0.875rem;
  flex-shrink: 0;
  font-family: var(--primary-font), sans-serif;
}
.ai-chat__error-close {
  margin-left: auto;
  background: transparent;
  border: none;
  color: inherit;
  font-size: 1.125rem;
  cursor: pointer;
  line-height: 1;
  padding: 0 0 0 0.5rem;
}

/* Footer / Input — always pinned at bottom */
.ai-chat__footer {
  flex-shrink: 0;
  padding: 0.875rem 1.25rem calc(0.875rem + env(safe-area-inset-bottom, 0px));
  background: var(--c-bg);
}

.ai-chat__form {
  background: var(--c-surface);
  border: 1px solid var(--c-border);
  border-radius: var(--c-radius);
  box-shadow: var(--c-shadow-lg);
  overflow: hidden;
  max-width: 720px;
  margin: 0 auto;
}

.ai-chat__input-row {
  display: flex;
  align-items: flex-end;
  gap: 0.5rem;
  padding: 0.75rem 1rem;
}

.ai-chat__input {
  flex: 1;
  border: none;
  resize: none;
  font-size: 0.9375rem;
  line-height: 1.5;
  padding: 0.4rem 0;
  min-height: 40px;
  max-height: 120px;
  font-family: var(--primary-font), sans-serif;
  color: var(--c-text);
  background: transparent;
}
.ai-chat__input::placeholder { color: var(--c-muted); }
.ai-chat__input:focus { outline: none; }

.ai-chat__send {
  width: 42px;
  height: 42px;
  border-radius: var(--c-radius-sm);
  border: none;
  background: var(--c-blue);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  cursor: pointer;
  flex-shrink: 0;
  transition: background 0.15s, opacity 0.15s;
}
.ai-chat__send:hover:not(:disabled) { background: var(--c-blue-dark); }
.ai-chat__send:disabled { opacity: 0.45; cursor: not-allowed; }

.ai-chat__hint {
  font-size: 0.6875rem;
  color: var(--c-muted);
  margin: 0 1rem 0.5rem;
  font-family: var(--primary-font), sans-serif;
}

/* ─── Markdown output inside assistant bubble ─── */
/* Flex + gap = consistent block spacing (paragraph vs heading vs list), no stacked margins */
.ai-chat__markdown {
  font-size: 0.9375rem;
  line-height: 1.5;
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}
.ai-chat__markdown :deep(p) { margin: 0; }
.ai-chat__markdown :deep(li > p) { margin: 0; }
.ai-chat__markdown :deep(h1),
.ai-chat__markdown :deep(h2),
.ai-chat__markdown :deep(h3) {
  font-weight: 600;
  margin: 0;
  font-size: inherit;
  font-family: var(--primary-font), sans-serif;
}
.ai-chat__markdown :deep(h1) { font-size: 1.05em; }
.ai-chat__markdown :deep(h2),
.ai-chat__markdown :deep(h3) { font-size: 1em; }
.ai-chat__markdown :deep(ul),
.ai-chat__markdown :deep(ol) {
  padding-left: 1.25rem;
  margin: 0;
}
.ai-chat__markdown :deep(li) { margin: 0 0 0.15rem; }
.ai-chat__markdown :deep(li:last-child) { margin-bottom: 0; }
.ai-chat__markdown :deep(code) {
  font-family: 'Fira Code', 'Courier New', monospace;
  font-size: 0.85em;
  background: rgba(0, 0, 0, .06);
  padding: 0.15em 0.4em;
  border-radius: 4px;
}
.ai-chat__markdown :deep(pre) {
  background: #1e293b;
  color: #e2e8f0;
  border-radius: 8px;
  padding: 0.875rem 1rem;
  overflow-x: auto;
  margin: 0;
}
.ai-chat__markdown :deep(pre code) {
  background: none;
  padding: 0;
  font-size: 0.875rem;
  color: inherit;
}
.ai-chat__markdown :deep(strong) { font-weight: 600; }
.ai-chat__markdown :deep(em) { font-style: italic; }
.ai-chat__markdown :deep(a) { color: var(--c-blue); text-decoration: underline; }
.ai-chat__markdown :deep(blockquote) {
  border-left: 3px solid var(--c-border);
  padding-left: 0.875rem;
  margin: 0;
  color: var(--c-muted);
}
.ai-chat__markdown :deep(hr) { border: none; border-top: 1px solid var(--c-border); margin: 0; }
.ai-chat__markdown :deep(table) { border-collapse: collapse; width: 100%; margin: 0; font-size: 0.875rem; }
.ai-chat__markdown :deep(th),
.ai-chat__markdown :deep(td) { border: 1px solid var(--c-border); padding: 0.375rem 0.625rem; text-align: left; }
.ai-chat__markdown :deep(th) { background: var(--c-bg); font-weight: 600; }
</style>
