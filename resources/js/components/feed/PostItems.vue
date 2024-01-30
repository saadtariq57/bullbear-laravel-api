<template>
  <div class="mt-3">
    <div v-if="allPosts.length > 0">
      <div v-for="post in       allPosts      " :key="post.id" class="post shadow mb-4 rounded-2">
        <!-- Post heading section -->
        <div class="post-wrapper">
          <div class="post-heading p-3">
            <div class="d-flex justify-content-between">
              <div class="user-avatar d-flex gap-2">
                <div class="img">
                  <img :src="`/${post.user.avatar}`" class="rounded-circle" :alt="post.user.name + ' profile picture'">
                </div>
                <div class="user-info">
                  <a href="" class="text-black fw-bold">{{ post.user.name }}</a>
                  <div class="time">
                    <span>{{ formatDateTime(post.created_at) }}</span>
                  </div>
                </div>
              </div>
              <!-- Post settings -->
              <!-- Include Post Settings Dropdown Here -->
            </div>
          </div>

          <!-- Post Content -->
          <div v-if="post.post_text" class="post-description px-3">
            <div v-if="post.colored_post_id" class="colored-post-text d-flex justify-content-center align-items-center">
              <p>{{ post.post_text }}</p>
            </div>
            <p v-else>{{ post.post_text }}</p>
          </div>

          <!-- Post Media -->
          <div v-if="post.post_type === 'photo'" class="post-file">
            <div v-if="post.multi_image > 0" class="d-flex flex-wrap row-gap-3 justify-content-between px-3">
              <div v-for="(photo, index) in  post.photos " :key="photo.id"
                class="multi-post-img-wrapper text-center btn p-0" data-bs-toggle="modal" data-bs-target="#postPreview">
                <div v-if="post.photos.length > 4" class="position-relative multi-post-img">
                  <img :src="`/${photo.image}`" alt="Post image" class="img-fluid object-fit-cover multi-post-img">
                  <div v-if="index === 3" class="overlay-post-gallery d-flex justify-content-center align-items-center">
                    <span class="text-white fs-2 fw-6">+{{ post.photos.length - 4 }}</span>
                  </div>
                </div>
                <div v-else-if="post.photos.length === 3" class="multi-post-img">
                  <img :src="`/${photo.image}`" alt="Post image" class="img-fluid object-fit-cover multi-post-img"
                    :class="{ 'w-100': index === 2 }">
                </div>
                <div v-else>
                  <img :src="`/${photo.image}`" alt="Post image" class="img-fluid object-fit-cover multi-post-img">
                </div>
                <!-- Post Preview Modal Start -->
                <div class="modal fade" id="postPreview" tabindex="-1" aria-labelledby="postPreviewLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mx-auto">
                    <div class="modal-content">
                      <div class="row">
                        <div class="col-xl-8 col-md-6">
                          <div class="modal-header">
                            <img :src="`/${photo.image}`" alt="Post image" class="img-fluid">
                          </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                          <div class="modal-body ps-0 pb-0 border-0">
                            <div class="post-preview-scroll">
                              <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-between">
                                  <div class="user-avatar d-flex gap-2">
                                    <div class="img">
                                      <img :src="`/${post.user.avatar}`" class="rounded-circle"
                                        :alt="post.user.name + ' profile picture'">
                                    </div>
                                    <div class="user-info">
                                      <a href="" class="text-black d-inline-block text-start fw-bold modal-username">{{
                                        post.user.name
                                      }}</a>
                                      <div class="time">
                                        <span>{{ formatDateTime(post.created_at) }}</span>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- Post settings -->
                                  <!-- Include Post Settings Dropdown Here -->
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                  aria-label="Close"></button>
                              </div>
                              <div>
                                <div class="post description pt-3 ">
                                  <p class="text-start">{{ post.post_text }}</p>
                                </div>
                                <div class="like-comment-count d-flex justify-content-between p-3 align-items-center">
                                  <div class="like-count">
                                    <!-- Reaction Post trigger modal -->
                                    <div class="reaction-icons">
                                      <span v-for="( reaction, index ) in  post.reactions.slice(0, 3) "
                                        :key="reaction.id">
                                        <button class="btn"><img :src="`/${reaction.reaction_type.icon}`"
                                            class="reaction-icon me-sm-2 me-1"><span> {{
                                              post.reactions_count
                                            }}</span></button>
                                      </span>
                                      <span v-if="post.reactions.length > 3">+{{ post.reactions_count }}</span>

                                    </div>
                                  </div>
                                  <div class="comment-count">
                                    <button @click="toggleComments(post.id)" class="btn btn-feed-hover border-0">
                                      <i class="bi bi-chat pe-sm-2 pe-1"></i> {{ post.comments_count }} comments
                                    </button>
                                  </div>
                                </div>
                                <div class="row post-reach pb-2 px-sm-4">
                                  <button type="button"
                                    class="btn fs-6 px-1 btn-feed-hover border-0 position-relative col-4"
                                    @mouseover="onReactionHover(post.id)" @mouseleave="hideReactionsForPost(post.id)"
                                    @click="handleDefaultReaction(post.id)"><i v-if="!userReactions[post.id]"
                                      class="bi bi-hand-thumbs-up pe-sm-2 pe-1"></i>
                                    <i v-else :class="getReactionName(userReactions[post.id])"></i>
                                    <span :class="getReactionName(userReactions[post.id])">
                                      {{ userReactions[post.id] ? getReactionName(userReactions[post.id]) : 'Like' }}
                                    </span>
                                    <div v-if="showReactionsForPost[post.id]"
                                      class="reaction-icons-wrapper position-absolute d-flex gap-1">
                                      <span v-for=" reactionType  in  reactionTypes " :key="reactionType.id"
                                        @click.stop="addOrUpdateReaction(post.id, 'post_id', reactionType.id)">
                                        <img :src="`/${reactionType.icon}`" class="reaction-icons-img">
                                      </span>
                                    </div>
                                  </button>
                                  <button type="button" class="btn fs-6 px-1 btn-feed-hover border-0 col-4"
                                    @click="toggleComments(post.id)"><i
                                      class="bi bi-chat pe-sm-2 pe-1"></i><span>Comment</span></button>
                                  <button type="button" class="btn fs-6 px-1 btn-feed-hover border-0 col-4"
                                    @click="sharePost"><i class="bi bi-share pe-sm-2 pe-1"></i><span>Share</span></button>
                                </div>
                                <PostComment v-if="fetchedCommentsFlags[post.id]" :userId="userData.id" :postId="post.id"
                                  :fetchedCommentsFlags="fetchedCommentsFlags" :userAvatar="userData.avatar"
                                  @fetch-comments="handleFetchComments" />
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div v-else class="text-center">
              <div v-for=" photo  in   post.photos  " :key="photo.id" class="btn p-0" data-bs-toggle="modal"
                data-bs-target="#postPreview">
                <img :src="`/${photo.image}`" alt="Post image" class="img-fluid">
              </div>
            </div>
          </div>
          <!-- Poll Content -->
          <div v-if="post.post_type === 'poll' && post.poll" class="post-poll">
            <div class="container-fluid px-sm-5">
              <div class="container shadow border border-light-grey py-4">
                <h5>{{ post.poll.text }}</h5>
                <span class="text-secondary fw-5 fs-12">The author can see how you vote. <a href="#" target="_blank"
                    class="astronaut-blue fw-6 fs-6">Learn more</a></span>
                <div class="py-4">
                  <div v-for="option in post.poll.options" :key="option.id" class="mb-2">
                    <button class="w-100 btn rounded-5 border-btn border-2 fw-6">{{ option.option_text }}</button>
                  </div>
                  <div class="text-secondary">
                    <span>35</span> votes - <span>2w</span> left
                  </div>
                </div>
                <!-- Progress bars and other poll details can be added here -->
              </div>
            </div>
          </div>
          <!-- link Media -->
          <div v-if="post.post_type === 'link'" class="link-file">
            <a :href="post.post_link" target="_blank">
              <img :src="post.post_link_image" alt="Post image" class="img-fluid w-100">
              <div class="link-post-details px-3 pt-3">
                <h3 class="link-title fs-5">{{ post.post_link_title }}</h3>
                <span class="Blue fs-12">{{ post.post_link }}</span>
              </div>
            </a>
          </div>
          <!-- Interaction buttons and Like/Comment counts -->
          <div class="like-comment-count d-flex justify-content-between p-3 align-items-center">
            <div class="like-count">
              <!-- Reaction Post trigger modal -->
              <div class="reaction-icons">
                <span v-for="(  reaction, index  ) in    post.reactions.slice(0, 3)   " :key="reaction.id">
                  <button class="btn" data-bs-toggle="modal" data-bs-target="#reactionPostModal"><img
                      :src="`/${reaction.reaction_type.icon}`" class="reaction-icon me-sm-2 me-1"><span> {{
                        post.reactions_count
                      }}</span></button>
                </span>
                <span v-if="post.reactions.length > 3">+{{ post.reactions_count }}</span>
                <!-- Reaction Post Modal Start -->
                <div class="modal fade" id="reactionPostModal" tabindex="-1" aria-labelledby="reactionPostModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header pb-0 border-0">
                        <h1 class="modal-title fs-5" id="reactionPostModalLabel">Reactions</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="mt-2 reactions-post-wrapper mx-3">
                        <ul class="nav border-0 nav-tabs gap-1 flex-nowrap" id="reactions-post-Followers-tab"
                          role="tablist">
                          <li class="nav-item" role="presentation">
                            <button
                              class="nav-link border-0 fs-6 text-black px-2 py-2 d-flex btn-feed-hover reactions-post-nav-btn text-nowrap active"
                              id="allreactions-tab" data-bs-toggle="tab" data-bs-target="#allreactions-tab-pane"
                              type="button" role="tab" aria-controls="allreactions-tab-pane" aria-selected="false"><span
                                class="me-1">All</span><span>6</span></button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button
                              class="nav-link border-0 fs-6 text-black px-2 py-2 d-flex btn-feed-hover reactions-post-nav-btn text-nowrap"
                              id="likereactions-tab" data-bs-toggle="tab" data-bs-target="#likereactions-tab-pane"
                              type="button" role="tab" aria-controls="likereactions-tab-pane" aria-selected="false"><img
                                src="/upload/icons/like.png" alt="" width="18px" class="me-1"><span>1</span></button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button
                              class="nav-link border-0 fs-6 text-black px-2 py-2 d-flex btn-feed-hover reactions-post-nav-btn text-nowrap"
                              id="lovereactions-tab" data-bs-toggle="tab" data-bs-target="#lovereactions-tab-pane"
                              type="button" role="tab" aria-controls="lovereactions-tab-pane" aria-selected="false"><img
                                src="/upload/icons/love.png" alt="" width="18px" class="me-1"><span>1</span></button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button
                              class="nav-link border-0 fs-6 text-black px-2 py-2 d-flex btn-feed-hover reactions-post-nav-btn text-nowrap"
                              id="hahareactions-tab" data-bs-toggle="tab" data-bs-target="#hahareactions-tab-pane"
                              type="button" role="tab" aria-controls="hahareactions-tab-pane" aria-selected="false"><img
                                src="/upload/icons/haha.png" alt="" width="18px" class="me-1"><span>1</span></button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button
                              class="nav-link border-0 fs-6 text-black px-2 py- d-flex btn-feed-hover reactions-post-nav-btn text-nowrap"
                              id="wowreactions-tab" data-bs-toggle="tab" data-bs-target="#wowreactions-tab-pane"
                              type="button" role="tab" aria-controls="wowreactions-tab-pane" aria-selected="false"><img
                                src="/upload/icons/wow.png" alt="" width="18px" class="me-1"><span>1</span></button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button
                              class="nav-link border-0 fs-6 text-black px-2 py- d-flex btn-feed-hover reactions-post-nav-btn text-nowrap"
                              id="sadreactions-tab" data-bs-toggle="tab" data-bs-target="#sadreactions-tab-pane"
                              type="button" role="tab" aria-controls="sadreactions-tab-pane" aria-selected="false"><img
                                src="/upload/icons/sad.png" alt="" width="18px" class="me-1"><span>1</span></button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button
                              class="nav-link border-0 fs-6 text-black px-2 py-2  d-flex btn-feed-hover reactions-post-nav-btn text-nowrap"
                              id="angryreactions-tab" data-bs-toggle="tab" data-bs-target="#angryreactions-tab-pane"
                              type="button" role="tab" aria-controls="angryreactions-tab-pane" aria-selected="false"><img
                                src="/upload/icons/angry.png" alt="" width="18px" class="me-1"><span>1</span></button>
                          </li>
                        </ul>
                      </div>
                      <div class="modal-body">

                        <div class="list-group">
                          <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="allreactions-tab-pane" role="tabpanel"
                              aria-labelledby="allreactions-tab" tabindex="0">
                              <a href="#"
                                class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0">
                                <div>
                                  <div class="position-relative">
                                    <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="40" height="40">
                                    <span class="user-reaction position-absolute bg-white rounded-5">
                                      <img src="/upload/icons/angry.png" alt="" width="15px" height="15px">
                                    </span>
                                  </div>
                                </div>
                                <div class="flex-fill border-bottom py-3">
                                  <h6 class=" fs-6 fw-6 clr-primary user-name">Anthony J James</h6>
                                  <p class="mb-0 fs-12 text-wrap lh-base">CEO | Innovation | Technology | Global
                                    Commercialization | Growth @ Trinity Consulting
                                  </p>

                                </div>
                              </a>
                              <a href="#"
                                class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0">
                                <div>
                                  <div class="position-relative"><img src="/build/images/brands/cryptocurrency_btc.png"
                                      alt="" width="40" height="40"></div>
                                </div>
                                <div class="flex-fill border-bottom py-3">
                                  <h6 class=" fs-6 fw-6 clr-primary user-name">Anthony J James</h6>
                                  <p class="mb-0 fs-12 text-wrap lh-base">CEO | Innovation | Technology | Global
                                    Commercialization | Growth @ Trinity Consulting
                                  </p>

                                </div>
                              </a>
                              <a href="#"
                                class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0">
                                <div>
                                  <div class="position-relative"><img src="/build/images/brands/cryptocurrency_btc.png"
                                      alt="" width="40" height="40"></div>
                                </div>
                                <div class="flex-fill border-bottom py-3">
                                  <h6 class=" fs-6 fw-6 clr-primary user-name">Anthony J James</h6>
                                  <p class="mb-0 fs-12 text-wrap lh-base">CEO | Innovation | Technology | Global
                                    Commercialization | Growth @ Trinity Consulting
                                  </p>

                                </div>
                              </a>
                              <a href="#"
                                class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0">
                                <div>
                                  <div class="position-relative"><img src="/build/images/brands/cryptocurrency_btc.png"
                                      alt="" width="40" height="40"></div>
                                </div>
                                <div class="flex-fill border-bottom py-3">
                                  <h6 class=" fs-6 fw-6 clr-primary user-name">Anthony J James</h6>
                                  <p class="mb-0 fs-12 text-wrap lh-base">CEO | Innovation | Technology | Global
                                    Commercialization | Growth @ Trinity Consulting
                                  </p>

                                </div>
                              </a>
                              <a href="#"
                                class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0">
                                <div>
                                  <div class="position-relative"><img src="/build/images/brands/cryptocurrency_btc.png"
                                      alt="" width="40" height="40"></div>
                                </div>
                                <div class="flex-fill border-bottom py-3">
                                  <h6 class=" fs-6 fw-6 clr-primary user-name">Anthony J James</h6>
                                  <p class="mb-0 fs-12 text-wrap lh-base">CEO | Innovation | Technology | Global
                                    Commercialization | Growth @ Trinity Consulting
                                  </p>

                                </div>
                              </a>
                              <a href="#"
                                class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0">
                                <div>
                                  <div class="position-relative"><img src="/build/images/brands/cryptocurrency_btc.png"
                                      alt="" width="40" height="40"></div>
                                </div>
                                <div class="flex-fill border-bottom py-3">
                                  <h6 class=" fs-6 fw-6 clr-primary user-name">Anthony J James</h6>
                                  <p class="mb-0 fs-12 text-wrap lh-base">CEO | Innovation | Technology | Global
                                    Commercialization | Growth @ Trinity Consulting
                                  </p>

                                </div>
                              </a>
                            </div>
                            <div class="tab-pane fade" id="likereactions-tab-pane" role="tabpanel"
                              aria-labelledby="likereactions-tab" tabindex="0">
                              <a href="#"
                                class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0">
                                <div>
                                  <div class="position-relative"><img src="/build/images/brands/cryptocurrency_btc.png"
                                      alt="" width="40" height="40"></div>
                                </div>
                                <div class="flex-fill border-bottom py-3">
                                  <h6 class=" fs-6 fw-6 clr-primary user-name">Anthony J James</h6>
                                  <p class="mb-0 fs-12 text-wrap lh-base">CEO | Innovation | Technology | Global
                                    Commercialization | Growth @ Trinity Consulting
                                  </p>

                                </div>
                              </a>
                            </div>
                            <div class="tab-pane fade" id="lovereactions-tab-pane" role="tabpanel"
                              aria-labelledby="likereactions-tab" tabindex="0">
                              <a href="#"
                                class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0">
                                <div>
                                  <div class="position-relative"><img src="/build/images/brands/cryptocurrency_btc.png"
                                      alt="" width="40" height="40"></div>
                                </div>
                                <div class="flex-fill border-bottom py-3">
                                  <h6 class=" fs-6 fw-6 clr-primary user-name">Anthony J James</h6>
                                  <p class="mb-0 fs-12 text-wrap lh-base">CEO | Innovation | Technology | Global
                                    Commercialization | Growth @ Trinity Consulting
                                  </p>

                                </div>
                              </a>
                            </div>
                            <div class="tab-pane fade" id="hahareactions-tab-pane" role="tabpanel"
                              aria-labelledby="likereactions-tab" tabindex="0">
                              <a href="#"
                                class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0">
                                <div>
                                  <div class="position-relative"><img src="/build/images/brands/cryptocurrency_btc.png"
                                      alt="" width="40" height="40"></div>
                                </div>
                                <div class="flex-fill border-bottom py-3">
                                  <h6 class=" fs-6 fw-6 clr-primary user-name">Anthony J James</h6>
                                  <p class="mb-0 fs-12 text-wrap lh-base">CEO | Innovation | Technology | Global
                                    Commercialization | Growth @ Trinity Consulting
                                  </p>

                                </div>
                              </a>
                            </div>
                            <div class="tab-pane fade" id="wowreactions-tab-pane" role="tabpanel"
                              aria-labelledby="likereactions-tab" tabindex="0">
                              <a href="#"
                                class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0">
                                <div>
                                  <div class="position-relative"><img src="/build/images/brands/cryptocurrency_btc.png"
                                      alt="" width="40" height="40"></div>
                                </div>
                                <div class="flex-fill border-bottom py-3">
                                  <h6 class=" fs-6 fw-6 clr-primary user-name">Anthony J James</h6>
                                  <p class="mb-0 fs-12 text-wrap lh-base">CEO | Innovation | Technology | Global
                                    Commercialization | Growth @ Trinity Consulting
                                  </p>

                                </div>
                              </a>
                            </div>
                            <div class="tab-pane fade" id="sadreactions-tab-pane" role="tabpanel"
                              aria-labelledby="likereactions-tab" tabindex="0">
                              <a href="#"
                                class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0">
                                <div>
                                  <div class="position-relative"><img src="/build/images/brands/cryptocurrency_btc.png"
                                      alt="" width="40" height="40"></div>
                                </div>
                                <div class="flex-fill border-bottom py-3">
                                  <h6 class=" fs-6 fw-6 clr-primary user-name">Anthony J James</h6>
                                  <p class="mb-0 fs-12 text-wrap lh-base">CEO | Innovation | Technology | Global
                                    Commercialization | Growth @ Trinity Consulting
                                  </p>

                                </div>
                              </a>
                            </div>
                            <div class="tab-pane fade" id="angryreactions-tab-pane" role="tabpanel"
                              aria-labelledby="likereactions-tab" tabindex="0">
                              <a href="#"
                                class="list-group-item list-group-item-action px-0 py-0 d-flex align-items-center gap-3 border-0">
                                <div>
                                  <div class="position-relative"><img src="/build/images/brands/cryptocurrency_btc.png"
                                      alt="" width="40" height="40"></div>
                                </div>
                                <div class="flex-fill border-bottom py-3">
                                  <h6 class=" fs-6 fw-6 clr-primary user-name">Anthony J James</h6>
                                  <p class="mb-0 fs-12 text-wrap lh-base">CEO | Innovation | Technology | Global
                                    Commercialization | Growth @ Trinity Consulting
                                  </p>

                                </div>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Reaction Post Modal End-->
              </div>
            </div>
            <div class="comment-count">
              <button @click="toggleComments(post.id)" class="btn btn-feed-hover border-0">
                <i class="bi bi-chat pe-sm-2 pe-1"></i> {{ post.comments_count }} comments
              </button>
            </div>
          </div>
          <div class="row post-reach pb-2 px-sm-4">
            <button type="button" class="btn fs-5 btn-feed-hover border-0 position-relative col-4"
              @mouseover="onReactionHover(post.id)" @mouseleave="hideReactionsForPost(post.id)"
              @click="handleDefaultReaction(post.id)"><i v-if="!userReactions[post.id]"
                class="bi bi-hand-thumbs-up pe-sm-2 pe-1"></i>
              <i v-else :class="getReactionName(userReactions[post.id])"></i>
              <span :class="getReactionName(userReactions[post.id])">
                {{ userReactions[post.id] ? getReactionName(userReactions[post.id]) : 'Like' }}
              </span>
              <div v-if="showReactionsForPost[post.id]" class="reaction-icons-wrapper position-absolute d-flex gap-1">
                <span v-for="reactionType in reactionTypes" :key="reactionType.id"
                  @click.stop="addOrUpdateReaction(post.id, 'post_id', reactionType.id)">
                  <img :src="`/${reactionType.icon}`" class="reaction-icons-img">
                </span>
              </div>
            </button>
            <button type="button" class="btn fs-5 btn-feed-hover border-0 col-4" @click="toggleComments(post.id)"><i
                class="bi bi-chat pe-sm-2 pe-1"></i><span>Comment</span></button>
            <button type="button" class="btn fs-5 btn-feed-hover border-0 col-4" @click="sharePost"><i
                class="bi bi-share pe-sm-2 pe-1"></i><span>Share</span></button>
          </div>

          <!-- Comments Section -->
          <PostComment v-if="fetchedCommentsFlags[post.id]" :userId="userData.id" :postId="post.id"
            :fetchedCommentsFlags="fetchedCommentsFlags" :userAvatar="userData.avatar"
            @fetch-comments="handleFetchComments" />
        </div>
      </div>
    </div>
    <div v-else>
      <p>Loading posts...</p>
    </div>
  </div>
