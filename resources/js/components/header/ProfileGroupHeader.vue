<template>
    <div class="position-relative">
        <div class="profile_bg_img w-100 position-relative overflow-hidden">
            <img ref="coverImage" v-if="context === 'profileHeader'" :src="coverImageSrc" alt="Cover Image"
                class="img-fluid w-100 profile-cover-photo object-fit-cover" @load="calculateOffsets"
                @error="handleCoverImageError" :style="{ top: userData.cover_position }" />
            <img ref="coverGroupImage" v-else-if="groupData != null" :src="groupCoverImageSrc" alt="Group Cover Image"
                class="img-fluid w-100 profile-cover-photo object-fit-cover" @load="calculateOffsets"
                @error="handleCoverImageError" :style="{ top: groupData.cover_position }" />
            <div class="cover-photo-overlay" v-if="isRepositioning" @wheel="repositionWithWheel"></div>
            <!-- Overlay for better visibility -->
        </div>
        <div class="btn-group position-absolute cover-photo-btn"
            v-if="isOwnProfile && context === 'profileHeader' || context === 'groupHeader' && authRole"
            v-show="!isRepositioning">
            <button type="button" data-bs-toggle="dropdown" aria-expanded="false"
                class="btn bg-white dropdown-toggle d-flex align-items-center gap-2 shadow z-1 text-cta"
                @click="toggleDropdown($event)">
                <i class="bi bi-camera-fill fs-5"></i><span class="fs-6 fw-5">Edit Cover Photo</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end z-1">
                <li>
                <li>
                    <button @click="showUploadCoverPhotoModal" class="dropdown-item fs-6 fw-5"><i
                            class="bi bi-upload me-2 fs-5"></i>Change Cover</button>
                </li>
                <li>
                    <button class="dropdown-item fs-6 fw-5 d-none d-lg-block" @click="repositionCoverPhoto">
                        <i class="bi bi-arrows-move me-2 fs-5"></i> Reposition
                    </button>
                </li>
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
        <div class="user-profile-info-wapper d-flex gap-4 align-item-center">
            <div
                class="user-avater-wappar position-relative bg-white rounded-circle d-flex justify-content-center align-items-center gap-5">
                <img v-if="context === 'profileHeader'"
                    :src="UpdatedProfileImagePath != null ? '/uploads/' + UpdatedProfileImagePath : '/uploads/' + profileImagePath"
                    alt="Profile Picture" width="165px" height="165px" class="rounded-circle"
                    @error="handlegroupprofileError">
                <img v-else-if="context === 'groupHeader' && groupData != null"
                    :src="groupData.avatar != null ? '/uploads/' + groupData.avatar : '/uploads/' + profileImagePath"
                    alt="Profile Picture" width="165px" height="165px" class="rounded-circle"
                    @error="handlegroupprofileError">
                <!-- Button trigger modal -->
                <button @click="showUploadPhotoeModal"
                    v-if="isOwnProfile && context === 'profileHeader' || context === 'groupHeader' && authRole"
                    class="position-absolute btn bg-white rounded-circle profile-photo-btn px-0 d-flex justify-content-center align-items-center shadow"><i
                        class="bi bi-camera-fill fs-4 text-cta"></i></button>
            </div>
            <span v-if="context === 'groupHeader' && groupData != null" class="align-self-end">
                <h1>{{ groupData.group_title }}</h1>
                <div class="fw-5 text-capitalize d-flex gap-2 align-items-center">
                    <span>{{ groupData.privacy }} Group</span>
                    <span class="group-privacy-divider rounded-circle"></span>
                    <span>{{ groupData.members_count }} Members</span>
                </div>
            </span>
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
                            <img v-if="context === 'profileHeader'"
                                :src="UpdatedCoverImagePath != null ? '/uploads/' + UpdatedCoverImagePath : '/uploads/' + coverImagePath"
                                alt="Profile Photo" class="img-fluid px-3">
                            <img v-else-if="context === 'groupHeader' && groupData != null"
                                :src="groupData.cover != null ? '/uploads/' + groupData.cover : '/uploads/' + coverImagePath"
                                alt="Profile Photo" class="img-fluid px-3">
                            <p class="px-3 my-3">{{ message }}</p>
                        </div>
                        <div v-else class="modal-body">
                            <div class="text-center py-3" v-if="!selectedImage && context === 'profileHeader'">
                                <p><span>{{ userData.name }}</span>, help others recognize you!</p>
                                <div class="my-5">
                                    <img :src="UpdatedCoverImagePath != null ? '/uploads/' + UpdatedCoverImagePath : '/uploads/' + coverImagePath"
                                        alt="Cover Photo" width="100%">
                                </div>
                                <p class="px-3">On Rich Tv, we require members to use their real identities, upload a
                                    cover photo</p>
                            </div>
                            <div class="text-center py-3"
                                v-else-if="!selectedImage && context === 'groupHeader' && groupData != null">
                                <p><span>{{ groupData.group_title }}</span>, help others recognize you!</p>
                                <div class="my-5">
                                    <img :src="groupData.cover != null ? '/uploads/' + groupData.cover : '/uploads/' + coverImagePath"
                                        alt="Cover Photo" width="100%">
                                </div>
                                <p class="px-3">On Rich Tv, we require admin to use group real identities, upload a
                                    cover photo
                                    of group</p>
                            </div>
                            <div v-if="selectedImage">
                                <div
                                    class="user-cover-wrapper position-relative bg-white d-flex justify-content-center align-items-center">
                                    <vue-cropper ref="covercropper" :src="selectedImage.preview" :view-mode="1"
                                        :drag-mode="'move'" :guides="true" :zoomable="true" :scalable="true"
                                        :crop-box-movable="true" :crop-box-resizable="true"
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
                        <div v-if="message != null" class=" text-center py-5">
                            <img :src="UpdatedProfileImagePath != null ? '/uploads/' + UpdatedProfileImagePath : '/uploads/' + profileImagePath"
                                alt="Profile Photo" class="rounded-circle" width="165" height="165">
                            <p class="px-3 my-3">{{ message }}</p>
                        </div>
                        <div v-else class="modal-body">
                            <div class="text-center py-3" v-if="!selectedImage && context === 'profileHeader'">
                                <p><span>{{ userData.name }}</span>, help others recognize you!</p>
                                <div class="my-5">
                                    <img :src="UpdatedProfileImagePath != null ? '/uploads/' + UpdatedProfileImagePath : '/uploads/' + profileImagePath"
                                        alt="Profile Photo" class="rounded-circle" width="165" height="165">
                                </div>
                                <p class="px-3">On Rich Tv, we require members to use their real identities, upload a
                                    photo
                                    of yourself</p>
                            </div>
                            <div class="text-center py-3"
                                v-else-if="!selectedImage && context === 'groupHeader' && groupData != null">
                                <p><span>{{ groupData.group_title }}</span>, help others recognize you!</p>
                                <div class="my-5">
                                    <img :src="groupData.avatar != null ? '/uploads/' + groupData.avatar : '/uploads/' + coverImagePath"
                                        alt="Profile Photo" class="rounded-circle" width="165" height="165">
                                </div>
                                <p class="px-3">On Rich Tv, we require admin to use group real identities, upload a
                                    photo
                                    of group</p>
                            </div>
                            <div v-if="selectedImage">
                                <div
                                    class="user-avatar-wrapper position-relative bg-white rounded-circle d-flex justify-content-center align-items-center">
                                    <vue-cropper ref="cropper" :src="selectedImage.preview" :view-mode="1"
                                        :drag-mode="'move'" :guides="true" :zoomable="true" :scalable="true"
                                        :crop-box-movable="true" :crop-box-resizable="true"
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
                            <button class="btn btn-primary w-100 my-3" @click="applyProfileSetting(context)"
                                v-if="selectedImage">Apply & Upload</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end profile Modal -->
        </div>
    </div>
