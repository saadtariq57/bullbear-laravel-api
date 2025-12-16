<template>
  <BottomSheet
    ref="sheet"
    v-model="isOpen"
    :snap-points="snapPoints"
    :initial-snap="0"
    :close-threshold="0.33"
    @expanded-change="onExpandedChange"
    @after-close="onAfterClose"
  >
    <template #default="{ close }">
      <div class="following-sheet">
        <header class="following-sheet__header">
          <h2 class="following-sheet__title">Following</h2>
        </header>
        <div v-if="followersList.length === 0" class="following-sheet__empty text-center py-4">
          <p class="mb-1 fw-6">No followers yet</p>
          <p class="text-muted fs-12 mb-0">When someone follows you, they’ll appear here.</p>
        </div>

        <ul v-else class="following-sheet__list list-unstyled m-0">
          <li
            v-for="follower in followersList"
            :key="follower.id"
            class="following-sheet__item position-relative"
            :class="{ 'has-unread': !follower.read_at }"
          >
            <span v-if="!follower.read_at" class="following-sheet__unread position-absolute rounded-circle"></span>
            <a
              @click.prevent="handleFollowerClick(follower, close)"
              :href="'/profile/' + follower.user.name"
              class="following-sheet__link d-flex align-items-center gap-3 text-decoration-none"
            >
              <img :src="'/uploads/' + follower.user.avatar" alt="" class="rounded-circle" width="48" height="48">
              <div class="flex-fill">
                <p class="mb-0 text-uppercase fw-5 fs-12 text-wrap">
                  {{ follower.user.name }} has started following you
                </p>
              </div>
            </a>
          </li>
          <li v-if="userData" class="following-sheet__see-all">
            <a :href="'/profile/' + userData.name + '/follow'" class="d-block text-center py-3 text-decoration-none fw-6">
              See All
            </a>
          </li>
        </ul>
      </div>
    </template>
  </BottomSheet>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import BottomSheet from './BottomSheet.vue';

export default {
  name: 'MobileFollowingDrawer',
  components: { BottomSheet },
  data() {
    return {
      isOpen: false,
      snapPoints: [0.5, 1],
    };
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('userNotification', ['followers']),
    followersList() {
      return this.followers || [];
    }
  },
  methods: {
    ...mapActions('userNotification', ['markNotificationAsRead']),
    open() {
      this.isOpen = true;
    },
    close() {
      this.isOpen = false;
    },
    onExpandedChange(value) {
      this.$emit('expanded-change', value);
    },
    onAfterClose() {
      this.$emit('closed');
    },
    handleFollowerClick(follower, closeSheet) {
      if (!follower.read_at) {
        this.markNotificationAsRead(follower.id);
      }
      closeSheet();
      window.location.href = '/profile/' + follower.user.name;
    }
  }
};
</script>

<style scoped>
.following-sheet {
  display: flex;
  flex-direction: column;
  gap: 8px;
  min-height: 100%;
}

.following-sheet__header {
  text-align: center;
  padding: 4px 0 8px;
}

.following-sheet__title {
  font-size: 18px;
  font-weight: 600;
  margin: 0;
}

.following-sheet__empty {
  padding: 24px 8px;
}

.following-sheet__list {
  flex: 1;
  overflow-y: auto;
  padding: 0 4px;
  margin: 0;
}

.following-sheet__item {
  padding: 8px 0;
}

.following-sheet__item + .following-sheet__item {
  border-top: 1px solid #f1f1f1;
}

.following-sheet__link {
  color: inherit;
}

.following-sheet__unread {
  width: 10px;
  height: 10px;
  background-color: #edb043;
  left: -2px;
  top: 18px;
}

.following-sheet__see-all {
  position: sticky;
  bottom: 0;
  background: #fff;
  border-top: 1px solid #eee;
  margin-top: 8px;
}

.following-sheet__see-all a {
  color: #0d6efd;
  transition: background-color 0.2s ease;
}

.following-sheet__see-all a:hover {
  background-color: #f8f9fa;
}

@media (min-width: 768px) {
  .following-sheet {
    padding: 0 12px;
  }

  .following-sheet__title {
    font-size: 20px;
  }
}
</style>
