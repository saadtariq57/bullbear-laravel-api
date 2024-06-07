<template>
    <section class="container-fluid my-4">
        <div class="container">
            <div class="text-center">
                <h1 class="fw-bold fs-1 text-uppercase">Webinars</h1>
                <div class="border-heading d-inline-block mt-3 mb-4"></div>
            </div>
            <div v-if="webinars.length === 0" class="d-flex justify-content-center align-items-center no-webinar-wrapper">
                <div class="text-center">
                    <img src="build/images/no-webinar.png" alt="" width="300px">
                    <p class="fw-5 fs-16 mt-1 mb-0">No Webinars Available</p>
                </div>
            </div>
            <div v-else class="row my-5">
                <div v-for="webinar in webinars" :key="webinar.id" class="col-md-4 mb-4">
                    <div class="card border shadow">
                        <div class="card-body p-4">
                            <h5 class="card-title fs-4 fw-6 mb-3">{{ webinar.title }}</h5>
                            <p class="card-text">Date: {{ formatDate(webinar.date) }}</p>
                            <p class="card-text">Time: {{ formatTime(webinar.start_time) }} - {{ formatTime(webinar.end_time) }}</p>
                            <div v-if="isWebinarStarted(webinar.date, webinar.start_time)">
                            <a :href="webinar.zoom_join_link" class="btn btn-primary" target="_blank">Join Webinar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from 'axios';
import moment from 'moment';

export default {
    data() {
        return {
            webinars: [],
        };
    },
    created() {
        this.fetchWebinars();
    },
    methods: {
        async fetchWebinars() {
            try {
                const response = await axios.get('/api/webinars'); // Adjust the URL to your actual API endpoint
                this.webinars = response.data;
            } catch (error) {
                console.error('Error fetching webinars:', error);
            }
        },
        formatDate(date) {
            return moment(date).format('DD MMMM YYYY');
        },
        formatTime(time) {
            return moment(time, 'HH:mm:ss').format('hh:mm A');
        },
        isWebinarStarted(date, time) {
            const webinarDateTime = moment(`${date} ${time}`, 'YYYY-MM-DD HH:mm:ss');
            return moment().isSameOrAfter(webinarDateTime);
        }
    },
};
</script>

<style>
.border-heading {
    width: 100px;
}
</style>
