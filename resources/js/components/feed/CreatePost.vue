<template>
  <form action="" class="publisher-box" onclick="feedoverlay()">
    <div class="user-post-panel shadow rounded bg-white" id="user-post-panel">
      <div class="user-post-textarea ps-2 pt-2 pe-2 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
          <div>
            <img class="post-avatar img-fluid rounded-circle post-avatar-img border-2 border-primary"
              src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png?cache=0">
          </div>
          <div class="sun_pub_name">
            <span class="fs-14 fw-5">Rich TV</span>
          </div>
        </div>
        <div>
          <i class="bi bi-emoji-smile fs-4"</i>
        </div>
      </div>
      <div class="user-post-text">
        <textarea name="" id="feed-textarea" placeholder="What's going on? #Hashtag.. @Mention.. Link.." rows="3"
          class="border-0 w-100 fs-12 fs-md-16"></textarea>
      </div>
      <div class="border-top border-bottom p-2">
        <div id="user-poster-con">
          <div class="user-poster-button d-flex align-items-center gap-3">
            <div>
              <span
                class="btn-file img d-flex justify-content-center align-items-center position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-pill">
                <i class="bi bi-image-fill fs-18"></i> Upload
                Image <input type="file" class="position-absolute border-0" id="publisher-photos" name="postPhotos[]"
                  multiple="multiple">
              </span>
            </div>
            <div>
              <span
                class=" btn-file poll-form pol d-flex justify-content-center align-items-center position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22" viewBox="0 0 24 24">
                  <path fill="#31a38c"
                    d="M17,17H15V13H17M13,17H11V7H13M9,17H7V10H9M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z">
                  </path>
                </svg> Create Poll </span>
            </div>
            <div>
              <span
                class=" btn-file vid d-flex justify-content-center align-items-center position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-pill">
                <i class="bi bi-file-earmark-richtext fs-18"></i> Upload
                file <input type="file" class="position-absolute border-0" id="publisher-video" name="postfile">
              </span>
            </div>
            <div>
              <span
                class="btn-file mor d-flex justify-content-center align-items-center position-relative gap-2 bg-light-grey fs-14 fw-4 rounded-pill"
                onclick="showColor()">
                <i class="bi bi-palette-fill fs-18"></i> Color</span>

            </div>
          </div>
        </div>
        <div id="user-color-con" class="d-none position-relative">
          <div class="d-flex justify-content-between align-items-center user-poster-button color-wrapper">
            <div class="d-flex gap-2">
              <div>
                <div class="all_colors_style">
                </div>
              </div>
              <div class="all_colors_style">
              </div>
              <div class="all_colors_style">
              </div>
              <div class="all_colors_style">
              </div>
              <div class="all_colors_style">
              </div>
              <div class="all_colors_style">
              </div>
              <div class="all_colors_style">
              </div>
              <div class="all_colors_style">
              </div>
              <div class="all_colors_style">
              </div>
              <div class="all_colors_style">
              </div>
            </div>
            <div class="btn-close-color bg-white">
              <button type="button" class="btn-close" aria-label="Close" onclick="hideColor()"></button>
            </div>
          </div>
        </div>

      </div>
      <div class="p-2 user-publisher-select-box d-flex align-items-center justify-content-between">
        <div><select id="recentFilings" name="recentFilings" class="form-select bg-white border"
            aria-label="Default select">
            <option selected>Everyone</option>
            <option value="1"> Only me</option>
            <option value="2"> My Friends</option>
            <option value="3"> Anonymous</option>

          </select></div>
        <div class="align-self-baseline">
          <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6" aria-label="share-btn">Share</a>
        </div>
      </div>
    </div>

  </form>
</template>