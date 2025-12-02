<template>
  <transition name="fade">
    <div v-if="userProfileData">
      <div class="row">
        <!-- Profile Completion Widget -->
        <div class="col-12">
        <ProfileCompletionWidget
          v-if="completionPercentage < 100"
          :completionPercentage="completionPercentage"
          :profileSteps="profileSteps"
        />
        </div>

        <!-- Info Widget -->
        <div class="col-12 mt-3">
        <InfoWidget
          :userProfileData="userProfileData"
          :userOnline="userOnline"
        />
        </div>

        <!-- Suggested Traders To Follow Widget -->
        <div class="col-12 mt-3">
        <SuggestedTradersWidget />
      </div>

      <!-- Risk Disclaimer -->
        <div class="col-12 mt-3">
      <RiskDisclaimer />
        </div>
      </div>

      <!-- Footer -->
      <FooterComponent />
    </div>
  </transition>
</template>

<script>
import { mapState, mapActions, mapGetters } from 'vuex';
import { Dropdown } from 'bootstrap';
import axios from 'axios';

// Importing the new components
import ProfileCompletionWidget from './ProfileCompletionWidget.vue';
import InfoWidget from './InfoWidget.vue';
import SuggestedTradersWidget from './SuggestedTradersWidget.vue';
import RiskDisclaimer from './RiskDisclaimer.vue';
import FooterComponent from './FooterComponent.vue';

export default {
  components: {
    ProfileCompletionWidget,
    InfoWidget,
    SuggestedTradersWidget,
    RiskDisclaimer,
    FooterComponent,
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('userProfile', ['userProfileData', 'userOnline']),
    profileSteps() {
      return [
        {
          label: 'Add your Profile Picture',
          iconClass: this.userData.avatar === 'photos/d-avatar.jpg' ? 'bi-plus-circle-fill' : 'bi-check-circle-fill text-success',
        },
        {
          label: 'Add your Cover Photo',
          iconClass: this.userData.cover === 'photos/d-cover.jpg' ? 'bi-plus-circle-fill' : 'bi-check-circle-fill text-success',
        },
        {
          label: 'Add your Socials Links',
          iconClass: this.userData.twitter || this.userData.linkedin || this.userData.youtube ? 'bi-check-circle-fill text-success' : 'bi-plus-circle-fill',
        },
        {
          label: 'Add your Phone Number',
          iconClass: !this.userData.phone_number ? 'bi-plus-circle-fill' : 'bi-check-circle-fill text-success',
        },
        {
          label: 'Add About Description',
          iconClass: !this.userData.about ? 'bi-plus-circle-fill' : 'bi-check-circle-fill text-success',
        },
      ];
    },
    completionPercentage() {
      let completedSteps = 0;
      const totalSteps = this.profileSteps.length;

      this.profileSteps.forEach(step => {
        if (step.iconClass.includes('bi-check-circle-fill')) {
          completedSteps++;
        }
      });

      return Math.round((completedSteps / totalSteps) * 100);
    },
  },
  methods: {
    ...mapActions(['fetchUserData']),
    toggleDropdown(event) {
      const dropdownElement = event.target.closest('.dropdown-toggle');
      const dropdownInstance = Dropdown.getOrCreateInstance(dropdownElement);
      dropdownInstance.toggle();
    },
  },
};
</script>

<style scoped>
.icon-round-bg {
  width: 27px;
  height: 27px;
}

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

.btn-outline-primary.btn-sm {
  transition: background-color 0.3s ease, color 0.3s ease;
}

.btn-outline-primary.btn-sm:hover {
  background-color: var(--cta-btn-hover);
  color: #000;
}

.hover-shadow:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: box-shadow 0.3s ease;
}

/* Fade Transition */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
