<template>
    <!-- Display user data -->
    <div v-if="userData">
        <div v-for="users in   userData  " :key="users.id" class="wow_content wow_side_loggd_usr bg-white p-3 mb-3 shadow">
            <!-- Display user information as needed -->
            <div class="wow_side_loggd_usr_cvr">
                <img class="width-100 height-100 object-fit-cover" :src="users.cover" alt="Rich TV Cover Image">
            </div>
            <div class="wow_side_loggd_usr_hdr">
                <div class="avatar">
                    <img id="updateImage-1" class="width-100 rounded-circle" alt="Rich TV Profile Picture"
                        :src="users.avatar">
                </div>
                <div class="title text-center">
                    <a id="user-full-name" class="text-black fw-bold" data-ajax="?link1=timeline&amp;u=admin"
                        href="/admin">{{ users.name }}</a>
                    <p>@admin</p>
                </div>
            </div>
            <ul class="wo_user_side_info list-unstyled row text-center">
                <li class="col-4">
                    <a class="menu_list text-black" href="/admin" data-ajax="?link1=timeline&amp;u=admin">
                        <span class="split-link d-block"><b>Watchlists</b></span>
                        <span id="user_post_count">{{ users.details.post_count }}</span>
                    </a>
                </li>
                <li class="col-4 border-start border-end">
                    <a class="menu_list text-black" href="/albums/admin" data-ajax="?link1=albums&amp;user=admin">
                        <span class="split-link d-block"><b>Posts</b></span>
                        <span>{{ users.details.album_count }}</span>
                    </a>
                </li>
                <li class="col-4">
                    <a class="menu_list text-black" href="/admin/followers"
                        data-ajax="?link1=timeline&amp;u=admin&amp;type=followers">
                        <span class="split-link d-block"><b>Followers</b></span>
                        <span>{{ users.details.following_count }}</span>
                    </a>
                </li>
            </ul>
            <!-- Add other user properties as needed -->
        </div>
    </div>
    <div class="wow_content wow_side_loggd_usr bg-white p-3 mb-3 shadow">
        <div class="wow_side_loggd_usr_cvr">
            <img class="width-100 height-100 object-fit-cover"
                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/7PXzviNVMJTCho6DpY6k_07_6fb286bb37958c93d0070f66161a8a15_cover.jpg?cache=1686159258"
                alt="Rich TV Cover Image">
        </div>
        <div class="wow_side_loggd_usr_hdr">
            <div class="avatar">
                <img id="updateImage-1" class="width-100 rounded-circle" alt="Rich TV Profile Picture"
                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0">
            </div>
            <div class="title text-center">
                <a id="user-full-name" class="text-black fw-bold" data-ajax="?link1=timeline&amp;u=admin" href="/admin">Rich
                    TV </a>
                <p>@admin</p>
            </div>
        </div>
        <ul class="wo_user_side_info list-unstyled row text-center">
            <li class="col-4">
                <a class="menu_list text-black" href="/admin" data-ajax="?link1=timeline&amp;u=admin">
                    <span class="split-link d-block"><b>posts</b></span>
                    <span id="user_post_count">106</span>
                </a>
            </li>
            <li class="col-4 border-start border-end">
                <a class="menu_list text-black" href="/albums/admin" data-ajax="?link1=albums&amp;user=admin">
                    <span class="split-link d-block"><b>Albums</b></span>
                    <span>0</span>
                </a>
            </li>
            <li class="col-4">
                <a class="menu_list text-black" href="/admin/followers"
                    data-ajax="?link1=timeline&amp;u=admin&amp;type=followers">
                    <span class="split-link d-block"><b>Friends</b></span>
                    <span>48</span>
                </a>
            </li>
        </ul>
    </div>
</template>
<script>

import axios from "axios";
export default {
    // Userdata.js

    data() {
        return {
            userData: null,
        };
    },
    created() {
        this.fetchUserData();
    },
    methods: {
        async fetchUserData() {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await axios.get('/api/userdata', { // Update this line
                    withCredentials: true,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                this.userData = response.data;
            } catch (error) {
                console.error('Error fetching user data:', error);
            }
        },
    },
};
</script>