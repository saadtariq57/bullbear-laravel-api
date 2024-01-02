<template>
    <div class="feed-posts">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs inner-tabs-btn my-3 shadow rounded" id="course-content-tab" role="tablist">
            <li class="nav-item col" role="presentation">
                <button class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black active"
                    id="about-tab" data-bs-toggle="tab" data-bs-target="#about-tab-pane" type="button" role="tab"
                    aria-controls="about-tab-pane" aria-selected="true"><i class="bi bi-file-earmark-text"></i></button>
            </li>
            <li class="nav-item col" role="presentation">
                <button class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                    id="content-tab" data-bs-toggle="tab" data-bs-target="#content-tab-pane" type="button" role="tab"
                    aria-controls="content-tab-pane" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" width="24" height="24">
                        <path
                            d="M11 4h10v2H11V4zm0 4h6v2h-6V8zm0 6h10v2H11v-2zm0 4h6v2h-6v-2zM3 4h6v6H3V4zm2 2v2h2V6H5zm-2 8h6v6H3v-6zm2 2v2h2v-2H5z"
                            fill="currentColor"></path>
                    </svg></button>
            </li>
            <li class="nav-item col" role="presentation">
                <button class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                    id="include-tab" data-bs-toggle="tab" data-bs-target="#include-tab-pane" type of="button" role="tab"
                    aria-controls="include-tab-pane" aria-selected="false"><i class="bi bi-image-fill"></i></button>
            </li>
            <li class="nav-item col" role="presentation">
                <button class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                    id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane" type="button" role="tab"
                    aria-controls="reviews-tab-pane" aria-selected="false"><i class="bi bi-camera-video-fill"></i></button>
            </li>
            <li class="nav-item col" role="presentation">
                <button class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                    id="new-tab1" data-bs-toggle="tab" data-bs-target="#new-tab1-pane" type="button" role="tab"
                    aria-controls="new-tab1-pane" aria-selected="false"><i class="bi bi-clock"></i></button>
            </li>
            <li class="nav-item col" role="presentation">
                <button class="nav-link border-end-0 border-top-0 border-start-0 border-bottom fs-5 text-black"
                    id="new-tab2" data-bs-toggle="tab" data-bs-target="#new-tab2-pane" type="button" role="tab"
                    aria-controls="new-tab2-pane" aria-selected="false"><i class="bi bi-journal-arrow-up"></i></button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="myTabContent">
            <!-- Dynamic Component based on active tab -->
            <component :is="currentTabComponent"></component>
        </div>
    </div>
</template>
  
<script>
import AllPosts from './AllPosts.vue';
import TextPosts from './TextPosts.vue';
import ImagePosts from './ImagePosts.vue';
import VideoPosts from './VideoPosts.vue';
import TimePosts from './TimePosts.vue';
import FilePosts from './FilePosts.vue';

export default {
    data() {
        return {
            currentTab: 'all', // default tab
        };
    },
    computed: {
        currentTabComponent() {
            switch (this.currentTab) {
                case 'text':
                    return TextPosts;
                case 'image':
                    return ImagePosts;
                case 'video':
                    return VideoPosts;
                case 'time':
                    return TimePosts;
                case 'file':
                    return FilePosts;
                default:
                    return AllPosts;
            }
        },
    },
    methods: {
        changeTab(tabName) {
            this.currentTab = tabName;
        },
    },
};
</script>
