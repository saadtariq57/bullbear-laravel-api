<template>
    <div class="position-relative">
        <div class="profile_bg_img w-100 position-relative overflow-hidden">
            <img ref="coverImage" v-if="context === 'profileHeader'" :src="UpdatedCoverImagePath != null ? '/uploads/'+UpdatedCoverImagePath : '/uploads/'+coverImagePath" alt="Cover Image"
                class="img-fluid w-100 profile-cover-photo object-fit-cover" /> 
            <img ref="coverImage" v-else :src="'uploads/'+UpdatedCoverImagePath" alt="Group Cover Image"
                class="img-fluid w-100 profile-cover-photo object-fit-cover" /> 
            <div class="cover-photo-overlay" v-show="isRepositioning"></div>
            <!-- Overlay for better visibility -->
        </div>
        <div class="btn-group position-absolute cover-photo-btn" v-if="isOwnProfile && context === 'profileHeader' || context === 'groupHeader'">
            <button type="button" class="btn bg-white dropdown-toggle d-flex align-items-center gap-2 shadow z-1 text-cta"
                @click="toggleDropdown($event)">
                <i class="bi bi-camera-fill fs-5"></i><span class="fs-6 fw-5">Edit Cover Photo</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end z-1">
                <li>
                    <label class="dropdown-item fs-6 fw-5">
                        <button @click="showUploadCoverPhotoModal" class="dropdown-item fs-6 fw-5"><i class="bi bi-upload me-2 fs-5"></i>Change Cover</button>
                    </label>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>
                    <button class="dropdown-item fs-6 fw-5" @click="RemoveCover(context)">
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
                <img v-if="context === 'profileHeader'" :src="UpdatedProfileImagePath != null ? '/uploads/'+UpdatedProfileImagePath : '/uploads/'+profileImagePath" alt="Profile Picture" width="165px" height="165px" class="rounded-circle">
                <img v-else :src="UpdatedProfileImagePath != null ? '/uploads/'+UpdatedProfileImagePath : '/uploads/'+profileImagePath" alt="Profile Picture" width="165px" height="165px" class="rounded-circle">
                <!-- Button trigger modal -->
                <button @click="showUploadPhotoeModal" v-if="isOwnProfile && context === 'profileHeader' || context === 'groupHeader'" 
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
                        <p v-if="message!=null">{{ message }}</p>
                        <div v-else class="modal-body">
                            <div class="text-center py-3" v-if="!selectedImage">
                                <p><span>{{ userData.name }}</span>, help others recognize you!</p>
                                <div class="my-5">
                                    <img :src="UpdatedCoverImagePath != null ? '/uploads/'+UpdatedCoverImagePath : '/uploads/'+coverImagePath" alt="Cover Photo" width="100%">
                                </div>
                                <p class="px-3">On Rich Tv, we require members to use their real identities, upload a cover photo</p>
                            </div>
                            <div v-if="selectedImage">
                                <div class="user-cover-wrapper position-relative bg-white d-flex justify-content-center align-items-center">
                                    <vue-cropper ref="covercropper" :src="selectedImage.preview" :view-mode="1" :drag-mode="'move'"
                                    :guides="true" :zoomable="true" :scalable="true" :crop-box-movable="true"
                                    :crop-box-resizable="true" :aspect-ratio="16 / 9" @cropmove="updatePreview"
                                    class="w-100 img-preview"></vue-cropper>
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
                        <div class="modal-footer" v-if="message==null">
                            <label class="btn btn-primary" v-if="!selectedImage">
                                <input ref="profileInput" type="file" accept="image/jpeg,image/jpg,image/png"
                                    @change="handleCoverPhotoChange" class="upload-profile-photo d-none">
                                Upload Cover
                            </label>
                            <!-- Apply Button -->
                            <button class="btn btn-primary w-100 my-3" @click="applyCoverImageSetting(context)"
                                v-if="selectedImage">Apply & Upload</button>
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
                        <p v-if="message!=null">{{ message }}</p>
                        <div v-else class="modal-body">
                            <div class="text-center py-3" v-if="!selectedImage">
                                <p><span>{{ userData.name }}</span>, help others recognize you!</p>
                                <div class="my-5">
                                    <img :src="UpdatedProfileImagePath != null ? '/uploads/'+UpdatedProfileImagePath : '/uploads/'+profileImagePath" alt="Profile Photo" class="rounded-circle" width="165"
                                        height="165">
                                </div>
                                <p class="px-3">On Rich Tv, we require members to use their real identities, upload a photo
                                    of yourself</p>
                            </div>
                            <div v-if="selectedImage">
                                <div class="user-avatar-wrapper position-relative bg-white rounded-circle d-flex justify-content-center align-items-center">
                                    <vue-cropper ref="cropper" :src="selectedImage.preview" :view-mode="1" :drag-mode="'move'"
                                    :guides="true" :zoomable="true" :scalable="true" :crop-box-movable="true"
                                    :crop-box-resizable="true" :aspect-ratio="1" @cropmove="updatePreview"
                                    class="w-100 img-preview"></vue-cropper>
                                </div>
                                <!-- Zoom Controls -->
                                <div class="my-4">
                                    <span class="d-block mb-1">Zoom</span>
                                    <input type="range" class="w-100" min="0" max="3" step="0.1" v-model="zoomLevel"
                                        @input="zoomImage">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" v-if="message==null">
                            <label class="btn btn-primary" v-if="!selectedImage">
                                <input ref="profileInput" type="file" accept="image/jpeg,image/jpg,image/png"
                                    @change="handleProfileChange" class="upload-profile-photo d-none">
                                Upload photo
                            </label>
                            <!-- Apply Button -->
                            <button class="btn btn-primary w-100 my-3" @click="applyProfileSetting(context)"
                                v-if="selectedImage">Apply & Upload</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end profile Modal -->
        </div>
        <div class="user-profile-btn align-self-end" v-if="isOwnProfile && context === 'profileHeader'">
            <a href="/profile/setting" class="btn btn-primary fs-6 fw-5 px-3"><i
                    class="bi bi-pencil-fill fs-6 me-2"></i>Edit Profile</a>
        </div>
    </div>
