<template>
    <div class="position-relative">
        <div class="profile_bg_img w-100 position-relative overflow-hidden">
            <img ref="coverImage"
                src="https://scontent.flhe25-1.fna.fbcdn.net/v/t39.30808-6/301075830_2934266940200020_4251971855002964343_n.jpg?stp=dst-jpg_p640x640&_nc_cat=101&ccb=1-7&_nc_sid=783fdb&_nc_eui2=AeHP3C-fpnD4d8DyEeiZzz9NyxBur5kLIfnLEG6vmQsh-RujimarzC0PLpU9Dbptm0KaB6XYoGyB9sCBRFBZDTRV&_nc_ohc=Gw73d_k6oYYAX9oopBV&_nc_ht=scontent.flhe25-1.fna&oh=00_AfCO4jARnnGrZ-vAp8CQzcPXOvTXSxvJ3nk9Dh3YBDzoJw&oe=65D7B7B7"
                alt="Cover Image" class="img-fluid w-100 profile-cover-photo object-fit-cover" />
            <div class="cover-photo-overlay" v-show="isRepositioning"></div>
            <!-- Overlay for better visibility -->
        </div>
        <div class="btn-group position-absolute cover-photo-btn">
            <button type="button" class="btn bg-white dropdown-toggle d-flex align-items-center gap-2 shadow"
                @click="toggleDropdown($event)">
                <i class="bi bi-camera-fill fs-5"></i><span class="fs-6 fw-5">Edit Cover Photo</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end z-1">
                <li>
                    <label class="dropdown-item fs-6 fw-5">
                        <input type="file" accept="image/jpeg,image/jpg,image/png" class="upload-profile-photo d-none" />
                        <i class="bi bi-upload me-2 fs-5"></i> Upload photo
                    </label>
                </li>
                <li>
                    <button class="dropdown-item fs-6 fw-5" @click="repositionCoverPhoto">
                        <i class="bi bi-arrows-move me-2 fs-5"></i> Reposition
                    </button>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>
                    <button class="dropdown-item fs-6 fw-5">
                        <i class="bi bi-trash3-fill me-2 fs-5"></i> Remove
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div class="user-profile-wrapper position-relative d-flex justify-content-between px-4">
        <div class="user-profile-info-wapper d-flex gap-4">
            <div
                class="user-avater-wappar position-relative bg-white rounded-circle d-flex justify-content-center align-items-center">
                <img :src="userData.avatar" alt="Profile Picture" width="165px" height="165px" class="rounded-circle">
                <!-- Button trigger modal -->
                <button @click="showUploadPhotoeModal"
                    class="position-absolute btn bg-white rounded-circle profile-photo-btn px-0 d-flex justify-content-center align-items-center"><i
                        class="bi bi-camera-fill fs-4"></i></button>
            </div>
            <!-- Modal -->
            <div class="modal fade" ref="profilePhotoModal" id="profilePhoto" tabindex="-1"
                aria-labelledby="profilePhotoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="profilePhotoModalLabel">Change Profile Photo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center py-3">
                                <p><span>{{ userData.name }}</span>, help others recognize you!</p>
                                <div class="my-5">
                                    <img :src="userData.avatar" alt="Profile Photo" class="rounded-circle" width="150"
                                        height="150">
                                </div>
                                <p class="px-3">On Rich Tv, we require members to use their real identities, so take or
                                    upload a photo of
                                    yourself</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <label class="btn btn-primary">
                                <input type="file" accept="image/jpeg,image/jpg,image/png"
                                    class="upload-profile-photo d-none">
                                Upload photo
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-profile-info align-self-end">
                <h1>{{ userData.name }}</h1>
                <a href="#" class="text-black fs-5"><span>{{ userData.followers_count }}</span> followers</a>
            </div>
        </div>
        <div class="user-profile-btn align-self-end">
            <button class="btn btn-primary fs-6 fw-5 px-3"><i class="bi bi-pencil-fill fs-6 me-2"></i>Edit Profile</button>
        </div>
    </div>
    <div>
        <div class="row user-chat-top-tab justify-content-center">
            <div class="col-md-10 user-bottom-nav bg-white shadow ps-0 pe-0 overflow-auto profile-main-navtab">
                <ul class="inner-tabs-btn nav justify-content-between flex-nowrap" id="admin-content-tab" role="tablist">
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
                            Chats
                        </a>
                    </li>
                    <li class="nav-item" role="presentation"> <a href="#" class="nav-link text-secondary user-li-navbtn"
                            id="user-friends-tab" data-bs-toggle="tab" data-bs-target="#user-friends" type="button"
                            role="tab" aria-controls="user-friends" aria-selected="false">
                            <span class="split-link d-block text-center"><i class="bi bi-person-plus-fill fs-18"></i></span>
                            Friends
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
                            id="user-video-tab" data-bs-toggle="tab" data-bs-target="#user-video" type="button" role="tab"
                            aria-controls="user-video" aria-selected="false">
                            <span class="split-link d-block text-center"><i
                                    class="bi bi-camera-video-fill fs-18"></i></span>
                            Videos
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
import { Dropdown } from 'bootstrap';
import { Modal } from 'bootstrap';
import { mapState } from 'vuex';
export default {
    computed: {
        ...mapState(['userData']),
    },
    data() {
        return {
            isRepositioning: false,
            initialY: 0,
            offsetY: 0,
            initialTop: 0,
            maxTop: 0,
        }
    },
    methods: {
        toggleDropdown(event) {
            const dropdownElement = event.target.closest('.dropdown-toggle');
            const dropdownInstance = Dropdown.getOrCreateInstance(dropdownElement);
            dropdownInstance.toggle();
        },
        showUploadPhotoeModal() {
            if (this.profilePhotoModalInstance) {
                this.profilePhotoModalInstance.show();
            } else {
                console.error('Modal instance is not initialized.');
            }
        },
      repositionCoverPhoto(event) {
      this.isRepositioning = true;
      this.initialY = event.clientY;
      const coverImage = this.$refs.coverImage;
      this.initialTop = parseInt(window.getComputedStyle(coverImage).top, 10) || 0;
      this.maxTop = -(coverImage.clientHeight - this.$refs.coverImage.parentElement.clientHeight);
      document.addEventListener('mousemove', this.handleMouseMove);
      document.addEventListener('mouseup', this.handleMouseUp);
    },
    handleMouseMove(event) {
      if (!this.isRepositioning) return;
      this.offsetY = event.clientY - this.initialY;
      const newTop = Math.min(Math.max(this.initialTop + this.offsetY, this.maxTop), 0);
      const coverImage = this.$refs.coverImage;
      coverImage.style.top = `${newTop}px`;
    },
    handleMouseUp() {
      this.isRepositioning = false;
      document.removeEventListener('mousemove', this.handleMouseMove);
      document.removeEventListener('mouseup', this.handleMouseUp);
    },
    handleMouseWheel(event) {
      if (!this.isRepositioning) return;
      event.preventDefault();
      const delta = Math.max(-1, Math.min(1, event.deltaY));
      const coverImage = this.$refs.coverImage;
      const currentTop = parseInt(window.getComputedStyle(coverImage).top, 10) || 0;
      const newTop = Math.min(Math.max(currentTop - delta * 10, this.maxTop), 0);
      coverImage.style.top = `${newTop}px`;
    },

    },
    mounted() {
        this.profilePhotoModalInstance = new Modal(this.$refs.profilePhotoModal, { backdrop: 'static' });
    }
}
</script>
<style>
.profile_bg_img {
    height: 400px;
    position: relative;
}

.profile-cover-photo {
    width: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
}

.cover-photo-overlay {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: none;
    /* Hide by default */
}

.cover-photo-btn {
    bottom: 20px;
    right: 21px;
}

.user-profile-wrapper {
    top: -60px;
}

.user-avater-wappar {
    width: 170px;
    height: 170px;
}

.user-profile-btn {
    transform: translateY(-30px);
}

.profile-photo-btn {
    width: 40px;
    height: 40px;
    right: 0;
    bottom: 10px;
}
</style>
