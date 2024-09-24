<template>
    <div class="container my-4">
        <!-- Header Section -->
        <div class="personal-head text-center border-bottom mb-4">
            <h1 class="fs-2 fw-bold">Personal Access</h1>
            <p class="lead">Book personal sessions with our experts tailored to your needs.</p>
        </div>

        <!-- Case 1: User Isn't Logged In -->
        <div v-if="!subscriptionStatus.authenticated" class="text-center">
            <h2>Join Us Today!</h2>
            <p>Unlock exclusive personal sessions by creating an account or logging in.</p>
            <div class="mt-3">
                <a href="/login" class="btn btn-primary me-2">Login</a>
                <a href="/register" class="btn btn-secondary">Register</a>
            </div>
        </div>

        <!-- Case 2 & 3: User Is Logged In -->
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
                                <p>Book a session with a professional to receive personalized assistance and efficient problem-solving.</p>
                                <button class="btn btn-primary" @click="showAppointmentModal()" :disabled="!canBookSession">Schedule</button>
                                <div v-if="!canBookSession" class="mt-2 text-danger">
                                    You have reached the maximum number of personal sessions.
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border">
                            <div class="card-body text-center">
                                <i class="bi bi-info-circle fs-2 mb-3"></i>
                                <h2 class="fs-4 fw-semibold">View Guidelines</h2>
                                <p>Understand how to make the most out of your personal sessions with our comprehensive guidelines.</p>
                                <a href="/guidelines" class="btn btn-outline-primary">Learn More</a>
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
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="session in paginatedSessions" :key="session.id">
                                        <td>{{ session.id }}</td>
                                        <td>{{ formatDate(session.scheduled_at) }}</td>
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
            ref="appointment"
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
            ref="viewSessionModal"
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
            ref="confirmCancelModal"
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
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import axios from 'axios';
import Swal from 'sweetalert2';
import { isLoggedIn } from '@/stores';

