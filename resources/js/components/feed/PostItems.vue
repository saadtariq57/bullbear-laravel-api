<template>
  <div class="mt-3">
      <div v-for="posts in allPosts" :key="posts.id" class="post shadow mb-4 rounded-2">

          <!-- Post heading section -->
          <div class="post-wrapper">
              <div class="post-heading p-3">
                  <div class="d-flex justify-content-between">
                      <div class="user-avatar d-flex gap-2">
                          <div class="img">
                              <img :src="posts.user.avatar_url" class="rounded-circle"
                                  :alt="posts.user.name + ' profile picture'">
                          </div>
                          <div class="user-info">
                              <a href="" class="text-black fw-bold">{{ posts.user.name }}</a>
                              <div class="time">
                                  <span>{{ formatDateTime(posts.created_at) }} - Translate</span>
                              </div>
                          </div>
                      </div>
                      <!-- Post settings -->
                      <div class="post-setting">
                          <!-- Dropdown for post settings -->
                      </div>
                  </div>
              </div>

              <div class="post-description" v-if="posts.post_text">
                  <p class="px-3">{{ posts.post_text }}</p>
              </div>
              <div class="post-file" v-if="posts.post_type === 'photo'">
                  <img :src="posts.post_link_image" alt="image" class="image-file pointer img-fluid">
              </div>
              <div class="post-file" v-else-if="posts.post_type === 'video'">
                  <iframe width="100%" height="315" :src="posts.post_youtube" title="YouTube video player" frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen></iframe>
              </div>

              <!-- Like and comment counts -->
              <div class="like-comment-count d-flex justify-content-between p-3">
                  <div class="like-count"><span><i class="bi bi-hand-thumbs-up"></i> {{ posts.likes_count }}</span></div>
                  <div class="comment-count"><span><i class="bi bi-chat pe-2"></i> {{ posts.comments_count }}</span></div>
              </div>

              <!-- Interaction buttons (like, comment, share) -->
              <div class="post-reach row mb-3">
                  <div class="col-4 text-center ">
                      <span class="py-2 d-block cursor-pointer"><i class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
                  </div>
                  <div class="col-4 text-center">
                      <span class="py-2 d-block cursor-pointer"><i class="bi bi-chat pe-2"></i>Comment</span>
                  </div>
                  <div class="col-4 text-center">
                      <!-- share Button trigger modal -->
                      <span class="py-2 d-block cursor-pointer" type="button" data-bs-toggle="modal"
                          data-bs-target="#shareModal"><i class="bi bi-share pe-2"></i>Share</span>


                      <!-- share Modal -->
                      <SharePost />
                  </div>
              </div>



              <!-- Comments Section -->
              <PostComment />
          </div>
      </div>
       <!-- Poll Post Type  -->
      <div class="post shadow mb-4">
          <div class="post-wrapper">
              <div class="post-heading p-3">
                  <div class="d-flex justify-content-between align-items-center">
                      <div class="user-avatar d-flex gap-2">
                          <div class="img">
                              <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png"
                                  class="rounded-circle" width="46" height="46" alt="Rich TV profile picture">
                          </div>
                          <div class="user-info">
                              <a href="" class="text-black fw-bold">Rich TV</a>
                              <div class="time">
                                  <span>1 d - <i class="bi bi-globe-americas fs-6"></i></span>
                              </div>
                          </div>
                      </div>
                      <div class="post-setting d-flex align-items-center gap-3">
                          <div class="btn-group">
                              <button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                                  data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                  <i class="bi bi-three-dots fs-4"></i>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                  <li><button class="dropdown-item" type="button">Save Post</button></li>
                                  <li><button class="dropdown-item" type="button">Report Post</button></li>
                                  <li><button class="dropdown-item" type="button">Hide Post</button></li>
                              </ul>
                          </div>
                          <button type="button" class="btn-close" aria-label="Close"></button>
                      </div>
                  </div>
              </div>
              <div class="post-description">
                  <p class="px-3">Which of the following are you most familiar with</p>
                  <div class="container-fluid px-5">
                      <div class="container shadow border border-light-grey py-4">
                          <h5>Are you currently seeking new opportunity?</h5>
                          <span class="text-secondary fw-5 fs-12">The author can see how you vote. <a href="#" target="_blank" class="astronaut-blue fw-6 fs-6">Learn more</a></span>
                          <div class="py-4" id="poll-options">
                          <button @click="handleButtonClick()" class="w-100 btn rounded-5 mb-2 border-btn border-2 fw-6">Yes</button>
                          <button @click="handleButtonClick()" class="w-100 btn rounded-5 mb-2 border-btn border-2 fw-6">No</button>
                      </div>
                      <div class="progress-bar-container py-4">
              <div class="option-bar mb-2">
                  
                  <div class="progress bg-transparent position-relative poll-prograss-bar">
                      <div class="progress-bar bg-poll-prograss" style="width: 60%" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                      <div class="option-text position-absolute fs-6 fw-6">
                         <div class="d-flex justify-content-between">
                          <span>Yes</span>
                          <span>60%</span>
                         </div>
                       </div>
                  </div>
              </div>

              <div class="option-bar mb-2">
                  <div class="progress bg-transparent position-relative poll-prograss-bar">
                      <div class="progress-bar bg-poll-prograss" style="width: 40%" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                  <div class="option-text position-absolute fs-6 fw-6">
                      <div class="d-flex justify-content-between">
                          <span>No</span>
                          <span>40%</span>
                         </div>
                  </div>
                  </div>
                  
              </div>
          </div>
                      <div class="text-secondary">
                          <span>35</span> votes - <span>2w</span> left
                      </div>
                      </div>
                  </div>
                  <div class="like-comment-count d-flex justify-content-between p-3">
                      <div class="like-count d-flex gap-2"><span><i class="bi bi-hand-thumbs-up"></i></span><span>3</span></div>
                      <div class="comment-count d-flex gap-2"><span>3</span><span>comments</span></div>
                  </div>
                  <div class="post-reach row mb-3">
                      <div class="col-4 text-center ">
                          <span class="py-2 d-block cursor-pointer"><i class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
                      </div>
                      <div class="col-4 text-center">
                          <span class="py-2 d-block cursor-pointer"><i class="bi bi-chat pe-2"></i>Comment</span>
                      </div>
                      <div class="col-4 text-center">
                          <span class="py-2 d-block cursor-pointer" type="button" data-bs-toggle="modal"
                              data-bs-target="#shareModal"><i class="bi bi-share pe-2"></i>Share</span>


                          <!-- share Modal -->
                          <SharePost />
                      </div>
                  </div>
                  <!-- Comments Section -->
                  <PostComment />
              </div>
          </div>
      </div>
       <!-- Video Post Type  -->
      <div class="post shadow mb-4">
          <div class="post-wrapper">
              <div class="post-heading p-3">
                  <div class="d-flex justify-content-between align-items-center">
                      <div class="user-avatar d-flex gap-2">
                          <div class="img">
                              <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png"
                                  class="rounded-circle" width="46" height="46" alt="Rich TV profile picture">
                          </div>
                          <div class="user-info">
                              <a href="" class="text-black fw-bold">Rich TV</a>
                              <div class="time">
                                  <span>1 d - <i class="bi bi-globe-americas fs-6"></i></span>
                              </div>
                          </div>
                      </div>
                      <div class="post-setting d-flex align-items-center gap-3">
                          <div class="btn-group">
                              <button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                                  data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                  <i class="bi bi-three-dots fs-4"></i>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                  <li><button class="dropdown-item" type="button">Save Post</button></li>
                                  <li><button class="dropdown-item" type="button">Report Post</button></li>
                                  <li><button class="dropdown-item" type="button">Hide Post</button></li>
                              </ul>
                          </div>
                          <button type="button" class="btn-close" aria-label="Close"></button>
                      </div>
                  </div>
              </div>
              <div class="post-description">
                  <p class="px-3">After-hours Gainers</p>
                  <div class="post-file">
                      <iframe width="100%" height="315"
                          src="https://www.youtube.com/embed/Sf2vgLNheUQ?si=EHa3GgvLP5YcrK30" title="YouTube video player"
                          frameborder="0"
                          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                          allowfullscreen></iframe>
                  </div>
                  <div class="like-comment-count d-flex     justify-content-between p-3">
                      <div class="like-count d-flex gap-2"><span><i class="bi bi-hand-thumbs-up"></i></span><span>3</span></div>
                      <div class="comment-count d-flex gap-2"><span>3</span><span>comments</span></div>
                  </div>
                  <div class="post-reach row mb-3">
                      <div class="col-4 text-center ">
                          <span class="py-2 d-block cursor-pointer"><i class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
                      </div>
                      <div class="col-4 text-center">
                          <span class="py-2 d-block cursor-pointer"><i class="bi bi-chat pe-2"></i>Comment</span>
                      </div>
                      <div class="col-4 text-center">
                          <span class="py-2 d-block cursor-pointer" type="button" data-bs-toggle="modal"
                              data-bs-target="#shareModal"><i class="bi bi-share pe-2"></i>Share</span>


                          <!-- share Modal -->
                          <SharePost />
                      </div>
                  </div>
                  <!-- Comments Section -->
                  <PostComment />
              </div>
          </div>
      </div>
       <!-- Image Post Type  -->

      <div class="post shadow mb-4">
          <div class="post-wrapper">
              <div class="post-heading p-3">
                  <div class="d-flex justify-content-between align-items-center">
                      <div class="user-avatar d-flex gap-2">
                          <div class="img">
                              <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2022/08/fKtTdh1OZpNVIqDZEPTY_22_3202a52699526cbda398b939872fc17e_avatar.png"
                                  class="rounded-circle" width="46" height="46" alt="Rich TV profile picture">
                          </div>
                          <div class="user-info">
                              <a href="" class="text-black fw-bold">Rich TV</a>
                              <div class="time">
                                  <span>1 d - <i class="bi bi-globe-americas fs-6"></i></span>
                              </div>
                          </div>
                      </div>
                      <div class="post-setting d-flex align-items-center gap-3">
                          <div class="btn-group">
                              <button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                                  data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                  <i class="bi bi-three-dots fs-4"></i>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                  <li><button class="dropdown-item" type="button">Save Post</button></li>
                                  <li><button class="dropdown-item" type="button">Report Post</button></li>
                                  <li><button class="dropdown-item" type="button">Hide Post</button></li>
                              </ul>
                          </div>
                          <button type="button" class="btn-close" aria-label="Close"></button>
                      </div>
                  </div>
              </div>
              <div class="post-description">
                  <p class="px-3">After-hours Gainers</p>
                  <div class="post-file">
                      <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/10/HxxaZjP9YL6tdswHK68t_29_59820aa89bbd25215a0f4b04549fcde7_image.jpg"
                          alt="image" class="img-fluid">
                  </div>
                  <div class="like-comment-count d-flex     justify-content-between p-3">
                      <div class="like-count d-flex gap-2"><span><i class="bi bi-hand-thumbs-up"></i></span><span>3</span></div>
                      <div class="comment-count d-flex gap-2"><span>3</span><span>comments</span></div>
                  </div>
                  <div class="post-reach row mb-3">
                      <div class="col-4 text-center ">
                          <span class="py-2 d-block cursor-pointer"><i class="bi bi-hand-thumbs-up pe-2"></i>Like</span>
                      </div>
                      <div class="col-4 text-center">
                          <span class="py-2 d-block cursor-pointer"><i class="bi bi-chat pe-2"></i>Comment</span>
                      </div>
                      <div class="col-4 text-center">
                          <span class="py-2 d-block cursor-pointer" type="button" data-bs-toggle="modal"
                              data-bs-target="#shareModal"><i class="bi bi-share pe-2"></i>Share</span>


                          <!-- share Modal -->
                          <SharePost />
                      </div>
                  </div>
                  <!-- Comments Section -->
                  <PostComment />
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import axios from "axios";
import SharePost from "./SharePost.vue";
import PostComment from './PostComment.vue';
export default {
  components: {
      PostComment,
      SharePost

  },
  data() {
      return {
          allPosts: [], // Stores all posts
          csrfToken: '', // CSRF token for API requests
          progressBarVisible: false,
      };
  },
  methods: {
      // Fetch all posts of the user
      async fetchUserPosts() {
          try {
              const response = await axios.get('/api/userposts/all', {
                  headers: {
                      'X-CSRF-TOKEN': this.csrfToken,
                      'Accept': 'application/json'
                  },
                  withCredentials: true,
              });

              this.allPosts = response.data;
          } catch (error) {
              console.error('Error fetching posts:', error);
              // Handle the error appropriately
          }
      },

      // Method to format the date/time (optional, implement as needed)
      formatDateTime(dateTime) {
          // Implement your date/time formatting logic here
          return dateTime;
      },
      handleButtonClick() {

    // Show the progress-bar-container
    $('#poll-options').hide();
    $('.progress-bar-container').show();
  },
  },
  mounted() {
      // Get the CSRF token from the meta tag
      this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      // Fetch posts when the component is mounted
      this.fetchUserPosts();
      $('.progress-bar-container').hide();
  }
};

</script>