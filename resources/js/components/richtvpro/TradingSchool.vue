<template>
    <section class="container-fluid my-4">
        <div class="container">
            <div class="trading-books-wrapper bg-white px-5 py-3 mt-4 border-1 border rounded-2 shadow-sm">
                <div class="text-center">
                    <h1 class="fw-bold fs-1 text-uppercase">TRADING SCHOOL</h1>
                    <div class="border-heading d-inline-block mt-4 mb-3"></div>
                    <p>Enlighten yourself with a wealth of trading literature that will help you polish your investment
                        skills, and undergo online assessments periodically to see where you stand knowledge-wise.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="trading-books container-fluid mb-4">
        <div class="container">
            <TradingBooks />
        </div>
    </section>
    <section class="container-fluid position-relative">
        <div class="container">
            <div class="tradind-videos-wrapper bg-white px-sm-4 py-4 border-1 border rounded-2 shadow-sm">
                <div class="text-center">
                    <h1 class="fw-bold fs-1 text-uppercase">TRADING VIDEOS <span
                            class="videos-count fs-12 fw-light">(204)</span></h1>
                    <div class="border-heading d-inline-block mt-4 mb-5"></div>
                </div>
                <div class="row gy-5">
                    <div class="col-lg-4 col-md-6" v-for="(video, index) in displayedVideos" :key="video.id">
                        <div class="video-card h-100 cursor-pointer" @click="openVideo(video)">
                            <div class="featured-video-1 m-auto bg-white card-hover pb-2 h-100">
                                <div class="video-featured position-relative">
                                    <div class="video-play-icon-small position-absolute">
                                        <span class="d-flex justify-content-center align-items-center"><img
                                                src="/build/images/play-icon.png" alt="circle_button"></span>
                                    </div>
                                    <img :src="video.snippet.thumbnails.maxres.url" alt="thumbnail_card_img"
                                        class="thumbnail-card w-100">
                                </div>
                                <div class="video-bio px-2 pt-2">
                                    <div class="artical-au d-flex justify-content-between pb-3">
                                        <div class="by-name"><i><span>{{ video.snippet.channelTitle }}</span></i></div>
                                        <div class="d-flex">
                                            <span>{{ formatDate(video.snippet.publishedAt) }}</span>
                                        </div>
                                    </div>
                                    <h3 class="fs-18 fw-bolder ">{{ video.snippet.title }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Iframe section -->
                    <div v-if="showIframe"
                        class="d-flex justify-content-center align-items-center ceo-interview-iframe-wrapper mt-0">
                        <div data-bs-theme="dark" class="ceo-interview-iframe-btn-close" @click="closeVideo">
                            <button type="button" class="btn-close fs-3" aria-label="Close"></button>
                        </div>
                        <iframe :src="'https://www.youtube.com/embed/' + iframeData.snippet.resourceId.videoId"
                            class="ceo-interview-iframe" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    </div>
                </div>
            </div>


            <div class="text-center my-5" v-if="displayedVideos.length < videos.length">
            <button class="btn-primary" @click="loadMore">VIEW MORE</button>
        </div>
        </div>
    </section>
    <section class="pre-footer container-fluid py-80 bg-smoke">
        <div class="container pb-120">
            <div class="row">
                <div class="col-12">
                    <div class="risk-disclaimer p-4">
                        <div class="risk-heading">
                            <div class="disclaimer-icon-name d-flex align-items-end mb-4 gap-3">
                                <div class="">
                                    <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/alert-icon.png"
                                        alt="icon">
                                </div>
                                <div>
                                    <h2 class="fw-bolder fs-1 mb-0">Risk Disclaimer</h2>
                                </div>
                            </div>
                            <div>
                                <div class="risk-para">
                                    <p class="margin-24 fs-18 lh-base">Rich TV's company profiles and other investor
                                        relations materials,
                                        publications or presentations, including web content, are based on data obtained
                                        from sources we believe to be reliable but are not guaranteed as to accuracy and
                                        are
                                        not purported to be complete. As such, the information should not be construed
                                        as
                                        advice designed to meet the particular investment needs of any investor. Any
                                        opinions expressed in Rich TV reports, company profiles, or other investor
                                        relations
                                        materials and presentations are subject to change. Rich TV and its affiliates
                                        may
                                        buy and sell shares of securities or options of the issuers mentioned on this
                                        website at any time.
                                        <!-- {{-- <a class="arrow-down show-more cursor-pointer"
                                            rel="nofollow" aria-label="See All"> See
                                            more</a> --}} -->
                                    </p>
                                </div>
                                <div class="slide-up-down">
                                    <!-- style="display: none;" -->
                                    <p>Stock market investing is inherently risky. Rich TV is not
                                        responsible for any gains or losses that result from the opinions expressed on
                                        this
                                        website, in its research reports, company profiles or in other investor
                                        relations
                                        materials or presentations that it publishes electronically or in print.
                                        We strongly encourage all investors to conduct their own research before making
                                        any
                                        investment decision. For more information on stock market investing, visit the
                                        Securities and Exchange Commission ("SEC") at www.sec.gov.
                                        <!-- <a
                                            class="arrow-down show-less cursor-pointer" rel="nofollow"
                                            aria-label="See less"> See less</a> -->
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import TradingBooks from '../widgets/TradingBooks.vue'
import axios from 'axios';

export default {
    components: {
        TradingBooks
    },
    data() {
        return {
            videos: [],
            displayedVideos: [],
            showIframe: false,
            iframeData: null,
            videosPerPage: 9, // Number of videos to display per page
            currentPage: 2 // Current page number
        };
    },
    mounted() {
        this.fetchVideos();
    },
    methods: {
        fetchVideos() {
            // Define API endpoint and parameters
            const api_key = 'AIzaSyA1i9la4IF4dQhmUTGSMT6aPkUekVd6D3w';
            const playlist_id = 'PLSr6qDstKBtkEd9zsFFxWPDUlkjU1KR3H';
            const api_url = `https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=24&playlistId=${playlist_id}&key=${api_key}`;

            // Make API call to fetch videos
            const proxyUrl = 'http://localhost:8000/';

            axios.get(proxyUrl + api_url)
                .then(response => {
                    // this.videos = response.data.items;
                    // console.log(this.videos)
                    // Extract the video items from the response
                    const videoItems = response.data.items;
                    // Map the video items to create an array of simplified video objects
                    this.videos = videoItems.map(item => ({
                        id: item.id,
                        snippet: item.snippet
                    }));
                    // Initialize the displayedVideos array with the first batch of videos
                    this.displayedVideos = this.videos.slice(0, this.videosPerPage);
                })
                .catch(error => {
                    console.error('Error fetching videos:', error);
                });
        },
        formatDate(isoDate) {
            const date = new Date(isoDate);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const month = months[date.getMonth()];
            const day = date.getDate();
            const year = date.getFullYear();
            return `${month} ${day} ${year}`;
        },
        openVideo(video) {
            this.iframeData = video;
            this.showIframe = true;
        },
        closeVideo() {
            this.iframeData = null;
            this.showIframe = false;
        },
        loadMore() {
            const startIndex = (this.currentPage - 1) * this.videosPerPage;
            const endIndex = startIndex + this.videosPerPage;
            this.displayedVideos = this.videos.slice(0, endIndex);
            this.currentPage++;
            console.log(this.displayedVideos)
        }
    }
};
</script>
<style>
.ceo-interview-iframe-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.664);
    z-index: 11;
}

.ceo-interview-iframe {
    width: 75%;
    height: 75%;
}

.ceo-interview-iframe-btn-close {
    position: absolute;
    right: 5%;
    top: 5%;
}
</style>