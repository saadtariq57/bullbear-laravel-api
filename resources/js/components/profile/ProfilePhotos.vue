<template>
    <div class="bg-white shadow-sm rounded">
        <div class="row">
            <div class="col-4 mb-4" v-for="userAlbum in userAlbumPhotos" :key="userAlbum.id">
                <a href="#">
                    <img :src="'uploads/'+userAlbum.image" alt="" class="img-fluid w-100 user-post-img rounded-1">
                </a>
            </div>
        </div>
        <!-- <div class="row py-2">
            <div class="col-4">
                <a href="#"><img
                        src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/CUCxaDeqzhdkv5C283Xg_14_61d2bdabff2519c1ceec13343e743876_image.jpg"
                        alt="" class="img-fluid w-100 user_post-img"></a>
            </div>
            <div class="col-4">
                <a href="#"><img
                        src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/PbA1WjX1SawYRTVsQXoj_14_31ad3c260af648ca168436b9628a6ea1_image.jpg"
                        alt="" class="img-fluid w-100 user_post-img"></a>
            </div>
            <div class="col-4">
                <a href="#"> <img
                        src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar_full.png?cache=0"
                        alt="" class="img-fluid w-100 user_post-img"></a>
            </div>
        </div>
        <div class="collapse" id="Picture-load-btn">
            <div class="row py-2">
                <div class="col-4">
                    <a href="#"><img
                            src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/CUCxaDeqzhdkv5C283Xg_14_61d2bdabff2519c1ceec13343e743876_image.jpg"
                            alt="" class="img-fluid w-100 user_post-img"></a>
                </div>
                <div class="col-4">
                    <a href="#"><img
                            src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/PbA1WjX1SawYRTVsQXoj_14_31ad3c260af648ca168436b9628a6ea1_image.jpg"
                            alt="" class="img-fluid w-100 user_post-img"></a>
                </div>
                <div class="col-4">
                    <a href="#"> <img
                            src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar_full.png?cache=0"
                            alt="" class="img-fluid w-100 user_post-img"></a>
                </div>
            </div>
            <div class="row py-2">
                <div class="col-4">
                    <a href="#"><img
                            src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/CUCxaDeqzhdkv5C283Xg_14_61d2bdabff2519c1ceec13343e743876_image.jpg"
                            alt="" class="img-fluid w-100 user_post-img"></a>
                </div>
                <div class="col-4">
                    <a href="#"><img
                            src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/09/PbA1WjX1SawYRTVsQXoj_14_31ad3c260af648ca168436b9628a6ea1_image.jpg"
                            alt="" class="img-fluid w-100 user_post-img"></a>
                </div>
                <div class="col-4">
                    <a href="#"> <img
                            src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar_full.png?cache=0"
                            alt="" class="img-fluid w-100 user_post-img"></a>
                </div>
            </div>
        </div> -->

    </div>
    <!-- <div class="pt-4 text-center">
        <a class="btn bg-primary text-white fs-18" data-bs-toggle="collapse" href="#" role="button" aria-expanded="false"
            aria-controls="Picture-load-btn" data-bs-target="#Picture-load-btn"><i
                class="bi bi-arrow-down pe-1 fs-18 fw-6"></i>
            Load more users</a>
    </div> -->
</template>
<script>
export default {
    data() {
        return {
            userAlbumPhotos: null,
        }
    },
    methods: {
        async userAlbumData(){
            try {
                const response = await axios.get('/api/userAlbumData');
                this.userAlbumPhotos = response.data;
            } catch (error) {
                console.error('Error retreiving user album:', error);
            }
        }
    },
    mounted() {
        this.userAlbumData();
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