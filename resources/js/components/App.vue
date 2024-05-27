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

export default {
  components: {
    Navigation
  },
  computed: {
    ...mapState(['userData', 'loggedIn']),
  }
};
</script>
