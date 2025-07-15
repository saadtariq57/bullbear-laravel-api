<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-lg-8">
        <h1 class="icon-heading mb-4 fw-bold border-bottom">
          Chat Rooms
          <i
            class="bi bi-chat-dots-fill ms-2"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="Explore various chat rooms"
          ></i>
        </h1>
        <div class="bg-white py-0 rounded-1 shadow-radius mt-3 groups-chats">
          <ul class="nav border-0 m-0 p-0" id="chats-content-tab" role="tablist">
            <li class="nav-item border-0 col-6" role="presentation">
              <button
                class="nav-link border-0 w-100 fs-16 fw-bold active m-0 py-2 px-3 bg-transparent"
                id="suggestedchats-tab"
                data-bs-toggle="tab"
                data-bs-target="#suggestedchats-tab-pane"
                type="button"
                role="tab"
                aria-controls="suggestedchats-tab-pane"
                aria-selected="true"
                title="View suggested chat rooms"
              >
                Suggested Chats
              </button>
            </li>
            <li class="nav-item col-6" role="presentation">
              <button
                class="nav-link border-0 fs-16 fw-bold m-0 py-2 px-3 bg-transparent w-100"
                id="joinedchats-tab"
                data-bs-toggle="tab"
                data-bs-target="#joinedchats-tab-pane"
                type="button"
                role="tab"
                aria-controls="joinedchats-tab-pane"
                aria-selected="false"
                title="View chat rooms you have joined"
              >
                Joined Chats
              </button>
            </li>
          </ul>
        </div>
        <div class="tab-content mt-3" id="mychatsContent">
          <div
            class="tab-pane fade show active"
            id="suggestedchats-tab-pane"
            role="tabpanel"
            aria-labelledby="suggestedchats-tab"
            tabindex="0"
          >
            <!-- Search Bar -->
            <div class="mb-3 border shadow-sm">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-search"></i>
                </span>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Search chat rooms..."
                  v-model="searchQuery"
                  @input="handleSearch"
                />
                <button
                  v-if="searchQuery"
                  class="btn btn-outline-secondary"
                  type="button"
                  @click="clearSearch"
                >
                  Clear
                </button>
              </div>
            </div>

            <ActiveChatRooms
              v-if="!isLoading || suggestedChats.length > 0"
              :chats="suggestedChats"
              :joined="false"
              @chat-joined="onChatJoined"
            />
            <div v-else-if="isLoading" class="d-flex justify-content-center my-5">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
            
            <!-- Show More Button -->
            <div v-if="suggestedChatsHasMore" class="text-center mt-4">
              <button
                @click="loadMoreSuggestedChats"
                class="btn btn-primary"
                :disabled="isLoading"
              >
                <span v-if="isLoading">
                  <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                  Loading...
                </span>
                <span v-else>Show More</span>
              </button>
            </div>

            <!-- No results message -->
            <div v-if="!isLoading && suggestedChats.length === 0" class="text-center my-5 py-5">
              <div class="no-chat-wrapper rounded-circle bg-cta d-flex justify-content-center align-items-center position-relative mx-auto">
                <i class="bi bi-search text-white" style="font-size: 35px;"></i>
              </div>
              <p class="fs-5 fw-5 mb-0 mt-2">
                {{ searchQuery ? `No chat rooms found for "${searchQuery}"` : 'No chat rooms available' }}
              </p>
            </div>
          </div>
          
          <div
            class="tab-pane fade"
            id="joinedchats-tab-pane"
            role="tabpanel"
            aria-labelledby="joinedchats-tab"
            tabindex="0"
          >
            <!-- Non-logged-in user message -->
            <template v-if="!loggedIn">
              <div class="text-center my-5 py-5">
                <div class="no-chat-wrapper rounded-circle bg-cta d-flex justify-content-center align-items-center position-relative mx-auto">
                  <i class="bi bi-person-lock text-white" style="font-size: 35px;"></i>
                </div>
                <p class="fs-5 fw-5 mb-3 mt-2">
                  You are not logged in. See suggested rooms below.
                </p>
                <button
                  @click="handleSignIn"
                  class="btn btn-primary"
                >
                  Sign In to Join Chat Rooms
                </button>
              </div>
            </template>
            
            <!-- Logged-in user content -->
            <template v-else>
              <template v-if="joinedChats && joinedChats.length">
                <ActiveChatRooms
                  :chats="joinedChats"
                  :joined="true"
                  :currentPage="currentPage"
                  :lastPage="lastPage"
                  @page-changed="handleJoinedChatsPageChange"
                  @chat-joined="onChatJoined"
                />
              </template>
              <template v-else>
                <div class="text-center my-5 py-5">
                  <div class="no-chat-wrapper rounded-circle bg-cta d-flex justify-content-center align-items-center position-relative mx-auto">
                    <i class="bi bi-chat-dots-fill text-white" style="font-size: 35px;"></i>
                  </div>
                  <p class="fs-5 fw-5 mb-0 mt-2">
                    You haven't joined any chat rooms. See suggested rooms below.
                  </p>
                </div>
                <ActiveChatRooms
                  v-if="!isLoading"
                  :chats="suggestedChats"
                  :joined="false"
                  @chat-joined="onChatJoined"
                />
                <div v-else class="d-flex justify-content-center my-5">
                  <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                </div>
              </template>
            </template>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <Markets />
        <MarketAnalysis />
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions, mapGetters } from 'vuex';
import { isLoggedIn } from '@/stores';
import ActiveChatRooms from './ActiveChatRooms.vue';
import Markets from '../widgets/Markets.vue';
import MarketAnalysis from '../widgets/MarketAnalysisSidebar.vue';
import userGroupModule from '@/stores/groupStore';

