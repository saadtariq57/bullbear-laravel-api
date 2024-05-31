<template>
    <div class="container my-4">
        <div class="personal-head text-center border-bottom mb-4">
            <h1 class="fs-2 fw-6">Personal Access</h1>
        </div>
        <div class="personal-card-wrapper row py-4">
            <div class="col-md-6">
                <div class="card flex-fill shadow-sm border">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar3 fs-2"></i>
                        <h2 class="fs-4 fw-5">Book An Appointment</h2>
                        <p>Booking an appointment with a professional guarantees personalized assistance and efficient
                            problem-solving.</p>
                        <button class="btn btn-primary" @click="showAppointmentModal()">Schedule</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-fill shadow-sm border">
                    <div class="card-body text-center">
                        <i class="bi bi-chat-dots fs-2"></i>
                        <h2 class="fs-4 fw-5">Chat With Professionals</h2>
                        <p>Chatting with a professional provides convenient access to tailored expertise and guidance in
                            real-time</p>
                        <button class="btn btn-primary">Select</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" ref="appointment" id="appointmentModal" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Book an Appointment</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="hideAppointmentModal()"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Add Calendly inline widget embed code here -->
                        <div class="calendly-inline-widget"
                            data-url="https://calendly.com/wajidfareed103/book-an-appointment?hide_event_type_details=1&hide_gdpr_banner=1"
                            style="min-width:320px; height:600px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
export default {
    data() {
        return {
            appointment: false,
        };
    },
    methods: {
        showAppointmentModal() {
            if (this.appointmentModalInstance) {
                this.appointmentModalInstance.show();
            } else {
                console.error('Modal instance is not initialized.');
            }
        },
        hideAppointmentModal() {
            this.appointmentModalInstance.hide();
        }
    },
    mounted() {
        // Load Calendly widget script asynchronously
        const script = document.createElement('script');
        script.src = 'https://assets.calendly.com/assets/external/widget.js';
        script.async = true;
        // Append the script to the document body
        document.body.appendChild(script);
        this.appointmentModalInstance = new Modal(this.$refs.appointment, { backdrop: 'static' });
    },
};
</script>

<style>
.personal-form-wrapper form {
    width: 50%;
}

#appointmentModal .modal-dialog {
    max-width: 30%;
}
</style>
