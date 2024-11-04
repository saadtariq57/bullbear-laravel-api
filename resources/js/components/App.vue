<template>
  <div v-if="!isCheckingAuthState">
    <Navigation></Navigation>
    <div class="page-content">
      <section class="feed-main container-fluid px-0">
        <router-view></router-view>
      </section>
    </div>
    
    <!-- Login Popup -->
    <div v-if="showLoginPopupState" class="modal-backdrop" @click="closeLoginPopup"></div>
    <div v-if="showLoginPopupState" class="modal show d-block" tabindex="-1" role="dialog">
      <LoginPopup @close="closeLoginPopup" />
    </div>
  </div>
  <div v-else>
    <div class="preloader">Loading...</div>
  </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import { useStore } from 'vuex';
import Navigation from "./header/Navigation.vue";
import LoginPopup from "./utils/LoginPopup.vue";
import { isCheckingAuth, checkLoginStatus, isLoggedIn } from '../stores';

export default {
  components: {
    Navigation,
    LoginPopup
  },
  setup() {
    const store = useStore();
    const isCheckingAuthState = ref(true);
    const showLoginPopupState = ref(false);

    onMounted(async () => {
      //await checkLoginStatus();
      isCheckingAuthState.value = isCheckingAuth();
    });

    watch(() => store.state.showLoginPopup, (newValue) => {
      showLoginPopupState.value = newValue;
    });

    const closeLoginPopup = () => {
      store.dispatch('hideLoginPopup');
    };

    return {
      isCheckingAuthState,
      showLoginPopupState,
      closeLoginPopup
    };
  }
};
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1040;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal.show {
  display: block;
  z-index: 1050;
}
</style>