</template>
<script>
import { Dropdown, Modal } from 'bootstrap';
import { mapState, mapActions } from 'vuex';
import VueCropper from 'vue-cropperjs';
import 'cropperjs/dist/cropper.css';

export default {
    components: {
        VueCropper
    },
    props: {
        context: String 
    },
    computed: {
        ...mapState(['userData','success']),
        ...mapState('userProfile',['userProfileData', 'coverImagePath', 'profileImagePath', 'isOwnProfile']),
        ...mapState('profileGroupHeader',['UpdatedCoverImagePath', 'message', 'UpdatedProfileImagePath']),
    },
    data() {
        return {
            isRepositioning: false,
            initialY: 0,
            offsetY: 0,
            initialTop: 0,
            maxTop: 0,
            selectedFiles: [],
            selectedImage: null,
            zoomLevel:0,
        }
    },
    created() {
        console.log('the context is: ', this.context);
     },
    methods: {
        ...mapActions('profileGroupHeader',['uploadCoverImage', 'RemoveCoverImage', 'uploadProfileImage', 'clearMessage']),
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
        showUploadCoverPhotoModal(){
            if(this.coverPhotoModalInstance){
                this.coverPhotoModalInstance.show();
            }else {
                console.error('Modal instance is not initialized.');
            }
        },
        closeProfileModal() {
            this.selectedImage = null;
            this.selectedFiles = [];
            this.clearMessage();
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
        handleCoverPhotoChange(event) {
            const file = event.target.files[0];
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (file && validTypes.includes(file.type)) { // Change 'files' to 'file'
                this.readFilesAndPreview([file]);
            } else {
                alert('Invalid file type. Please select an image file (jpeg, jpg, png).');
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
                    alert('Invalid file type. Please select an image file (jpeg, jpg, png).');
                }
            }
        },
        readFilesAndPreview(files) {
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
        applyProfileSetting(context) {
            const canvas = this.$refs.cropper.getCroppedCanvas();
            canvas.toBlob((blob) => {
                const file = new File([blob], 'profile_photo.jpg', { type: 'image/jpeg' });
                this.uploadProfileImage({file, context});
            }, 'image/jpeg');
        },
        applyCoverImageSetting(context) {
            const canvas = this.$refs.covercropper.getCroppedCanvas();
            canvas.toBlob((blob) => {
                const file = new File([blob], 'cover_photo.jpg', { type: 'image/jpeg' });
                this.uploadCoverImage({file, context});
            }, 'image/jpeg');
        },
        RemoveCover(context){
            this.RemoveCoverImage(context);
        },
        updatePreview() {},
    },
    mounted() {
        this.profilePhotoModalInstance = new Modal(this.$refs.profilePhotoModal, { backdrop: 'static' });
        this.coverPhotoModalInstance  = new Modal(this.$refs.coverPhotoModal, { backdrop: 'static' });
    }
}
</script>
<style>
.profile_bg_img{
    position: relative;
    height:400px;
}

.profile-cover-photo {
    width: 100%;
    height: 400px;
    object-fit: cover!important;
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
    top: -30px;
}

.user-avater-wappar {
    width: 165px;
    height: 165px;
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
.rounded-circle{
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
</style>
