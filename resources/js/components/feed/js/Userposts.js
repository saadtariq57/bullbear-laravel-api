import UserPosts from '../Userposts.vue';
import AllPosts from '../Allposts.vue';
import TextPosts from '../Textposts.vue';
import ImagePosts from '../Imageposts.vue';

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