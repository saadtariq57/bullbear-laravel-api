<template>
  <div class="user-post-panel shadow rounded bg-white px-4 pt-3">
    <div class="d-flex align-items-center gap-3">
      <div>
        <a href="#">
          <img class="post-avatar img-fluid rounded-circle post-avatar-img border-2 border-primary"
            src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png?cache=0">
        </a>
      </div>
      <div class="flex-fill">
        <!-- Create Post trigger modal -->
        <button type="button" class="btn border border-secondary w-100 text-start rounded-5 p-3" data-bs-toggle="modal"
          data-bs-target="#postModal">
          <span class="fs-5">Start a post</span>
        </button>

        <!-- Single Post Modal -->
        <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <!-- Post Settings trigger button -->
                <button data-bs-toggle="modal" data-bs-target="#postSettingModal"
                  class="btn d-flex gap-3 align-items-center">
                  <img class="post-avatar img-fluid rounded-circle post-avatar-img border-2 border-primary"
                    src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png?cache=0">
                  <div>
                    <div class="d-flex gap-2 align-items-center">
                      <span class="fs-4 fw-6">Rich Tv</span>
                      <i class="bi bi-caret-down-fill"></i>
                    </div>
                    <div>Post to Anyone</div>
                  </div>
                </button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <!-- Content for create post modal -->
                <form action="" class="post-textarea">
                  <textarea v-model="textContent" rows="10" class="w-100 border-0 fs-5"
                    :style="{ 'color': textColor, 'background-image': selectedColor }"
                    placeholder="What's going on? #Hashtag.. @Mention.. Link.."></textarea>
                </form>
                <div class="d-flex justify-content-between">
                  <div class="d-flex" id="user-poster-con">
                    <abbr title="Color Posts">
                      <span class="post-icon-bg d-flex justify-content-center align-items-center"
                        v-on:click="showColor()">
                        <i class="bi bi-palette-fill fs-4"></i></span></abbr>

                  </div>
                  <div id="user-color-con" class="d-none position-relative">
                    <div class="d-flex justify-content-between align-items-center user-poster-button color-wrapper">
                      <div class="d-flex gap-2">
                        <div v-for="(style, index) in colorStyles" :key="index" class="all_colors_style"
                          :style="{ 'background-image': style }" @click="selectColor(style)"></div>
                      </div>
                      <div class="btn-close-color bg-white">
                        <button type="button" class="btn-close ms-5" aria-label="Close" v-on:click="hideColor()"></button>

                      </div>
                    </div>
                  </div>
                  <button class="btn">
                    <abbr title="Open Emoji">
                      <i class="bi bi-emoji-smile fs-4"></i></abbr>
                  </button>
                </div>
                <div class="d-flex gap-3 my-2">
                  <abbr title="Add Media">
                    <span class="post-icon-bg d-flex justify-content-center align-items-center" data-bs-toggle="modal"
                      data-bs-target="#mediapostModal">
                      <i class="bi bi-image fs-4"></i>
                    </span></abbr>
                  <abbr title="Create a Poll">
                    <span class="post-icon-bg d-flex justify-content-center align-items-center" data-bs-toggle="modal"
                      data-bs-target="#pollpostModal">
                      <i class="bi bi-bar-chart-line-fill fs-4"></i>
                    </span></abbr>
                  <abbr title="Add a Document">
                    <span class="post-icon-bg d-flex justify-content-center align-items-center" data-bs-toggle="modal"
                      data-bs-target="#decumentpostModal">
                      <i class="bi bi-file-earmark-text fs-4"></i>
                    </span></abbr>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Post Setting Modal -->
        <div class="modal fade" id="postSettingModal" tabindex="-1" aria-labelledby="postSettingModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="postSettingModalLabel">Post Settings</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <!-- Content for post setting modal -->
                <div>
                  <h3>Who can see your post?</h3>
                  <form action="">
                    <div class="form-check ps-0">
                      <div class="d-flex justify-content-between align-items-center">
                        <label class="form-check-label d-flex flex-fill gap-3 align-items-center" for="Radioanyone">
                          <span class="post-icon-bg d-flex justify-content-center align-items-center">
                            <i class="bi bi-globe-americas fs-4"></i>
                          </span>
                          <span>
                            <span class="fw-6">
                              Anyone
                            </span><br>
                            <span class="fw-4">
                              Anyone on or off LinkedIn
                            </span>
                          </span>
                        </label>
                        <input class="form-check-input" type="radio" name="postsettingRadio" id="Radioanyone" checked>
                      </div>
                    </div>
                    <div class="form-check ps-0">
                      <div class="d-flex justify-content-between align-items-center">
                        <label class="form-check-label d-flex flex-fill gap-3 align-items-center"
                          for="Radioconnectiononly">
                          <span class="post-icon-bg d-flex justify-content-center align-items-center">
                            <i class="bi bi-people-fill fs-4"></i>
                          </span>
                          <span>
                            <span class="fw-6">
                              Connection only
                            </span>
                          </span>
                        </label>
                        <input class="form-check-input" type="radio" name="postsettingRadio" id="Radioconnectiononly">
                      </div>
                    </div>
                    <!-- Select a group Button trigger modal -->

                    <div class="form-check ps-0" data-bs-toggle="modal" data-bs-target="#selectgroupModal">
                      <div class="d-flex justify-content-between align-items-center">
                        <label class="form-check-label d-flex flex-fill gap-3 align-items-center" for="Radiopostgroup">
                          <span class="post-icon-bg d-flex justify-content-center align-items-center">
                            <i class="bi bi-people-fill fs-4"></i>
                          </span>
                          <span>
                            <span class="fw-6">
                              Group
                            </span>
                          </span>
                          <span><i class="bi bi-caret-right-fill"></i></span>
                        </label>
                        <input class="form-check-input" type="radio" name="postsettingRadio" id="Radiopostgroup">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary">Back</button>
                <button type="button" class="btn btn-primary">Done</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Select a group Modal -->
        <div class="modal fade" id="selectgroupModal" tabindex="-1" aria-labelledby="selectgroupModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="selectgroupModalLabel">Select a group</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="">
                  <div class="form-check ps-0">
                    <div class="d-flex justify-content-between align-items-center">
                      <label class="form-check-label d-flex flex-fill gap-3 align-items-center" for="Radioselectgroup1">
                        <img
                          src="https://media.licdn.com/dms/image/C4D07AQFK5LmvZWWTGg/group-logo_image-shrink_72x72/0/1630999696851?e=1704816000&v=beta&t=TPFY-uolwr5tVt5f_cFzeBjMk4zscSYudwDuIJnamaA"
                          alt="" width="55">
                        <span>
                          <span class="fw-6">
                            JavaScript
                          </span><br>
                          <span class="fw-4">
                            <i class="bi bi-globe-americas fs-6"></i> Public
                          </span>
                        </span>
                      </label>
                      <input class="form-check-input" type="radio" name="selectgroupRadio" id="Radioselectgroup1" checked>
                    </div>
                  </div>
                  <div class="form-check ps-0">
                    <div class="d-flex justify-content-between align-items-center">
                      <label class="form-check-label d-flex flex-fill gap-3 align-items-center" for="Radioselectgroup2">
                        <img
                          src="https://media.licdn.com/dms/image/C4D07AQFK5LmvZWWTGg/group-logo_image-shrink_72x72/0/1630999696851?e=1704816000&v=beta&t=TPFY-uolwr5tVt5f_cFzeBjMk4zscSYudwDuIJnamaA"
                          alt="" width="55">
                        <span>
                          <span class="fw-6">
                            JavaScript
                          </span><br>
                          <span class="fw-4">
                            <i class="bi bi-globe-americas fs-6"></i> Public
                          </span>
                        </span>
                      </label>
                      <input class="form-check-input" type="radio" name="selectgroupRadio" id="Radioselectgroup2" checked>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary">Back</button>
                <button type="button" class="btn btn-primary">Save</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-around py-2">
      <!-- Media Post trigger modal -->
      <button type="button" class="btn fs-5" data-bs-toggle="modal" data-bs-target="#mediapostModal">
        <i class="bi bi-image me-2 media-icon"></i>
        <span>Media</span>
      </button>
      <!-- Media Post Modal -->
      <div class="modal fade" id="mediapostModal" tabindex="-1" aria-labelledby="mediapostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="mediapostModalLabel">Editor</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="d-flex justify-content-center h-100">
                <div class="text-center align-self-center">
                  <img src="	https://www.fzcoltd.com/wp-content/uploads/2022/11/company-registration-1024x827.jpg" alt=""
                    class="mb-3" width="200">
                  <h2>Select files to begin</h2>
                  <p>Share images or a single video in your post.</p>
                  <form action="">
                    <label class="btn btn-primary">
                      <input type="file" />
                      Upload from computer
                    </label>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Poll Post trigger modal -->
      <button type="button" class="btn fs-5" data-bs-toggle="modal" data-bs-target="#pollpostModal">
        <i class="bi bi-bar-chart-line-fill me-2"></i>
        <span>Poll</span>
      </button>
      <!-- Poll Post Modal -->
      <div class="modal fade" id="pollpostModal" tabindex="-1" aria-labelledby="pollpostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="pollpostModal">Create a poll</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="" id="myForm">

                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">Your question</label>
                  <textarea class="form-control border border-dark" id="exampleFormControlTextarea1" rows="3"
                    placeholder="E.g., How do you commute to work?"></textarea>
                </div>

                <div class="options-container">
                  <div class="mb-3 option-group">
                    <label class="form-label">Option 1</label>
                    <input type="text" class="form-control border border-dark" placeholder="E.g., Public transportation">
                  </div>
                  <div class="mb-3 option-group">
                    <label class="form-label">Option 2</label>
                    <input type="text" class="form-control border border-dark" placeholder="E.g., Drive myself">
                  </div>
                </div>
                <div class="mb-3">
                  <button type="button" id="addOptionBtn" class="btn btn-primary">Add Option</button>
                </div>
                <div class="mb-3">
                  <select class="form-select border border-dark" aria-label="Default select example">
                    <option value="1" selected>1 day</option>
                    <option value="3">3 day</option>
                    <option value="7">1 week</option>
                    <option value="14">2 week</option>
                  </select>
                </div>
              </form>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
              <button type="button" class="btn btn-primary">Done</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Document Post trigger modal -->
      <button type="button" class="btn fs-5" data-bs-toggle="modal" data-bs-target="#decumentpostModal">
        <i class="bi bi-file-earmark-text me-2"></i>
        <span>Document</span>
      </button>

      <!-- Media Post Modal -->
      <div class="modal fade" id="decumentpostModal" tabindex="-1" aria-labelledby="decumentpostModallLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="decumentpostModallLabel">Share a document</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="">
                <label class="btn btn-primary w-100">
                  <input type="file" />
                  Choose file
                </label>
              </form>
              <div class="d-flex gap-2 mt-3">
                <i class="bi bi-info-square-fill fs-5"></i>
                <p>For accessibility purposes, Rich Tv members who can view your post will be able to download your
                  document as a PDF</p>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
              <button type="button" class="btn btn-primary">Done</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      selectedColor: '',
      textContent: '',
      colorStyles: [
        'linear-gradient(45deg, #8d2de2 0%, #4a00e0 100%)',
        'linear-gradient(45deg, #ff416c 0%, #ff4b2b 100%)',
        'linear-gradient(45deg, #ffe000 0%, #799f0c 100%)',
        'linear-gradient(45deg, #011627 0%, #02223c 100%)',
        'linear-gradient(45deg, #38b000 0%, #011627 100%)',
        'linear-gradient(45deg, #38b000 0%, #38b000 100%)',
        'linear-gradient(45deg, #a8ff78 0%, #78ffd6 100%)',
        'linear-gradient(45deg, #333333 0%, #dd1818 100%)',
        'linear-gradient(45deg, #0f0c29 0%, #302b63 100%)',
        'linear-gradient(45deg, #ed4263 0%, #ffedbc 100%)'
      ]
    };
  },
  methods: {
    selectColor(style) {
      this.selectedColor = style;
    },
    showColor() {
      var x = document.getElementById("user-poster-con");
      x.classList.add("d-none");
      var y = document.getElementById("user-color-con");
      y.classList.remove("d-none");
    },
    hideColor() {
      var x = document.getElementById("user-poster-con");
      x.classList.remove("d-none");
      var y = document.getElementById("user-color-con");
      y.classList.add("d-none");
    }
  }
};

