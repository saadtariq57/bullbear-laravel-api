<template>
    <div class="position-relative">
        <div class="profile_bg_img w-100 position-relative overflow-hidden">

            <img ref="coverImage" :src="'uploads/' + coverImagePath" alt="Cover Image"
                class="img-fluid w-100 profile-cover-photo" @load="calculateOffsets"
                :style="{ top: userData.cover_position }" />
            <div class="cover-photo-overlay" v-if="isRepositioning" @wheel="repositionWithWheel"></div>
            <!-- Overlay for better visibility -->
        </div>
        <div class="btn-group position-absolute cover-photo-btn" v-if="!isRepositioning">
            <button type="button"
                class="btn bg-white dropdown-toggle d-flex align-items-center gap-2 shadow z-1 text-cta"
                @click="toggleDropdown($event)" data-bs-toggle="dropdown" data-bs-display="static"
                aria-expanded="false">
                <i class="bi bi-camera-fill fs-5"></i><span class="fs-6 fw-5">Edit Cover Photo</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end z-1">
                <li>
                    <button @click="showUploadCoverPhotoModal" class="dropdown-item fs-6 fw-5"><i
                            class="bi bi-upload me-2 fs-5"></i>Change Cover</button>
                </li>
                <li>
                    <button class="dropdown-item fs-6 fw-5 d-none d-lg-block" @click="repositionCoverPhoto">
                        <i class="bi bi-arrows-move me-2 fs-5"></i> Reposition
                    </button>
                </li>
                <li>
                    <hr class="dropdown-divider m-0" />
                </li>
                <li>
                    <button class="dropdown-item fs-6 fw-5" @click="RemoveCoverImage">
                        <i class="bi bi-trash3-fill me-2 fs-5"></i> Remove
                    </button>
                </li>
            </ul>
        </div>
        <div class="btn-group position-absolute cover-photo-btn" v-if="isRepositioning">
            <button type="button" class="btn btn-primary px-3 rounded-3 z-1" @click="SetCoverPosition">
                <i class="bi bi-check-lg fs-5 icon-bold"></i>
            </button>
            <button type="button" class="btn bg-white px-3 ms-3 rounded-3 z-1" @click="CancelCoverPosition">
                <i class="bi bi-x-lg fs-5 icon-bold"></i>
            </button>
        </div>
    </div>
    <div class="user-profile-wrapper position-relative d-flex justify-content-between px-4">
        <div class="user-profile-info-wapper d-flex gap-4">
            <div
                class="user-avater-wappar position-relative bg-white rounded-circle d-flex justify-content-center align-items-center">
                <img :src="'uploads/' + profileImagePath" alt="Profile Picture" width="165px" height="165px"
                    class="rounded-circle">
                <!-- Button trigger modal -->
                <button @click="showUploadPhotoeModal"
                    class="position-absolute btn bg-white rounded-circle profile-photo-btn px-0 d-flex justify-content-center align-items-center shadow"><i
                        class="bi bi-camera-fill fs-4 text-cta"></i></button>
            </div>
            <!-- Cover Modal -->
            <div class="modal fade" ref="coverPhotoModal" id="coverPhoto" tabindex="-1"
                aria-labelledby="coverPhotoModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width:800px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="coverPhotoModalLabel">Change Cover Photo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="closeProfileModal"></button>
                        </div>
                        <div v-if="message != null" class=" text-center py-5">
                            <img :src="'uploads/' + coverImagePath" alt="Profile Photo" class="img-fluid px-3">
                            <p class="px-3 my-3">{{ message }}</p>
                        </div>
                        <div v-else class="modal-body">
                            <div class="text-center py-3" v-if="!selectedImage">
                                <p><span>{{ userData.name }}</span>, help others recognize you!</p>
                                <div class="my-5">
                                    <img :src="'uploads/' + coverImagePath" alt="Cover Photo" width="100%">
                                </div>
                                <p class="px-3">On Rich Tv, we require members to use their real identities, upload a
                                    cover photo</p>
                            </div>
                            <div v-if="selectedImage">
                                <div
                                    class="user-cover-wrapper position-relative bg-white d-flex justify-content-center align-items-center">
                                    <vue-cropper ref="covercropper" :src="selectedImage.preview" :view-mode="1"
                                        :drag-mode="'move'" :guides="true" :zoomable="true" :scalable="true"
                                        :crop-box-movable="true" :crop-box-resizable="true" :aspect-ratio="16 / 9"
                                        @cropmove="updatePreview" class="w-100 img-preview"></vue-cropper>
                                </div>
                                <!-- Zoom Controls -->
                                <div class="my-4">
                                    <span class="d-block mb-1">Zoom</span>
                                    <input type="range" class="w-100" min="0" max="3" step="0.1" v-model="zoomLevel"
                                        @input="zoomImage">
                                </div>
                                <div class="my-4">
                                    <span class="d-block mb-1">Straighten</span>
                                    <input type="range" class="w-100" min="-180" max="180" @input="rotateImage">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" v-if="message == null">
                            <label class="btn btn-primary" v-if="!selectedImage">
                                <input ref="profileInput" type="file" accept="image/jpeg,image/jpg,image/png"
                                    @change="handleCoverPhotoChange" class="upload-profile-photo d-none">
                                Upload Cover
                            </label>
                            <!-- Apply Button -->
                            <button class="btn btn-primary w-100 my-3" @click="applyCoverImageSetting"
                                v-if="selectedImage" :disabled="!uploadingProfilePhoto">Apply & Upload</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end Cover Modal -->
            <!-- profile Modal -->
            <div class="modal fade" ref="profilePhotoModal" id="profilePhoto" tabindex="-1"
                aria-labelledby="profilePhotoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="profilePhotoModalLabel">Change Profile Photo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="closeProfileModal"></button>
                        </div>
                        <div v-if="message != null" class=" text-center py-5">
                            <img :src="'uploads/' + profileImagePath" alt="Profile Photo" class="rounded-circle"
                                width="165" height="165">
                            <p class="px-3 my-3">{{ message }}</p>
                        </div>
                        <div v-else class="modal-body">
                            <div class="text-center py-3" v-if="!selectedImage">
                                <p><span>{{ userData.name }}</span>, help others recognize you!</p>
                                <div class="my-5">
                                    <img :src="'uploads/' + profileImagePath" alt="Profile Photo" class="rounded-circle"
                                        width="165" height="165">
                                </div>
                                <p class="px-3">On Rich Tv, we require members to use their real identities, upload a
                                    photo
                                    of yourself</p>
                            </div>
                            <div v-if="selectedImage">
                                <div
                                    class="user-avatar-wrapper position-relative bg-white d-flex justify-content-center align-items-center">
                                    <vue-cropper ref="cropper" :src="selectedImage.preview" :view-mode="1"
                                        :drag-mode="'move'" :guides="true" :zoomable="true" :scalable="true"
                                        :crop-box-movable="true" :crop-box-resizable="true" :aspect-ratio="1"
                                        @cropmove="updatePreview" class="w-100 img-preview"></vue-cropper>
                                </div>
                                <!-- Zoom Controls -->
                                <div class="my-4">
                                    <span class="d-block mb-1">Zoom</span>
                                    <input type="range" class="w-100" min="0" max="3" step="0.1" v-model="zoomLevel"
                                        @input="zoomImage">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" v-if="message == null">
                            <label class="btn btn-primary" v-if="!selectedImage">
                                <input ref="profileInput" type="file" accept="image/jpeg,image/jpg,image/png"
                                    @change="handleProfileChange" class="upload-profile-photo d-none">
                                Upload photo
                            </label>
                            <!-- Apply Button -->
                            <button class="btn btn-primary w-100 my-3" @click="applyProfileSetting" v-if="selectedImage"
                                :disabled="!uploadingProfilePhoto">Apply & Upload</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end profile Modal -->
            <div class="user-profile-info align-self-end">
                <div class="d-flex align-items-center gap-2">
                    <h1>{{ userData.name }}</h1>
                    <span v-if="userData.subscription_plan != 'free'"><i
                            class="bi bi-patch-check-fill fs-2 user-verified-icon"></i></span>
                    <!-- <span class="user-pro text-white px-2 py-1 fs-10 rounded-2"
                        v-if="userData.subscription_plan == 'platinum'">PRO</span> -->
                    <span class="user-pro text-white px-2 py-1 fs-10 rounded-2"
                        v-if="userData.subscription_plan != 'free'">{{ userData.subscription_plan }}</span>
                </div>
                <a href="#" class="text-black fs-5"><span>{{ userData.followers_count }}</span> followers</a>
            </div>
        </div>
        <div class="user-profile-btn align-self-end">
            <!-- <button class="btn btn-primary fs-6 fw-5 px-3 py-2 me-3"><i
                    class="bi bi-list-ul fs-5 me-2 align-middle"></i>Activities</button> -->
            <a href="/profile/setting" class="btn btn-primary fs-6 fw-5 px-3"><i
                    class="bi bi-pencil-fill fs-6 me-2"></i>Edit Profile</a>

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
import axios from 'axios';
import { Dropdown } from 'bootstrap';
import { Modal } from 'bootstrap';
import { mapState } from 'vuex';
import VueCropper from 'vue-cropperjs';
import 'cropperjs/dist/cropper.css';
export default {
    components: {
        VueCropper
    },
    computed: {
        ...mapState(['userData']),
    },
    data() {
        return {
            isRepositioning: false,
            cover_position: 0,
            offsetY: 0,
            maxOffsetY: 0,
            minOffsetY: 0,
            selectedFiles: [],
            selectedImage: null,
            zoomLevel: 0,
            profileImagePath: 'photos/d-avatar.jpg',
            coverImagePath: 'photos/d-cover.jpg',
            message: null,
            uploadingProfilePhoto: true,
        }
    },
    methods: {
        toggleDropdown(event) {
            const dropdownElement = event.target.closest('.dropdown-toggle');
            const dropdownInstance = Dropdown.getOrCreateInstance(dropdownElement);
            dropdownInstance.toggle();
        },
        showUploadPhotoeModal() {
            this.message = null;
            if (this.profilePhotoModalInstance) {
                this.profilePhotoModalInstance.show();
            } else {
                console.error('Modal instance is not initialized.');
            }
        },
        showUploadCoverPhotoModal() {
            this.message = null;
            if (this.coverPhotoModalInstance) {
                this.coverPhotoModalInstance.show();
            } else {
                console.error('Modal instance is not initialized.');
            }
        },
        closeProfileModal() {
            this.selectedImage = null;
            this.selectedFiles = [];
            this.uploadingProfilePhoto = true;
        },
        repositionCoverPhoto(event) {
            this.isRepositioning = true;
        },
        repositionWithWheel(event) {
            if (this.isRepositioning) {
                // Adjust deltaY value as needed based on mouse wheel sensitivity
                const deltaY = event.deltaY;
                // Update offsetY within its boundaries
                this.offsetY = Math.max(this.minOffsetY, Math.min(this.maxOffsetY, this.offsetY + deltaY));
                this.$refs.coverImage.style.top = this.offsetY + 'px';
                // Prevent default scrolling behavior
                event.preventDefault();
            }
        },
        async SetCoverPosition() {
            this.isRepositioning = false;
            this.uploadingProfilePhoto = false;
            this.cover_position = this.offsetY + 'px';
            this.userData.cover_position = this.cover_position;
            try {
                // Update cover position via API
                await axios.post('/api/update-cover-position', {
                    cover_position: this.cover_position
                });

                // Refetch user data to update the Vuex store
                await this.$store.dispatch('fetchUserData');

                console.log('Cover position updated successfully');
            } catch (error) {
                console.error('Error updating cover position:', error);
            }
        },
        CancelCoverPosition() {
            this.isRepositioning = false;
            this.$refs.coverImage.style.top = cover_position;
        },
        calculateOffsets() {
            // Calculate the maximum and minimum offset values based on the actual height of the cover photo
            this.maxOffsetY = 0;
            this.minOffsetY = -(this.$refs.coverImage.clientHeight - this.$refs.coverImage.parentElement.clientHeight);
        },
        handleCoverPhotoChange(event) {
            const file = event.target.files[0];
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (file && validTypes.includes(file.type)) { // Change 'files' to 'file'
                this.readFilesAndPreview([file]);
            } else {
                alert('Invalid file type. Please select an image file (gif, jpeg, jpg, png).');
            }
        },
        handleProfileChange(event) {
            const files = event.target.files;
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (files && files.length > 0) {
                const filteredFiles = Array.from(files).filter(file => validTypes.includes(file.type));

                if (filteredFiles.length > 0) {
                    this.readFilesAndPreview(filteredFiles);
                } else {
                    alert('Invalid file type. Please select an image file (gif, jpeg, jpg, png).');
                }
            }
        },
        readFilesAndPreview(files) {
            this.uploadingProfilePhoto = true;
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const fileWithPreview = {
                        file,
                        preview: e.target.result,
                        alt: ""
                    };
                    this.selectedFiles.push(fileWithPreview);
                    if (!this.selectedImage) {
                        this.selectedImage = fileWithPreview;
                    }
                };
                reader.readAsDataURL(file);
            });
        },
        zoomImage() {
            this.$refs.cropper.zoomTo(this.zoomLevel);
            this.$refs.covercropper.zoomTo(this.zoomLevel);
        },
        rotateImage(event) {
            const degrees = parseInt(event.target.value);
            const cropper = this.$refs.covercropper;
            if (!cropper) {
                console.error('Cropper instance not found');
                return;
            }
            cropper.rotateTo(degrees);
        },
        applyProfileSetting() {
            const canvas = this.$refs.cropper.getCroppedCanvas();
            const croppedBlob = canvas.toBlob((blob) => {
                const file = new File([blob], 'profile_photo.jpg', { type: 'image/jpeg' });
                this.uploadProfileImage(file);
            }, 'image/jpeg');
        },
        applyCoverImageSetting() {
            this.uploadingProfilePhoto = false;
            const canvas = this.$refs.covercropper.getCroppedCanvas();
            const croppedBlob = canvas.toBlob((blob) => {
                const file = new File([blob], 'cover_photo.jpg', { type: 'image/jpeg' });
                this.uploadImage(file, 'cover');
            }, 'image/jpeg');
        },
        updatePreview() { },
        async uploadImage(file) {
            const formData = new FormData();
            formData.append('cover_photo', file);

            try {
                const response = await axios.post('/api/uploadCover', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                // Update cover image path
                this.coverImagePath = response.data.cover_photo;

                // Update cover position and fetch user data again
                this.userData.cover_position = "0px";
                await axios.post('/api/update-cover-position', {
                    cover_position: this.userData.cover_position
                });
                await this.$store.dispatch('fetchUserData');

                // Handle response from server
                console.log('Cover photo:', response.data);
                this.message = response.data.message;
                this.uploadingProfilePhoto = true;
                this.$refs.coverImage.style.top = '0px';
                this.closeProfileModal();
            } catch (error) {
                console.error('Error uploading cover photo:', error);
                this.uploadingProfilePhoto = true;
            }
        },
        async uploadProfileImage(file) {
            this.uploadingProfilePhoto = false;
            const formData = new FormData();
            formData.append('profile_photo', file);

            try {
                const response = await axios.post('/api/profileImage', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                // Handle response from server
                this.profileImagePath = response.data.profile_photo;
                this.message = response.data.message;
                console.log('Profile photo:', response.data);
                this.closeProfileModal();
                this.$store.dispatch('fetchUserData');

            } catch (error) {
                console.error('Error uploading profile photo:', error);
                this.message = response.data.error;
            }
        },
        async RemoveCoverImage() {
            try {
                const response = await axios.post('/api/removeCover', {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                console.log('cover photo:', response.data);
                this.coverImagePath = 'photos/d-cover.jpg';
                // Update cover position and fetch user data again
                this.userData.cover_position = "0px";
                await axios.post('/api/update-cover-position', {
                    cover_position: this.userData.cover_position
                });
                await this.$store.dispatch('fetchUserData');
                this.$refs.coverImage.style.top = '0px';
            } catch (error) {
                console.error('Error removing cover photo:', error);
                this.message = response.data.error;
            }
        }
    },
    mounted() {
        if (this.userData.avatar != '') {
            this.profileImagePath = this.userData.avatar;
        }
        if (this.userData.cover != '') {
            this.coverImagePath = this.userData.cover;
        }

        this.profilePhotoModalInstance = new Modal(this.$refs.profilePhotoModal, { backdrop: 'static' });
        this.coverPhotoModalInstance = new Modal(this.$refs.coverPhotoModal, { backdrop: 'static' });
        // console.log(this.userData);
        this.cover_position = this.userData.cover_position;
    }
}
</script>
<style>
.profile_bg_img {
    position: relative;
    height: 50vh;
}

.profile-cover-photo {
    width: 100%;
    height: auto;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 0;
    /* Ensure cover photo is above overlay */
    /* cursor: move; Make the cover photo draggable */
}

.cover-photo-overlay {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.3);
    /* Semi-transparent overlay for better visibility */
    /* z-index: 1; Ensure overlay is above cover photo */
    cursor: ns-resize;
    /* Change cursor to indicate vertical resize */
}

.cover-photo-btn {
    bottom: 20px;
    right: 21px;
}

.user-profile-wrapper {
    top: -55px;
}

.user-avater-wappar {
    width: 170px;
    height: 170px;
}

.user-verified-icon {
    color: var(--cta-hover);
}

.user-pro {
    background-color: var(--cta-hover);
}

.user-profile-btn {
    transform: translateY(-10px);
}

.profile-photo-btn {
    width: 40px;
    height: 40px;
    right: 0;
    bottom: 10px;
}

.rounded-circle {
    object-fit: cover;
}

.user-avatar-wrapper {
    width: 100%;
    height: 100%;
    border: 3px solid #ccc;
    /* border-radius: 50%; */
    overflow: hidden;
}

.user-avatar-wrapper .cropper-view-box,
.user-avatar-wrapper .cropper-face {
    border-radius: 100%;
}

/* .user-cover-wrapper .cropper-view-box,
.user-cover-wrapper .cropper-face,.user-cover-wrapper .cropper-crop-box {
    width: 100%!important;
    height:400px!important;
} */
@media (max-width: 767px) {
    .inner-tabs-btn {
        min-width: 660px;
    }
}

@media (max-width: 991px) {
    .profile-cover-photo {
        top: 0px !important;
    }
}

/* @media (max-width: 1199px) {
    .profile-cover-photo{
        top: 0px !important;
    }
} */
</style>
