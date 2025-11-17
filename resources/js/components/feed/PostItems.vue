<template>
  <div class="mt-3" v-if="userData">
    <div v-if="$store.state.userFeed.newPostAvailable" class="new-post-alert text-center mb-3">
      <button @click="$store.commit('userFeed/shiftNewPost')" class="btn fs-5 btn-feed-hover border-0 rounded-5 px-3">
        New Post Available - Click to View <i class="bi bi-arrow-up-short fw-bold fs-5"></i>
      </button>
    </div>
    <div v-if="computedPosts.length > 0">
      <div
        ref="scrollContainer"
        v-for="post in computedPosts"
        :key="post.id"
        class="post shadow mb-4 rounded-2"
      >
        <!-- Post heading section -->
        <div class="post-wrapper">
          <div class="post-heading p-3">
            <div class="d-flex justify-content-between">
              <div class="user-avatar d-flex gap-2 align-items-center">
                <div class="img">
                  <img
                    :src="'/uploads/' + post.user.avatar"
                    class="rounded-circle"
                    :alt="post.user.name + ' profile picture'"
                  />
                </div>
                <div class="user-info text-start">
                    <a :href="`/profile/${post.user.name}`" class="text-black fw-bold">{{ post.user.name }}</a>
                    <a v-if="post.group_name && !post.originalPost" :href="`/groups/${post.group_id}/${post.group_name}/discussion`" class="text-black fw-bold">
                    <i class="bi bi-caret-right-fill clr-primary"></i>
                    <span class="fw-semibold">
                      {{ formatGroupName(post.group_name) }} 
                    </span>
                    </a>
                  
                  <div class="time">
                    <span>{{ formatDateTime(post.created_at) }}</span>
                  </div>
                </div>
              </div>
              <!-- Post settings -->
              <div v-if="post.user.id === userData.id && post.post_type != 'poll'" class="position-relative">
                <button
                  class="btn dropdown-toggle"
                  type="button"
                  id="postSettingsMenuButton"
                  @click="toggleDropdown($event)"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="postSettingsMenuButton">
                  <li>
                    <button class="dropdown-item" @click="editPost(post)">Edit</button>
                  </li>
                  <li>
                    <button class="dropdown-item text-danger" @click="deletePost(post.id)">Delete</button>
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Post Content -->
          <div v-if="post.post_text" class="post-description px-3 text-break">
            <div
              v-if="post.colored_post_id && post.colored_post"
              class="colored-post-text d-flex justify-content-center align-items-center"
              :style="{
                backgroundImage:
                  'linear-gradient(45deg, ' +
                  post.colored_post.color_1 +
                  ' 0%, ' +
                  post.colored_post.color_2 +
                  ' 100%)'
              }"
            >
              <p
                :style="{ color: post.colored_post.text_color }"
                class="px-3 py-2 lh-base"
              >
                {{ post.post_text }}
              </p>
            </div>
            <div v-else class="markdown-body" v-html="renderedMarkdown(post.post_text)"></div>
          </div>

          <!-- Post Media -->
          <div
            v-if="post.post_type === 'photo'"
            class="post-file"
            @post-clicked="handlePostClicked"
          >
            <div
              v-if="post.multi_image > 0"
              class="d-flex flex-wrap row-gap-3 justify-content-between px-3"
            >
              <div
                v-for="(photo, index) in post.photos"
                :key="photo.id"
                class="multi-post-img-wrapper text-center btn p-0"
                @click="openPostPreviewModal(post)"
              >
                <div
                  v-if="post.photos.length > 4"
                  class="position-relative multi-post-img"
                >
                  <img
                    :src="'/uploads/' + photo.image"
                    alt="Post image"
                    class="img-fluid object-fit-cover multi-post-img"
                  />
                  <div
                    v-if="index === 3"
                    class="overlay-post-gallery d-flex justify-content-center align-items-center"
                  >
                    <span class="text-white fs-2 fw-6">
                      +{{ post.photos.length - 4 }}
                    </span>
                  </div>
                </div>
                <div
                  v-else-if="post.photos.length === 3"
                  class="multi-post-img"
                >
                  <img
                    :src="'/uploads/' + photo.image"
                    alt="Post image"
                    class="img-fluid object-fit-cover multi-post-img"
                    :class="{ 'w-100': index === 2 }"
                  />
                </div>
                <div v-else class="multi-post-img">
                  <img
                    :src="'/uploads/' + photo.image"
                    alt="Post image"
                    class="img-fluid object-fit-cover multi-post-img"
                  />
                </div>
              </div>
            </div>
            <div v-else class="text-center single-post-img">
              <div
                v-for="photo in post.photos"
                :key="photo.id"
                class="btn p-0"
                @click="openPostPreviewModal(post)"
              >
                <img
                  :src="'/uploads/' + photo.image"
                  alt="Post image"
                  class="img-fluid"
                />
              </div>
            </div>
          </div>

          <!-- Poll Content -->
          <div
            v-if="post.post_type === 'poll' && post.poll && post.poll.isActive"
            class="post-poll"
          >
            <div class="container-fluid px-sm-5">
              <div class="container shadow border border-light-grey py-4">
                <h5>{{ post.poll.text }}</h5>
                <div class="py-4">
                  <!-- Display options if voting time is active and the user hasn't voted yet -->
                  <div v-if="!post.poll.userVoted">
                    <div
                      v-for="option in post.poll.options"
                      :key="option.id"
                      class="mb-2"
                    >
                      <button
                        @click="submitVote(post.poll.id, option.id)"
                        class="w-100 btn rounded-5 border-btn border-2 fw-6"
                      >
                        {{ option.option_text }}
                      </button>
                    </div>
                  </div>

                  <!-- Display results if the user has voted or the voting time has expired -->
                  <div v-else-if="post.poll.isActive">
                    <div
                      v-for="option in post.poll.options"
                      :key="option.id"
                      class="mb-2"
                    >
                      <div class="poll-result">
                        <div
                          class="poll-meter-container rounded-2 d-flex justify-content-between align-items-center p-2"
                          :style="{
                            background:
                              'linear-gradient(to right, #8c8c8c33 ' +
                              calculatePercentage(option.votes, post.poll.totalVotes) +
                              '%, transparent ' +
                              calculatePercentage(option.votes, post.poll.totalVotes) +
                              '%)'
                          }"
                        >
                          <div class="poll-option-text">
                            {{ option.option_text }}
                          </div>
                          <div class="poll-percentage t-black t-bold t-14">
                            {{ calculatePercentage(option.votes, post.poll.totalVotes) }}%
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-secondary">
                    Total votes: {{ post.poll.totalVotes }} - Time left: {{ post.poll.timeLeft }}
                    <button
                      v-if="post.poll.userVoted"
                      @click="undoVote(post.poll.id)"
                      class="btn undo-vote-btn ps-2 fw-bold"
                    >
                      Undo Vote
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Link Media -->
          <div v-if="post.post_type === 'link'" class="link-file">
            <a :href="post.post_link" target="_blank">
              <img
                :src="post.post_link_image"
                alt="Post image"
                class="img-fluid w-100"
              />
              <div class="link-post-details px-3 pt-3">
                <h3 class="link-title fs-5">{{ post.post_link_title }}</h3>
                <span class="Blue fs-12">{{ post.post_link }}</span>
              </div>
            </a>
          </div>
          <!-- Shared Post Preview -->
          <div v-if="post.originalPost" class="shared-post-preview px-3 py-2 mx-3 my-2 border-top border-secondary-subtle">
            <div class="d-flex align-items-center mb-2">
              <img
                :src="'/uploads/' + post.originalPost.user.avatar"
                class="rounded-circle me-2"
                width="40"
                height="40"
                :alt="post.originalPost.user.name + ' avatar'"
              />
              <div class="shared-post-info">
                <a :href="`/profile/${post.originalPost.user.name}`">
                <span class="fw-semibold">
                  {{ post.originalPost.user.name }}
                </span>
                </a>
                <a v-if="post.originalPost.group_name" :href="`/groups/${post.originalPost.group_id}/${post.originalPost.group_name}/discussion`">
                <i class="bi bi-caret-right-fill clr-primary"></i>
                <span class="fw-semibold">
                  {{ formatGroupName(post.originalPost.group_name) }} 
                </span>
                </a>
                <span class="text-muted ms-2">{{ formatDateTime(post.originalPost.created_at) }}</span>
              </div>
              <FollowButton
                v-if="post.originalPost && post.originalPost.user && post.originalPost.user.id && !isOwnProfile(post.originalPost.user.id)"
                :userId="post.originalPost.user.id"
                :initialIsFollowing="isFollowing(post.originalPost.user.id)"
                :initialFollowersCount="this.userData.followers_count"
                :userName="post.originalPost.user.name"
                class="ms-auto"
              />
              <JoinGroupButton
                v-else-if="isGroupPost(post.originalPost)"
                :groupId="post.originalPost.group_id"
                :groupName="post.originalPost.group_name"
                :groupAvatar="post.originalPost.group_avatar || null"
                :createdAt="post.originalPost.created_at || null"
                :requestPending="isRequestPending(post.originalPost.group_id)"
                :joined="isJoined(post.originalPost.group_id)"
                class="ms-auto"
              />
            </div>
            <div class="shared-post-content">
              <!-- Render based on shared post type -->
              <template v-if="post.originalPost.post_type === 'text'">
                <div v-if="post.originalPost.colored_post_id && post.originalPost.colored_post" class="colored-post-text d-flex justify-content-center align-items-center"
                  :style="{ backgroundImage: 'linear-gradient(45deg, ' + post.originalPost.colored_post.color_1 + ' 0%, ' + post.originalPost.colored_post.color_2 + ' 100%)' }">
                  <p :style="{ color: post.originalPost.colored_post.text_color }" class="px-3 py-2 lh-base">
                    {{ post.originalPost.post_text }}
                  </p>
                </div>
                <div v-else class="markdown-body" v-html="renderedMarkdown(post.originalPost.post_text)"></div>
              </template>

              <template v-else-if="post.originalPost.post_type === 'color'">
                <div v-if="post.originalPost.colored_post_id && post.originalPost.colored_post" class="colored-post-text d-flex justify-content-center align-items-center"
                  :style="{ backgroundImage: 'linear-gradient(45deg, ' + post.originalPost.colored_post.color_1 + ' 0%, ' + post.originalPost.colored_post.color_2 + ' 100%)' }">
                  <p :style="{ color: post.originalPost.colored_post.text_color }" class="px-3 py-2 lh-base">
                    {{ post.originalPost.post_text }}
                  </p>
                </div>
                <div v-else class="markdown-body" v-html="renderedMarkdown(post.originalPost.post_text)"></div>
              </template>

              <template v-else-if="post.originalPost.post_type === 'photo'">
                <div class="post-file" @click="openPostPreviewModal(post.originalPost)">
                  <div v-if="post.originalPost.multi_image > 0" class="d-flex flex-wrap row-gap-3 justify-content-between">
                    <div
                      v-for="(photo, index) in post.originalPost.photos"
                      :key="photo.id"
                      class="multi-post-img-wrapper text-center btn p-0"
                      @click.stop="openPostPreviewModal(post.originalPost)"
                    >
                      <div v-if="post.originalPost.photos.length > 4" class="position-relative multi-post-img">
                        <img
                          :src="'/uploads/' + photo.image"
                          alt="Post image"
                          class="img-fluid object-fit-cover multi-post-img"
                        />
                        <div v-if="index === 3" class="overlay-post-gallery d-flex justify-content-center align-items-center">
                          <span class="text-white fs-2 fw-6">+{{ post.originalPost.photos.length - 4 }}</span>
                        </div>
                      </div>
                      <div v-else-if="post.originalPost.photos.length === 3" class="multi-post-img">
                        <img
                          :src="'/uploads/' + photo.image"
                          alt="Post image"
                          class="img-fluid object-fit-cover multi-post-img"
                          :class="{ 'w-100': index === 2 }"
                        />
                      </div>
                      <div v-else class="multi-post-img">
                        <img
                          :src="'/uploads/' + photo.image"
                          alt="Post image"
                          class="img-fluid object-fit-cover multi-post-img"
                        />
                      </div>
                    </div>
                  </div>
                  <div v-else class="text-center single-post-img">
                    <div
                      v-for="photo in post.originalPost.photos"
                      :key="photo.id"
                      class="btn p-0"
                      @click.stop="openPostPreviewModal(post.originalPost)"
                    >
                      <img
                        :src="'/uploads/' + photo.image"
                        alt="Post image"
                        class="img-fluid"
                      />
                    </div>
                  </div>
                </div>
              </template>

              <template v-else-if="post.originalPost.post_type === 'poll'">
                <div class="post-poll">
                  <div class="container-fluid px-sm-5 py-2">
                    <div class="container shadow border border-light-grey py-4">
                      <h5>{{ post.originalPost.poll.text }}</h5>
                      <div class="py-4">
                        <!-- Display options if voting time is active and the user hasn't voted yet -->
                        <div v-if="!post.originalPost.poll.userVoted">
                          <div
                            v-for="option in post.originalPost.poll.options"
                            :key="option.id"
                            class="mb-2"
                          >
                            <button
                              @click="submitVote(post.originalPost.poll.id, option.id)"
                              class="w-100 btn rounded-5 border-btn border-2 fw-6"
                            >
                              {{ option.option_text }}
                            </button>
                          </div>
                        </div>

                        <!-- Display results if the user has voted or the voting time has expired -->
                        <div v-else-if="post.originalPost.poll.isActive">
                          <div
                            v-for="option in post.originalPost.poll.options"
                            :key="option.id"
                            class="mb-2"
                          >
                            <div class="poll-result">
                              <div
                                class="poll-meter-container rounded-2 d-flex justify-content-between align-items-center p-2"
                                :style="{
                                  background: 'linear-gradient(to right, #8c8c8c33 ' +
                                    calculatePercentage(option.votes, post.originalPost.poll.totalVotes) +
                                    '%, transparent ' +
                                    calculatePercentage(option.votes, post.originalPost.poll.totalVotes) +
                                    '%)'
                                }"
                              >
                                <div class="poll-option-text">
                                  {{ option.option_text }}
                                </div>
                                <div class="poll-percentage t-black t-bold t-14">
                                  {{ calculatePercentage(option.votes, post.originalPost.poll.totalVotes) }}%
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="text-secondary">
                          Total votes: {{ post.originalPost.poll.totalVotes }} - Time left: {{ post.originalPost.poll.timeLeft }}
                          <button
                            v-if="post.originalPost.poll.userVoted"
                            @click="undoVote(post.originalPost.poll.id)"
                            class="btn undo-vote-btn ps-2 fw-bold"
                          >
                            Undo Vote
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </template>

              <template v-else-if="post.originalPost.post_type === 'link'">
                <div class="link-file">
                  <a :href="post.originalPost.post_link" target="_blank">
                    <img
                      :src="post.originalPost.post_link_image"
                      alt="Post image"
                      class="img-fluid w-100"
                    />
                    <div class="link-post-details px-3 pt-3">
                      <h3 class="link-title fs-5">{{ post.originalPost.post_link_title }}</h3>
                      <span class="Blue fs-12">{{ post.originalPost.post_link }}</span>
                    </div>
                  </a>
                </div>
              </template>
            </div>
          </div>
          <!-- End of Shared Post Preview -->
          <!-- Interaction buttons and Like/Comment counts -->
          <div class="like-comment-count d-flex justify-content-between p-3 align-items-center">
            <div class="like-count">
              <!-- Reaction Post trigger modal -->
              <div class="reaction-icons">
                <button
                  @click="handleShowReactionsPost(post.id, post.organizedReactions)"
                  class="btn"
                >
                  <span
                    v-for="(reactionDetail, index) in Object.values(post.organizedReactions).slice(0, 3)"
                    :key="index"
                  >
                    <img
                      :src="`/${reactionDetail.details[0].reactionImage}`"
                      class="reaction-icon"
                    />{{ reactionDetail.count }}
                    <span v-if="Object.keys(post.organizedReactions).length > 3">
                      +{{ Object.values(post.organizedReactions).reduce((acc, r) => acc + r.count, 0) }}
                    </span>
                  </span>
                </button>
              </div>
            </div>
            <div class="comment-count">
              <button
                @click="toggleComments(post.id, userData.id)"
                class="btn btn-feed-hover border-0"
              >
                <i class="bi bi-chat pe-sm-2 pe-1"></i> {{ post.comments_count }} comments
              </button>
            </div>
          </div>
          <div class="row post-reach pb-2 px-sm-4">
            <button
              type="button"
              class="btn fs-5 btn-feed-hover border-0 position-relative col-4"
              @mouseover="onReactionHover(post.id)"
              @mouseleave="hideReactionsForPost(post.id)"
              @click="onReactionButtonClick(post.id)"
              @touchstart.passive="onReactionTouchStart($event, post.id)"
              @touchend="onReactionTouchEnd($event, post.id)"
              @touchmove.passive="onReactionTouchMove($event, post.id)"
              @touchcancel="onReactionTouchCancel($event, post.id)"
            >
              <i :class="`${getReactionClassName(post.userReaction)} pe-sm-2 pe-1`"></i>
              <i
                v-if="!post.userReaction"
                class="bi bi-hand-thumbs-up fs-5 pe-sm-2 pe-1"
              ></i>
              <span :class="getReactionClassName(post.userReaction)">
                {{ getReactionName(post.userReaction) }}
              </span>
              <div
                v-if="showReactionsForPost[post.id]"
                class="reaction-icons-wrapper position-absolute d-flex gap-1"
              >
                <span
                  v-for="reactionType in reactionTypes"
                  :key="reactionType.id"
                  @click.stop="handleReaction(post.id, reactionType.id)"
                >
                  <img
                    :src="`/${reactionType.icon}`"
                    class="reaction-icons-img"
                  />
                </span>
              </div>
            </button>
            <button
              type="button"
              class="btn fs-5 btn-feed-hover border-0 col-4 px-2"
              @click="toggleComments(post.id, userData.id)"
            >
              <i class="bi bi-chat pe-sm-2 pe-1"></i><span>Comment</span>
            </button>
            <div class="btn-group col-4">
              <button
                type="button"
                class="btn fs-5 btn-feed-hover border-0 px-2 dropdown-toggle"
                @click="toggleDropdown($event)"
                data-bs-toggle="dropdown"
                data-bs-display="static"
                aria-expanded="false"
              >
                <i class="bi bi-share pe-sm-2 pe-1"></i><span>Share</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end z-1">
                <li>
                  <button class="dropdown-item fw-5" @click="triggerPostModal(post)">
                    <i class="bi bi-pencil-square me-2"></i>Share to Feed
                  </button>
                </li>
                <li>
                  <button class="dropdown-item fw-5" @click="openShareToGroupModal(post)">
                    <i class="bi bi-people-fill me-2"></i>Share to Group
                  </button>
                </li>
                <li>
                  <button class="dropdown-item fw-5" @click="shareToExternal('twitter', post)">
                    <i class="bi bi-twitter me-2"></i>Share to Twitter
                  </button>
                </li>
                <li>
                  <button class="dropdown-item fw-5" @click="shareToExternal('whatsapp', post)">
                    <i class="bi bi-whatsapp me-2"></i>Send in WhatsApp
                  </button>
                </li>
                <li>
                  <button class="dropdown-item fw-5" @click="shareToExternal('telegram', post)">
                    <i class="bi bi-telegram me-2"></i>Send in Telegram
                  </button>
                </li>
              </ul>
            </div>
          </div>
          <ShareToGroupModal
            ref="shareToGroupModal"
            v-if="shareToGroupPost"
            :post="shareToGroupPost"
            @share-post="handlePostShare"
            @modal-mounted="handleShareModalMounted"
            @close-modal="handleShareModalClosed"
          />
          <!-- Comments Section -->
          <PostComment
            v-if="visibleCommentsFlags[post.id]"
            :postId="post.id"
            :reactionTypes="reactionTypes"
            @show-reactions="handleShowReactions"
            @comment-submitted="updateCommentsCount($event)"
            @comment-deleted="updateCommentsCount($event)"
          />
        </div>
      </div>
      <!-- Sentinel for infinite scroll (triggers before widgets on mobile) -->
      <div ref="infiniteScrollSentinel" style="height:1px;width:100%;"></div>

      <!-- Loading Indicator for More Posts -->
      <div v-if="isFetchingMore" class="text-center my-4">
        <span>Loading more posts...</span>
        <div class="spinner-border" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      <!-- Optional: No More Posts Message -->
      <div v-else-if="!hasMorePosts" class="text-center my-4">
        <span>No more posts to load.</span>
      </div>
    </div>
    <div v-else-if="loadingComputedPosts">
      <!-- Skeleton Loaders (Existing) -->
      <div class="post-wrapper shadow mb-3">
        <div class="post-heading p-3">
          <div class="d-flex justify-content-between">
            <div class="user-avatar d-flex gap-2 align-items-center">
              <div class="img">
                <Skeletor height="35px" width="35px" class="rounded-circle" />
              </div>
              <div class="user-info text-start">
                <Skeletor height="10px" width="30px" />
                <div class="mt-2">
                  <span>
                    <Skeletor height="10px" width="50px" />
                  </span>
                </div>
              </div>
            </div>
            <!-- Post settings -->
          </div>
        </div>

        <!-- Post Content -->
        <div class="post-description px-3">
          <Skeletor height="20px" width="100%" />
        </div>

        <div class="post-file mt-3">
          <Skeletor height="300px" width="100%" />
        </div>
        <!-- Interaction buttons and Like/Comment counts -->
        <div class="like-comment-count d-flex justify-content-between p-3 align-items-center">
          <div class="like-count">
            <!-- Reaction Post trigger modal -->
            <div class="reaction-icons">
              <Skeletor height="15px" width="30px" />
            </div>
          </div>
          <div class="comment-count">
            <Skeletor height="15px" width="60px" />
          </div>
        </div>
        <div class="row post-reach pb-2 px-sm-4 mt-2">
          <button
            type="button"
            class="btn fs-5 btn-feed-hover border-0 position-relative col-4"
          >
            <Skeletor height="30px" width="100%" />
          </button>
          <button
            type="button"
            class="btn fs-5 btn-feed-hover border-0 col-4 px-2"
          >
            <Skeletor height="30px" width="100%" />
          </button>
          <button
            type="button"
            class="btn fs-5 btn-feed-hover border-0 col-4 px-2"
          >
            <Skeletor height="30px" width="100%" />
          </button>
        </div>
      </div>
      <div class="post-wrapper shadow mb-3">
        <div class="post-heading p-3">
          <div class="d-flex justify-content-between">
            <div class="user-avatar d-flex gap-2 align-items-center">
              <div class="img">
                <Skeletor height="35px" width="35px" class="rounded-circle" />
              </div>
              <div class="user-info text-start">
                <Skeletor height="10px" width="30px" />
                <div class="mt-2">
                  <span>
                    <Skeletor height="10px" width="50px" />
                  </span>
                </div>
              </div>
            </div>
            <!-- Post settings -->
          </div>
        </div>

        <!-- Post Content -->
        <div class="post-description px-3">
          <Skeletor height="20px" width="100%" />
        </div>

        <div class="post-file mt-3">
          <Skeletor height="300px" width="100%" />
        </div>
        <!-- Interaction buttons and Like/Comment counts -->
        <div class="like-comment-count d-flex justify-content-between p-3 align-items-center">
          <div class="like-count">
            <!-- Reaction Post trigger modal -->
            <div class="reaction-icons">
              <Skeletor height="15px" width="30px" />
            </div>
          </div>
          <div class="comment-count">
            <Skeletor height="15px" width="60px" />
          </div>
        </div>
        <div class="row post-reach pb-2 px-sm-4 mt-2">
          <button
            type="button"
            class="btn fs-5 btn-feed-hover border-0 position-relative col-4"
          >
            <Skeletor height="30px" width="100%" />
          </button>
          <button
            type="button"
            class="btn fs-5 btn-feed-hover border-0 col-4 px-2"
          >
            <Skeletor height="30px" width="100%" />
          </button>
          <button
            type="button"
            class="btn fs-5 btn-feed-hover border-0 col-4 px-2"
          >
            <Skeletor height="30px" width="100%" />
          </button>
        </div>
      </div>
    </div>
    <div v-else class="d-flex justify-content-center align-items-center no-posts-wrapper">
      <div>
        <div
          class="mx-auto border border-2 rounded-circle no-posts-icon d-flex justify-content-center align-items-center my-3"
        >
          <i class="bi bi-camera fs-1"></i>
        </div>
        <p class="fs-4 fw-5 no-post-text">No Posts Yet</p>
      </div>
    </div>
    <ReactionModal
      ref="reactionModal"
      v-if="activeReactionData"
      :activeItem="activeReactionData"
      @close-modal="activeReactionData = null"
      @modal-mounted="handleModalMounted"
    />
    <PreviewModal
      ref="previewModal"
      :previewPost="clickedPost"
      :reactionTypes="clickedPostReactionTypes"
      @close-modal="clickedPost = null"
      @modal-mounted="handlePreviewModalMounted"
      @comments-count-updated="updateCommentsCount($event)"
      @comments-count-reupdated="updateCommentsCount($event)"
    />
  </div>
  <div v-else class="text-center my-4">
    <span>Loading feed...</span>
  </div>
