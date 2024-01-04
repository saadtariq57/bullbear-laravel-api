<template>
    <div class="d-flex gap-3">
        <div class="btn-group">
            <button type="button" class="btn dropdown-toggle profile-dropdown-toggle border-0 p-0" data-bs-toggle="dropdown"
                data-bs-display="static" aria-expanded="false">
                <i class="bi bi-chat-dots fs-4"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end m-0 p-0">
                <li class="py-0"><button class="dropdown-item px-3 py-3 d-flex align-items-center gap-3 border-bottom"
                        type="button">
                        <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="30" height="30">
                        <div>
                            <h6 class="text-uppercase fs-6 fw-6 clr-primary">Bitcoin</h6>
                            <div class="text-uppercase fs-12 fw-5 w180 text-wrap">bitcoin recently just hit 31k on bullish
                                sentiment
                            </div>
                        </div>
                        <div>
                            <div class="d-flex gap-2"><button class="btn btn-cta"><i class="bi bi-check2-all"></i></button>
                            </div>
                        </div>
                    </button></li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn dropdown-toggle profile-dropdown-toggle border-0 p-0" data-bs-toggle="dropdown"
                data-bs-display="static" aria-expanded="false">
                <i class="bi bi-chat-dots fs-4"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end m-0 p-0">
                <li class="py-0"><button class="dropdown-item px-3 py-3 d-flex align-items-center gap-3 border-bottom"
                        type="button">
                        <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="30" height="30">
                        <div>
                            <h6 class="text-uppercase fs-6 fw-6 clr-primary">Bitcoin</h6>
                            <div class="text-uppercase fs-12 fw-5 w180 text-wrap">bitcoin recently just hit 31k on bullish
                                sentiment
                            </div>
                        </div>
                        <div class="fs-6 fw-5">25 W</div>
                    </button></li>
                <li class="py-0"><button class="dropdown-item px-3 py-3 d-flex align-items-center gap-3 border-bottom"
                        type="button">
                        <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="30" height="30">
                        <div>
                            <h6 class="text-uppercase fs-6 fw-6 clr-primary">Bitcoin</h6>
                            <div class="text-uppercase fs-12 fw-5 w180 text-wrap">bitcoin recently just hit 31k on bullish
                                sentiment
                            </div>
                        </div>
                        <div class="fs-6 fw-5">25 W</div>
                    </button></li>
                <li class="py-0"><button class="dropdown-item px-3 py-3 d-flex align-items-center gap-3 border-bottom"
                        type="button">
                        <img src="build/images/brands/cryptocurrency_btc.png" alt="" width="30" height="30">
                        <div>
                            <h6 class="text-uppercase fs-6 fw-6 clr-primary">Bitcoin</h6>
                            <div class="text-uppercase fs-12 fw-5 w180 text-wrap">bitcoin recently just hit 31k on bullish
                                sentiment
                            </div>
                        </div>
                        <div class="fs-6 fw-5">25 W</div>
                    </button></li>
                <li class="py-0"><a href="/groups" class="dropdown-item text-center py-2"><span>See All</span></a></li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="btn dropdown-toggle profile-dropdown-toggle border-0 p-0" data-bs-toggle="dropdown"
                data-bs-display="static" aria-expanded="false">
                <i class="bi bi-bell-fill fs-4"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end m-0 p-0">
                <li><button class="dropdown-item ps-2 pe-5 fw-6 d-flex align-items-center py-0" type="button"><i
                            class="bi bi-volume-up pe-2 fs-3"></i><span class="fs-6">Turn off notification
                            sound</span></button>
                </li>
                <li class="notifications-list p-0">
                    <div class="d-flex justify-content-center align-items-center empty-notifications mb-5">
                        <div>
                            <span
                                class="bg-secondary rounded-circle empty-notifications-icon d-flex justify-content-center align-items-center mx-auto"><i
                                    class="bi bi-bell-slash-fill text-white fs-2"></i></span>
                            <p class="m-0 text-secondary">You do not have any notifications</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="dropdown-center">
            <button class="btn dropdown-toggle border-0 profile-dropdown-toggle p-0" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <div class="img">
                    <img :src="userData.avatar" class="rounded-circle" width="40" height="40" alt="Rich TV profile picture">
                </div>
            </button>
            <ul class="dropdown-menu bg-light dropdown-menu-end m-0 p-0">
                <li class="px-4 py-4">
                    <div class="bg-white rounded-3 px-3 py-3 w180"><a href="/profile"
                            class="d-flex align-items-center gap-2">
                            <img :src="userData.avatar" class="rounded-circle" width="40" height="40"
                                alt="Rich TV profile picture">
                            <b class="text-uppercase text-black">{{ userData.name }}</b></a>
                    </div>
                </li>
                <li class="px-4 pb-4">
                    <div class="bg-white rounded-3 px-3 py-3 w180">
                        <a class="dropdown-item text-black ps-0 fw-6" href="/profile">My Profile</a>
                        <a class="dropdown-item text-black ps-0 fw-6" href="#">Upgrade To Pro</a>
                        <!-- <a class="dropdown-item text-black ps-0 fw-6" href="#">Find Friend</a> -->
                        <a class="dropdown-item text-black ps-0 fw-6" href="#">Settings</a>
                    </div>
                </li>
                <li class="px-4 pb-4">
                    <div class="bg-white rounded-3 px-3 py-3 w180 header_login">
                        <a href="/logout" class="d-flex gap-2 fs-16 fw-6 text-black" aria-label="login"><i
                                class="bi bi-box-arrow-in-right"></i>Logout</a>

                    </div>
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
.profile-dropdown-toggle::after {
    display: none !important;
}

.notifications-list {
    width: 330px;
}

.empty-notifications {
    height: 300px;
}

.empty-notifications-icon {
    width: 50px;
    height: 50px;
}
</style>