<template>
    <div class="bg-white shadow-sm rounded p-2">
        <div class="row g-3" v-if="userMedia != ''">
            <div class="col-4" v-for="userAlbum in userMedia" :key="userAlbum.id">
                <a href="#">
                    <img :src="'/uploads/'+userAlbum.image" alt="" class="img-fluid w-100 user_post-img object-fit-cover">
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
<style>
.user-post-img{
 object-fit: cover;
 height: 250px;
}
</style>