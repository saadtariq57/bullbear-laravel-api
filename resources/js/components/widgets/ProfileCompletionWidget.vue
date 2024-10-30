<template>
  <ul class="bg-white list-unstyled rounded-1 pb-2 shadow position-relative">
    <div class="profile-completion-overlay d-flex justify-content-center align-items-center" v-if="completionPercentage === 100">
      <div class="completion-icon rounded-circle d-flex justify-content-center align-items-center text-cta">
        <i class="bi bi-check-lg fs-1 fw-bolder"></i>
      </div>
    </div>
    <li class="mb-1">
      <div class="progress profile-progress position-relative rounded-top rounded-0">
        <div class="progress-bar profile-progress-bar" role="progressbar" :aria-valuenow="completionPercentage"
          aria-valuemin="0" aria-valuemax="100" :style="{ width: completionPercentage + '%' }"></div>
        <h4 class="d-flex justify-content-between position-absolute w-100 text-white m-0 px-3 py-2 fw-6 fs-6">
          <span>Profile Completion</span>
          <span>{{ completionPercentage }}%</span>
        </h4>
      </div>
    </li>
    <li class="px-3 py-1 fs-16" v-for="(item, index) in profileSteps" :key="index">
      <i class="bi me-3 fs-5" :class="item.iconClass"></i>
      <span>{{ item.label }}</span>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'ProfileCompletionWidget',
  props: {
    completionPercentage: {
      type: Number,
      required: true,
    },
    profileSteps: {
      type: Array,
      required: true,
    },
  },
};
</script>

<style scoped>
.profile-progress-bar {
  background-color: var(--cta-btn);
}

.profile-completion-overlay {
  background: rgba(255, 255, 255, 0.8);
  transition: opacity 0.3s ease;
}

.profile-completion-overlay:hover {
  opacity: 1;
}

.completion-icon {
  width: 60px;
  height: 60px;
  background-color: var(--cta-btn);
  transition: transform 0.3s ease;
}

.completion-icon:hover {
  transform: scale(1.1);
}
</style>
