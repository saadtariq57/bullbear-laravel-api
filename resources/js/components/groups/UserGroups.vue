<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-lg-8">
        <h1 class="icon-heading mb-4 fw-bold border-bottom">
          Chat Rooms
          <i
            class="bi bi-chat-dots-fill ms-2 tooltip-element"
            data-bs-placement="top"
            title="Explore various chat rooms"
          ></i>
        </h1>
        <div class="bg-white py-0 rounded-1 shadow-radius mt-3 groups-chats">
          <ul class="nav border-0 m-0 p-0" id="chats-content-tab" role="tablist">
            <li class="nav-item border-0 col-6" role="presentation">
              <button
                class="nav-link border-0 w-100 fs-16 fw-bold active m-0 py-2 px-3 bg-transparent tooltip-element"
                id="suggestedchats-tab"
                data-bs-toggle="tab"
                data-bs-target="#suggestedchats-tab-pane"
                type="button"
                role="tab"
                aria-controls="suggestedchats-tab-pane"
                aria-selected="true"
                data-bs-placement="bottom"
                title="View suggested chat rooms"
              >
                Suggested Chats
              </button>
            </li>
            <li class="nav-item col-6" role="presentation">
              <button
                class="nav-link border-0 fs-16 fw-bold m-0 py-2 px-3 bg-transparent w-100 tooltip-element"
                id="joinedchats-tab"
                data-bs-toggle="tab"
                data-bs-target="#joinedchats-tab-pane"
                type="button"
                role="tab"
                aria-controls="joinedchats-tab-pane"
                aria-selected="false"
                data-bs-placement="bottom"
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
          </div>
          <div
            class="tab-pane fade"
            id="joinedchats-tab-pane"
            role="tabpanel"
            aria-labelledby="joinedchats-tab"
            tabindex="0"
          >
            <template v-if="joinedChats && joinedChats.length">
              <ActiveChatRooms :chats="joinedChats" :joined="true" />
            </template>
            <template v-else>
              <div class="text-center my-5 py-5">
                <div
                  class="no-chat-wrapper rounded-circle bg-cta d-flex justify-content-center align-items-center position-relative mx-auto"
                >
                  <i
                    class="bi bi-chat-dots-fill text-white tooltip-element"
                    style="font-size: 35px;"
                    data-bs-placement="bottom"
                    title="No joined chat rooms"
                  ></i>
                </div>
                <p v-if="!loggedIn">
                  You are not logged in. See suggested rooms below.
                  <button
                    @click="handleSignIn"
                    class="btn btn-secondary mt-2 tooltip-element"
                    data-bs-placement="right"
                    title="Sign in to join chat rooms"
                  >
                    Sign in to Join
                  </button>
                </p>
                <p v-else class="fs-5 fw-5 mb-0 mt-2">
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
import { mapState, mapActions } from 'vuex';
import { isLoggedIn } from '@/stores';
import ActiveChatRooms from './ActiveChatRooms.vue';
import Markets from '../widgets/Markets.vue';
import MarketAnalysis from '../widgets/MarketAnalysisSidebar.vue';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userGroupsModule from '@/stores/groupStore';
import Swal from 'sweetalert2';

export default {
  name: 'UserGroups',
  components: {
    ActiveChatRooms,
    MarketAnalysis,
    Markets,
  },
  data() {
    return {
      moduleRegistered: false,
      loggedIn: false,
      tooltips: [],
    };
  },
  computed: {
    ...mapState('UserGroups', ['suggestedChats', 'joinedChats', 'isLoading', 'error']),
  },
  created() {
    if (!this.$store.hasModule('UserGroups')) {
      registerVuexModule('UserGroups', userGroupsModule);
      this.moduleRegistered = true;
    }
    this.checkLoginStatus();
    this.fetchSuggestedChats();
    if (this.loggedIn) {
      this.fetchJoinedChats();
    }
  },
  methods: {
    ...mapActions('UserGroups', ['fetchSuggestedChats', 'fetchJoinedChats']),
    async checkLoginStatus() {
      this.loggedIn = await isLoggedIn();
      if (this.loggedIn) {
        this.fetchJoinedChats();
      }
    },
    handleSignIn() {
      this.$store.dispatch('showLoginPopup');
      this.$store.dispatch('setRedirectPath', '/groups');
    },
    onChatJoined() {
      this.fetchJoinedChats();
    },
    initializeTooltips() {
      if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('.tooltip-element'));
        tooltipTriggerList.forEach((tooltipTriggerEl) => {
          const tooltip = new bootstrap.Tooltip(tooltipTriggerEl, {
            trigger: 'hover focus',
            delay: { hide: 100 },
          });
          this.tooltips.push(tooltip);
        });
      }
    },
    disposeTooltips() {
      this.tooltips.forEach((tooltip) => tooltip.dispose());
      this.tooltips = [];
    },
  },
  mounted() {
    this.initializeTooltips();
  },
  beforeUnmount() {
    if (this.moduleRegistered) {
      unregisterVuexModule('UserGroups');
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
