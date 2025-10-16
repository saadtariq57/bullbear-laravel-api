<template>
  <section class="container-fluid my-4 generel_setting_section">
    <div class="container">
      <div class="row">
        <div class="col-lg-9">
          <div class="tab-content shadow rounded pb-4 bg-white" id="v-pills-tabContent">
            <!-- General+setting-tabs start -->
            <div class="tab-pane fade show active" id="v-pills-setting" role="tabpanel"
              aria-labelledby="v-pills-setting-tab" tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img :src="`/uploads/${userData.avatar}`" :alt="`${userData.name} Profile Picture`"
                      class="avatar rounded-circle">
                  </div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">{{ userData.name }}</a></h5>
                    <p class="fs-28 pt-2">General Setting</p>
                  </div>
                </div>

              </div>
              
              <!-- Profile Completed Success Message -->
              <div v-if="isProfileComplete" class="alert alert-success mx-3 mt-3 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill fs-4"></i>
                <strong class="mb-0">Profile Completed!</strong>
              </div>
              <form @submit.prevent="updateGeneralUserData" class="mt-5 pt-3 text-capitalize">
                <div class="row g-3 px-3">
                  <div class="col-md-6">
                    <label for="username" class="form-label col-form-label-lg">Username</label>
                    <input type="text" class="form-control form-control-lg" id="username" placeholder="Enter username"
                      :value="userData.name" disabled>
                  </div>
                  <div class="col-md-6">
                    <label for="phone" class="form-label col-form-label-lg">Phone</label>
                    <input type="text" class="form-control form-control-lg" id="phone" placeholder="Enter phone number"
                      v-model="userData.phone_number">
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-6">
                    <label for="fname" class="form-label col-form-label-lg">First name</label>
                    <input type="text" class="form-control form-control-lg" id="fname" placeholder="Enter first name"
                      v-model="userData.first_name">
                  </div>
                  <div class="col-md-6">
                    <label for="lname" class="form-label col-form-label-lg">Last name</label>
                    <input type="text" class="form-control form-control-lg" id="lname" placeholder="Enter last name"
                      v-model="userData.last_name">
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col">
                    <label for="email" class="form-label col-form-label-lg">E-mail</label>
                    <input type="email" class="form-control form-control-lg" id="email" placeholder="Enter email"
                      :value="userData.email" disabled>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-12">
                    <label for="about" class="form-label col-form-label-lg">About me</label>
                    <textarea class="form-control form-control-lg" id="about" placeholder="Describe yourself here..."
                      v-model="userData.about"></textarea>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-6">
                    <label for="gender" class="form-label col-form-label-lg">Gender</label>
                    <select class="form-select form-select-lg" id="gender" v-model="userData.gender">
                      <option :selected="userData.gender === 'male'" value="male">Male</option>
                      <option :selected="userData.gender === 'female'" value="female">Female</option>
                      <option :selected="userData.gender === 'other'" value="other">Other</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="pro_type" class="form-label col-form-label-lg">Member Type</label>
                    <input type="text" class="form-control form-control-lg" id="pro_type"
                      :value="`${userData.subscription_plan} Member`" disabled>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-6">
                    <label for="birthday" class="form-label col-form-label-lg">Birthday</label>
                    <input type="date" class="form-control form-control-lg" id="birthday" v-model="userData.birthday">
                  </div>
                  <div class="col-md-6">
                    <label for="country" class="form-label col-form-label-lg">Country</label>
                    <select class="form-select form-select-lg" id="country" v-model="userData.state">
                      <option v-for="(name, code) in countries" :key="code" :value="name"
                        :selected="userData.state == name">
                        {{ name }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-6">
                    <label for="city" class="form-label col-form-label-lg">City</label>
                    <input type="text" class="form-control form-control-lg" id="city" placeholder="Enter city"
                      v-model="userData.city">
                  </div>
                  <div class="col-md-6">
                    <label for="zip" class="form-label col-form-label-lg">Zip</label>
                    <input type="text" class="form-control form-control-lg" id="zip" placeholder="Enter Zip"
                      v-model="userData.zip">
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-12">
                    <label for="website" class="form-label col-form-label-lg">Website</label>
                    <input type="text" class="form-control form-control-lg" id="website"
                      placeholder="https://yourwebsite.com/" v-model="userData.website">
                  </div>
                </div>
                <div class="mt-4 text-center">
                  <button type="submit" class="btn btn-primary rounded-2 fs-18 fw-6">Save</button>
                </div>
              </form>
            </div>
            <!-- Privacy-tabs start -->
            <div class="tab-pane fade" id="v-pills-privacy" role="tabpanel" aria-labelledby="v-pills-privacy-tab"
              tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img :src="`/uploads/${userData.avatar}`" :alt="`${userData.name} Profile Picture`"
                      class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">{{ userData.name }}</a></h5>
                    <p class="fs-28 pt-2">Privacy Setting</p>
                  </div>
                </div>

              </div>
              <form @submit.prevent="updatePrivacySettings" class="mt-5 pt-3">
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Allow people to view my posts?</p>
                  </div>
                  <div class="col-12 col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg fs-16 mb-3" v-model="privacySettings.post_privacy" aria-label="post_privacy">
                      <option value="Everyone">Everyone</option>
                      <option value="Followers">Followers</option>
                      <option value="Private">Only Me</option>
                    </select>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Allow people to view my joined groups?</p>
                  </div>
                  <div class="col-12 col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg fs-16 mb-3" v-model="privacySettings.groups_privacy" aria-label="groups_privacy">
                      <option value="Everyone">Everyone</option>
                      <option value="Followers">Followers Only</option>
                      <option value="Private">Only Me</option>
                    </select>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Allow people to view my watchlists?</p>
                  </div>
                  <div class="col-12 col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg fs-16 mb-3" v-model="privacySettings.watchlists_privacy" aria-label="watchlists_privacy">
                      <option value="Everyone">Everyone</option>
                      <option value="Followers">Followers Only</option>
                      <option value="Private">Only Me</option>
                    </select>
                    <p class="notice">If you want people to view your specific watchlists please <a href="/watchlist/manage">click here to manage watchlists</a></p>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Allow people to view my Photos?</p>
                  </div>
                  <div class="col-12 col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg fs-16 mb-3" v-model="privacySettings.photos_privacy" aria-label="photos_privacy">
                      <option value="Everyone">Everyone</option>
                      <option value="Followers">Followers Only</option>
                      <option value="Private">Only Me</option>
                    </select>
                  </div>
                </div>
                <div class="mt-4 text-center">
                  <button type="submit" class="btn btn-primary rounded-2 fs-18 fw-6">Save</button>
                </div>
              </form>
            </div>
            <!-- Password-tabs start -->
            <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab"
              tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img :src="`/uploads/${userData.avatar}`" :alt="`${userData.name} Profile Picture`"
                      class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">{{ userData.name }}</a></h5>
                    <p class="fs-28 pt-2">Change Password</p>
                  </div>
                </div>
                <form @submit.prevent="updatePassword" class="mt-5 pt-3">
                  <div class="row g-3 px-3 pt-3">
                    <input type="text" name="username" hidden aria-hidden="true" autocomplete="username">
                    <div class="col">
                      <label for="current-password" class="form-label col-form-label-lg pb-0">Current Password</label>
                      <div class="position-relative">
                        <input v-model="updatePasswordData.currentPassword" :type="show.current ? 'text' : 'password'" class="form-control form-control-lg text-secondary" placeholder="Enter current password" aria-label="currentPassword" name="currentPassword" autocomplete="current-password">
                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3" @click="show.current = !show.current" style="border: none; background: none; z-index: 10; color: #6c757d;">
                          <i class="bi" :class="show.current ? 'bi-eye' : 'bi-eye-slash'" style="font-size: 18px;"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="row g-3 px-3 pt-3">
                    <div class="col-md-6">
                      <label for="New-password" class="form-label col-form-label-lg">New password</label>
                      <div class="position-relative">
                        <input v-model="updatePasswordData.newPassword" :type="show.new ? 'text' : 'password'" class="form-control form-control-lg text-secondary" placeholder="Enter new password" aria-label="New password" name="newPassword" autocomplete="new-password">
                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3" @click="show.new = !show.new" style="border: none; background: none; z-index: 10; color: #6c757d;">
                          <i class="bi" :class="show.new ? 'bi-eye' : 'bi-eye-slash'" style="font-size: 18px;"></i>
                        </button>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="colFormLabelLg" class="form-label col-form-label-lg">Repeat password</label>
                      <div class="position-relative">
                        <input v-model="updatePasswordData.newPassword_confirmation" :type="show.repeat ? 'text' : 'password'" class="form-control form-control-lg text-secondary" placeholder="Enter new password" aria-label="New password" name="newPassword_confirmation" autocomplete="new-password">
                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3" @click="show.repeat = !show.repeat" style="border: none; background: none; z-index: 10; color: #6c757d;">
                          <i class="bi" :class="show.repeat ? 'bi-eye' : 'bi-eye-slash'" style="font-size: 18px;"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="px-3 pt-4">
                    <hr class="text-secondary">
                  </div>
                  <!-- <div class="row g-3 px-3 pt-3">
                    <div class="col">
                      <label for="authentication" class="form-label col-form-label-lg">Two-factor authentication</label>
                      <select v-model="updatePasswordData.twoFactor" class="form-select form-select-lg mb-3 authentication text-secondary" aria-label="factor authentication" name="factor-authentication">
                        <option value="1">Enable</option>
                        <option value="2">Disable</option>
                      </select>
                    </div>
                  </div> -->
                  <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-primary rounded-2 fs-18 fw-6" aria-label="share-btn">Save</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- Social-tabs start -->
            <div class="tab-pane fade" id="v-pills-social-links" role="tabpanel"
              aria-labelledby="v-pills-social-links-tab" tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img :src="`/uploads/${userData.avatar}`" :alt="`${userData.name} Profile Picture`"
                      class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">{{ userData.name }}</a></h5>
                    <p class="fs-28 pt-2">Social Links</p>
                  </div>
                </div>
              </div>
              <form @submit.prevent="updateGeneralUserData" class="mt-5 pt-3">
                <div class="row g-3 px-3 ">
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="twitter-FormLabelLg" class="form-label col-form-label-lg mb-0 ">Twitter</label>
                    <input type="text" class="form-control form-control-lg twitter fs-16" placeholder="Add twitter link"
                      aria-label="twitter" v-model="userData.twitter">
                  </div>
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg mb-0">Linkedin</label>
                    <input type="text" class="form-control form-control-lg fs-16" placeholder="Add linkedin link"
                      aria-label="linkedIn" v-model="userData.linkedin">
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-12 pt-3 pt-md-0">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg">YouTube</label>
                    <input type="text" class="form-control form-control-lg fs-16" placeholder="Add youtube link"
                      aria-label="youtube" v-model="userData.youtube">
                  </div>
                </div>
                <div class="mt-4 text-center">
                  <button type="submit" class="btn btn-primary rounded-2 fs-18 fw-6">Save</button>
                </div>
              </form>
            </div>
            <!-- Notification-tabs start -->
            <div class="tab-pane fade" id="v-pills-notification-setting" role="tabpanel"
              aria-labelledby="v-pills-notification-setting-tab" tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img :src="`/uploads/${userData.avatar}`" :alt="`${userData.name} Profile Picture`"
                      class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">{{ userData.name }}</a></h5>
                    <p class="fs-28 pt-2">Notification</p>
                  </div>
                </div>

              </div>
              <div class="pt-5"></div>

              <div class="tab-content mx-3 pt-5">
                <div class="alerts">
                  <div class="d-flex align-items-center justify-content-between">
                    <div class="emailalerts-heading">
                      <h1 class="text-black fw-5 mb-0 fs-1">
                        Marketwatch Newsletter
                      </h1>
                    </div>
                    <div>
                      <span class="text-uppercase fs-18 fw-5">Subscribe</span>
                    </div>
                  </div>
                  <hr class="mt-2" />

                  <div class="alert_headings d-none d-lg-flex align-items-center justify-content-end">
                    <span>Email</span>
                    <span>Notification</span>
                  </div>
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">Need To Know</h2>
                      <p class="MarketWatch-p">
                        Need to know guide investor to the most important
                        ,insightful items required to chart a course ahead of
                        each trading day
                      </p>
                    </div>
                    <div class="alert_headings d-flex d-lg-none mt-4 align-items-center justify-content-center">
                      <span>Email</span>
                      <span>Notification</span>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <div>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                        </div>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                        <!-- <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox
                                              input</label> -->
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">Distributed Ledger</h2>
                      <p class="MarketWatch-p">
                        A distributed ledger is the consensus of replicated,
                        shared, and synchronized digital data that is
                        geographically spread (distributed) across many sites
                      </p>
                    </div>
                    <div class="alert_headings d-flex d-lg-none mt-4 align-items-center justify-content-center">
                      <span>Email</span>
                      <span>Notification</span>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <div>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                        </div>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">How to Invest</h2>
                      <p class="MarketWatch-p">
                        You can invest in Bitcoin directly by using one of the
                        major cryptocurrency exchanges, such as Coinbase or
                        Binance.
                      </p>
                    </div>
                    <div class="alert_headings d-flex d-lg-none mt-4 align-items-center justify-content-center">
                      <span>Notification</span>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">Bulletin</h2>
                      <p class="MarketWatch-p">
                        Get breaking News notification via email
                      </p>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <div>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                        </div>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">Personal Finance Daily</h2>
                      <p class="MarketWatch-p">
                        Top stories in personal financial
                      </p>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <div>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                        </div>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">The Moneyist</h2>
                      <p class="MarketWatch-p">
                        Welcome to MarketWatch's private Facebook community for
                        advice on money ethics and financial etiquette. The
                        Moneyist (aka Quentin Fottrell) will lead
                      </p>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <div>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                        </div>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">Need To Know</h2>
                      <p class="MarketWatch-p">
                        Need to know guide investor to the most important
                        ,insightful items required to chart a course ahead of
                        each trading day
                      </p>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <div>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                        </div>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">Need To Know</h2>
                      <p class="MarketWatch-p">
                        Need to know guide investor to the most important
                        ,insightful items required to chart a course ahead of
                        each trading day
                      </p>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <div>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                        </div>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">Need To Know</h2>
                      <p class="MarketWatch-p">
                        Need to know guide investor to the most important
                        ,insightful items required to chart a course ahead of
                        each trading day
                      </p>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <div>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                        </div>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div class="d-flex align-items-center justify-content-between pt-5">
                    <div class="emailalerts-heading">
                      <h1 class="text-black fw-5 mb-0 fs-1">
                        Barron's Newsletter
                      </h1>
                    </div>
                    <div>
                      <span class="text-uppercase fs-18 fw-5">Subscribe</span>
                    </div>
                  </div>
                  <hr class="mt-2" />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">Barron's Update</h2>
                      <p class="MarketWatch-p">
                        Need to know guide investor to the most important
                        ,insightful items required to chart a course ahead of
                        each trading day
                      </p>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <!-- <div>
                                          <button class=" text-uppercase btn-preview text-black">Preview</button>
                                      </div> -->
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">The Barron's Daily</h2>
                      <p class="MarketWatch-p">
                        Need to know guide investor to the most important
                        ,insightful items required to chart a course ahead of
                        each trading day
                      </p>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <div>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                        </div>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">Benta Weekly</h2>
                      <p class="MarketWatch-p">
                        Need to know guide investor to the most important
                        ,insightful items required to chart a course ahead of
                        each trading day
                      </p>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <div>
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                        </div>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />

                  <div class="d-flex align-items-center justify-content-between pt-5">
                    <div class="emailalerts-heading">
                      <h1 class="text-black fw-5 mb-0 fs-1">
                        Mansion Global Newsletter
                      </h1>
                    </div>
                    <div>
                      <span class="text-uppercase fs-18 fw-5">Subscribe</span>
                    </div>
                  </div>
                  <hr class="mt-2" />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">Daily Briefing</h2>
                      <p class="MarketWatch-p">
                        Need to know guide investor to the most important
                        ,insightful items required to chart a course ahead of
                        each trading day
                      </p>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <!-- <div>
                                          <button class=" text-uppercase btn-preview text-black">Preview</button>
                                      </div> -->
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">Week In Review</h2>
                      <p class="MarketWatch-p">
                        Need to know guide investor to the most important
                        ,insightful items required to chart a course ahead of
                        each trading day
                      </p>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <!-- <div>
                                          <button class=" text-uppercase btn-preview text-black">Preview</button>
                                      </div> -->
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">
                        Best of the Mansion Global Boutique
                      </h2>
                      <p class="MarketWatch-p">
                        Need to know guide investor to the most important
                        ,insightful items required to chart a course ahead of
                        each trading day
                      </p>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <!-- <div>
                                          <button class=" text-uppercase btn-preview text-black">Preview</button>
                                      </div> -->
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <div
                    class="d-lg-flex emailalerts-heading align-items-center justify-content-lg-between text-center text-lg-start MarketWatch-box">
                    <div>
                      <h2 class="astronaut-blue">
                        Dow Jones Updates and Special Offers
                      </h2>
                      <p class="MarketWatch-p">
                        Need to know guide investor to the most important
                        ,insightful items required to chart a course ahead of
                        each trading day
                      </p>
                    </div>
                    <div
                      class="d-flex pt-4 pt-lg-0 align-items-center justify-content-center justify-content-lg-start gap-5 switch-button">
                      <!-- <div>
                                          <button class=" text-uppercase btn-preview text-black">Preview</button>
                                      </div> -->
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div class="d-flex justify-content-end py-4">
                    <button class="btn-scrollbar text-white justify-content-between align-items-center gap-2"
                      id="scroll_TopBtn" onclick="scrollToTopBtn()">
                      Back To Top <span class="fs-13">▲</span>
                    </button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <h5 class="text-secondary fs-16">Email me when</h5>
                  </div>
                  <div class="col-md-9 pt-3 pt-md-0">
                    <div class="form-check round-check">
                      <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                        name="Completed-checkbox" id="email-check-1">
                      <label class="form-check-label fs-14 text-secondary cursor-pointer" for="email-check-1">
                        Someone liked my posts
                      </label>
                    </div>
                    <div class="form-check round-check pt-3">
                      <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                        name="Completed-checkbox" id="email-check-2">
                      <label class="form-check-label fs-14 text-secondary cursor-pointer" for="email-check-2">
                        Someone commented on my posts
                      </label>
                    </div>
                    <div class="form-check round-check pt-3">
                      <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                        name="Completed-checkbox" id="email-check-3">
                      <label class="form-check-label fs-14 text-secondary cursor-pointer" for="email-check-3">
                        Someone shared on my posts
                      </label>
                    </div>
                    <div class="form-check round-check pt-3">
                      <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                        name="Completed-checkbox" id="email-check-4">
                      <label class="form-check-label fs-14 text-secondary cursor-pointer" for="email-check-4">
                        Someone followed me
                      </label>
                    </div>
                    <div class="form-check round-check pt-3">
                      <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                        name="Completed-checkbox" id="email-check-5">
                      <label class="form-check-label fs-14 text-secondary cursor-pointer" for="email-check-5">
                        Someone mentioned me
                      </label>
                    </div>
                    <div class="form-check round-check pt-3">
                      <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                        name="Completed-checkbox" id="email-check-6">
                      <label class="form-check-label fs-14 text-secondary cursor-pointer" for="email-check-6">
                        Someone joined my chats
                      </label>
                    </div>
                    <div class="form-check round-check pt-3">
                      <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                        name="Completed-checkbox" id="email-check-7">
                      <label class="form-check-label fs-14 text-secondary cursor-pointer" for="email-check-7">
                        Someone accepted my friend/follow requset
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Membership-tabs start -->
            <div class="tab-pane fade" id="v-pills-membership" role="tabpanel" aria-labelledby="v-pills-membership-tab"
              tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img :src="`/uploads/${userData.avatar}`" :alt="`${userData.name} Profile Picture`"
                      class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">{{ userData.name }}</a></h5>
                    <p class="fs-28 pt-2">Membership</p>
                  </div>
                </div>

              </div>
              <div class="mt-5 member_ship_card_main">
                <div class="member_ship_card shadow-sm rounded p-3 bg-white m-3 border border-1">
                  <h2 class="text-secondary text-center fs-22">PAYMENT METHODS</h2>
                  <div class="border-heading m-auto my-4"></div>
                  <div class="member-card-main pt-4 pb-2">
                    <table border="1">
                      <thead>
                        <tr>
                          <th>Card Type</th>
                          <th>Name on Card</th>
                          <th>Card Number</th>
                          <th>Expiration</th>
                        </tr>
                      </thead>
                      <tbody v-if="userPaymentMethod">
                        <tr v-for="(method, index) in userPaymentMethod" :key="index">
                          <td>{{ method.card.brand }}</td>
                          <td>{{ method.billing_details.name }}</td>
                          <td>************{{ method.card.last4 }}</td>
                          <td>{{ method.card.exp_month }} / {{ method.card.exp_year }}</td>
                        </tr>
                      </tbody>
                      <tfoot v-else>
                        <tr>
                          <td colspan="5" class="text-center py-6">
                            <p class="no_payment">No payment methods to show</p>
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                    <button v-if="userPaymentMethod" class="btn btn-primary update_card" type="button"
                      data-bs-toggle="modal" data-bs-target="#updateCard"> Update Card</button>
                  </div>
                </div>
                <div class="member_ship_card shadow-sm rounded p-4 bg-white m-3 border border-1">
                  <h2 class="text-secondary text-center fs-22 ">MY MEMBERSHIP</h2>
                  <div class="border-heading m-auto my-4 text-secondary"></div>
                  <div class="member-card-main pt-3">
                    <table border="1">
                      <thead>
                        <tr>
                          <th>Plan</th>
                          <th>Subscription Started</th>
                          <th>Expiration Date</th>
                          <!-- <th>Amount</th>
                          <th>Transaction Type</th> -->
                          <th>Status</th>
                          <th>Cancel</th>
                        </tr>
                      </thead>
                      <tbody v-if="userSubscriptions">
                        <tr v-for="Subscription in userSubscriptions" :key="userSubscriptions.id">
                          <td>{{ Subscription.name }}</td>
                          <td>{{ new Date(Subscription.created_at).toLocaleString() }}</td>
                          <td v-if="Subscription.stripe_status === 'active'">
                            {{ Subscription.ends_at ? new Date(Subscription.ends_at).toLocaleString() : 'Never' }}
                          </td>
                          <td v-else-if="Subscription.stripe_status == 'incomplete'">
                            Pending
                          </td>
                          <td v-else>Expired</td>
                          <!-- <td>{{ Subscription.name }}</td>
                          <td>{{ Subscription.name }}</td> -->
                          <td>
                            {{ Subscription.ends_at != null && Subscription.stripe_status == 'active' ? 'Expiring Soon'
                    : Subscription.stripe_status }}</td>
                          <td v-if="Subscription.stripe_status == 'active' && Subscription.ends_at == null">
                            <a @click="showConfirmModel" class="subscription_cancel btn btn-primary">Cancel
                              Subscription</a>

                          </td>

                        </tr>
                      </tbody>
                      <p v-else>No Subscriptions</p>
                    </table>
                    <div class="modal fade" id="exampleModal" ref="confirm_popup" tabindex="-1"
                      aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure you want to cancel your
                              subscription?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="button" class="btn btn-primary"
                              @click="cancelSubscription(userSubscriptions[0].name)">Yes</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Upcoming invoices -->
                <div class="member_ship_card shadow-sm rounded p-3 bg-white m-3 border border-1">
                  <h2 class="text-secondary text-center fs-22 ">Upcoming INVOICES</h2>
                  <div class="border-heading m-auto my-4 text-secondary"></div>
                  <div class="member-card-main pt-4 pb-2">
                    <table border="1">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Plan Type</th>
                          <th>Amount</th>
                          <th>Transaction Type</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody v-if="upcomingInvoices.length > 0">
                        <tr :key="upcomingInvoices.id">
                          <td>{{ formatDate(upcomingInvoices.created) }}</td>
                          <td>
                            <ul>
                              <li v-for="lineItem in upcomingLineData" :key="lineItem.id">
                                {{ lineItem.description }}
                              </li>
                            </ul>
                          </td>
                          <td>
                            ${{ (upcomingInvoices.amount_due / 100).toFixed(2) }}
                          </td>
                          <td>{{ upcomingInvoices.billing_reason }}</td>
                          <td>{{ upcomingInvoices.paid ? 'Paid' : 'Pending' }}</td>
                        </tr>
                      </tbody>
                      <tfoot v-else>
                        <tr>
                          <td colspan="5" class="text-center py-6">
                            <p class="no_invoices">No upcoming invoices to show</p>
                          </td>
                        </tr>
                      </tfoot>

                    </table>
                  </div>
                </div>
                <!-- Past invoices -->
                <div class="member_ship_card shadow-sm rounded p-3 bg-white m-3 border border-1">
                  <h2 class="text-secondary text-center fs-22 ">PAST INVOICES</h2>
                  <div class="border-heading m-auto my-4 text-secondary"></div>
                  <div class="member-card-main pt-4 pb-2  past_invoice">
                    <table border="1">
                      <thead>
                        <tr>
                          <th># Invoice Id</th>
                          <th>Date</th>
                          <th>Plan Type</th>
                          <th>Amount</th>
                          <th>Transaction Type</th>
                          <th>Status</th>
                          <th>Download Invoice</th>
                        </tr>
                      </thead>
                      <tbody v-if="pastInvoices">
                        <tr v-for="invoice in pastInvoices" :key="invoice.id">
                          <td>{{ invoice.id }}</td>
                          <td>{{ formatDate(invoice.created) }}</td>
                          <td>
                            <ul>
                              <li v-for="lineItem in invoice.lines.data" :key="lineItem.id">
                                {{ lineItem.description }}
                              </li>
                            </ul>
                          </td>
                          <td>
                            {{ invoice.paid ? '$' + (invoice.amount_paid / 100).toFixed(2) : '$' +
                    (invoice.amount_remaining / 100).toFixed(2) }}
                          </td>
                          <td>{{ invoice.billing_reason }}</td>
                          <td>{{ invoice.paid ? 'Paid' : 'Pending' }}</td>
                          <td><a :href="invoice.invoice_pdf" target="_blank"
                              class="download btn btn-primary">Download</a></td>
                        </tr>
                      </tbody>
                      <p v-else>No past invoices to show</p>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- Repeat this structure for the rest -->

          </div>
        </div>
        <div class="col-lg-3 mt-5 mt-lg-0">
          <div class="nav flex-column border-0 shadow rounded bg-white" id="general-setting-Tab">
            <div class="nav flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <button class="nav-link active text-start" id="v-pills-setting-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-setting" type="button" role="tab" aria-controls="v-pills-setting"
                aria-selected="true">
                <i class="bi bi-gear-fill pe-3 fs-18 align-middle"></i>General Setting
              </button>
              <div class="collapse-tabs">
                <p class="mb-0">
                  <a class="btn d-flex align-items-center border-0 px-3" @click="toggleCollapse" role="button"
                    ref="collapseToggle">
                    <i class="bi bi-shield-fill-check pe-3 fs-18"></i>
                    <span class="d-flex justify-content-between w-100">
                      <span>Security</span>
                      <i class="bi bi-chevron-down fs-18 align-middle"></i>
                    </span>
                  </a>
                </p>
                <div class="collapse" id="collapseSecurity" ref="collapseContent">
                  <div class="card card-body p-0 shadow-none">
                    <button class="nav-link text-start" id="v-pills-privacy-tab" data-bs-toggle="pill"
                      data-bs-target="#v-pills-privacy" type="button" role="tab" aria-controls="v-pills-privacy"
                      aria-selected="false">Privacy</button>
                    <button class="nav-link text-start" id="v-pills-password-tab" data-bs-toggle="pill"
                      data-bs-target="#v-pills-password" type="button" role="tab" aria-controls="v-pills-password"
                      aria-selected="false">Password</button>
                  </div>
                </div>
              </div>

              <button class="nav-link text-start" id="v-pills-social-links-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-social-links" type="button" role="tab" aria-controls="v-pills-social-links"
                aria-selected="false"><i class="bi bi-twitter-x pe-3 fs-18 align-middle"></i>Social Links</button>
              <!-- <button class="nav-link text-start" id="v-pills-notification-setting-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-notification-setting" type="button" role="tab"
                aria-controls="v-pills-notification-setting" aria-selected="false"><i
                  class="bi bi-bell-fill pe-3 fs-18 align-middle"></i>Notification Setting</button> -->
              <button class="nav-link text-start" id="v-pills-membership-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-membership" type="button" role="tab" aria-controls="v-pills-membership"
                aria-selected="false"><i class="bi bi-person-lines-fill pe-3 fs-18 align-middle"></i>Membership</button>
              <!-- Repeat this structure for the rest of your tabs -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- update car popup -->

  <div class="modal fade" id="updateCard" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Update Your Payment Method</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="handleSubmit" id="UpdatePaymentMethod">
            <div class="mb-3">
              <label>Enter Card Holder Name</label>
              <input type="text" v-model="formData.cardHolderName" id="cardHolderName" name="cardHolderName"
                class="form-control border  shadow-sm" placeholder="Card holder name">
            </div>

            <!-- Payment Method Element -->
            <label for="card-element">Credit or Debit Card</label>
            <div id="card-element">
              <!-- A Stripe Element will be inserted here. -->
            </div>

            <!-- Form submission -->
            <button type="submit" id="submit-button" data-bs-dismiss="modal" class="btn btn-primary mt-4">UPDATE
              CARD</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { loadStripe } from '@stripe/stripe-js';
import { mapState } from 'vuex';
import { Modal, Collapse } from 'bootstrap';
import { getNames } from 'country-list';
import Swal from 'sweetalert2';
export default {
  computed: {
    ...mapState(['userData']),
    isProfileComplete() {
      // Check if all required profile fields are filled
      const hasCustomAvatar = this.userData?.avatar && this.userData.avatar !== 'photos/d-avatar.jpg';
      const hasCustomCover = this.userData?.cover && this.userData.cover !== 'photos/d-cover.jpg';
      const hasSocialLinks = !!(this.userData?.twitter || this.userData?.linkedin || this.userData?.youtube);
      const hasPhoneNumber = !!this.userData?.phone_number;
      const hasAbout = !!this.userData?.about;
      
      return hasCustomAvatar && hasCustomCover && hasSocialLinks && hasPhoneNumber && hasAbout;
    },
  },
  data() {
    return {
      userSubscriptions: [],
      pastInvoices: [],
      upcomingInvoices: [],
      upcomingLineData: [],
      userPaymentMethod: [],
      formData: {
        cardHolderName: '',
        payment_method: '',
      },
      countries: getNames(),
      privacySettings: {
        // Default all privacy controls to "Everyone"
        post_privacy: 'Everyone',
        groups_privacy: 'Everyone',
        watchlists_privacy: 'Everyone',
        photos_privacy: 'Everyone',
      },
      updatePasswordData: {
        currentPassword: '',
        newPassword: '',
        newPassword_confirmation: '',
        // twoFactor: '1',
      },
      show: { current: false, new: false, repeat: false },
    };
  },
  mounted() {
    this.getInvoices();
    this.stripePaymentMethod();
    this.loadPrivacySettings();
    this.confirmModalInstance = new Modal(this.$refs.confirm_popup, { backdrop: 'static' });
  },
  methods: {
    toggleCollapse() {
      const collapseElement = this.$refs.collapseContent;
      const collapseInstance = Collapse.getOrCreateInstance(collapseElement);
      collapseInstance.toggle();
    },
    updateGeneralUserData() {
      this.$store.dispatch('updateUserData', this.userData);
    },
    showConfirmModel() {
      if (this.confirmModalInstance) {
        this.confirmModalInstance.show();
      } else {
        console.error('Modal instance is not initialized.');
      }
    },
    async getInvoices() {
      try {
        const response = await axios.get('/api/subscriptionInvoices');
        this.userSubscriptions = response.data.Invoices.allUserSubscriptions || [];
        this.pastInvoices = response.data.Invoices.previousInvoices || [];
        this.upcomingInvoices = response.data.Invoices.upcomingInvoice || [];
        if (this.upcomingInvoices && this.upcomingInvoices.lines && this.upcomingInvoices.lines.data) {
          this.upcomingLineData = this.upcomingInvoices.lines.data;
        } else {
          this.upcomingLineData = [];
        }
        this.userPaymentMethod = response.data.Invoices.paymentMethods || [];
      } catch (error) {
        console.error('Error fetching data:', error);
        // Handle error appropriately
      }
    },
    async cancelSubscription(subscriptionName) {
      try {
        const response = await axios.post(`/api/cancelSubscription/${subscriptionName}`);
        this.getInvoices();
        this.confirmModalInstance.hide();
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          width: "400px",
          timer: 1000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        Toast.fire({
          icon: "success",
          title: "Card remove successfully"
        });
      } catch (error) {
        console.error('Error removing card:', error);
        // Handle error appropriately
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          width: "400px",
          timer: 1000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        Toast.fire({
          icon: "error",
          title: "Error removing card"
        });
      }
    },
    formatDate(timestamp) {
      return new Date(timestamp * 1000).toLocaleString();
    },
    stripePaymentMethod() {
      var stripePromise = loadStripe('pk_test_51Hwe7XJYG6q3yq60zNuah9X3DSCMF4142Y43Ufsz2KlZJpz1cLTKzrMkUMlFB3OATwluVbqWdzqrp2unJOAUt5Gg00EipuAVQa');

      stripePromise.then(stripe => {
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');
        var cardElementContainer = document.getElementById('card-element'); cardElementContainer.style.border = '1px solid #ddd7d7'; cardElementContainer.style.padding = '10px'; cardElementContainer.style.borderRadius = '4px'; cardElementContainer.style.boxShadow = '0 1px 1px rgba(0, 0, 0, .05)';
        var form = document.getElementById('UpdatePaymentMethod');
        form.addEventListener('submit', async (event) => {
          event.preventDefault();
          const { paymentMethod, error } = await stripe.createPaymentMethod('card', card, {
            billing_details: { name: this.formData.cardHolderName }
          });
          var paymentMethodID = paymentMethod.id;

          // Submit the form
          if (error) {
            alert(error.message);
          } else {
            this.stripePaymentMethodHandler(paymentMethodID);
          }
        });
      });
    },
    stripePaymentMethodHandler(paymentMethodId) {
      var form = document.getElementById('UpdatePaymentMethod');
      var paymentMethodInput = document.createElement('input');
      paymentMethodInput.setAttribute('type', 'hidden');
      paymentMethodInput.setAttribute('name', 'payment_method');
      paymentMethodInput.setAttribute('value', paymentMethodId);
      form.appendChild(paymentMethodInput);
      this.formData.payment_method = paymentMethodId;
      if (!paymentMethodId) {
        console.error('Invalid payment method ID');
      } else {
        axios.post(`/api/updatePaymentMethod/`, this.formData)
          .then(response => {
          })
          .catch(error => {
            console.error('Error:', error);
          });
      }
    },
    loadPrivacySettings() {
      const normalize = (value) => {
        const v = (value || '').toString();
        if (['Everyone', 'Public', 'public', 'anyone', 'Anyone'].includes(v)) return 'Everyone';
        if (['Followers', 'followers', 'Friends'].includes(v)) return 'Followers';
        if (['Private', 'private', 'Only Me'].includes(v)) return 'Private';
        return 'Everyone';
      };

      this.privacySettings = {
        // Normalize possible legacy or variant values
        post_privacy: normalize(this.userData.post_privacy),
        groups_privacy: normalize(this.userData.groups_privacy),
        watchlists_privacy: normalize(this.userData.watchlists_privacy),
        photos_privacy: normalize(this.userData.photos_privacy),
      };
    },
    async updatePrivacySettings() {
      try {
        const response = await axios.post('/api/privacy-settings', this.privacySettings);
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          width: "400px",
          timer: 1000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        Toast.fire({
          icon: "success",
          title: "Privacy settings updated successfully"
        });
      } catch (error) {
        // console.error('Error updating privacy settings:', error);
        // alert('An error occurred. Please try again.');
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          width: "400px",
          timer: 1000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        Toast.fire({
          icon: "error",
          title: "Error updating privacy settings"
        });
      }
    },
    async updatePassword() {
      try {
        const response = await axios.post('/api/update-password', this.updatePasswordData);
        // alert(response.data.message);
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          width: "400px",
          timer: 1000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        Toast.fire({
          icon: "success",
          title: "Password updated successfully"
        });
      } catch (error) {
        if (error.response && error.response.data.errors) {
          // alert(Object.values(error.response.data.errors).join('\n'));
          Toast.fire({
          icon: "error",
          title: "Error updating password"
        });
        } else {
          // alert('An error occurred. Please try again.');
          Toast.fire({
          icon: "error",
          title: "Error updating password"
        });
        }
      }
    },
  },
};
</script>
<style>
.member_ship_card_main table,
.member_ship_card_main th,
.member_ship_card_main td,
.member_ship_card_main tr {
  border: 1px solid #000 !important;
  padding: 8px 12px;
}

.member_ship_card_main table {
  width: 100%;
}

.text-secondary {
  color: var(--cta-btn) !important;
}

.member_ship_card_main th {
  font: 600 16px/28px Poppins;
  color: #000;
}

p.no_payment,
.no_invoices {
  font: 600 16px/28px Poppins;
  color: #000;
  margin: 0px;
  padding: 10px
}

.update_card {
  display: block;
  margin: auto;
  margin-top: 20px;
}

.past_invoice {
  overflow: auto;
}

.past_invoice table {
  min-width: 1250px
}

a.subscription_cancel,
a.download {
  font: 600 12px /20px poppins;
  text-align: center;
  display: block;
  cursor: pointer;
  max-width: max-content;
  padding: 5px 11px;
  margin: auto;
}

.member_ship_card_main table ul {
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 7px;
}

.border {
  border-color: #dfdfdf !important;
}

.alert_headings span {
  font: 600 15px /25px poppins;
}

.alert_headings {
  gap: 30px;
}
</style>