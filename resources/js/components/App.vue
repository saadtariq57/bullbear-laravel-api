<template>
      <!-- Topbar -->
      <Navigation></Navigation>
        <div class="page-content">
          <section class="feed-main container-fluid px-0">
            <router-view></router-view>
          </section>
        </div>
</template>

<script>
import { mapState } from 'vuex';
import Navigation from "./header/Navigation.vue";
import ablyService from '../services/ablyService.js';

export default {
  components: {
    Navigation,
  },
  computed: {
    ...mapState(['userData', 'loggedIn']),
  },
  watch: {
    loggedIn(newValue) {
      if (newValue && this.userData) {
        ablyService.initializeAbly().then(() => {
          ablyService.subscribeToUserNotifications(this.userData.id);
        });
      } else {
        ablyService.unsubscribeFromUserNotifications(this.userData?.id);
      }
    },
  },
  mounted() {
    if (this.loggedIn && this.userData) {
      ablyService.initializeAbly().then(() => {
        ablyService.subscribeToUserNotifications(this.userData.id);
      });
    }
  },
};
</script>
