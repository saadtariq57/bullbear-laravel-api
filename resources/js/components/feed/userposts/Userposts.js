import VideoPosts from './Userposts.vue';
import TextPosts from '../textposts/Textposts.vue';
import ImagePosts from '../imageposts/Imageposts.vue';
// import VideoPosts from './VideoPosts.vue';
// import TimePosts from './TimePosts.vue';
// import FilePosts from './FilePosts.vue';
import AllPosts from '../allposts/Allposts.vue';

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