</template>

<script>
import { formatDateTime } from '../../utils';
import { Modal, Dropdown } from 'bootstrap';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userFeedModule from '@/stores/userFeedStore';
import userFeedCommentModule from '@/stores/userFeedCommentStore';
import { mapState, mapActions } from 'vuex';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import { renderMarkdownToHtml } from '../../services/markdown';
import CreatePost from './CreatePost.vue';
import PostComment from './PostComment.vue';
import ReactionModal from '../utils/ReactionModal.vue';
import PreviewModal from './PreviewModal.vue';
import ShareToGroupModal from './ShareToGroupModal.vue';
import FollowButton from '../profile/FollowButton.vue';
import JoinGroupButton from '../utils/JoinGroupButton.vue';
import Swal from 'sweetalert2';

export default {
  emits: ['show-reactions', 'show-post-modal', 'show-edit-model', 'post-deleted'],
  props: {
    posts: Array,
    reactionTypes: Array,
    context: {
      type: String,
      default: 'feed'
    },
    groupName: {
      type: String,
      default: null
    },
  },
  components: {
    PostComment,
    ReactionModal,
    PreviewModal,
    CreatePost,
    Skeletor,
    ShareToGroupModal,
    FollowButton,
    JoinGroupButton,
  },
  data() {
    return {
      showReactionsForPost: {},
      activeReactionData: null,
      clickedPost: null,
      clickedPostReactionTypes: null,
      loadingComputedPosts: true,
      moduleRegistered: false,
      commentModuleRegistered: false,
      debouncedHandleScroll: null,
      shareToGroupPost: null,
      shareModalInstance: null,
      editPostData: null,
      infiniteObserver: null,
      isMobile: false,
      safetyCheckInterval: null,
      bottomReachCheckInterval: null,
      immediateBottomCheck: null,
      scrollPositionBeforeLoad: null,
      reactionTouchData: {},
      touchHandledPosts: {},
      reactionHoldDelay: 400,
    };
  },
  computed: {
    ...mapState(['userData']),
    ...mapState('userFeed', ['fetchedCommentsFlags', 'visibleCommentsFlags', 'hasMorePosts', 'isFetchingMore']),
    computedPosts() {
      if (this.posts.length === 0) {
        this.postsLoaded();
        return [];
      }
      return this.posts.map(post => {
        let updatedPost = {
          ...post,
        };
        if (post.post_type === 'poll' && post.poll) {
          const isActive = this.isPollActive(post.poll);
          const totalVotes = this.calculateTotalVotes(post.poll.options);
          updatedPost.poll = {
            ...post.poll,
            isActive: isActive,
            timeLeft: this.timeLeft(post.poll),
            totalVotes: totalVotes
          };
        }
        return updatedPost;
      });
    },
    userName() {
      return this.context === 'profile' ? this.$route.params.userName : null;
    }
  },
  watch: {
    activeReactionData(newVal) {
      if (newVal) {
        this.$nextTick(() => {
          if (!this.reactionModalInstance) {
            this.reactionModalInstance = new Modal(this.$refs.reactionModal, { backdrop: 'static' });
          }
          this.reactionModalInstance.show();
        });
      }
    },
    shareToGroupPost(newVal) {
      if (newVal) {
        this.$nextTick(() => {
          if (!this.shareModalInstance) {
            this.shareModalInstance = new Modal(this.$refs.shareToGroupModal, { backdrop: 'static' });
          }
          this.shareModalInstance.show();
        });
      }
    },
    computedPosts: {
      handler() {
        this.postsLoaded();
      },
      immediate: false
    }
  },
  methods: {
    detectMobileDevice() {
      // Check if device is mobile based on screen width and user agent
      const isMobileWidth = window.innerWidth <= 768;
      const isMobileUserAgent = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
      this.isMobile = isMobileWidth || isMobileUserAgent;
    },
    startSafetyCheck() {
      // Safety mechanism: periodically check if user is near bottom and load more posts
      this.safetyCheckInterval = setInterval(() => {
        if (this.isFetchingMore || !this.hasMorePosts) return;
        
        const scrollingElement = document.scrollingElement || document.documentElement;
        const scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : scrollingElement.scrollTop;
        const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
        const fullHeight = scrollingElement.scrollHeight;
        
        // Very aggressive check - trigger if user is within 2000px of bottom
        const safetyBuffer = this.isMobile ? 2000 : 1500;
        const nearBottom = (scrollTop + viewportHeight) >= (fullHeight - safetyBuffer);
        
        if (nearBottom) {
          console.log('Safety check triggered - loading more posts');
          this.loadMorePosts();
        }
      }, 1000); // Check every second
    },
    stopSafetyCheck() {
      if (this.safetyCheckInterval) {
        clearInterval(this.safetyCheckInterval);
        this.safetyCheckInterval = null;
      }
    },
    startBottomReachCheck() {
      // Dedicated mechanism to detect when user reaches absolute bottom
      this.bottomReachCheckInterval = setInterval(() => {
        if (this.isFetchingMore || !this.hasMorePosts) return;
        
        const scrollingElement = document.scrollingElement || document.documentElement;
        const scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : scrollingElement.scrollTop;
        const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
        const fullHeight = scrollingElement.scrollHeight;
        
        // Check if user has reached the absolute bottom (within 10px)
        const atAbsoluteBottom = (scrollTop + viewportHeight) >= (fullHeight - 10);
        
        if (atAbsoluteBottom) {
          console.log('User reached absolute bottom - forcing post load');
          this.loadMorePosts();
        }
      }, 500); // Check every 500ms for more responsive detection
    },
    stopBottomReachCheck() {
      if (this.bottomReachCheckInterval) {
        clearInterval(this.bottomReachCheckInterval);
        this.bottomReachCheckInterval = null;
      }
    },
    immediateBottomDetection() {
      // Immediate bottom detection that runs on every scroll event
      if (this.isFetchingMore || !this.hasMorePosts) return;
      
      const scrollingElement = document.scrollingElement || document.documentElement;
      const scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : scrollingElement.scrollTop;
      const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
      const fullHeight = scrollingElement.scrollHeight;
      
      // Check if user has reached the absolute bottom (within 5px for maximum sensitivity)
      const atAbsoluteBottom = (scrollTop + viewportHeight) >= (fullHeight - 5);
      
      if (atAbsoluteBottom) {
        console.log('Immediate bottom detection - user at absolute bottom - FORCING post load');
        this.loadMorePosts();
      }
    },
    setupInfiniteObserver() {
      // Teardown any existing observer
      if (this.infiniteObserver) {
        if (this.$refs.infiniteScrollSentinel) {
          try { this.infiniteObserver.unobserve(this.$refs.infiniteScrollSentinel); } catch (e) {}
        }
        try { this.infiniteObserver.disconnect(); } catch (e) {}
        this.infiniteObserver = null;
      }

      if ('IntersectionObserver' in window && this.$refs.infiniteScrollSentinel) {
        // Use much more aggressive rootMargin to trigger loading much earlier
        const rootMargin = this.isMobile ? '0px 0px 2000px 0px' : '0px 0px 1500px 0px';
        const options = { root: null, rootMargin, threshold: 0 };
        this.infiniteObserver = new IntersectionObserver((entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting && !this.isFetchingMore && this.hasMorePosts) {
              console.log('IntersectionObserver triggered - loading more posts');
              this.loadMorePosts();
            }
          });
        }, options);
        this.infiniteObserver.observe(this.$refs.infiniteScrollSentinel);
      }
    },
    renderedMarkdown(text) {
      return renderMarkdownToHtml(text);
    },
    ...mapActions('userFeed', [
      'addOrUpdateReaction',
      'removeReaction',
      'fetchMorePosts',
      'addVote',
      'removeVote',
      'updateFetchedCommentsFlag',
      'updateFetchedCommentsVisibility'
    ]),
    ...mapActions('userFeedComment', ['fetchCommentsForPost']),
    formatDateTime,
    debounce(func, wait) {
      let timeout;
      return function(...args) {
        const later = () => {
          clearTimeout(timeout);
          func.apply(this, args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
      };
    },
    editPost(post) {
      this.editPostData = post;
      this.triggerPostEditModal(post);
    },
    deletePost(postId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`/api/delete-post/${postId}`)
          .then((response) => {
            Swal.fire('Deleted!', 'The post has been deleted.', 'success');
            this.$emit('post-deleted', postId);
          })
          .catch((error) => {
            console.error('Error deleting post:', error);
            Swal.fire('Error!', 'There was a problem deleting your post.', 'error');
          });
        }
      });
    },
    getReactionBaseName(reactionTypeId) {
      if (!reactionTypeId) return null;
      if (!Array.isArray(this.reactionTypes)) return null;
      const reactionType = this.reactionTypes.find(rt => rt.id === reactionTypeId);
      if (!reactionType || !reactionType.name) return null;
      return reactionType.name.toString().trim().toLowerCase();
    },
    getReactionName(reactionTypeId) {
      const baseName = this.getReactionBaseName(reactionTypeId) || 'like';
      return baseName.charAt(0).toUpperCase() + baseName.slice(1);
    },
    getReactionClassName(reactionTypeId) {
      const baseName = this.getReactionBaseName(reactionTypeId);
      return baseName || '';
    },
    toggleDropdown(event) {
      const dropdownElement = event.target.closest('.dropdown-toggle');
      const dropdownInstance = Dropdown.getOrCreateInstance(dropdownElement);
      dropdownInstance.toggle();
    },
    postsLoaded() {
      this.loadingComputedPosts = false;
    },
    triggerPostModal(post) {
      this.$emit('show-post-modal', { post: post, groupId: null, groupName: this.groupName });
    },
    triggerPostEditModal(post){
      this.$emit('show-edit-model', post);
    },
    handlePreviewModalMounted(modalElement) {
      if (modalElement) {
        this.previewModalInstance = new Modal(modalElement, { backdrop: 'static' });
      } else {
        console.error('Modal element is not available.');
      }
    },
    openPostPreviewModal(post) {
      this.clickedPost = post;
      this.clickedPostReactionTypes = this.reactionTypes;
      if (this.previewModalInstance) {
        this.previewModalInstance.show();
      } else {
        console.error('Modal instance is not initialized.');
      }
    },

    handleModalMounted(modalElement) {
      this.reactionModalInstance = new Modal(modalElement, { backdrop: 'static' });
    },
    showReactionModal() {
      if (this.reactionModalInstance) {
        this.reactionModalInstance.show();
      }
    },

    handleShowReactions(reactionData) {
      this.activeReactionData = reactionData;
    },
    handleShowReactionsPost(postId, reactionData) {
      this.activeReactionData = { postId, reactionData };
    },
    handleScroll() {
      const scrollingElement = document.scrollingElement || document.documentElement;
      const scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : scrollingElement.scrollTop;
      const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
      const fullHeight = scrollingElement.scrollHeight;
      
      // Much more aggressive buffer - trigger loading when user is still far from bottom
      const scrollBuffer = this.isMobile ? 1500 : 1000;
      const nearBottom = (scrollTop + viewportHeight) >= (fullHeight - scrollBuffer);
      
      // Fallback: trigger loading even when user reaches absolute bottom
      const atBottom = (scrollTop + viewportHeight) >= (fullHeight - 50);
      
      // Emergency fallback: trigger loading when user reaches very bottom (within 10px)
      const atVeryBottom = (scrollTop + viewportHeight) >= (fullHeight - 10);
      
      if ((nearBottom || atBottom || atVeryBottom) && !this.isFetchingMore && this.hasMorePosts) {
        if (nearBottom) {
          console.log('Scroll handler triggered (near bottom) - loading more posts');
        } else if (atBottom) {
          console.log('Scroll handler triggered (at bottom) - loading more posts');
        } else if (atVeryBottom) {
          console.log('Scroll handler triggered (at very bottom) - FORCING post load');
        }
        this.loadMorePosts();
      }
      
      // Also run immediate bottom detection on every scroll
      this.immediateBottomDetection();
    },
    async loadMorePosts() {
      // Detect if user is at (or near) bottom before loading
      const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
      const fullHeight = document.documentElement.scrollHeight;
      const wasAtBottom = (scrollTop + viewportHeight) >= (fullHeight - 120);
      // Capture current count to locate first newly appended post after render
      const prevCount = Array.isArray(this.posts) ? this.posts.length : 0;

      console.log('Loading more posts - current posts count:', this.posts.length);
      console.log('User was at bottom:', wasAtBottom, 'prevCount:', prevCount);

      if (this.userName) {
        await this.fetchMorePosts({ context: this.context, userName: this.userName });
      } else {
        await this.fetchMorePosts({ context: this.context });
      }

      console.log('More posts loaded - new posts count:', this.posts.length);

      // If user was at bottom, bring the first newly loaded post into view immediately
      if (wasAtBottom) {
        this.$nextTick(() => {
          this.scrollFirstNewPostIntoView(prevCount);
        });
      }
    },
    scrollFirstNewPostIntoView(prevCount) {
      // Use existing ref array from v-for (ref="scrollContainer") to locate the first newly appended post
      const containers = this.$refs && this.$refs.scrollContainer ? this.$refs.scrollContainer : null;
      if (!containers) return;

      const isArray = Array.isArray(containers);
      const firstNewEl = isArray ? containers[prevCount] : null;
      if (firstNewEl && typeof firstNewEl.scrollIntoView === 'function') {
        // Scroll so the first new post is placed at the top of the viewport
        firstNewEl.scrollIntoView({ behavior: 'auto', block: 'start' });
      } else if (firstNewEl) {
        const rect = firstNewEl.getBoundingClientRect();
        const absoluteTop = rect.top + (window.pageYOffset || document.documentElement.scrollTop);
        window.scrollTo({ top: absoluteTop, behavior: 'auto' });
      } else {
        // Fallback: scroll to bottom
        const fullHeight = (document.scrollingElement || document.documentElement).scrollHeight;
        window.scrollTo({ top: fullHeight, behavior: 'auto' });
      }
    },
    toggleComments(postId, userId) {
      if (!this.fetchedCommentsFlags[postId]) {
        this.fetchCommentsForPost({ postId, userId });
        this.updateFetchedCommentsFlag(postId);
      } else {
        this.updateFetchedCommentsVisibility(postId);
      }
    },
    updateCommentsCount(data) {
      const postId = data.postId;
      const increment = data.increment;
      const postIndex = this.posts.findIndex(post => post.id === postId);
      if (postIndex !== -1) {
        this.posts[postIndex].comments_count += increment;
      }
    },
    submitVote(pollId, optionId) {
      this.addVote({ pollId, optionId });
    },

    undoVote(pollId) {
      this.removeVote(pollId);
    },
    calculatePercentage(votes, totalVotes) {
      return totalVotes > 0 ? ((votes / totalVotes) * 100).toFixed(2) : 0;
    },

    isPollActive(poll) {
      const pollEndTime = new Date(poll.created_at).getTime() + poll.time * 24 * 60 * 60 * 1000;
      return Date.now() < pollEndTime;
    },

    timeLeft(poll) {
      const pollEndTime = new Date(poll.created_at).getTime() + poll.time * 24 * 60 * 60 * 1000;
      const timeLeft = pollEndTime - Date.now();
      if (timeLeft <= 0) {
        return 'Voting closed';
      }
      const daysLeft = Math.floor(timeLeft / (24 * 60 * 60 * 1000));
      return daysLeft > 0 ? daysLeft + ' days' : 'Less than a day';
    },
    calculateTotalVotes(options) {
      return options.reduce((sum, option) => sum + option.votes, 0);
    },
    onReactionHover(postId) {
      if (this.isMobile) return;
      this.showReactionsForPost[postId] = true;
    },
    hideReactionsForPost(postId) {
      this.showReactionsForPost[postId] = false;
    },
    handleReaction(post_id, reactionTypeId) {
      const post = this.posts.find(p => p.id === post_id);
      if (post) {
        if (post.userReaction === reactionTypeId) {
          // Remove the reaction
          this.removeReaction(post_id);
        } else {
          // Add or update the reaction
          this.addOrUpdateReaction({ post_id, reactionTypeId });
        }
        this.showReactionsForPost[post_id] = false;
        this.clearReactionTouchData(post_id);
      }
    },
    onReactionButtonClick(postId) {
      if (this.isMobile && this.touchHandledPosts[postId]) {
        this.touchHandledPosts[postId] = false;
        return;
      }
      this.handleReaction(postId, 1);
    },
    onReactionTouchStart(event, postId) {
      if (!this.isMobile) return;
      if (this.isTouchWithinReactionTray(event)) return;
      const touch = event.touches && event.touches[0];
      if (!touch) return;
      this.clearReactionTouchData(postId);
      const holdTimer = setTimeout(() => {
        const data = this.reactionTouchData[postId];
        if (!data) return;
        data.longPress = true;
        this.showReactionsForPost[postId] = true;
      }, this.reactionHoldDelay);
      this.reactionTouchData[postId] = {
        timer: holdTimer,
        longPress: false,
        startX: touch.clientX,
        startY: touch.clientY,
        hasMoved: false,
      };
    },
    onReactionTouchMove(event, postId) {
      if (!this.isMobile) return;
      if (this.isTouchWithinReactionTray(event)) return;
      const data = this.reactionTouchData[postId];
      if (!data || data.longPress) return;
      const touch = event.touches && event.touches[0];
      if (!touch) return;
      const deltaX = Math.abs(touch.clientX - data.startX);
      const deltaY = Math.abs(touch.clientY - data.startY);
      const MOVE_THRESHOLD = 10;
      if (deltaX > MOVE_THRESHOLD || deltaY > MOVE_THRESHOLD) {
        if (data.timer) {
          clearTimeout(data.timer);
          data.timer = null;
        }
        data.hasMoved = true;
      }
    },
    onReactionTouchEnd(event, postId) {
      if (!this.isMobile) return;
      if (this.isTouchWithinReactionTray(event)) {
        this.touchHandledPosts[postId] = true;
        this.clearReactionTouchData(postId);
        return;
      }
      this.touchHandledPosts[postId] = true;
      const data = this.reactionTouchData[postId];
      if (data && data.timer) {
        clearTimeout(data.timer);
        data.timer = null;
      }
      if (data) {
        if (data.longPress) {
          // Tray already shown, keep it open for selection
          this.showReactionsForPost[postId] = true;
        } else if (!data.hasMoved) {
          this.handleReaction(postId, 1);
        }
      }
      this.clearReactionTouchData(postId);
    },
    onReactionTouchCancel(event, postId) {
      if (!this.isMobile) return;
      if (this.isTouchWithinReactionTray(event)) {
        this.touchHandledPosts[postId] = true;
        this.clearReactionTouchData(postId);
        return;
      }
      this.touchHandledPosts[postId] = true;
      this.clearReactionTouchData(postId);
      this.showReactionsForPost[postId] = false;
    },
    clearReactionTouchData(postId) {
      const data = this.reactionTouchData[postId];
      if (data && data.timer) {
        clearTimeout(data.timer);
      }
      if (Object.prototype.hasOwnProperty.call(this.reactionTouchData, postId)) {
        delete this.reactionTouchData[postId];
      }
    },
    isTouchWithinReactionTray(event) {
      if (!event || !event.target) return false;
      return Boolean(event.target.closest('.reaction-icons-wrapper'));
    },
    handleShareModalMounted(modalElement) { 
      this.shareModalInstance = new Modal(modalElement, { backdrop: 'static' });
    },

    openShareToGroupModal(post) {
      // If reopening for the same post and modal instance exists, just show it
      if (this.shareToGroupPost && this.shareToGroupPost.id === post.id && this.shareModalInstance) {
        this.shareModalInstance.show();
        return;
      }
      // Force re-mount to retrigger watcher and child mount if same reference
      this.shareToGroupPost = null;
      this.$nextTick(() => {
        this.shareToGroupPost = post;
      });
    },
    handleShareModalClosed(modalElement){
      if (this.shareModalInstance && modalElement) {
        const onHidden = () => {
          try { if (typeof this.shareModalInstance.dispose === 'function') this.shareModalInstance.dispose(); } catch (e) {}
          this.shareModalInstance = null;
          // Clean any leftover Bootstrap artifacts to prevent scroll freeze
          document.body.classList.remove('modal-open');
          try { document.body.style.removeProperty('padding-right'); } catch (e) {}
          const backdrops = document.querySelectorAll('.modal-backdrop');
          backdrops.forEach(b => b.remove());
          // Clear the post so subsequent opens for the same post work
          this.shareToGroupPost = null;
        };
        modalElement.addEventListener('hidden.bs.modal', onHidden, { once: true });
        try { this.shareModalInstance.hide(); } catch (e) { onHidden(); }
      } else {
        // Fallback cleanup
        this.shareModalInstance = null;
        this.shareToGroupPost = null;
        document.body.classList.remove('modal-open');
        try { document.body.style.removeProperty('padding-right'); } catch (e) {}
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(b => b.remove());
      }
    },
    handlePostShare({ groupId, groupName }) {
      this.$emit('show-post-modal', {
        post: this.shareToGroupPost,
        groupId: groupId,
        groupName: groupName
      });
      this.shareToGroupPost = null;
    },
    shareToExternal(platform, post) {
      const postUrl = encodeURIComponent(`${window.location.origin}/post/${post.user.name}/${post.id}`);
      const postText = encodeURIComponent(this.shareToGroupPost ? this.shareToGroupPost.post_text : 'Check out this post!');
      let shareUrl = '';

      switch(platform) {
        case 'twitter':
          shareUrl = `https://twitter.com/intent/tweet?url=${postUrl}&text=${postText}`;
          break;
        case 'whatsapp':
          shareUrl = `https://wa.me/?text=${postText}%20${postUrl}`;
          break;
        case 'telegram':
          shareUrl = `https://t.me/share/url?url=${postUrl}&text=${postText}`;
          break;
        default:
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: `Unsupported platform: ${platform}`,
            toast: true,
            position: 'top-right',
            timer: 3000,
            showConfirmButton: false,
          });
          return;
      }

      window.open(shareUrl, '_blank');

      // Show SweetAlert notification
      Swal.fire({
        icon: 'success',
        title: 'Shared',
        text: `Post shared to ${platform.charAt(0).toUpperCase() + platform.slice(1)}!`,
        toast: true,
        position: 'top-right',
        timer: 3000,
        showConfirmButton: false,
      });
    },
    isGroupPost(post) {
      // Define logic to determine if a post is a group post
      return post.group_id !== null;
    },
    isOwnProfile(userId) {
      return this.userData.id === userId;
    },
    isFollowing(userId) {
      const followingList = Array.isArray(this.userData?.following) ? this.userData.following : [];
      return followingList.includes(userId);
    },
    isJoined(groupId) {
      const groups = Array.isArray(this.userData?.groups_info) ? this.userData.groups_info : [];
      const group = groups.find(g => g.id === Number(groupId));
      return !!group && group.status === 'active';
    },
    isRequestPending(groupId) {
      const groups = Array.isArray(this.userData?.groups_info) ? this.userData.groups_info : [];
      const group = groups.find(g => g.id === Number(groupId));
      return !!group && group.status === 'pending';
    },
    formatGroupName(groupName){
      return groupName
          .replace(/-/g, ' ')
          .toLowerCase()
          .replace(/\b\w/g, char => char.toUpperCase());
    },
  },
  mounted() {
    // Detect mobile device
    this.detectMobileDevice();
    
    this.debouncedHandleScroll = this.debounce(this.handleScroll, 200);
    window.addEventListener('scroll', this.debouncedHandleScroll, { passive: true });
    
    // Listen for resize events to handle orientation changes
    window.addEventListener('resize', this.detectMobileDevice);

    // Start safety check mechanism
    this.startSafetyCheck();
    
    // Start bottom reach check mechanism
    this.startBottomReachCheck();

    // IntersectionObserver for reliable mobile infinite scroll
    this.$nextTick(() => { this.setupInfiniteObserver(); });
  },
  updated() {
    // Re-detect mobile device in case of orientation changes
    this.detectMobileDevice();
    // Ensure observer stays attached after virtual DOM updates (e.g., after appending posts)
    this.$nextTick(() => { this.setupInfiniteObserver(); });
  },
  beforeDestroy() {
    if (this.moduleRegistered) {
      unregisterVuexModule('userFeed');
    }
    if (this.commentModuleRegistered) {
      unregisterVuexModule('userFeedComment');
    }
    window.removeEventListener('scroll', this.debouncedHandleScroll);
    window.removeEventListener('resize', this.detectMobileDevice);
    
    // Stop safety check
    this.stopSafetyCheck();
    
    // Stop bottom reach check
    this.stopBottomReachCheck();
    
    if (this.infiniteObserver && this.$refs.infiniteScrollSentinel) {
      this.infiniteObserver.unobserve(this.$refs.infiniteScrollSentinel);
      this.infiniteObserver.disconnect();
      this.infiniteObserver = null;
    }
  },
  created() {
    if (!this.$store.hasModule('userFeed')) {
      registerVuexModule('userFeed', userFeedModule);
      this.moduleRegistered = true;
    }
    if (!this.$store.hasModule('userFeedComment')) {
      registerVuexModule('userFeedComment', userFeedCommentModule);
      this.commentModuleRegistered = true;
    }
  }
};
</script>

