<template>
  <div v-if="!isCheckingAuthState">
    <Navigation></Navigation>
    <div class="page-content">
      <section class="feed-main container-fluid px-0">
        <router-view></router-view>
      </section>
    </div>
    <LoginPopup v-if="showLoginPopupState" />
  </div>
  <div v-else>
    <div class="preloader">Loading...</div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import Navigation from "./header/Navigation.vue";
import LoginPopup from "./login/LoginPopup.vue";
import { isCheckingAuth, checkLoginStatus, isLoggedIn, showLoginPopup } from '../stores';

export default {
  components: {
    Navigation,
    LoginPopup
  },
  setup() {
    const isCheckingAuthState = ref(true);
    const showLoginPopupState = ref(false);

    onMounted(async () => {
      await checkLoginStatus();
      isCheckingAuthState.value = isCheckingAuth();
      showLoginPopupState.value = showLoginPopup();
    });

    return {
      isCheckingAuthState,
      showLoginPopupState
    };
  }
};
</script>