</template>


<script>
import axios from "axios";
import { mapState } from 'vuex';
import SharePost from "./SharePost.vue";
import PostComment from './PostComment.vue';

export default {
  components: {
    PostComment,
    SharePost
  },
  data() {
    return {
      allPosts: [],
      showReactionsForPost: {},
      reactionTypes: [],
      userReactions: {},
      fetchedCommentsFlags: {},
      csrfToken: ''
    };
  },
  computed: {
    ...mapState(['userData'])
  },
  methods: {
    async fetchUserPosts() {
      try {
        const response = await axios.get('/api/user-feed', {
          headers: {
            'X-CSRF-TOKEN': this.csrfToken,
            'Accept': 'application/json'
          }
        });
        this.allPosts = response.data.data;
        // Reset userReactions
        this.userReactions = {};
        this.allPosts.forEach(post => {
          // Check if reactions array exists and is not empty
          if (post.reactions && post.reactions.length > 0) {
            const userReaction = post.reactions.find(reaction => reaction.user_id === this.userData.id);
            if (userReaction) {
              this.userReactions[post.id] = userReaction.reaction_type_id;
            }
          }
        });
      } catch (error) {
        console.error('Error fetching posts:', error);
      }
    },
    getReactionName(reactionTypeId) {
      const reactionType = this.reactionTypes.find(rt => rt.id === reactionTypeId);
      return reactionType ? reactionType.name : 'Like';
    },
    formatDateTime(dateTime) {
      const now = new Date();
      const postedDate = new Date(dateTime);
      const diffInSeconds = Math.floor((now - postedDate) / 1000);
      const minute = 60, hour = 3600, day = 86400, week = 604800, month = 2629800, year = 31557600;

      if (diffInSeconds < minute) {
        return 'Just now';
      } else if (diffInSeconds < hour) {
        const mins = Math.floor(diffInSeconds / minute);
        return mins + (mins === 1 ? ' min ago' : ' mins ago');
      } else if (diffInSeconds < day) {
        const hrs = Math.floor(diffInSeconds / hour);
        return hrs + (hrs === 1 ? ' hour ago' : ' hours ago');
      } else if (diffInSeconds < week) {
        const days = Math.floor(diffInSeconds / day);
        return days + (days === 1 ? ' day ago' : ' days ago');
      } else if (diffInSeconds < month) {
        const weeks = Math.floor(diffInSeconds / week);
        return weeks + (weeks === 1 ? ' week ago' : ' weeks ago');
      } else if (diffInSeconds < year) {
        const months = Math.floor(diffInSeconds / month);
        return months + (months === 1 ? ' month ago' : ' months ago');
      } else {
        const years = Math.floor(diffInSeconds / year);
        return years + (years === 1 ? ' year ago' : ' years ago');
      }
    },
    toggleComments(postId) {
      if (!this.fetchedCommentsFlags[postId]) {
        this.$emit('fetch-comments', postId);
      }
      this.fetchedCommentsFlags[postId] = !this.fetchedCommentsFlags[postId];
    },
    handleFetchComments(postId) {
      if (!this.fetchedCommentsFlags[postId]) {
        // Fetch comments logic here
        this.fetchedCommentsFlags = { ...this.fetchedCommentsFlags, [postId]: true };
      }
    },
    onReactionHover(postId) {
      this.showReactionsForPost[postId] = true;
      this.fetchReactionTypesIfNeeded();
    },

    hideReactionsForPost(postId) {
      this.showReactionsForPost[postId] = false;
    },
    async fetchReactionTypesIfNeeded() {
      if (this.reactionTypes.length > 0) return;
      try {
        const response = await axios.get('/api/reaction-types');
        this.reactionTypes = response.data;
      } catch (error) {
        console.error('Error fetching reaction types:', error);
      }
    },

    handleDefaultReaction(postId) {
      const defaultReactionId = 1;
      if (this.userReactions[postId] === defaultReactionId) {
        this.removeReaction(postId, 'post_id');
      } else {
        this.addOrUpdateReaction(postId, 'post_id', defaultReactionId);
      }
    },


    async addOrUpdateReaction(id, idType, reactionTypeId) {
      const postIndex = this.allPosts.findIndex(post => post.id === id);
      if (postIndex === -1) return;

      const existingReactionIndex = this.allPosts[postIndex].reactions.findIndex(r => r.user_id === this.userData.id);

      // Update the existing reaction if it exists
      if (existingReactionIndex !== -1) {
        this.allPosts[postIndex].reactions[existingReactionIndex].reaction_type_id = reactionTypeId;
        this.allPosts[postIndex].reactions[existingReactionIndex].reaction_type = this.reactionTypes.find(rt => rt.id === reactionTypeId);
      } else {
        // Add new reaction
        const newReaction = {
          id: Date.now(), // Temporary ID, replace with real ID when available
          user_id: this.userData.id,
          reaction_type_id: reactionTypeId,
          reaction_type: this.reactionTypes.find(rt => rt.id === reactionTypeId)
        };
        this.allPosts[postIndex].reactions.push(newReaction);
        this.allPosts[postIndex].reactions_count++;
      }

      this.userReactions[id] = reactionTypeId; // Update userReactions

      try {
        const payload = { reaction_type_id: reactionTypeId };
        payload[idType] = id;

        await axios.post('/api/add-or-update-reaction', payload, {
          headers: {
            'X-CSRF-TOKEN': this.csrfToken
          }
        });
      } catch (error) {
        console.error('Error adding/updating reaction:', error);
        // Revert UI changes in case of error
        delete this.userReactions[id];
        if (existingReactionIndex !== -1) {
          // Revert to previous state if reaction was updated
          this.allPosts[postIndex].reactions[existingReactionIndex].reaction_type_id = previousReactionTypeId;
        } else if (postIndex !== -1) {
          this.allPosts[postIndex].reactions.pop();
          this.allPosts[postIndex].reactions
          _count--;
        }
      }
    },


    async removeReaction(id, idType) {
      // Optimistic UI Update
      delete this.userReactions[id];
      const postIndex = this.allPosts.findIndex(post => post.id === id);
      if (postIndex !== -1) {
        this.allPosts[postIndex].reactions_count--;

        // Remove user's reaction from the post's reactions array
        const reactionIndex = this.allPosts[postIndex].reactions.findIndex(r => r.user_id === this.userData.id);
        if (reactionIndex !== -1) {
          this.allPosts[postIndex].reactions.splice(reactionIndex, 1);
        }
      }

      try {
        const payload = {};
        payload[idType] = id;

        await axios.post('/api/remove-reaction', payload, {
          headers: {
            'X-CSRF-TOKEN': this.csrfToken
          }
        });
      } catch (error) {
        console.error('Error removing reaction:', error);
        // Revert UI changes in case of error
        // This is a simple example, you might need to handle it according to your application's needs
        if (postIndex !== -1) {
          this.allPosts[postIndex].reactions_count++;
          // Optionally, re-add the reaction to the array if you removed it
        }
      }
    },


    sharePost() {
      // Share post logic
    }
  },
  mounted() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    this.fetchUserPosts();
  }
};
</script>
<style>
/* .btn-feed-hover:focus{
  background-color: #00000014 !important;
} */
.link-file {
  max-height: 700px;
  overflow: hidden;
  cursor: pointer;
}

