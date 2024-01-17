<template>
  <!-- Media Post Modal -->
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="mediapostModalLabel">Upload Media</h1>
    </div>

    <div class="modal-body">
      <div class="d-flex align-items-center justify-content-center modal-row" v-if="!uploadimageSelected">
        <div class="text-center">
          <img src="https://www.fzcoltd.com/wp-content/uploads/2022/11/company-registration-1024x827.jpg" alt=""
            class="mb-3" width="200">
          <h2>Select files to begin</h2>
          <p>Share images or a single video in your post.</p>

          <label class="btn btn-primary">
            <input ref="fileInput" type="file" @change="handleFileChange" multiple
              accept="image/gif,image/jpeg,image/jpg,image/png" class="upload-media-post">
            Upload from computer
          </label>
        </div>
      </div>
      <div class="row modal-row gy-4" v-if="uploadimageSelected">
        <!-- Left Column -->
        <div class="col-lg-8">
          <!-- Image Preview Area -->
          <div v-if="selectedImage"
            class="image-preview-container mb-3 d-flex align-items-center justify-content-center modal-row">
            <vue-cropper v-if="isEditing" ref="cropper" :src="selectedImage.preview" :view-mode="1" :drag-mode="'move'"
              :aspect-ratio="aspectRatio" :guides="true" :zoomable="true" :rotatable="true" :scalable="true"
              :crop-box-movable="true" :crop-box-resizable="true" @cropmove="updatePreview"
              class="w-100 img-preview"></vue-cropper>
            <img v-else :src="selectedImage.preview" alt="Selected" class="img-fluid img-preview">
          </div>

          <!-- Edit and Alt Text Buttons -->
          <div v-if="selectedImage" class="d-flex justify-content-center gap-3">
            <button class="btn icons-hover d-flex justify-content-center align-items-center" @click="toggleEditing">
              <i class="bi bi-pencil fs-4 text-secondary icon-bold"></i>
            </button>
            <button class="btn icons-hover d-flex justify-content-center align-items-center" @click="toggleAltText">
              <span class="text-secondary fw-bold fs-6">ALT</span>
            </button>
          </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
          <!-- Thumbnails or Editing Tools Based on State -->
          <div v-if="!mutipleimagesSelected">
            <button class="btn icons-hover" @click="backtoEditing"><i class="bi bi-arrow-left fs-5"></i></button>
            <div class="d-flex align-items-center justify-content-center modal-row">
              <div class="text-center">
                <img src="https://www.fzcoltd.com/wp-content/uploads/2022/11/company-registration-1024x827.jpg" alt=""
                  class="mb-3" width="200">
                <h2>Select files to begin</h2>
                <p>Share images or a single video in your post.</p>

                <label class="btn btn-primary">
                  <input ref="fileInput" type="file" @change="handleFileChange" multiple
                    accept="image/gif,image/jpeg,image/jpg,image/png" class="upload-media-post">
                  Upload from computer
                </label>
              </div>
            </div>
          </div>
          <div v-if="!isEditing && !showAltText && mutipleimagesSelected"
            class="d-flex justify-content-between align-items-center flex-column modal-row">
            <div class="thumbnail-wrapper d-flex flex-wrap justify-content-center gap-4 position-relative">
              <div v-for="(file, index) in selectedFiles" :key="index" class="thumbnail position-relative">
                <button class="btn btn-sm btn-left-index btn-index-arrows position-absolute"
                  @click="moveImage(index, 'left')">&lt;</button>
                <img :src="file.preview" alt="Thumbnail" class="img-thumbnail" @click="selectImageForEdit(file)">
                <button class="btn btn-sm btn-right-index btn-index-arrows position-absolute"
                  @click="moveImage(index, 'right')">&gt;</button>
              </div>
            </div>
            <div v-if="cannotGoBack" class="align-self-center mt-4">
              <button class="btn icons-hover btn icons-hover d-inline-flex justify-content-center align-items-center me-3"
                @click="additionalImageUpload"><i class="bi bi-plus-circle fs-4"></i></button>
              <button class="btn icons-hover btn icons-hover d-inline-flex justify-content-center align-items-center"
                @click="removeImage"><i class="bi bi-trash fs-4"></i></button>
            </div>
          </div>

          <div v-if="isEditing" class="editing-tools">
            <!-- Aspect Ratio, Rotation, Flip, Zoom, and Apply Buttons -->
            <button class="btn icons-hover d-block mb-4" @click="toggleEditing">
              <span v-if="isEditing"><i class="bi bi-arrow-left fs-4"></i></span>
              <span v-else>Edit</span>
            </button>
            <div class="crop-setting mb-4">
              <!-- Rotation and Flip Buttons -->
              <span class="d-block mb-3">Crop</span>
              <div class="d-flex justify-content-around">
                <button class="btn icons-hover" @click="rotateImage(45)"><i
                    class="bi bi-arrow-clockwise fs-4"></i></button>
                <button class="btn icons-hover rotate-80 " @click="flipImage('horizontal')"><i
                    class="bi bi-hourglass-top fs-4"></i></button>
                <button class="btn icons-hover" @click="flipImage('vertical')"><i
                    class="bi bi-hourglass-top fs-4"></i></button>
              </div>

            </div>

            <!-- Aspect Ratio Buttons -->
            <div class="ratios  mb-4">
              <span class="d-block mb-3">Aspect Ratio</span>
              <div class="d-flex flex-wrap gap-3">
                <button class="btn rounded-5 border-btn px-4" @click="setAspectRatio(null)">Original Size</button>
                <button class="btn rounded-5 border-btn px-4" @click="setAspectRatio('square')">Square</button>
                <button class="btn rounded-5 border-btn px-4" @click="setAspectRatio(1)">1:1</button>
                <button class="btn rounded-5 border-btn px-4" @click="setAspectRatio(3 / 2)">3:2</button>
                <button class="btn rounded-5 border-btn px-4" @click="setAspectRatio(4 / 5)">4:5</button>
                <button class="btn rounded-5 border-btn px-4" @click="setAspectRatio(16 / 9)">16:9</button>
              </div>
            </div>


            <!-- Zoom Controls -->
            <div class=" my-4">
              <span class="d-block mb-1">Zoom</span>
              <input type="range" class="w-100" min="0.1" max="3" step="0.1" v-model="zoomLevel" @input="zoomImage">
            </div>

            <!-- Apply Button -->
            <button class="btn btn-primary w-100 my-3" @click="applyCropping">Apply</button>
          </div>

          <div v-if="showAltText" class="alt-text-input">
            <!-- Input and Apply Button for Alt Text -->
            <span>Alt text describes images for people who can’t see them. <br><br>There may be an automatically generated
              description. You can edit it anytime.</span>
            <input type="text" class="form-control my-4 border-1 border border-dark p-3 rounded-2" v-model="altText"
              placeholder="How Would You Discribe This Image">

            <button class="btn btn-primary w-100" @click="applyAltText">Apply</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn rounded-2 border-btn px-4" @click="backToPostModal"
        :disabled="cannotGoBack">Back</button>
      <button type="button" class="btn btn-primary" @click="proceedToNextStep"
        :disabled="!selectedFiles.length">Next</button>
    </div>
  </div>
