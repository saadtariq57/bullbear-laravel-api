<template>
  <div v-if="userProfileData">
    <ul class="bg-white list-unstyled rounded-1 pb-2 shadow position-relative" v-if="userData.id == userProfileData.id">
      <div class="profile-completion-overlay d-flex justify-content-center align-items-center" v-if="completionPercentage == 100">
        <div class="completion-icon rounded-circle d-flex justify-content-center align-items-center text-cta">
          <i class="bi bi-check-lg fs-1 fw-bolder"></i>
        </div>
      </div>
      <li class="mb-1">
        <div class="progress profile-progress position-relative rounded-top rounded-0">
          <div class="progress-bar profile-progress-bar" role="progressbar" :aria-valuenow="completionPercentage"
            aria-valuemin="0" aria-valuemax="100" :style="{ width: completionPercentage + '%' }"></div>
          <h4 class="d-flex justify-content-between position-absolute w-100 text-white m-0 px-3 py-2 fw-6 fs-6">
            <span>Profile Completion</span>
            <span>{{ completionPercentage }}%</span>
          </h4>
        </div>
      </li>
      <li class="px-3 py-1 fs-16">
        <i class="bi me-3 fs-5"
          :class="userData.avatar == 'upload/photos/d-avatar.jpg' ? 'bi-plus-circle-fill' : 'bi-check-circle-fill text-success'"></i>
        <span>Add your Profile Picture</span>
      </li>
      <li class="px-3 py-1 fs-16">
        <i class="bi me-3 fs-5"
          :class="userData.cover == 'upload/photos/d-cover.jpg' ? 'bi-plus-circle-fill' : 'bi-check-circle-fill text-success'"></i>
        <span>Add your Cover Photo</span>
      </li>
      <li class="px-3 py-1 fs-16">
        <i class="bi me-3 fs-5"
          :class="userData.twitter || userData.linkedin || userData.youtube ? 'bi-check-circle-fill text-success' : 'bi-plus-circle-fill'"></i>
        <span>Add your Socials Links</span>
      </li>
      <li class="px-3 py-1 fs-16">
        <i class="bi me-3 fs-5"
          :class="!userData.phone_number ? 'bi-plus-circle-fill' : 'bi-check-circle-fill text-success'"></i>
        <span>Add your Phone Number</span>
      </li>
      <li class="px-3 py-1 fs-16">
        <i class="bi me-3 fs-5"
          :class="!userData.about ? 'bi-plus-circle-fill' : 'bi-check-circle-fill text-success'"></i>
        <span>Add About Description</span>
      </li>
    </ul>
    <ul
      class="bg-white list-unstyled rounded-1 pb-2 shadow rounded border-top border-2 border-warning widgets-border text-capitalize">
      <div class="border-bottom fw-6 fs-6 py-2 ps-3 mb-1 d-flex align-items-center">
        <span class="icon-round-bg me-2 bg-cta rounded-5 d-flex justify-content-center align-items-center"><i
            class="bi bi-info-circle-fill text-white"></i></span><span class="fs-5 text-black">Info</span>
      </div>
      <li class="px-3 py-1 fs-16" v-if="userProfileData.status"><i class="bi bi-eye-fill me-2 text-black fs-5"></i>
        <span :class="userProfileData.status === 'active' ? 'text-success' : 'text-danger'"> {{ userProfileData.status
    == 'active' ?
    'Online' : 'Offline' }}</span>
      </li>
      <li class="px-3 py-1 fs-16" v-if="userProfileData.posts_count"><i
          class="bi bi-file-post me-2 text-black fs-5"></i> <span>{{ userProfileData.posts_count }}</span>
        <span v-if="userProfileData.posts_count > 1"> Posts</span>
        <span v-else> Post</span>
      </li>
      <li class="px-3 py-1 fs-16" v-if="userProfileData.watchlists_count"><i
          class="bi bi-star-fill me-2 text-black fs-5"></i> <span>{{ userProfileData.watchlists_count
          }}</span>
        <span v-if="userProfileData.watchlists_count > 1"> Watchlists</span>
        <span v-else> Watchlist</span>
      </li>
      <li class="px-3 py-1 fs-16" v-if="userProfileData.followings_count"><i
          class="bi bi-person-fill-check me-2 text-black fs-5"></i> <span>{{
    userProfileData.followings_count }}</span>
        <span v-if="userProfileData.followings_count > 1"> Followers</span>
        <span v-else> Follower</span>
      </li>
      <!-- <li class="border-bottom my-1"></li>
    <li class="px-3 py-1 fs-16"><i class="bi bi-person-fill me-2 text-black fs-5"></i> <span>{{
          userData.gender }}</span>
    </li>
    <li class="px-3 py-1 fs-16"><i class="bi bi-cake-fill me-2 text-black fs-5"></i> <span>{{ userData.birthday
        }}</span>
    </li>
    <li class="px-3 py-1 fs-16"><i class="bi bi-globe-americas me-2 text-black fs-5"></i> <span> Living in
        {{ userData.state }}</span></li> -->
      <li class="border-bottom my-1"></li>
      <li class="px-3 py-1 fs-16" v-if="userProfileData.linkedin"><i class="bi bi-linkedin me-2 text-black fs-5"></i> <a
          :href="userProfileData.linkedin" class="text-black">{{ userProfileData.name }}</a></li>
      <li class="px-3 py-1 fs-16" v-if="userProfileData.twitter"><i class="bi bi-twitter me-2 text-black fs-5"></i> <a
          :href="userProfileData.twitter" class="text-black">{{ userProfileData.name }}</a></li>
      <li class="px-3 py-1 fs-16" v-if="userProfileData.youtube"><i class="bi bi-youtube me-2 text-black fs-5"></i> <a
          :href="userProfileData.youtube" class="text-black">{{ userProfileData.name }}</a></li>

    </ul>
  </div>

  <!-- <div class="bg-white px-3 py-4 rounded-1 mb-3 shadow rounded border-top border-2 border-warning widgets-border">
                    <form action="">
                        <div class="form-group">
                            <label for="search-field-post" class="mb-1">Search for posts</label>
                            <input type="email" class="form-control shadow border" id="search-field-post"
                                aria-describedby="emailHelp" placeholder="">
                        </div>
                    </form>
                </div> -->
  <!-- <ul class="bg-white list-unstyled rounded-1 pb-2 shadow">
                    <div class="border-bottom fw-6 fs-6 py-1 ps-3">My Watchlist</div>
                    <li class="text-center py-2 border-bottom">No watchlist to show</li>
                    <li class="text-center py-2">
                        <a href="#" class="btn btn-primary fw-6 fs-5 ">Create
                            Watchlist</a>
                    </li>
                </ul>
                <ul class="bg-white list-unstyled rounded-1 pb-2 shadow">
                    <div class="border-bottom fw-6 fs-6 py-1 ps-3">My Watchlist</div>
                    <li class="py-2 border-bottom">
                        <div class="d-flex justify-content-between px-3"><span>STOCKS</span><a href="#">
                                <i class="bi bi-eye-fill text-success bg-light rounded-5 px-1"></i></a>
                        </div>
                    </li>
                    <li class="text-center py-2">
                        <a href="#" class="btn btn-primary fw-6 fs-5">My
                            Watchlist</a>
                    </li>
                </ul> -->

  <!-- <ul class="bg-white list-unstyled rounded-1 pb-1 shadow rounded border-top border-2 border-warning widgets-border">
    <div class="border-bottom fw-6 fs-6 py-3 ps-3 mb-1 text-secondary"><i
        class="bi bi-images me-2 bg-cta text-white rounded-5 text-black px-2 py-1"></i><a href="#"
        class="text-secondary">Gallery <span>(1)</span></a>
    </div>
    <li class="p-1 ">
      <div class="row gx-2 gy-2">
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
              alt="" class="w-100">
          </div>
        </a>

      </div>
    </li>
  </ul> -->
  <!-- <ul class="bg-white list-unstyled rounded-1 pb-1 shadow rounded border-top border-2 border-warning widgets-border">
    <div class="border-bottom fw-6 fs-6 py-2 ps-3 mb-1 d-flex align-items-center">
      <span class="icon-round-bg me-2 bg-cta rounded-5 d-flex justify-content-center align-items-center"><i
          class="bi bi bi-person-fill-check text-white"></i></span><span class="fs-5 text-black">Followers <span
          class="fs-12">(3)</span></span>
    </div>
    <li class="p-1 ">
      <div class="row gx-2 gy-2">
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img src="/uploads/photos/d-avatar.jpg" alt="" class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
              Wajid Fareed
            </div>
          </div>
        </a>
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img src="/uploads/photos/f-avatar.jpg" alt="" class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
              dev123
            </div>
          </div>
        </a>
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
              alt="" class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
              dev123
              test
            </div>
          </div>
        </a>
      </div>
    </li>
  </ul>
  <ul class="bg-white list-unstyled rounded-1 pb-1 shadow rounded border-top border-2 border-warning widgets-border">
    <div class="border-bottom fw-6 fs-6 py-2 ps-3 mb-1 d-flex align-items-center">
      <span class="icon-round-bg me-2 bg-cta rounded-5 d-flex justify-content-center align-items-center"><i
          class="bi bi-chat-right-dots text-white"></i></span><span class="fs-5 text-black">Popular Chatrooms <span
          class="fs-12">(7)</span></span>
    </div>
    <li class="p-1 ">
      <div class="row gx-2 gy-2">
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img
              src="uploads/photos/2022/03/KtzcCYPA8QlNCuay1Qx7_14_c4d91fd1d21b8dacdd7f91ad5ef74b0a_avatar.png" alt=""
              class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white px-1 img-text w-100 text-oneline">
              DeFi Technologies Inc.
            </div>
          </div>
        </a>
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img
              src="uploads/photos/2022/03/KtzcCYPA8QlNCuay1Qx7_14_c4d91fd1d21b8dacdd7f91ad5ef74b0a_avatar.png" alt=""
              class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white px-1 img-text w-100 text-oneline">
              DeFi Technologies Inc.
            </div>
          </div>
        </a>
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img
              src="uploads/photos/2022/03/KtzcCYPA8QlNCuay1Qx7_14_c4d91fd1d21b8dacdd7f91ad5ef74b0a_avatar.png" alt=""
              class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white px-1 img-text w-100 text-oneline">
              DeFi Technologies Inc.
            </div>
          </div>
        </a>
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img
              src="uploads/photos/2022/03/KtzcCYPA8QlNCuay1Qx7_14_c4d91fd1d21b8dacdd7f91ad5ef74b0a_avatar.png" alt=""
              class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white px-1 img-text w-100 text-oneline">
              DeFi Technologies Inc.
            </div>
          </div>
        </a>
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img
              src="uploads/photos/2022/03/KtzcCYPA8QlNCuay1Qx7_14_c4d91fd1d21b8dacdd7f91ad5ef74b0a_avatar.png" alt=""
              class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white px-1 img-text w-100 text-oneline">
              DeFi Technologies Inc.
            </div>
          </div>
        </a>
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img
              src="uploads/photos/2022/03/KtzcCYPA8QlNCuay1Qx7_14_c4d91fd1d21b8dacdd7f91ad5ef74b0a_avatar.png" alt=""
              class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white px-1 img-text w-100 text-oneline">
              DeFi Technologies Inc.
            </div>
          </div>
        </a>
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img
              src="uploads/photos/2022/03/KtzcCYPA8QlNCuay1Qx7_14_c4d91fd1d21b8dacdd7f91ad5ef74b0a_avatar.png" alt=""
              class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white px-1 img-text w-100 text-oneline">
              DeFi Technologies Inc.
            </div>
          </div>
        </a>
      </div>
    </li>
  </ul> -->
  <div class="people-you-know mb-3 pb-2 shadow-sm rounded border-top border-2 border-warning widgets-border">
    <div class=" border-bottom">
      <div class="d-flex align-items-center pt-2 pb-1 justify-content-between">
        <div class="fw-6 fs-6 ps-3 mb-1 d-flex align-items-center">
          <span class="icon-round-bg me-2 bg-cta rounded-5 d-flex justify-content-center align-items-center"><i
              class="bi bi bi-person-plus-fill text-white"></i></span><span class="fs-5 text-black">People You May
            Know</span>
        </div>
        <div class="reload-widget pe-3"><i class="bi bi-arrow-clockwise" style="font-size: 22px;"></i></div>
      </div>
    </div>
    <div class="px-2 py-2 user-feed-card bg-white border border-1 d-flex gap-2 rounded-2">
      <div class="avatar user-chat-avatar-feed">
        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
          alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle" width="50px">
      </div>
      <div class="text-start align-self-end">
        <div class="user-lastseen text-light-emphasis fs-12 fw-5">7<span class="ps-1">W</span>
        </div>
        <a href="#"><span class="user_wrapper_link fs-16 fw-5 Blue d-inline-block">rommanch</span>
        </a>
      </div>
      <div class="user_follow-button pt-2 flex-fill text-end">
        <button class="btn fs-14 btn-primary rounded-pill px-4" type="button">Add
          Friends</button>
      </div>
    </div>
    <div class="px-2 py-2 user-feed-card bg-white border border-1 d-flex gap-2 rounded-2">
      <div class="avatar user-chat-avatar-feed">
        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
          alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle" width="50px">
      </div>
      <div class="text-start align-self-end">
        <div class="user-lastseen text-light-emphasis fs-12 fw-5">7<span class="ps-1">W</span>
        </div>
        <a href="#"><span class="user_wrapper_link fs-16 fw-5 Blue d-inline-block">rommanch</span>
        </a>
      </div>
      <div class="user_follow-button pt-2 flex-fill text-end">
        <button class="btn fs-14 btn-primary rounded-pill px-4" type="button">Add
          Friends</button>
      </div>
    </div>
    <div class="px-2 py-2 user-feed-card bg-white border border-1 d-flex gap-2 rounded-2">
      <div class="avatar user-chat-avatar-feed">
        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
          alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle" width="50px">
      </div>
      <div class="text-start align-self-end">
        <div class="user-lastseen text-light-emphasis fs-12 fw-5">7<span class="ps-1">W</span>
        </div>
        <a href="#"><span class="user_wrapper_link fs-16 fw-5 Blue d-inline-block">rommanch</span>
        </a>
      </div>
      <div class="user_follow-button pt-2 flex-fill text-end">
        <button class="btn fs-14 btn-primary rounded-pill px-4" type="button">Add
          Friends</button>
      </div>
    </div>
    <div class="px-2 py-2 user-feed-card bg-white border border-1 d-flex gap-2 rounded-2">
      <div class="avatar user-chat-avatar-feed">
        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
          alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle" width="50px">
      </div>
      <div class="text-start align-self-end">
        <div class="user-lastseen text-light-emphasis fs-12 fw-5">7<span class="ps-1">W</span>
        </div>
        <a href="#"><span class="user_wrapper_link fs-16 fw-5 Blue d-inline-block">rommanch</span>
        </a>
      </div>
      <div class="user_follow-button pt-2 flex-fill text-end">
        <button class="btn fs-14 btn-primary rounded-pill px-4" type="button">Add
          Friends</button>
      </div>
    </div>
    <div class="px-2 py-2 user-feed-card bg-white border border-1 d-flex gap-2 rounded-2">
      <div class="avatar user-chat-avatar-feed">
        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
          alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle" width="50px">
      </div>
      <div class="text-start align-self-end">
        <div class="user-lastseen text-light-emphasis fs-12 fw-5">7<span class="ps-1">W</span>
        </div>
        <a href="#"><span class="user_wrapper_link fs-16 fw-5 Blue d-inline-block">rommanch</span>
        </a>
      </div>
      <div class="user_follow-button pt-2 flex-fill text-end">
        <button class="btn fs-14 btn-primary rounded-pill px-4" type="button">Add
          Friends</button>
      </div>
    </div>
    <div class="px-2 py-2 user-feed-card bg-white border border-1 d-flex gap-2 rounded-2">
      <div class="avatar user-chat-avatar-feed">
        <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
          alt="Water Ways Technologies Inc Profile Picture" class="rounded-circle" width="50px">
      </div>
      <div class="text-start align-self-end">
        <div class="user-lastseen text-light-emphasis fs-12 fw-5">7<span class="ps-1">W</span>
        </div>
        <a href="#"><span class="user_wrapper_link fs-16 fw-5 Blue d-inline-block">rommanch</span>
        </a>
      </div>
      <div class="user_follow-button pt-2 flex-fill text-end">
        <button class="btn fs-14 btn-primary rounded-pill px-4" type="button">Add
          Friends</button>
      </div>
    </div>
  </div>
  <div class="border-primary pt-4 pb-2 px-3 border mb-2 rounded-1" style="background-color: #ffb8001a">
    <h1 class="fw-6 fs-5 text-secondary"><img
        src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/alert-icon.png" alt="" width="20" height="20"
        class="align-top">
      RISK DISCLAIMER!</h1>
    <p class="fs-14 text-black">Stock market investing is inherently risky. Rich TV is not
      responsible for any gains or losses that result from the opinions expressed on this website,
      in its research reports,
      company profiles or in other investor relations materials or presentations that it publishes
      electronically or in print. We strongly encourage all investors to conduct their own
      research before making any investment decision. For more information on stock market
      investing, visit the Securities and Exchange Commission ("SEC") at www.sec.gov.</p>
  </div>
  <div>
    <div class="border-bottom">
      <p class="fs-13 text-secondary my-1">© 2024 Rich Tv</p>
    </div>
    <ul class="d-flex justify-content-between align-items-center list-unstyled mt-2">
      <li><a href="#" class="fs-13 text-secondary">About</a></li>
      <li><a href="#" class="fs-13 text-secondary">Contact Us</a></li>
      <li>
        <div class="btn-group">
          <button type="button" class="btn bg-transparent dropdown-toggle border-0 fs-13 text-secondary"
            data-bs-toggle="dropdown" aria-expanded="false" @click="toggleDropdown($event)">
            More
          </button>
          <ul class="dropdown-menu text-uppercase">
            <li class="px-2 py-1"><a href="#" class="text-black">Privacy Policy</a></li>
            <li class="px-2 py-1"><a href="#" class="text-black">Terms of use</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
import { Dropdown } from 'bootstrap';
export default {
  computed: {
    ...mapState(['userData']),
    ...mapState('userProfile', ['userProfileData']),
    completionPercentage() {
      let completedSteps = 0;
      const totalSteps = 5;

      if (this.userData.avatar !== 'upload/photos/d-avatar.jpg') completedSteps++;
      if (this.userData.cover !== 'upload/photos/d-cover.jpg') completedSteps++;
      if (this.userData.twitter || this.userData.linkedin || this.userData.youtube) completedSteps++;
      if (this.userData.phone_number) completedSteps++;
      if (this.userData.about) completedSteps++;

      return Math.round((completedSteps / totalSteps) * 100);
    },
  },
  methods: {
    toggleDropdown(event) {
      const dropdownElement = event.target.closest('.dropdown-toggle');
      const dropdownInstance = Dropdown.getOrCreateInstance(dropdownElement);
      dropdownInstance.toggle();
    },
  }
}
</script>
<style>
.icon-round-bg {
  width: 27px;
  height: 27px;
}

.profile-progress-bar {
  background-color: var(--cta-btn);
}
</style>