.link-file a img {
  max-height: 500px;
}

.btn-feed-hover:active {
  background-color: transparent !important;
}

.user-avatar img,
.reaction-icons-img {
  width: 30px;
  height: 30px;
  transition: ease-in-out .4s;
}

.reaction-icons-img:hover {
  transform: scale(1.1);
  transition: ease-in-out .5s;
}

.reaction-icons-wrapper {
  top: -30px;
  left: 50%;
  padding-bottom: 5px;
  transform: translateX(-40%);
  /* transform: translateY(-10px); */
}

.reaction-icon {
  vertical-align: sub;
  width: 20px;
  height: 20px;
}

.post-reach span.like::before,
.post-reach span.love::before,
.post-reach span.haha::before,
.post-reach span.wow::before,
.post-reach span.sad::before,
.post-reach span.angry::before {
  content: "";
  background-repeat: no-repeat;
  background-size: cover;
  width: 20px;
  height: 20px;
  display: inline-block;
  margin-right: 5px;
  vertical-align: text-top;
}

.love {
  color: #EE3757;
}

.post-reach span.love::before {
  background-image: url('/upload/icons/love.png');

}

.like {
  color: #378FE9;
}

.post-reach span.like::before {
  background-image: url('/upload/icons/like.png');
}

.haha,
.wow,
.sad {
  color: #F2B43B;
}