<style scoped>
.shared-post-info a{
  color: #000000;
}
.undo-vote-btn {
  padding: 10px 0;
  background: transparent;
  border: 0;
  color: #4a6ee0;
}

.new-post-alert button {
  background-color: #00000014;
}

.new-post-alert button:hover {
  background-color: #00000020;
}

.post.shadow,
.new-post-alert {
  transition: .4s ease all;
}

.preview-modal-item.carousel-item {
  transition: unset !important;
  vertical-align: middle;
}

.preview-modal-item.carousel-item.active {
  display: flex;
  justify-content: center;
  height: 100%;
  opacity: 1;
}
.post-preview-comments-modal {
  max-height: 550px !important;
  overflow-y: auto !important;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to

/* .fade-leave-active in <2.1.8 */
{
  opacity: 0;
}

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
.user-avatar .img{
  width: 35px;
  height: 35px;
  overflow: hidden;
}
.user-avatar img,
.reaction-icons-img {
  width: 35px;
  height: 35px;
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
  transform: translateX(-30%);
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
  background-size: contain;
  background-position: center;
  width: 18px;
  height: 18px;
  min-width: 18px;
  min-height: 18px;
  display: inline-block;
  margin-right: 5px;
  vertical-align: middle;
}

.love {
  color: #EE3757;
}

.post-reach span.love::before {
  background-image: url('/uploads/icons/love.png');
}

.like {
  color: #378FE9;
}

.post-reach span.like::before {
  background-image: url('/uploads/icons/like.png');
}

.haha,
.wow,
.sad {
  color: #F2B43B;
}

.post-reach span.haha::before {
  background-image: url('/uploads/icons/haha.png');
}

.post-reach span.wow::before {
  background-image: url('/uploads/icons/wow.png');
}

.post-reach span.sad::before {
  background-image: url('/uploads/icons/sad.png');
}

.angry {
  color: #E57D28;
}

.post-reach span.angry::before {
  background-image: url('/uploads/icons/angry.png');
}

.colored-post-text {
  min-height: 400px;
}

.colored-post-text p {
  font-size: 2.5rem;
}

#postPreview .modal-dialog {
  max-width: 100%;
}