$(document).ready(function () {
  // Add Option
  $("#addOptionBtn").on("click", function () {
    var optionGroup = $(".option-group:first").clone();
    optionGroup.find("input").val(""); // Clear the input value
    optionGroup.append('<button type="button" class="deleteOptionBtn btn text-danger">Delete</button>');
    $(".options-container").append(optionGroup);
  });

  // Delete Option
  $(document).on("click", ".deleteOptionBtn", function () {
    if ($(this).closest(".option-group").index() > 1) {
      $(this).closest(".option-group").remove();
    }
  });
});

</script>
<style>
#mediapostModal .modal-dialog {
  max-width: 70%;
  height: 93vh;
}

#mediapostModal .modal-dialog .modal-content {
  height: 100%;
}

input[type="file"] {
  display: none;
}

#postModal .modal-dialog {
  max-width: 50%;
}

.post-textarea textarea {
  resize: none
}

.post-icon-bg {
  width: 55px;
  height: 55px;
  background-color: rgb(244, 242, 238);
  border-radius: 50%;
  cursor: pointer;
}

.post-icon-bg:hover {
  box-shadow:
    rgba(140, 140, 140, 0.2) 0px 0px 0px 1px,
    rgba(0, 0, 0, 0.3) 0px 4px 4px 0px;
}
</style>