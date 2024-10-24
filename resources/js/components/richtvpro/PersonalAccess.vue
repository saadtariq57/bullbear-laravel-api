<template>
  <div class="container my-4">
    <!-- Header Section -->
    <div class="personal-head text-center border-bottom mb-4">
      <h1 class="fs-2 fw-bold">Personal Access</h1>
      <p class="lead">Book personal sessions with our experts tailored to your needs.</p>
    </div>

    <!-- Non-Logged-In Members Marketing Page -->
    <div v-if="!isUserLoggedIn" class="PersonalSessionsMarketingPage-marketingPageContainer d-flex flex-column">
      <!-- Buttons at Top Left -->
      <div class="PersonalSessionsMarketingPage-buttons d-flex justify-content-start mb-5">
        <button
          class="PersonalSessionsMarketingPage-signInButton me-2"
          @click="handleSignIn"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          title="Sign in to your existing account"
        >
          <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
        <button
          class="PersonalSessionsMarketingPage-createAccountButton"
          @click="handleCreateAccount"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          title="Create a free account to get started"
        >
          <i class="bi bi-person-plus me-2"></i>Create Free Account
        </button>
      </div>

      <!-- Main Content -->
      <div class="PersonalSessionsMarketingPage-content d-flex">
        <!-- Left Column: Heading and Text -->
        <div class="PersonalSessionsMarketingPage-text">
          <h2 class="fs-3">Unlock Exclusive Personal Sessions</h2>
          <p class="text-muted">
            Gain access to personalized sessions with our experts, designed to help you achieve your goals efficiently.
          </p>
          <h2>Enhance Your Learning Experience</h2>
          <p>
            Gain access to personalized sessions with our experts, designed to help you achieve your goals efficiently.
            Whether you're looking to improve your skills or seek professional guidance, our Personal Sessions are here to assist you.
          </p>
          <p class="mt-3 text-muted">
            Start your journey towards personal growth by signing up today.
          </p>
        </div>
        
        <!-- Right Column: Image -->
        <div class="PersonalSessionsMarketingPage-imageContainer ms-auto">
          <img src="../../../images/sessions-preview.png" alt="Personal Sessions Marketing Image" loading="lazy">
        </div>
      </div>
    </div>


    <!-- Logged-In User Content -->
    <div v-else>
      <!-- Subcase 2: Logged In but Doesn't Have the Feature -->
      <div v-if="!hasPersonalSessionsFeature" class="text-center">
        <h2>Upgrade to Unlock Personal Sessions</h2>
        <p>Enhance your experience by upgrading your subscription to access personal sessions with our experts.</p>
        <div class="mt-3">
          <a href="/upgrade" class="btn btn-primary">Upgrade Now</a>
        </div>
      </div>

      <!-- Subcase 3: Logged In and Has the Feature -->
      <div v-else>
        <!-- Action Cards -->
        <div class="personal-card-wrapper row py-4">
          <!-- Book an Appointment Card -->
          <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border">
              <div class="card-body text-center">
                <i class="bi bi-calendar3 fs-2 mb-3"></i>
                <h2 class="fs-4 fw-semibold">Book An Appointment</h2>
                <p>Schedule a session with a professional to receive personalized assistance and efficient problem-solving.</p>
                <button class="btn btn-primary" @click="showAppointmentModal()" :disabled="!canBookSession">Schedule</button>
                <div v-if="!canBookSession" class="mt-2 text-danger">
                  You have reached the maximum number of personal sessions.
                </div>
              </div>
            </div>
          </div>

          <!-- View Guidelines Card -->
          <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border">
              <div class="card-body text-center">
                <i class="bi bi-info-circle fs-2 mb-3"></i>
                <h2 class="fs-4 fw-semibold">View Guidelines</h2>
                <p>Understand how to make the most out of your personal sessions with our comprehensive guidelines.</p>
                <button class="btn btn-outline-primary" @click="showGuidelinesModal">Learn More</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="row mb-3">
          <div class="col-md-6">
            <input
              type="text"
              class="form-control"
              placeholder="Search Sessions"
              v-model="searchQuery"
              @input="filterSessions"
              aria-label="Search Sessions"
            >
          </div>
          <div class="col-md-6 text-md-end mt-2 mt-md-0">
            <button class="btn btn-outline-secondary me-2" @click="sortSessions('scheduled_at')">
              Sort by Date <i :class="sortIcon('scheduled_at')"></i>
            </button>
            <button class="btn btn-outline-secondary" @click="sortSessions('status')">
              Sort by Status <i :class="sortIcon('status')"></i>
            </button>
          </div>
        </div>
        <!-- Previous Sessions -->
        <div class="mt-5">
          <h3>Your Booked Sessions</h3>
          <div v-if="loading" class="text-center my-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
          <div v-else>
            <div v-if="filteredSessions.length > 0" class="table-responsive">
              <table class="table table-hover table-nowrap align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th>ID</th>
                    <th>Scheduled At</th>
                    <th>Meeting Link</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="session in paginatedSessions" :key="session.id">
                    <td>{{ session.id }}</td>
                    <td>{{ formatDate(session.scheduled_at) }}</td>
                    <td><a :href="session.meet_link" target="_blank">{{ session.meet_link }}</a></td>
                    <td>
                      <span :class="statusBadge(session.status)" aria-label="Session Status">
                        {{ capitalize(session.status) }}
                      </span>
                    </td>
                    <td>
                      <button
                        class="btn btn-sm btn-outline-primary me-2"
                        @click="viewSession(session)"
                        aria-label="View Session Details"
                        data-bs-toggle="tooltip"
                        title="View detailed information about this session"
                      >
                        <i class="bi bi-eye"></i> View
                      </button>
                      <button
                        class="btn btn-sm btn-outline-danger"
                        @click="confirmCancel(session)"
                        aria-label="Cancel Session"
                        data-bs-toggle="tooltip"
                        title="Cancel this session"
                      >
                        <i class="bi bi-x-circle"></i> Cancel
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div v-else class="text-center">
              <p>You have no booked sessions yet.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for Booking -->
    <div
      class="modal fade"
      ref="appointmentModalRef"
      id="appointmentModal"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="appointmentModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="appointmentModalLabel">Book an Appointment</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="hideAppointmentModal()"
            ></button>
          </div>
          <div class="modal-body">
            <!-- Custom booking form -->
            <form @submit.prevent="bookSession">
              <div class="mb-3">
                <label for="scheduled_at" class="form-label">Choose Date and Time</label>
                <input
                  type="datetime-local"
                  v-model="scheduledAt"
                  class="form-control"
                  id="scheduled_at"
                  required
                  aria-required="true"
                >
              </div>
              <button type="submit" class="btn btn-primary">Book Session</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal for Viewing Session Details -->
    <div
      class="modal fade"
      ref="viewSessionModalRef"
      id="viewSessionModal"
      tabindex="-1"
      aria-labelledby="viewSessionModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="viewSessionModalLabel">Session Details</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="hideViewSessionModal()"
            ></button>
          </div>
          <div class="modal-body" v-if="selectedSession">
            <p><strong>ID:</strong> {{ selectedSession.id }}</p>
            <p><strong>Scheduled At:</strong> {{ formatDate(selectedSession.scheduled_at) }}</p>
            <p><strong>Status:</strong> {{ capitalize(selectedSession.status) }}</p>
            <p><strong>Meeting Link:</strong> <a :href="selectedSession.meet_link" target="_blank">{{ selectedSession.meet_link }}</a></p>
          </div>
          <div class="modal-body" v-else>
            <p>Loading...</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Confirmation Modal for Canceling Session -->
    <div
      class="modal fade"
      ref="confirmCancelModalRef"
      id="confirmCancelModal"
      tabindex="-1"
      aria-labelledby="confirmCancelModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmCancelModalLabel">Cancel Session</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="hideConfirmCancelModal()"
            ></button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to cancel this session?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="hideConfirmCancelModal()">No</button>
            <button type="button" class="btn btn-danger" @click="cancelSession()">Yes, Cancel</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for Guidelines -->
    <div
      class="modal fade"
      ref="guidelinesModalRef"
      id="guidelinesModal"
      tabindex="-1"
      aria-labelledby="guidelinesModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="guidelinesModalLabel">How It Works</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="hideGuidelinesModal()"
            ></button>
          </div>
          <div class="modal-body">
            <div class="guidelines-steps">
              <div class="step mb-4" v-for="(step, index) in guidelines" :key="index">
                <div class="d-flex align-items-center mb-2">
                  <div class="step-number me-3">
                    <span class="badge bg-primary rounded-circle">{{ index + 1 }}</span>
                  </div>
                  <h5 class="mb-0 g-title">{{ step.title }}</h5>
                </div>
                <p>{{ step.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import { Modal } from 'bootstrap';
import axios from 'axios';
import Swal from 'sweetalert2';
import { isLoggedIn } from '@/stores';
import { computed, ref, onMounted } from 'vue';
import { useStore } from 'vuex';

export default {
  setup() {
    const store = useStore();

    // DOM Element Refs
    const appointmentModalRef = ref(null);
    const viewSessionModalRef = ref(null);
    const confirmCancelModalRef = ref(null);
    const guidelinesModalRef = ref(null); // Ref for Guidelines Modal

    // Bootstrap Modal Instances
    let appointmentModalInstance = null;
    let viewSessionModalInstance = null;
    let confirmCancelModalInstance = null;
    let guidelinesModalInstance = null; // Instance for Guidelines Modal

    // Reactive data
    const scheduledAt = ref('');
    const subscriptionStatus = ref({
      authenticated: false,
      features: {},
      subscription: {},
    });
    const sessions = ref([]);
    const filteredSessions = ref([]);
    const searchQuery = ref('');
    const sortKey = ref('');
    const sortAsc = ref(true);
    const loading = ref(false);
    const selectedSession = ref(null);
    const sessionToCancel = ref(null);
    const currentPage = ref(1);
    const perPage = ref(5);
    const statusFilter = ref('');

    // Guidelines Data
    const guidelines = ref([
      {
        title: 'Book',
        description: 'Choose a convenient date and time to book your personal session with one of our trading experts.',
      },
      {
        title: 'Assignment',
        description: 'Once booked, your session will be assigned to a suitable expert based on your needs and availability.',
      },
      {
        title: 'Confirmation',
        description: 'After assignment, you will receive a confirmation email containing a meeting link to join your session.',
      },
      {
        title: 'Join',
        description: 'Use the provided link to join your session and engage in a productive discussion with our trading expert.',
      },
    ]);

    // Computed properties
    const isUserLoggedIn = computed(() => store.state.userData !== null);

    const hasPersonalSessionsFeature = computed(() => {
      const featureNames = ['monthly_personal_sessions', 'monthly_personal_session'];
      for (let featureName of featureNames) {
        const feature = subscriptionStatus.value.features[featureName];
        if (feature && feature.enabled) {
          return true;
        }
      }
      return false;
    });

    const totalPages = computed(() => {
      return Math.ceil(filteredSessions.value.length / perPage.value);
    });

    const paginatedSessions = computed(() => {
      const start = (currentPage.value - 1) * perPage.value;
      const end = start + perPage.value;
      return filteredSessions.value.slice(start, end);
    });

    const canBookSession = computed(() => {
      const personalSessionFeature = subscriptionStatus.value.features.monthly_personal_session;
      return personalSessionFeature && personalSessionFeature.can_access;
    });

    // Methods
    const handleSignIn = () => {
      store.dispatch('showLoginPopup');
      store.dispatch('setRedirectPath', '/personal-access');
    };

    const handleCreateAccount = () => {
      store.dispatch('showSignUpPopup');
      store.dispatch('setRedirectPath', '/personal-access');
    };

    const fetchSubscriptionStatus = async () => {
      loading.value = true;
      try {
        const response = await axios.get('/api/subscriptionStatus');
        subscriptionStatus.value = response.data;

        if (subscriptionStatus.value.authenticated && hasPersonalSessionsFeature.value) {
          await fetchSessions();
        }
        filteredSessions.value = sessions.value;
      } catch (error) {
        console.error('Error fetching subscription status:', error);
        Swal.fire({
          title: 'Error!',
          text: 'Failed to fetch subscription status.',
          icon: 'error',
          confirmButtonText: 'OK',
        });
      } finally {
        loading.value = false;
      }
    };

    const fetchSessions = async () => {
      loading.value = true;
      try {
        const response = await axios.get('/api/personal_sessions');
        sessions.value = response.data.data.data; // Adjust based on API response structure
        filteredSessions.value = sessions.value;

        // Update can_access based on current_count
        const personalSessionFeature = subscriptionStatus.value.features.monthly_personal_session;
        if (personalSessionFeature) {
          personalSessionFeature.can_access = personalSessionFeature.current_count < personalSessionFeature.limit;
        }
      } catch (error) {
        console.error('Error fetching sessions:', error);
        Swal.fire({
          title: 'Error!',
          text: 'Failed to fetch sessions.',
          icon: 'error',
          confirmButtonText: 'OK',
        });
      } finally {
        loading.value = false;
      }
    };

    const showAppointmentModal = () => {
      if (appointmentModalInstance) {
        appointmentModalInstance.show();
      } else {
        console.error('Appointment Modal instance is not initialized.');
      }
    };

    const hideAppointmentModal = () => {
      if (appointmentModalInstance) {
        appointmentModalInstance.hide();
      }
    };

    const bookSession = async () => {
      if (!scheduledAt.value) {
        Swal.fire({
          title: 'Error!',
          text: 'Please select a date and time.',
          icon: 'error',
          confirmButtonText: 'OK',
        });
        return;
      }

      // Check if user can book more sessions
      const personalSessionFeature = subscriptionStatus.value.features.monthly_personal_session;
      if (personalSessionFeature && !personalSessionFeature.can_access) {
        Swal.fire({
          title: 'Limit Reached!',
          text: 'You have reached the maximum number of personal sessions allowed. Please cancel an existing session to book a new one.',
          icon: 'warning',
          confirmButtonText: 'OK',
        });
        return;
      }

      try {
        const response = await axios.post('/api/personal_sessions', {
          scheduled_at: scheduledAt.value,
        });

        // Handle success
        hideAppointmentModal();
        Swal.fire({
          title: 'Success!',
          text: 'Session booked successfully.',
          icon: 'success',
          confirmButtonText: 'OK',
        });
        scheduledAt.value = '';
        await fetchSessions();
      } catch (error) {
        // Handle error
        Swal.fire({
          title: 'Error!',
          text: error.response?.data?.message || 'Failed to book session. Please try again.',
          icon: 'error',
          confirmButtonText: 'OK',
        });
        console.error(error);
      }
    };

    const viewSession = (session) => {
      selectedSession.value = session;
      if (viewSessionModalInstance) {
        viewSessionModalInstance.show();
      }
    };

    const hideViewSessionModal = () => {
      selectedSession.value = null;
      if (viewSessionModalInstance) {
        viewSessionModalInstance.hide();
      }
    };

    const confirmCancel = (session) => {
      sessionToCancel.value = session;
      if (confirmCancelModalInstance) {
        confirmCancelModalInstance.show();
      }
    };

    const hideConfirmCancelModal = () => {
      sessionToCancel.value = null;
      if (confirmCancelModalInstance) {
        confirmCancelModalInstance.hide();
      }
    };

    const cancelSession = async () => {
      try {
        // Send a PUT request to update the session status to 'cancelled'
        await axios.put(`/api/personal_sessions/${sessionToCancel.value.id}`, {
          status: 'cancelled',
        });
        Swal.fire({
          title: 'Cancelled!',
          text: 'Your session has been cancelled.',
          icon: 'success',
          confirmButtonText: 'OK',
        });
        hideConfirmCancelModal();
        await fetchSessions();
      } catch (error) {
        Swal.fire({
          title: 'Error!',
          text: error.response?.data?.message || 'Failed to cancel session. Please try again.',
          icon: 'error',
          confirmButtonText: 'OK',
        });
        console.error(error);
      }
    };

    const showGuidelinesModal = () => {
      if (guidelinesModalInstance) {
        guidelinesModalInstance.show();
      } else {
        console.error('Guidelines Modal instance is not initialized.');
      }
    };

    const hideGuidelinesModal = () => {
      if (guidelinesModalInstance) {
        guidelinesModalInstance.hide();
      }
    };

    const formatDate = (dateStr) => {
      const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
      return new Date(dateStr).toLocaleDateString(undefined, options);
    };

    const capitalize = (text) => {
      if (!text) return '';
      return text.charAt(0).toUpperCase() + text.slice(1);
    };

    const statusBadge = (status) => {
      const statusMap = {
        pending: 'badge bg-warning text-dark',
        confirmed: 'badge bg-success',
        completed: 'badge bg-secondary',
        cancelled: 'badge bg-danger',
      };
      return statusMap[status] || 'badge bg-light text-dark';
    };

    const filterSessions = () => {
      let tempSessions = sessions.value;

      if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        tempSessions = tempSessions.filter((session) => {
          return (
            session.id.toString().includes(query) ||
            formatDate(session.scheduled_at).toLowerCase().includes(query) ||
            session.status.toLowerCase().includes(query)
          );
        });
      }

      if (statusFilter.value) {
        tempSessions = tempSessions.filter((session) => session.status === statusFilter.value);
      }

      filteredSessions.value = tempSessions;
      currentPage.value = 1;
    };

    const sortSessions = (key) => {
      if (sortKey.value === key) {
        sortAsc.value = !sortAsc.value;
      } else {
        sortKey.value = key;
        sortAsc.value = true;
      }

      filteredSessions.value.sort((a, b) => {
        let result = 0;
        if (a[key] < b[key]) result = -1;
        if (a[key] > b[key]) result = 1;
        return sortAsc.value ? result : -result;
      });
    };

    const sortIcon = (key) => {
      if (sortKey.value !== key) return 'bi bi-arrow-down-up';
      return sortAsc.value ? 'bi bi-arrow-up' : 'bi bi-arrow-down';
    };

    const changePage = (page) => {
      if (page < 1 || page > totalPages.value) return;
      currentPage.value = page;
    };

    const exportSessions = () => {
      if (filteredSessions.value.length === 0) {
        Swal.fire({
          title: 'No Data!',
          text: 'There are no sessions to export.',
          icon: 'info',
          confirmButtonText: 'OK',
        });
        return;
      }

      const csvContent =
        'data:text/csv;charset=utf-8,' +
        ['ID,Scheduled At,Status']
          .concat(
            filteredSessions.value.map(
              (session) => `${session.id},"${formatDate(session.scheduled_at)}",${session.status}`
            )
          )
          .join('\n');

      const encodedUri = encodeURI(csvContent);
      const link = document.createElement('a');
      link.setAttribute('href', encodedUri);
      link.setAttribute('download', 'sessions.csv');
      document.body.appendChild(link); // Required for FF

      link.click();
      document.body.removeChild(link);
    };

    // Lifecycle hooks
    onMounted(() => {
      // Initialize Bootstrap Modals using refs
      appointmentModalInstance = new Modal(appointmentModalRef.value, { backdrop: 'static' });
      viewSessionModalInstance = new Modal(viewSessionModalRef.value, { backdrop: 'static' });
      confirmCancelModalInstance = new Modal(confirmCancelModalRef.value, { backdrop: 'static' });
      guidelinesModalInstance = new Modal(guidelinesModalRef.value, { backdrop: 'static' });

      // Initialize tooltips if any
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });

      if (isLoggedIn()) {
        subscriptionStatus.value.authenticated = true;
        fetchSubscriptionStatus();
      }
    });

    return {
      // DOM Element Refs
      appointmentModalRef,
      viewSessionModalRef,
      confirmCancelModalRef,
      guidelinesModalRef,

      // Data
      scheduledAt,
      subscriptionStatus,
      sessions,
      filteredSessions,
      searchQuery,
      sortKey,
      sortAsc,
      loading,
      selectedSession,
      sessionToCancel,
      currentPage,
      perPage,
      statusFilter,

      // Guidelines Data
      guidelines,

      // Computed
      isUserLoggedIn,
      hasPersonalSessionsFeature,
      totalPages,
      paginatedSessions,
      canBookSession,

      // Methods
      handleSignIn,
      handleCreateAccount,
      fetchSubscriptionStatus,
      fetchSessions,
      showAppointmentModal,
      hideAppointmentModal,
      bookSession,
      viewSession,
      hideViewSessionModal,
      confirmCancel,
      hideConfirmCancelModal,
      cancelSession,
      showGuidelinesModal,
      hideGuidelinesModal,
      formatDate,
      capitalize,
      statusBadge,
      filterSessions,
      sortSessions,
      sortIcon,
      changePage,
      exportSessions,
    };
  },
};
</script>