.post-preview-scroll {
  max-height: 100vh;
  height: 92vh;
}

.multi-post-img-wrapper {
  width: 49%;
}

.multi-post-img {
  height: 285px;
  width: 100%;
}

.multi-post-img-wrapper:has(.multi-post-img.w-100) {
  width: 100% !important;
}
.single-post-img .btn img{
  max-height: 600px;
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

.reaction-icons button:empty {
  display: none;
}

.no-posts-wrapper {
  height: 60vh;
}

.no-posts-icon {
  width: 80px;
  height: 80px;
  border-color: #47484A !important;
}

.no-post-text {
  color: #47484A;
}

@media (max-width: 767px) {
  .post-preview-scroll {
    max-height: 100%;
    height: 100%;
  }
}

@media (max-width: 600px) {
  .multi-post-img {
    height: 200px;
  }
}
@media (max-width: 575px) {
  .post-file{
    max-height: 420px;
  }
}

@media (max-width: 506px) {
  .post-reach button {
    padding-left: 2px;
    padding-right: 2px;
    font-size: 13px !important;
  }

  .multi-post-img {
    height: 180px;
  }
  .post-file{
    max-height: 380px;
  }
}

@media (max-width: 350px) {
  .multi-post-img {
    height: 120px;
  }
  .post-file{
    max-height: 260px;
  }

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

/* Shared Post Preview Styles */
.shared-post-preview {
  background-color: #f8f9fa;
  border-radius: 0.5rem;
  margin-bottom: 1rem;
}

.shared-post-preview .shared-post-info {
  display: flex;
  align-items: center;
}

.shared-post-preview .shared-post-info .fw-semibold {
  margin-right: 0.5rem;
}

.shared-post-preview .shared-post-content {
  margin-top: 0.5rem;
}

/* Follow Button and Join Group Button Alignment */
.shared-post-preview .follow-button,
.shared-post-preview .join-group-button {
  margin-left: auto;
}
.post-description {
  white-space: pre-wrap;
}

.markdown-body {
  white-space: normal;
}
</style>
