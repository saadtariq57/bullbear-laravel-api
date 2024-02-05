<template>
  <div ref="reactionModal" class="modal fade" id="reactionPostModal" tabindex="-1"
    aria-labelledby="reactionPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header pb-0 border-0">
          <h1 class="modal-title fs-5" id="reactionPostModalLabel">Reactions</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
            @click="$emit('close-modal')"></button>
        </div>
        <div class="mt-2 reactions-post-wrapper mx-3">
          <ul class="nav border-0 nav-tabs gap-1 flex-nowrap" id="reactions-post-Followers-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button
                class="nav-link border-0 fs-6 text-black px-2 py-2 d-flex btn-feed-hover reactions-post-nav-btn text-nowrap active"
                id="allreactions-tab" data-bs-toggle="tab" data-bs-target="#allreactions-tab-pane" type="button"
                role="tab" aria-controls="allreactions-tab-pane" aria-selected="false">
                <span class="me-1">All</span>
                <span>{{ totalReactionsCount }}</span>
              </button>
            </li>
            <li class="nav-item" role="presentation" v-for="(reaction, type) in activeItem.reactionData" :key="type">
              <button
                class="nav-link border-0 fs-6 text-black px-2 py-2 d-flex btn-feed-hover reactions-post-nav-btn text-nowrap"
                :id="`${type}reactions-tab`" data-bs-toggle="tab" :data-bs-target="`#${type}reactions-tab-pane`"
                type="button" role="tab" :aria-controls="`${type}reactions-tab-pane`" aria-selected="false">
                <img :src="`/upload/icons/${type}.png`" alt="" width="18px" class="me-1">
                <span>{{ reaction.count }}</span>
              </button>
            </li>
          </ul>
        </div>
        <div class="modal-body">
          <div class="list-group">
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="allreactions-tab-pane" role="tabpanel"
                aria-labelledby="allreactions-tab" tabindex="0">
                <template v-for="(reaction, type) in activeItem.reactionData">
                  <a href="#"
                    class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0"
                    v-for="detail in reaction.details" :key="`${type}-${detail.userId}`">
                    <div class="position-relative">
                      <img :src="detail.userImage" alt="" width="45" height="45" class="rounded-circle">
                      <span
                        class="user-reaction position-absolute bg-white rounded-circle d-flex justify-content-center align-items-center">
                        <img :src="detail.reactionImage" alt="" width="15px" height="15px">
                      </span>
                    </div>
                    <div class="flex-fill border-bottom py-3">
                      <h6 class="fs-6 fw-6 clr-primary user-name">{{ detail.userName }}</h6>
                      <!-- Add the user's about text or any other information if available -->
                    </div>
                  </a>
                </template>
              </div>
              <div class="tab-pane fade" v-for="(reaction, type) in activeItem.reactionData"
                :id="`${type}reactions-tab-pane`" role="tabpanel" :aria-labelledby="`${type}reactions-tab`" tabindex="0"
                :key="type">
                <a href="#"
                  class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0"
                  v-for="detail in reaction.details" :key="`${type}-${detail.userId}`">
                  <div class="position-relative">
                    <img :src="detail.userImage" alt="" width="45" height="45" class="rounded-circle">
                  </div>
                  <div class="flex-fill border-bottom py-3">
                    <h6 class="fs-6 fw-6 clr-primary user-name">{{ detail.userName }}</h6>
                    <!-- Add the user's about text or any other information if available -->
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    activeItem: Object,
  },
  computed: {
    totalReactionsCount() {
      return Object.values(this.activeItem.reactionData).reduce((acc, reaction) => acc + reaction.count, 0);
    },
    allReactions() {
      return Object.values(this.activeItem.reactionData).flatMap(reaction => reaction.details);
    },
  },
  mounted() {
    this.$emit('modal-mounted', this.$el);
  }
};
</script>
<style>
#reactionPostModal .modal-dialog-scrollable .modal-content {
  height: 600px;
}

.reactions-post-wrapper {
  min-height: 39px;
  overflow: auto;
  border-bottom: 1px solid #00000014;
}

.reactions-post-wrapper ul {
  max-width: fit-content;
  height: 38px;
}

.reactions-post-wrapper::-webkit-scrollbar {
  height: 0PX;
}

.reactions-post-nav-btn.active {
  background-color: #00000014 !important;
  border-bottom: 1px solid #000000 !important;
}

.user-reaction {
  right: -3px;
  bottom: 0;
  width: 20px;
  height: 20px;
}
</style>