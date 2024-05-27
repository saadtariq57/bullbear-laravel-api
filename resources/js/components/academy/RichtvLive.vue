<template>
    <div class="container">
        <div class="live_stream">
            <div class="text-center pt-4">
                <h1 class="fw-bold fs-1 text-uppercase">Live Stream</h1>
                <div class="border-heading d-inline-block mt-3 mb-4"></div>
            </div>
            <div class="richtv-live mt-4 mb-4">
                <div v-if="liveStreamUrl">
                    <iframe
                        :src="liveStreamUrl"
                        width="1250"
                        height="703"
                        title="Live Stream"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen
                        class="w-100 rounded-2 richtvlive-iframe"
                    ></iframe>
                </div>
                <div v-else-if="embeddedStream">
                    <h2 class="mb-4 fs-2 fw-bold icon-heading">{{ embeddedStream.title }}</h2>
                    <div class="frame_embeded">
                        <iframe
                        :src="embeddedStream.src"
                        width="1250"
                        height="703"
                        title="Live Stream"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen
                        class="w-100 rounded-2 richtvlive-iframe"
                    ></iframe>
                    </div>
                </div>
                <div v-else>
                    <div class="not_live">
                        <p>
                            We are not live at the moment. Check out our latest
                            videos.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="latest_videos mt-5 pt-2">
            <div class="my-4 position-relative">
                <div class="text-center">
                    <h1 class="fw-bold fs-1 text-uppercase">Latest Videos</h1>
                    <div class="border-heading d-inline-block mt-4 mb-5"></div>
                </div>
                <div class="row gy-5">
                    <div
                        class="col-lg-4 col-ms-6"
                        v-for="(video, index) in displayedVideos"
                        :key="video.id"
                    >
                        <div
                            class="video-card h-100 cursor-pointer"
                            @click="openVideo(video)"
                        >
                            <div
                                class="featured-video-1 m-auto bg-white card-hover pb-2 h-100"
                            >
                                <div class="video-featured position-relative">
                                    <div
                                        class="video-play-icon-small position-absolute"
                                    >
                                        <span
                                            class="d-flex justify-content-center align-items-center"
                                            ><img
                                                src="/build/images/play-icon.png"
                                                alt="circle_button"
                                        /></span>
                                    </div>
                                    <img
                                        :src="
                                            video.snippet.thumbnails.maxres.url
                                        "
                                        alt="thumbnail_card_img"
                                        class="thumbnail-card w-100"
                                    />
                                </div>
                                <div class="video-bio px-2 pt-2">
                                    <div
                                        class="artical-au d-flex justify-content-between pb-3"
                                    >
                                        <div class="by-name">
                                            <i
                                                ><span>{{
                                                    video.snippet.channelTitle
                                                }}</span></i
                                            >
                                        </div>
                                        <div class="d-flex">
                                            <span>{{
                                                formatDate(
                                                    video.snippet.publishedAt
                                                )
                                            }}</span>
                                        </div>
                                    </div>
                                    <h3 class="fs-18 fw-bolder">
                                        {{ video.snippet.title }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Iframe section -->
                <div
                    v-if="showIframe"
                    class="d-flex justify-content-center align-items-center ceo-interview-iframe-wrapper"
                >
                    <div
                        data-bs-theme="dark"
                        class="ceo-interview-iframe-btn-close"
                        @click="closeVideo"
                    >
                        <button
                            type="button"
                            class="btn-close fs-3"
                            aria-label="Close"
                        ></button>
                    </div>
                    <iframe
                        :src="
                            'https://www.youtube.com/embed/' +
                            iframeData.snippet.resourceId.videoId
                        "
                        class="ceo-interview-iframe"
                        allowfullscreen
                        referrerpolicy="strict-origin-when-cross-origin"
                    ></iframe>
                </div>
                <div
                    class="text-center my-5"
                    v-if="displayedVideos.length < videos.length"
                >
                    <button class="btn-primary" @click="loadMore">
                        VIEW MORE
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            liveStreamUrl: null,
            embeddedStream: null,
            videos: [],
            displayedVideos: [],
            showIframe: false,
            iframeData: null,
            videosPerPage: 9,
            currentPage: 2,
        };
    },
    mounted() {
        this.fetchLiveStreams();
        this.fetchVideos();
        this.fetchEmbeddedStream();
    },
    methods: {
        async fetchLiveStreams() {
            const apiKey = "AIzaSyA1i9la4IF4dQhmUTGSMT6aPkUekVd6D3w";
            const channelId = "UCrvJc8oOqtQf9MEs_UXsBMQ";
            const apiUrl = `https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=${channelId}&eventType=live&type=video&key=${apiKey}`;

            const proxyUrl = "http://localhost:8000/";

            try {
                const response = await axios.get(proxyUrl + apiUrl);
                console.log("API Response:", response); // Log the entire response for debugging

                if (response.data && response.data.items) {
                    const liveVideos = response.data.items;

                    if (liveVideos.length) {
                        this.liveStreamUrl = `https://www.youtube.com/embed/${liveVideos[0].id.videoId}`;

                        // Fetch previous live streams
                        await this.fetchPreviousLiveStreams(channelId, apiKey);
                    } else {
                        console.error("No live videos found");
                    }
                } else {
                    console.error("Invalid response structure", response.data);
                }
            } catch (error) {
                console.error("Error fetching live streams", error);
            }
        },
        async fetchEmbeddedStream() {
            try {
                const response = await axios.get("/api/richtv-live");
                if (response.data ) {
                    this.embeddedStream = {
                        title: response.data.title,
                        src: response.data.embedded_code,
                    };
                    console.log(response.data);
                } else {
                    console.error("No embedded live stream found");
                }
            } catch (error) {
                console.error("Error fetching embedded live stream", error);
            }
        },
        fetchVideos() {
            // Define API endpoint and parameters
            const api_key = "AIzaSyA1i9la4IF4dQhmUTGSMT6aPkUekVd6D3w";
            const playlist_id = "UUrvJc8oOqtQf9MEs_UXsBMQ";
            const api_url = `https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=24&playlistId=${playlist_id}&key=${api_key}`;

            // Make API call to fetch videos
            const proxyUrl = "http://localhost:8000/";

            axios
                .get(proxyUrl + api_url)
                .then((response) => {
                    const videoItems = response.data.items;
                    this.videos = videoItems.map((item) => ({
                        id: item.id,
                        snippet: item.snippet,
                    }));
                    this.displayedVideos = this.videos.slice(
                        0,
                        this.videosPerPage
                    );
                })
                .catch((error) => {
                    console.error("Error fetching videos:", error);
                });
        },
        formatDate(isoDate) {
            const date = new Date(isoDate);
            const months = [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ];
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
            console.log(this.displayedVideos);
        },
    },
};
</script>

<style>
.not_live p {
    font-size: 22px;
    line-height: 32px;
    font-weight: 500;
    margin: 0;
}
.not_live {
    text-align: center;
    padding: 40px;
    border: 1px solid #ccc;
    border-radius: 10px;
    margin-bottom: 60px;
}
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
