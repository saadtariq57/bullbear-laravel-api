<template>
  <!-- Media Post Modal -->
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="mediapostModalLabel">Upload Media</h1>
    </div>

    <div class="modal-body row">
      <!-- Left Column -->
      <div class="col-lg-8">
        <input ref="fileInput" type="file" @change="handleFileChange" multiple accept="image/gif,image/jpeg,image/jpg,image/png">
        <!-- Image Preview Area -->
        <div v-if="selectedImage" class="image-preview-container mb-3">
          <vue-cropper
            v-if="isEditing"
            ref="cropper"
            :src="selectedImage.preview"
            :view-mode="1"
            :drag-mode="'move'"
            :aspect-ratio="aspectRatio"
            :guides="true"
            :zoomable="true"
            :rotatable="true"
            :scalable="true"
            :crop-box-movable="true"
            :crop-box-resizable="true"
            @cropmove="updatePreview"
            class="w-100 img-preview"
          ></vue-cropper>
          <img v-else :src="selectedImage.preview" alt="Selected" class="img-fluid img-preview">
        </div>

        <!-- Edit and Alt Text Buttons -->
        <div v-if="selectedImage" class="d-flex justify-content-start mb-3">
          <button class="btn" @click="toggleEditing">
            <i class="bi bi-pencil-square"></i> 
          </button>
          <button class="btn" @click="toggleAltText">
            <i class="bi bi-chat-text"></i>
          </button>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-lg-4">
        <!-- Thumbnails or Editing Tools Based on State -->
        <div v-if="!isEditing && !showAltText">
            <div v-for="(file, index) in selectedFiles" :key="index" class="thumbnail mb-2 d-flex align-items-center">
              <button class="btn btn-sm" @click="moveImage(index, 'left')">&lt;</button>
              <img :src="file.preview" alt="Thumbnail" class="img-thumbnail" @click="selectImageForEdit(file)">
              <button class="btn btn-sm" @click="moveImage(index, 'right')">&gt;</button>
            </div>
            <div v-if="cannotGoBack">
              <button class="btn btn-primary" @click="additionalImageUpload">Upload More</button>
              <button class="btn btn-danger" @click="removeImage">Delete</button>
            </div>
        </div>
            
        <div v-if="isEditing" class="editing-tools">
          <!-- Aspect Ratio, Rotation, Flip, Zoom, and Apply Buttons -->
          <button class="btn btn-primary" @click="toggleEditing">{{ isEditing ? 'Cancel' : 'Edit' }}</button>
            <!-- Aspect Ratio Buttons -->
            <button class="btn" @click="setAspectRatio(1)">1:1</button>
            <button class="btn" @click="setAspectRatio(16/9)">16:9</button>
            <button class="btn" @click="setAspectRatio(4/5)">4:5</button>
            <button class="btn" @click="setAspectRatio(3/2)">3:2</button>
            <!-- Rotation and Flip Buttons -->
            <button class="btn" @click="rotateImage(45)">Rotate 45°</button>
            <button class="btn" @click="flipImage('horizontal')">Flip Horizontal</button>
            <button class="btn" @click="flipImage('vertical')">Flip Vertical</button>
            <!-- Zoom Controls -->
            <input type="range" min="0.1" max="3" step="0.1" v-model="zoomLevel" @input="zoomImage">
            <!-- Apply Button -->
            <button class="btn btn-success" @click="applyCropping">Apply</button>
        </div>

        <div v-if="showAltText" class="alt-text-input">
          <!-- Input and Apply Button for Alt Text -->
          <input type="text" class="form-control mb-2" v-model="altText" placeholder="Enter alternative text">
          <button class="btn btn-success" @click="applyAltText">Apply</button>
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-primary" @click="backToPostModal" :disabled="cannotGoBack">Back</button>
      <button type="button" class="btn btn-primary" @click="proceedToNextStep" :disabled="!selectedFiles.length">Next</button>
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
      isEditing: false
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
        multiImage: this.multiImage
      });
    },
    handleFileChange(event) {
      const files = event.target.files;
      const validTypes = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png'];

      if (files && files.length > 0) {
        const filteredFiles = Array.from(files).filter(file => validTypes.includes(file.type));

        if(filteredFiles.length > 0){
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
      if (!this.isEditing) {
        // Update the preview to the final cropped image
        this.applyCropping();
      }
    },
    setAspectRatio(ratio) {
      this.aspectRatio = ratio;
      this.$refs.cropper.setAspectRatio(ratio);
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
    },
    additionalImageUpload() {
      this.$refs.fileInput.click();
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
.img-preview {
  height: auto;
  object-fit: cover;
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
.img-thumbnail {
  max-width: 100px;
  margin-right: 10px;
  margin-bottom: 10px;
  cursor: pointer;
}
</style>