.post-reach span.haha::before {
  background-image: url('/upload/icons/haha.png');
}

.post-reach span.wow::before {
  background-image: url('/upload/icons/wow.png');
}

.post-reach span.sad::before {
  background-image: url('/upload/icons/sad.png');
}

.angry {
  color: #E57D28;
}

.post-reach span.angry::before {
  background-image: url('/upload/icons/angry.png');
}

.colored-post-text {
  color: rgb(255, 255, 255);
  background-image: linear-gradient(45deg, rgb(255, 154, 139) 0%, rgb(255, 106, 136) 100%);
  min-height: 400px;
}

.colored-post-text p {
  font-size: 2.5rem;
}

#reactionPostModal .modal-dialog-scrollable .modal-content {
  height: 600px;
}

.reactions-post-wrapper {
  min-height: 39px;
  overflow: auto;
  border-bottom: 1px solid #00000014;
}

.reactions-post-wrapper ul {
  max-width: fit-content;
  height: 38px;
}

.reactions-post-wrapper::-webkit-scrollbar {
  height: 0PX;
}

.reactions-post-nav-btn.active {
  background-color: #00000014 !important;
  border-bottom: 1px solid #000000 !important;
}

.user-reaction {
  right: 0;
  bottom: 0;
  padding-left: 1px;
  padding-right: 1px;
  padding-top: 0px;
  padding-bottom: 0px;
}

#postPreview .modal-dialog {
  max-width: 80%;
}

.post-preview-scroll {
  max-height: 88vh;
}

.multi-post-img-wrapper {
  width: 49%;
}

.multi-post-img {
  height: 285px;
}

.multi-post-img-wrapper:has(.multi-post-img.w-100) {
  width: 100% !important;
}

.overlay-post-gallery {
  background-color: rgba(0, 0, 0, 0.5);
  inset: 0;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.modal-username {
  margin-left: -40px;
}

@media screen and (max-width: 767px) {
  .user-info a {
    margin-left: -40px;
  }
}

@media screen and (max-width: 506px) {
  .post-reach button {
    padding-left: 2px;
    padding-right: 2px;
    font-size: 13px !important;
  }
}

@media screen and (max-width: 350px) {
  .post-reach button i {
    margin-right: 3px !important;
  }

  .user-icon img {
    width: 30px;
    height: 30px;
  }

  .post-reach span.like::before,
  .post-reach span.love::before,
  .post-reach span.haha::before,
  .post-reach span.wow::before,
  .post-reach span.sad::before,
  .post-reach span.angry::before {
    width: 15px;
    height: 15px;
    vertical-align: top;
  }
}
</style>