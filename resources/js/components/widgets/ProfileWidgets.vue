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
    <li class="px-3 py-1"><i class="bi bi-check-circle-fill text-success me-3"></i><span>Add your
        profile picture</span> </li>
    <li class="px-3 py-1"><i class="bi bi-plus-circle-fill me-3"></i><span>Add your name</span>
    </li>
    <li class="px-3 py-1"><i class="bi bi-plus-circle-fill me-3"></i><span>Add your
        workplace</span>
    </li>
    <li class="px-3 py-1"><i class="bi bi-check-circle-fill text-success me-3"></i><span>Add your
        country</span></li>
    <li class="px-3 py-1"><i class="bi bi-plus-circle-fill me-3"></i><span>Add your address</span>
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
    <div class="border-bottom fw-6 fs-6 py-3 ps-3 mb-1"><i
        class="bi bi-info-circle-fill me-2 bg-cta text-white rounded-5 px-2 py-1"></i>Info
    </div>
    <li class="px-3 py-1"><i class="bi bi-eye-fill me-2 text-secondary"></i> <span class="text-success">Online</span>
    </li>
    <li class="px-3 py-1"><i class="bi bi-file-post me-2 text-secondary"></i> <span>2
        posts</span></li>
    <li class="border-bottom my-1"></li>
    <li class="px-3 py-1"><i class="bi bi-person-fill me-2 text-secondary"></i> <span>Male</span>
    </li>
    <li class="px-3 py-1"><i class="bi bi-cake-fill me-2 text-secondary"></i> <span>03/01/00</span>
    </li>
    <li class="px-3 py-1"><i class="bi bi-globe-americas me-2 text-secondary"></i> <span> Living in
        Pakistan</span>
    </li>
  </ul>
  <ul class="bg-white list-unstyled rounded-1 pb-1 shadow rounded border-top border-2 border-warning widgets-border">
    <div class="border-bottom fw-6 fs-6 py-3 ps-3 mb-1 text-secondary"><i
        class="bi bi-images me-2 bg-cta text-white rounded-5 text-black px-2 py-1"></i><a href="#"
        class="text-secondary">Gallery <span>(1)</span></a>
    </div>
    <li class="p-1 ">
      <div class="row gx-2 gy-2">
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
    <div class="border-bottom fw-6 fs-6 py-3 ps-3 mb-1"><i
        class="bi bi-person-plus-fill me-2 bg-cta text-white text-black rounded-5 px-2 py-1"></i><a href="#"
        class="text-secondary">Friends <span>(3)</span></a>
    </div>
    <li class="p-1 ">
      <div class="row gx-2 gy-2">
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
              alt="" class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
              dev123
              test
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
    <div class="border-bottom fw-6 fs-6 py-3 ps-3 mb-1"><i
        class="bi bi-chat-right-dots me-2 bg-cta text-white text-black rounded-5 px-2 py-1 fs-13"></i>
      <a href="#" class="text-secondary">Chats <span>(7)</span></a>
    </div>
    <li class="p-1 ">
      <div class="row gx-2 gy-2">
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
              alt="" class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
              dev123
              test
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
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
              alt="" class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
              dev123
              test
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
        <a href="#" class="col-lg-4 col-md-4 col-sm-4 col-4">
          <div class="position-relative"><img src="	https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
              alt="" class="w-100">
            <div class="position-absolute bottom-0 start-0 text-white ps-1 img-text w-100">
              dev123
              test
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
  <div class="border-primary pt-4 pb-2 px-3 border mb-2 rounded-1" style="background-color: #ffb8001a">
    <h1 class="fw-6 fs-5 text-secondary"><img
        src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/alert-icon.png" alt="" width="20" height="20">
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