export default {
  name: 'UserGroups',
  components: {
    ActiveChatRooms,
    MarketAnalysis,
    Markets,
  },
  data() {
    return {
      loggedIn: false,
      tooltips: [],
      searchQuery: '',
      searchTimeout: null,
    };
  },
  computed: {
    ...mapState('UserGroups', [
      'suggestedChats',
      'joinedChats',
      'isLoading',
      'error',
      'currentPage',
      'lastPage',
    ]),
    ...mapGetters('UserGroups', [
      'getSuggestedChatsHasMore',
      'getSearchQuery'
    ]),
    suggestedChatsHasMore() {
      return this.getSuggestedChatsHasMore;
    }
  },
  beforeCreate() {
    if (!this.$store.hasModule('UserGroups')) {
      this.$store.registerModule('UserGroups', userGroupModule);
    }
  },
  watch: {
    suggestedChats: {
      handler() {
        this.reinitializeTooltips();
      },
      deep: true,
    },
    joinedChats: {
      handler() {
        this.reinitializeTooltips();
      },
      deep: true,
    },
    isLoading() {
      this.reinitializeTooltips();
    },
  },
  created() {
    this.checkLoginStatus();
    this.fetchSuggestedChats();
    
    if (this.loggedIn) {
      this.fetchJoinedChats({});
    }
  },
  methods: {
    ...mapActions('UserGroups', [
      'fetchSuggestedChats', 
      'fetchJoinedChats',
      'searchSuggestedChats',
      'loadMoreSuggestedChats'
    ]),
    async checkLoginStatus() {
      this.loggedIn = await isLoggedIn();
      
      if (this.loggedIn) {
        this.fetchJoinedChats({});
      }
    },
    handleSignIn() {
      this.$store.dispatch('showLoginPopup');
      this.$store.dispatch('setRedirectPath', '/groups');
    },
    onChatJoined() {
      this.fetchJoinedChats({});
    },
    handleJoinedChatsPageChange(page) {
      this.fetchJoinedChats({ page });
    },
    handleSearch() {
      // Clear previous timeout
      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout);
      }
      
      // Set new timeout for search
      this.searchTimeout = setTimeout(() => {
        this.searchSuggestedChats(this.searchQuery);
      }, 300);
    },
    clearSearch() {
      this.searchQuery = '';
      this.searchSuggestedChats('');
    },
    initializeTooltips() {
      if (typeof bootstrap !== 'undefined') {
        this.disposeTooltips();
        
        this.$nextTick(() => {
          const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
          tooltipTriggerList.forEach((tooltipTriggerEl) => {
            if (!bootstrap.Tooltip.getInstance(tooltipTriggerEl)) {
              try {
                const tooltip = new bootstrap.Tooltip(tooltipTriggerEl, {
                  trigger: 'hover focus',
                  delay: { hide: 100 },
                });
                this.tooltips.push(tooltip);
              } catch (error) {
                // Silently handle tooltip initialization errors
              }
            }
          });
        });
      }
    },
    disposeTooltips() {
      if (typeof bootstrap !== 'undefined') {
        const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipElements.forEach((element) => {
          const tooltip = bootstrap.Tooltip.getInstance(element);
          if (tooltip) {
            try {
              tooltip.dispose();
            } catch (error) {
              // Silently handle tooltip disposal errors
            }
          }
        });
      }
      this.tooltips = [];
    },
    reinitializeTooltips() {
      this.$nextTick(() => {
        this.initializeTooltips();
      });
    },
  },
  mounted() {
    this.initializeTooltips();
  },
  updated() {
    this.reinitializeTooltips();
  },
  beforeUnmount() {
    if (this.searchTimeout) {
      clearTimeout(this.searchTimeout);
    }
    this.disposeTooltips();
  },
};
</script>

<style scoped>
.no-chat-wrapper {
  width: 55px;
  height: 55px;
}
.icon-heading {
  display: flex;
  align-items: center;
}
</style>
