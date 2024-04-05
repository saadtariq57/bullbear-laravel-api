<template>
    <div v-if="userData">
        <!-- Display user information -->
        <div class="wow_content wow_side_loggd_usr bg-white p-3 mb-3 shadow">
            <div class="wow_side_loggd_usr_cvr">
                <img class="w-100 h-100 object-fit-cover" :src="userData.cover" alt="Cover Image">
            </div>
            <div class="wow_side_loggd_usr_hdr">
                <div class="avatar">
                    <img class="w-100 rounded-circle" :src="userData.avatar" alt="Profile Picture">
                </div>
                <div class="title text-center">
                    <a class="text-black fw-bold" href="/profile">{{ userData.name }}</a>
                    <p>@{{ userData.name }}</p>
                </div>
            </div>
            <ul class="wo_user_side_info list-unstyled row text-center">
                <li class="col-4">
                    <a class="menu_list text-black" href="/profile">
                        <span class="split-link d-block"><b>Posts</b></span>
                        <span id="user_post_count">{{ userData.posts_count }}</span>
                    </a>
                </li>
                <li class="col-4 border-start border-end">
                    <a class="menu_list text-black" href="/profile">
                        <span class="split-link d-block"><b>Watchlists</b></span>
                        <span>{{ userData.watchlists_count }}</span>
                    </a>
                </li>
                <li class="col-4">
                    <a class="menu_list text-black" href="/profile">
                        <span class="split-link d-block"><b>Followers</b></span>
                        <span>{{ userData.followers_count }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    computed: mapState(['userData']),
};
</script>
<style>
.wow_side_loggd_usr_cvr {
    height: 150px;
}
</style>