export default {
    data() {
        return {
            appointmentModalInstance: null,
            viewSessionModalInstance: null,
            confirmCancelModalInstance: null,
            scheduledAt: '',
            subscriptionStatus: {
                authenticated: false,
                features: {},
                subscription: {},
            },
            sessions: [],
            filteredSessions: [],
            searchQuery: '',
            sortKey: '',
            sortAsc: true,
            loading: false,
            selectedSession: null,
            sessionToCancel: null,
            currentPage: 1,
            perPage: 5,
            statusFilter: '',
            darkMode: false,
        };
    },
    computed: {
        hasPersonalSessionsFeature() {
            const featureNames = ['monthly_personal_sessions', 'monthly_personal_session'];
            for (let featureName of featureNames) {
                const feature = this.subscriptionStatus.features[featureName];
                if (feature && feature.enabled) { 
                    return true;
                }
            }
            return false;
        },
        totalPages() {
            return Math.ceil(this.filteredSessions.length / this.perPage);
        },
        paginatedSessions() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredSessions.slice(start, end);
        },
        canBookSession() {
            const personalSessionFeature = this.subscriptionStatus.features.monthly_personal_session;
            return personalSessionFeature && personalSessionFeature.can_access;
        }
    },
    methods: {
        async fetchSubscriptionStatus() {
            this.loading = true;
            try {
                const response = await axios.get('/api/subscriptionStatus');
                this.subscriptionStatus = response.data;

                if (this.subscriptionStatus.authenticated && this.hasPersonalSessionsFeature) {
                    await this.fetchSessions();
                }
                this.filteredSessions = this.sessions;
            } catch (error) {
                console.error('Error fetching subscription status:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to fetch subscription status.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } finally {
                this.loading = false;
            }
        },
        showAppointmentModal() {
            if (this.appointmentModalInstance) {
                this.appointmentModalInstance.show();
            } else {
                console.error('Modal instance is not initialized.');
            }
        },
        hideAppointmentModal() {
            if (this.appointmentModalInstance) {
                this.appointmentModalInstance.hide();
            }
        },
        async bookSession() {
            if (!this.scheduledAt) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select a date and time.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Check if user can book more sessions
            const personalSessionFeature = this.subscriptionStatus.features.monthly_personal_session;
            if (personalSessionFeature && !personalSessionFeature.can_access) {
                Swal.fire({
                    title: 'Limit Reached!',
                    text: 'You have reached the maximum number of personal sessions allowed. Please cancel an existing session to book a new one.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            try {
                const response = await axios.post('/api/personal_sessions', {
                    scheduled_at: this.scheduledAt,
                });

                // Handle success
                this.hideAppointmentModal();
                Swal.fire({
                    title: 'Success!',
                    text: 'Session booked successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                this.scheduledAt = '';
                this.fetchSessions();
            } catch (error) {
                // Handle error
                Swal.fire({
                    title: 'Error!',
                    text: error.response?.data?.message || 'Failed to book session. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error(error);
            }
        },
        async fetchSessions() {
            this.loading = true;
            try {
                const response = await axios.get('/api/personal_sessions');
                this.sessions = response.data.data.data;
                this.filteredSessions = this.sessions;

                // Update can_access based on current_count
                const personalSessionFeature = this.subscriptionStatus.features.monthly_personal_session;
                if (personalSessionFeature) {
                    personalSessionFeature.can_access = personalSessionFeature.current_count < personalSessionFeature.limit;
                }
            } catch (error) {
                console.error('Error fetching sessions:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to fetch sessions.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } finally {
                this.loading = false;
            }
        },
        formatDate(dateStr) {
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            return new Date(dateStr).toLocaleDateString(undefined, options);
        },
        capitalize(text) {
            if (!text) return '';
            return text.charAt(0).toUpperCase() + text.slice(1);
        },
        statusBadge(status) {
            const statusMap = {
                pending: 'badge bg-warning text-dark',
                confirmed: 'badge bg-success',
                completed: 'badge bg-secondary',
                cancelled: 'badge bg-danger'
            };
            return statusMap[status] || 'badge bg-light text-dark';
        },
        viewSession(session) {
            this.selectedSession = session;
            if (this.viewSessionModalInstance) {
                this.viewSessionModalInstance.show();
            }
        },
        hideViewSessionModal() {
            this.selectedSession = null;
            if (this.viewSessionModalInstance) {
                this.viewSessionModalInstance.hide();
            }
        },
        confirmCancel(session) {
            this.sessionToCancel = session;
            if (this.confirmCancelModalInstance) {
                this.confirmCancelModalInstance.show();
            }
        },
        hideConfirmCancelModal() {
            this.sessionToCancel = null;
            if (this.confirmCancelModalInstance) {
                this.confirmCancelModalInstance.hide();
            }
        },
        async cancelSession() {
            try {
                // Send a PUT request to update the session status to 'cancelled'
                await axios.put(`/api/personal_sessions/${this.sessionToCancel.id}`, {
                    status: 'cancelled'
                });
                Swal.fire({
                    title: 'Cancelled!',
                    text: 'Your session has been cancelled.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                this.hideConfirmCancelModal();
                this.fetchSessions();
            } catch (error) {
                Swal.fire({
                    title: 'Error!',
                    text: error.response?.data?.message || 'Failed to cancel session. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error(error);
            }
        },
        filterSessions() {
            let tempSessions = this.sessions;

            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                tempSessions = tempSessions.filter(session => {
                    return (
                        session.id.toString().includes(query) ||
                        this.formatDate(session.scheduled_at).toLowerCase().includes(query) ||
                        session.status.toLowerCase().includes(query)
                    );
                });
            }

            if (this.statusFilter) {
                tempSessions = tempSessions.filter(session => session.status === this.statusFilter);
            }

            this.filteredSessions = tempSessions;
            this.currentPage = 1;
        },
        sortSessions(key) {
            if (this.sortKey === key) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortKey = key;
                this.sortAsc = true;
            }

            this.filteredSessions.sort((a, b) => {
                let result = 0;
                if (a[key] < b[key]) result = -1;
                if (a[key] > b[key]) result = 1;
                return this.sortAsc ? result : -result;
            });
        },
        sortIcon(key) {
            if (this.sortKey !== key) return 'bi bi-arrow-down-up';
            return this.sortAsc ? 'bi bi-arrow-up' : 'bi bi-arrow-down';
        },
        changePage(page) {
            if (page < 1 || page > this.totalPages) return;
            this.currentPage = page;
        },
        exportSessions() {
            if (this.filteredSessions.length === 0) {
                Swal.fire({
                    title: 'No Data!',
                    text: 'There are no sessions to export.',
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const csvContent = "data:text/csv;charset=utf-8,"
                + ["ID,Scheduled At,Status"]
                .concat(this.filteredSessions.map(session => `${session.id},${this.formatDate(session.scheduled_at)},${session.status}`))
                .join("\n");

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "sessions.csv");
            document.body.appendChild(link); // Required for FF

            link.click();
            document.body.removeChild(link);
        },
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            document.body.classList.toggle('dark-mode', this.darkMode);
        }
    },
    mounted() {
        // Initialize modals
        this.appointmentModalInstance = new Modal(this.$refs.appointment, { backdrop: 'static' });
        this.viewSessionModalInstance = new Modal(this.$refs.viewSessionModal, { backdrop: 'static' });
        this.confirmCancelModalInstance = new Modal(this.$refs.confirmCancelModal, { backdrop: 'static' });

        // Initialize tooltips if any
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Check if user is logged in before fetching subscription status
        if (isLoggedIn()) {
            this.subscriptionStatus.authenticated = true;
            this.fetchSubscriptionStatus();
        }
    }
};
</script>

<style scoped>
.personal-form-wrapper form {
    width: 50%;
}

/* Modal Dialog Widths */
#appointmentModal .modal-dialog,
#viewSessionModal .modal-dialog,
#confirmCancelModal .modal-dialog {
    max-width: 500px;
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

/* Responsive Table */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
}

/* Additional Styling */
.personal-card-wrapper .card {
    transition: transform 0.2s;
}

.personal-card-wrapper .card:hover {
    transform: translateY(-5px);
}
</style>
