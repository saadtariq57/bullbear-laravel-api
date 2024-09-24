<template>
    <div class="bg-white shadow-sm rounded p-2">
        <div class="row g-3" v-if="userMedia != ''">
            <div class="col-4" v-for="userAlbum in userMedia" :key="userAlbum.id">
                <a href="#">
                    <img :src="'/'+userAlbum.image" alt="" class="img-fluid w-100 user_post-img object-fit-cover">
                </a>
            </div>
        </div>
        <p v-else>No Media Found</p>
    </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userProfileModule from '@/stores/profileStore';

export default {
  data() {
    return {
      moduleRegistered: false
    };
  },
  computed: {
    ...mapState('userProfile', ['userMedia']),
  },
  created() {
    if (!this.$store.hasModule('userProfile')) {
      registerVuexModule('userProfile', userProfileModule);
      this.moduleRegistered = true;
    }
  },
  beforeDestroy() {
    if (this.moduleRegistered) {
      unregisterVuexModule('userProfile');
    }
  }
};
</script>

<style>
.user-post-img{
 object-fit: cover;
 height: 250px;
}
</style>