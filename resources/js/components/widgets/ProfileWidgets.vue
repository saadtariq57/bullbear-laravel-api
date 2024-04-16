<template>
  <ul class="bg-white list-unstyled rounded-1 pb-2 shadow position-relative">
    <div class="profile-completion-overlay d-flex justify-content-center align-items-center">
      <div class="completion-icon rounded-circle d-flex justify-content-center align-items-center text-cta"><i
          class="bi bi-check-lg fs-1 fw-bolder"></i></div>
    </div>
    <li class="mb-1">
      <div class="progress profile-progress position-relative rounded-top rounded-0">
        <div class="progress-bar profile-progress-bar" role="progressbar" aria-label="Basic example" aria-valuenow="40"
          aria-valuemin="0" aria-valuemax="100">
        </div>
        <h4 class="d-flex justify-content-between position-absolute w-100 text-white m-0 px-3 py-2 fw-6 fs-6">
          <span>Profile Completion</span>
          <span>40%</span>
        </h4>
      </div>
    </li>
    <li class="px-3 py-1 fs-16"><i class="bi bi-check-circle-fill text-success me-3 fs-5"></i><span>Add your
        profile picture</span> </li>
    <li class="px-3 py-1 fs-16"><i class="bi bi-plus-circle-fill me-3 fs-5"></i><span>Add your name</span>
    </li>
    <li class="px-3 py-1 fs-16"><i class="bi bi-plus-circle-fill me-3 fs-5"></i><span>Add your
        workplace</span>
    </li>
    <li class="px-3 py-1 fs-16"><i class="bi bi-check-circle-fill text-success me-3 fs-5"></i><span>Add your
        country</span></li>
    <li class="px-3 py-1 fs-16"><i class="bi bi-plus-circle-fill me-3 fs-5"></i><span>Add your address</span>
    </li>
  </ul>
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
  <ul class="bg-white list-unstyled rounded-1 pb-1 shadow rounded border-top border-2 border-warning widgets-border">
    <div class="border-bottom fw-6 fs-6 py-2 ps-3 mb-1 d-flex align-items-center">
      <span class="icon-round-bg me-2 bg-cta rounded-5 d-flex justify-content-center align-items-center"><i
          class="bi bi-info-circle-fill text-white"></i></span><span class="fs-5 text-black">Info</span>
    </div>
    <li class="px-3 py-1 fs-16"><i class="bi bi-eye-fill me-2 text-black fs-5"></i> <span
        class="text-success">Online</span>
    </li>
    <li class="px-3 py-1 fs-16"><i class="bi bi-file-post me-2 text-black fs-5"></i> <span>0
        posts</span></li>
        <li class="px-3 py-1 fs-16"><i class="bi bi-star-fill me-2 text-black fs-5"></i> <span>0
        Watchlists</span></li>
        <li class="px-3 py-1 fs-16"><i class="bi bi-person-fill-check me-2 text-black fs-5"></i> <span>3
        Followers</span></li>
    <li class="border-bottom my-1"></li>
    <li class="px-3 py-1 fs-16"><i class="bi bi-person-fill me-2 text-black fs-5"></i> <span>Male</span>
    </li>
    <li class="px-3 py-1 fs-16"><i class="bi bi-cake-fill me-2 text-black fs-5"></i> <span>03/01/00</span>
    </li>
    <li class="px-3 py-1 fs-16"><i class="bi bi-globe-americas me-2 text-black fs-5"></i> <span> Living in
        Pakistan</span>
        <li class="border-bottom my-1"></li>
        <li class="px-3 py-1 fs-16"><i class="bi bi-linkedin me-2 text-black fs-5"></i> <a href="https://www.linkedin.com/in/wajid" class="text-black">Wajid Fareed</a></li>
        <li class="px-3 py-1 fs-16"><i class="bi bi-twitter-x me-2 text-black fs-5"></i> <a href="https://www.twitter.com/in/wajid" class="text-black">Wajid Fareed</a></li>
        <li class="px-3 py-1 fs-16"><i class="bi bi-youtube me-2 text-black fs-5"></i> <a href="https://www.youtube.com/in/wajid" class="text-black">Wajid Fareed</a></li>
    </li>
  </ul>
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
  <ul class="bg-white list-unstyled rounded-1 pb-1 shadow rounded border-top border-2 border-warning widgets-border">
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
  </ul>
  <div class="people-you-know mb-3 shadow-sm rounded border-top border-2 border-warning widgets-border">
    <div class=" border-bottom">
      <div class="d-flex align-items-center pt-2 pb-1 justify-content-between">
        <div class="fw-6 fs-6 ps-3 mb-1 d-flex align-items-center">
      <span class="icon-round-bg me-2 bg-cta rounded-5 d-flex justify-content-center align-items-center"><i
          class="bi bi bi-person-plus-fill text-white"></i></span><span class="fs-5 text-black">People You May Know</span>
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
        src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/alert-icon.png" alt="" width="20" height="20" class="align-top">
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
        <div class="btn-group dropup">
          <button type="button" class="btn bg-transparent dropdown-toggle border-0 fs-13 text-secondary"
            data-bs-toggle="dropdown" aria-expanded="false">
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
<style>
.icon-round-bg {
  width: 27px;
  height: 27px;
}
</style>