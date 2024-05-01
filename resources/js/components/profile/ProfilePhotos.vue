<template>
    <div class="mb-3 ps-3 pt-3 pb-3 bg-white shadow rounded">
        <div class="d-flex align-items-center gap-3">
            <div><span class="bg-primary rounded-circle user-top-bar d-inline-block text-center"><i
                        class="bi bi-image-fill fs-12"></i></span></div>
            <div class="fs-18 fw-6">Photos</div>
        </div>
    </div>
    <div class="mt-5 bg-white shadow-sm rounded p-2">
        <div class="row py-2" v-if="userMedia != ''">
            <div class="col-4" v-for="userAlbum in userMedia" :key="userAlbum.id">
                <a href="#">
                    <img :src="'/uploads/'+userAlbum.image" alt="" class="img-fluid w-100 user_post-img">
                </a>
            </div>
        </div>
        <p v-else>No Media Found</p>
    </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
export default {
    data() {
        return {
            // userAlbumPhotos: null,
        }
    },
    computed: {
        ...mapState('userProfile',['userMedia']),
    },
    methods: {
        // async userAlbumData(){
        //     try {
        //         const response = await axios.get('/api/userAlbumData');
        //         this.userAlbumPhotos = response.data;
        //     } catch (error) {
        //         console.error('Error retreiving user album:', error);
        //     }
        // }
    },
    mounted() {
        // this.userAlbumData();
        // console.log(this.userData);
    }
}
</script>