</template>

<script>
import VueCropper from 'vue-cropperjs';
import 'cropperjs/dist/cropper.css';

export default {
  components: {
    VueCropper
  },
  emits: ['mediaUploaded', 'backFromUpload'],
  data() {
    return {
      selectedFiles: [],
      selectedImage: null,
      showAltText: false,
      altText: "",
      isEditing: false,
      uploadimageSelected: false,
      mutipleimagesSelected: true,
      aspectRatio: null,
    };
  },
  computed: {
    multiImage() {
      return this.selectedFiles.length > 1;
    },
    cannotGoBack() {
      return this.selectedFiles.length > 0;
    }
  },
  methods: {
    backToPostModal() {
      this.resetState();
      this.$emit('backFromUpload');
    },
    proceedToNextStep() {
      this.$emit('mediaUploaded', {
        files: this.selectedFiles,
        multiImage: this.multiImage,
      });
      const textarea = document.getElementById('textarea-modalpost');
      if (textarea) {
        textarea.style.height = '100px';
      }
      this.uploadimageSelected = true;
    },
    handleFileChange(event) {
      const files = event.target.files;
      const validTypes = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png'];
      this.uploadimageSelected = true;
      this.mutipleimagesSelected = true;
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
    moveImage(index, direction) {
      if (direction === 'left' && index > 0) {
        [this.selectedFiles[index - 1], this.selectedFiles[index]] = [this.selectedFiles[index], this.selectedFiles[index - 1]];
      } else if (direction === 'right' && index < this.selectedFiles.length - 1) {
        [this.selectedFiles[index + 1], this.selectedFiles[index]] = [this.selectedFiles[index], this.selectedFiles[index + 1]];
      }
    },
    selectImageForEdit(file) {
      this.selectedImage = file;
      this.isEditing = false;
      this.altText = file.alt || "";
    },
    toggleAltText() {
      this.showAltText = !this.showAltText;
      this.isEditing = false;
      this.mutipleimagesSelected = true;
    },
    applyAltText() {
      if (this.selectedImage) {
        const fileIndex = this.selectedFiles.findIndex(file => file === this.selectedImage);
        if (fileIndex !== -1) {
          this.selectedFiles[fileIndex].alt = this.altText;
        }
      }
      this.showAltText = false;
    },
    toggleEditing() {
      this.isEditing = !this.isEditing;
      this.showAltText= false;
      this.mutipleimagesSelected = true;
      if (!this.isEditing) {
        // Update the preview to the final cropped image
        this.applyCropping();
      }
    },
    setAspectRatio(ratio) {
      // this.aspectRatio = ratio;
      // this.$refs.cropper.setAspectRatio(ratio);
      if (ratio === 'square') {
        this.aspectRatio = 1;
      } else {
        this.aspectRatio = ratio;
      }
      this.$refs.cropper.setAspectRatio(this.aspectRatio);
    },
    rotateImage(degrees) {
      this.$refs.cropper.rotate(degrees);
    },
    flipImage(direction) {
      if (direction === 'horizontal') {
        this.$refs.cropper.scaleX(-1);
      } else {
        this.$refs.cropper.scaleY(-1);
      }
    },
    zoomImage() {
      this.$refs.cropper.zoomTo(this.zoomLevel);
    },
    updatePreview() {
      // Update the preview in real-time
      if (this.isEditing) {
        const croppedData = this.$refs.cropper.getCroppedCanvas().toDataURL();
        this.selectedImage.preview = croppedData;
      }
    },
    applyCropping() {
      if (this.isEditing && this.$refs.cropper) {
        const croppedData = this.$refs.cropper.getCroppedCanvas().toDataURL();
        this.selectedImage.preview = croppedData;
        this.isEditing = false;
      }
    },
    removeImage(index) {
      this.selectedFiles.splice(index, 1);
      this.selectedImage = this.selectedFiles.length > 0 ? this.selectedFiles[0] : null;
      
      // Check if there are selectedFiles
    if (this.selectedImage != null) {
        this.isEditing = false;
        this.showAltText = false;
        this.uploadimageSelected = true;
    } else {
        this.uploadimageSelected = false;
        this.mutipleimagesSelected = true;
    }
      
    },
    additionalImageUpload() {
      this.mutipleimagesSelected = false;
      setTimeout(() => {
        this.$refs.fileInput.click();
      }, 200);
    },
    backtoEditing() {
      this.mutipleimagesSelected = true;
    },
    resetState() {
      if (!this.cannotGoBack) {
        this.selectedFiles = [];
        this.selectedImage = null;
        this.isEditing = false;
      }
    },
    resetStateParent() {
      this.selectedFiles = [];
      this.selectedImage = null;
      this.isEditing = false;
    },
  }
};
</script>
<style>
.modal-row {
  min-height: 65vh;
}

.img-preview {
  max-height: 500px;
  object-fit: contain;
}

.image-collage {
  display: flex;
  flex-direction: column;
}

.selected-image {
  max-width: 100%;
  cursor: pointer;
  margin-bottom: 10px;
}

.thumbnail-wrapper {
  height: 500px;
  overflow-y: auto;
  overflow-x: hidden;
}

.thumbnail {
  height: 200px;
  width: 46%;
}

.img-thumbnail {
  /* max-width: 100px; */
  margin-right: 10px;
  margin-bottom: 10px;
  cursor: pointer;
  object-fit: contain;
  width: 100%;
  height: 100%;
  border: 2px solid var(--astronaut-blue)
}

.btn-left-index {
  left: 5px;
}

.btn-right-index {
  right: 5px;
}

.btn-index-arrows {
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(0, 0, 0, 0.6);
  color: var(--white);
  font-size: 20px;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  appearance: none;
}

.btn-index-arrows:hover {
  background-color: rgba(0, 0, 0, 0.39);
  color: var(--white);
}

.rotate-80 {
  transform: rotate(88deg);
}
</style>