</template>
<script>
import { Dropdown, Modal } from 'bootstrap';
import { mapState, mapActions } from 'vuex';
import VueCropper from 'vue-cropperjs';
import 'cropperjs/dist/cropper.css';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import Swal from 'sweetalert2';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userProfileModule from '@/stores/profileStore';
import userGroupModule from '@/stores/groupStore';

export default {
  components: {
    VueCropper,
    Skeletor
  },
  props: {
    context: String,
    id: String,
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
      uploadingProfilePhoto: true,
      showSkeletor: false,
      authRole: null,
      defaultCoverImage: '/uploads/photos/d-cover.jpg',
      defaultProfileImage: '/uploads/photos/d-avatar.jpg',
      coverImageLoadAttempts: 0,
      profileImageLoadAttempts: 0,
      maxLoadAttempts: 2,
      moduleRegistered: false
    };
  },
  computed: {
    ...mapState(['userData', 'success']),
    ...mapState('userProfile', ['userProfileData', 'coverImagePath', 'profileImagePath', 'isOwnProfile']),
    ...mapState('profileGroupHeader', ['UpdatedCoverImagePath', 'message', 'UpdatedProfileImagePath']),
    ...mapState('userGroup', ['groupData']),
    coverImageSrc() {
      return this.UpdatedCoverImagePath != null
        ? `/uploads/${this.UpdatedCoverImagePath}`
        : `/uploads/${this.coverImagePath}`;
    },
    groupCoverImageSrc() {
      return this.groupData && this.groupData.cover != null
        ? `/uploads/${this.groupData.cover}`
        : `/uploads/${this.coverImagePath}`;
    },
  },
  created() {
    if (!this.$store.hasModule('userProfile')) {
      registerVuexModule('userProfile', userProfileModule);
      this.moduleRegistered = true;
    }

    if (!this.$store.hasModule('userGroup')) {
      registerVuexModule('userGroup', userGroupModule);
      this.moduleRegistered = true;
    }
    if (this.context == "groupHeader") {
        this.fetchGroupData(this.id);
    }
  },
  methods: {
    ...mapActions('profileGroupHeader', ['uploadCoverImage', 'RemoveCoverImage', 'uploadProfileImage', 'clearMessage']),
    ...mapActions('userGroup', ['fetchGroupData']),
    toggleDropdown(event) {
      const dropdownElement = event.target.closest('.dropdown-toggle');
      const dropdownInstance = Dropdown.getOrCreateInstance(dropdownElement);
      dropdownInstance.toggle();
    },
    showUploadPhotoeModal() {
      this.clearMessage();
      if (this.profilePhotoModalInstance) {
        this.profilePhotoModalInstance.show();
      } else {
        console.error('Modal instance is not initialized.');
      }
    },
    showUploadCoverPhotoModal() {
      this.clearMessage();
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
      this.clearMessage();
    },
    repositionCoverPhoto(event) {
      this.isRepositioning = true;
    },
    repositionWithWheel(event) {
      if (this.isRepositioning) {
        // Adjust deltaY value as needed based on mouse wheel sensitivity
        if (this.context == "profileHeader") {
          const deltaY = event.deltaY;
          // Update offsetY within its boundaries
          this.offsetY = Math.max(this.minOffsetY, Math.min(this.maxOffsetY, this.offsetY + deltaY));
          this.$refs.coverImage.style.top = this.offsetY + 'px';
        } else {
          const deltaY = event.deltaY;
          this.offsetY = Math.max(this.minOffsetY, Math.min(this.maxOffsetY, this.offsetY + deltaY));
          this.$refs.coverGroupImage.style.top = this.offsetY + 'px';
        }
        // Prevent default scrolling behavior
        event.preventDefault();
      }
    },
    async SetCoverPosition() {
      this.isRepositioning = false;
      this.uploadingProfilePhoto = false;
      try {
        if (this.context == "profileHeader") {
          this.cover_position = this.offsetY + 'px';
          this.userData.cover_position = this.cover_position;
          // Update cover position via API
          await axios.post('/api/update-cover-position', {
            cover_position: this.cover_position
          });

          // Refetch user data to update the Vuex store
          await this.$store.dispatch('fetchUserData');

          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            width: "450px",
            timer: 1000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            }
          });
          Toast.fire({
            icon: "success",
            title: "Cover position updated successfully!"
          });
        } else {
          this.cover_position = this.offsetY + 'px';
          this.groupData.cover_position = this.cover_position;

          await axios.post('/api/group-cover-position', {
            cover_position: this.cover_position,
            group_id: this.id
          });
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            width: "450px",
            timer: 1000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            }
          });
          Toast.fire({
            icon: "success",
            title: "Cover position updated successfully!"
          });
        }
      } catch (error) {
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          width: "400px",
          timer: 1000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        Toast.fire({
          icon: "error",
          title: "Error updating cover position"
        });
      }
    },
    CancelCoverPosition() {
      if (this.context == "profileHeader") {
        this.isRepositioning = false;
        this.$refs.coverImage.style.top = this.cover_position;
      } else {
        this.isRepositioning = false;
        this.$refs.coverGroupImage.style.top = this.cover_position;
      }
    },
    calculateOffsets() {
      if (this.context == "profileHeader") {
        this.maxOffsetY = 0;
        this.minOffsetY = -(this.$refs.coverImage.clientHeight - this.$refs.coverImage.parentElement.clientHeight);
      } else {
        this.maxOffsetY = 0;
        this.minOffsetY = -(this.$refs.coverGroupImage.clientHeight - this.$refs.coverGroupImage.parentElement.clientHeight);
      }
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
      if (context === 'profileHeader') {
        canvas.toBlob((blob) => {
          const file = new File([blob], 'profile_photo.jpg', { type: 'image/jpeg' });
          this.uploadProfileImage({ file, context });
          this.$store.dispatch('fetchUserData');
        }, 'image/jpeg');
      } else {
        canvas.toBlob((blob) => {
          const file = new File([blob], 'profile_photo.jpg', { type: 'image/jpeg' });
          const group_Id = this.id;
          this.uploadProfileImage({ file, context, group_Id });
          this.fetchGroupData(this.id);
        }, 'image/jpeg');
      }
    },
    async applyCoverImageSetting(context) {
      const canvas = this.$refs.covercropper.getCroppedCanvas();

      if (context === 'profileHeader') {
        this.userData.cover_position = "0px";
        canvas.toBlob((blob) => {
          const file = new File([blob], 'cover_photo.jpg', { type: 'image/jpeg' });
          this.uploadCoverImage({ file, context });
        }, 'image/jpeg');
        try {
          this.$refs.coverImage.style.top = '0px';
          await axios.post('/api/update-cover-position', {
            cover_position: this.userData.cover_position
          });
          this.calculateOffsets();
          await this.$store.dispatch('fetchUserData');
        } catch (error) {
          this.uploadingProfilePhoto = true;
        }
      } else {
        this.groupData.cover_position = "0px";
        canvas.toBlob(async (blob) => {
          const file = new File([blob], 'cover_photo.jpg', { type: 'image/jpeg' });
          const groupId = this.id;
          await this.uploadCoverImage({ file, context, groupId });
          await this.fetchGroupData(this.id); 
          await this.calculateOffsets();
        }, 'image/jpeg');
      }
    },
    async RemoveCover(context) {
      if (context === 'profileHeader') {
        this.RemoveCoverImage(context);
        this.$refs.coverImage.style.top = '0px';
        this.$store.dispatch('fetchUserData');
        this.calculateOffsets();
      } else {
        const group_Id = this.id;
        this.RemoveCoverImage({ context, group_Id });
        this.fetchGroupData(this.id);
        this.calculateOffsets();
      }
    },
    updatePreview() { },
    handleCoverImageError(event) {
      if (this.coverImageLoadAttempts < this.maxLoadAttempts) {
        this.coverImageLoadAttempts++;
        event.target.src = this.defaultCoverImage;
      } else {
        event.target.src = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22100%25%22%20height%3D%22100%25%22%3E%3Crect%20fill%3D%22%23dddddd%22%20width%3D%22100%25%22%20height%3D%22100%25%22%2F%3E%3Ctext%20fill%3D%22%23666666%22%20font-family%3D%22Arial%2C%20sans-serif%22%20font-size%3D%2220%22%20x%3D%2250%25%22%20y%3D%2250%25%22%20text-anchor%3D%22middle%22%20dominant-baseline%3D%22middle%22%3EImage%20not%20available%3C%2Ftext%3E%3C%2Fsvg%3E';
      }
      this.calculateOffsets();
    },
    handlegroupprofileError(event) {
      if (this.profileImageLoadAttempts < this.maxLoadAttempts) {
        this.profileImageLoadAttempts++;
        event.target.src = this.defaultProfileImage;
      } else {
        event.target.src = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2Fsvg%22%20width%3D%22100%25%22%20height%3D%22100%25%22%3E%3Crect%20fill%3D%22%23dddddd%22%20width%3D%22100%25%22%20height%3D%22100%25%22%2F%3E%3Ctext%20fill%3D%22%23666666%22%20font-family%3D%22Arial%2C%20sans-serif%22%20font-size%3D%2220%22%20x%3D%2250%25%22%20y%3D%2250%25%22%20text-anchor%3D%22middle%22%20dominant-baseline%3D%22middle%22%3EProfile%20image%20not%20available%3C%2Ftext%3E%3C%2Fsvg%3E';
      }
    },
    checkUserRole() {
      axios.get(`/api/groups/${this.id}/check`)
        .then(response => {
          if (response.data.authorized) {
            this.authRole = true;
          } else {
            this.authRole = false;
          }
        })
        .catch(error => {
          console.error('Error fetching group role:', error);
          this.authRole = false;
        });
    }
  },
  mounted() {
    this.profilePhotoModalInstance = new Modal(this.$refs.profilePhotoModal, { backdrop: 'static' });
    this.coverPhotoModalInstance = new Modal(this.$refs.coverPhotoModal, { backdrop: 'static' });
    this.cover_position = this.userData.cover_position;
    if (this.id) {
      this.checkUserRole();
      this.showSkeletor = true;
    }
  },
  beforeDestroy() {
    if (this.moduleRegistered) {
      unregisterVuexModule('userProfile');
      unregisterVuexModule('userGroup');
    }
  }
}
</script>

<style>
.profile_bg_img {
    position: relative;
    height: 25vh;
}

.profile-cover-photo {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 0;
}

.cover-photo-overlay {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.3);
    cursor: ns-resize;
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

.group-privacy-divider {
    width: 5px;
    height: 5px;
    background-color: rgba(71, 72, 74);
}

@media (max-width: 991px) {
    .profile-cover-photo {
        top: 0px !important;
    }
}

@media (max-width: 767px) {
    .user-profile-wrapper {
        row-gap: 120px;
    }
}
</style>
