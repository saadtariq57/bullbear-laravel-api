<template>
    <div class="position-relative">
    <ProfileGroupHeader context="profileHeader" ref="ProfileGroupHeader" />
    <div class="user-profile-info" v-if="userProfileData">
        <div class="d-flex align-items-center gap-2">
            <h1>{{ userProfileData.name }}</h1>
            <span v-if="userProfileData.subscription_plan != 'free'"><i class="bi bi-patch-check-fill fs-2 user-verified-icon"></i></span>
            <span class="user-pro text-white px-2 py-1 fs-10 rounded-2" v-if="userProfileData.subscription_plan != 'free'">{{ userProfileData.subscription_plan }}</span>
        </div>
        <p class="text-black fs-5"><span>{{ followersCount }} Followers</span> | <span>{{ followingsCount }} Followings</span></p>
        <p class="text-black fs-5"> </p>
        <button v-if="!isOwnProfile && !isFollowing" type="button" class="btn btn-primary fs-6 fw-5 px-3" @click="handleFollowUser(userProfileData.id, followersCount)">
            Follow
        </button>
        <button v-if="!isOwnProfile && isFollowing" type="button" class="btn btn-primary fs-6 fw-5 px-3" @click="HandleUnfollowUser(userProfileData.id, followersCount)">
            UnFollow
        </button>
    </div>
</div>
    <div class="row user-chat-top-tab mb-3 px-2">
        <div class="col-12 user-bottom-nav bg-white shadow overflow-auto profile-main-navtab">
            <ul class="inner-tabs-btn nav justify-content-around flex-nowrap" id="admin-content-tab" role="tablist">
                <li class="nav-item " role="presentation"> <a href="#"
                        class="nav-link active user-li-navbtn text-secondary" id="user-Timeline-tab"
                        data-bs-toggle="tab" data-bs-target="#user-Timeline" type="button" role="tab"
                        aria-controls="user-Timeline" aria-selected="true">
                        <span class="split-link d-block text-center"><i class="bi bi-ui-checks fs-18"></i></span>
                        Timeline
                    </a>
                </li>
                <li class="nav-item " role="presentation"> <a href="#" class="nav-link text-secondary user-li-navbtn"
                        id="user-chat-tab" data-bs-toggle="tab" data-bs-target="#user-chat" type="button" role="tab"
                        aria-controls="user-chat" aria-selected="false">
                        <span class="split-link d-block text-center"><i class="bi bi-chat-right-dots fs-18"></i></span>
                        Chat Room
                    </a>
                </li>
                <li class="nav-item" role="presentation"> <a href="#" class="nav-link text-secondary user-li-navbtn"
                        id="user-watchlists-tab" data-bs-toggle="tab" data-bs-target="#user-watchlists" type="button"
                        role="tab" aria-controls="user-watchlists" aria-selected="false">
                        <span class="split-link d-block text-center"><i class="bi bi-star-fill fs-18"></i></span>
                        Watchlists
                    </a>
                </li>
                <li class="nav-item" role="presentation"> <a href="#" class="nav-link text-secondary user-li-navbtn"
                        id="user-photos-tab" data-bs-toggle="tab" data-bs-target="#user-photos" type="button" role="tab"
                        aria-controls="user-photos" aria-selected="false">
                        <span class="split-link d-block text-center"><i class="bi bi-image-fill fs-18"></i></span>
                        Photos
                    </a>
                </li>

                <li class="nav-item " role="presentation"> <a href="#" class="nav-link text-secondary user-li-navbtn"
                        id="user-followers-tab" data-bs-toggle="tab" data-bs-target="#user-followers" type="button"
                        role="tab" aria-controls="user-followers" aria-selected="false">
                        <span class="split-link d-block text-center"><i class="bi bi-person-plus-fill fs-18"></i></span>
                        Followers
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
import ProfileGroupHeader from '../header/ProfileGroupHeader.vue';
export default {
    components: {
        ProfileGroupHeader
    },
    computed: {
        ...mapState(['userData']),
        ...mapState('userProfile',['userProfileData', 'message', 'success', 'isOwnProfile', 'isFollowing', 'followersCount', 'followingsCount']),
    },
    data() {
        return {}
    },
    created() {
        const context = 'profileHeader';
    },
    methods: {
        ...mapActions('userProfile',['followUser', 'unfollowUser']),
        handleFollowUser(userId, followersCount){
            this.followUser({userId, followersCount});
        },
        HandleUnfollowUser(userId, followersCount){
            this.unfollowUser({userId, followersCount});
        }
    },
    mounted() {
    }
}
</script>
<style>
.user-profile-info{
    position: absolute;
    bottom: 45px;
    left: 210px;
}
@media (max-width: 767px) {
    .inner-tabs-btn {
        min-width: 660px;
    }
    .user-profile-info{
        bottom: 110px;
        left: 50%;
        transform: translateX(-50%);
    }
}
</style>