<style scoped>
.PersonalSessionsMarketingPage-marketingPageContainer {
  background-color: #e7eef6; /* Matching the Stock Screener background */
  background-image: linear-gradient(135deg, transparent 50%, #f3f7fb 0);
  padding: 50px 40px;
  display: flex;
  flex-direction: column;
  align-items: flex-start; /* Align items to the start for left alignment */
}

/* Buttons Styling */
.PersonalSessionsMarketingPage-buttons button {
  padding: 15px 25px;
  background-color: #005594;
  color: #fff;
  border: none;
  cursor: pointer;
  font-size: 1rem;
  font-weight: 600;
  letter-spacing: 1px;
  display: flex;
  align-items: center;
}

.PersonalSessionsMarketingPage-buttons button i {
  margin-right: 8px;
}

/* Text Section */
.PersonalSessionsMarketingPage-text {
  flex: 0 0 40%;
  padding-right: 30px;
}

.PersonalSessionsMarketingPage-text h2 {
  font-size: 1.53125rem !important;
  margin-bottom: 15px;
}

.PersonalSessionsMarketingPage-text p {
  color: #555;
  font-size: 1rem;
}

.PersonalSessionsMarketingPage-text .text-muted {
  color: #6c757d;
}

/* Image Container */
.PersonalSessionsMarketingPage-imageContainer {
  flex: 0 0 60%;
}

.PersonalSessionsMarketingPage-imageContainer img {
  max-width: 100%;
  object-fit: cover;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Responsive Design */
@media (max-width: 992px) {
  .PersonalSessionsMarketingPage-text {
    flex: 0 0 100%;
    padding-right: 0px;
    margin-bottom: 40px;
    text-align: center;
  }
  .PersonalSessionsMarketingPage-imageContainer {
    flex: 0 0 100%;
  }
  .PersonalSessionsMarketingPage-content {
    flex-direction: column;
    align-items: center;
  }
}

@media (max-width: 576px) {
  .PersonalSessionsMarketingPage-buttons {
    flex-direction: column;
    gap: 15px;
    width: 100%;
  }
  .PersonalSessionsMarketingPage-buttons button {
    width: 100%;
    justify-content: center;
  }
}
/* General Styling */
.g-title {
  max-width: 110px !important;
  width: 110px !important;
}

/* Additional Styling for Action Cards */
.personal-card-wrapper .card {
  transition: transform 0.2s;
}

.personal-card-wrapper .card:hover {
  transform: translateY(-5px);
}

/* Badge Styles for Status */
.badge.bg-warning.text-dark {
  background-color: #ffc107;
  color: #212529;
}

.badge.bg-success {
  background-color: #198754;
}

.badge.bg-secondary {
  background-color: #6c757d;
}

.badge.bg-danger {
  background-color: #dc3545;
}

/* Modal Dialog Widths */
#appointmentModal .modal-dialog,
#viewSessionModal .modal-dialog,
#confirmCancelModal .modal-dialog,
#guidelinesModal .modal-dialog {
  max-width: 500px;
}

/* Guidelines Modal Styling */
.guidelines-steps .step {
  display: flex;
  align-items: flex-start;
  animation: fadeInUp 0.5s ease forwards;
}

.guidelines-steps .step-number {
  flex-shrink: 0;
}

.guidelines-steps .step h5 {
  margin: 0;
}

.guidelines-steps .step p {
  margin: 0;
  margin-left: 10px;
}

/* Fade In Up Animation */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive Table */
@media (max-width: 768px) {
  .table-responsive {
    font-size: 0.9rem;
  }
}
</style>
