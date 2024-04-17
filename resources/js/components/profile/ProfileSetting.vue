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
              <form action="" class="mt-5 pt-3">
                <div class="row g-3 px-3 ">
                  <div class="col-md-6">
                    <label for="username-lable" class="form-label col-form-label-lg">Username</label>
                    <input type="text" class="form-control form-control-lg" placeholder="Enter username" name="user-name"
                      aria-label="username" :value="userData.name" disabled>
                  </div>
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="Phone-lable" class="form-label col-form-label-lg">Phone</label>
                    <input type="text" class="form-control form-control-lg" placeholder="Enter phone number"
                      name="phone-number" aria-label="phone-number" :value="userData.phone_number">
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-6">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg">First
                      name</label>
                    <input type="text" class="form-control form-control-lg first-name" id="fname" name="fname"
                      placeholder="Enter first name" aria-label="fname" :value="userData.first_name">
                  </div>
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg">Last
                      name</label>
                    <input type="text" class="form-control form-control-lg" placeholder="Enter ast name"
                      aria-label="lname" :value="userData.last_name">
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col">
                    <label for="email-lable" class="form-label col-form-label-lg">E-mail</label>
                    <input type="email" class="form-control form-control-lg email" name="email" placeholder="Enter email"
                      aria-label="Email" :value="userData.email" disabled>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-12">
                    <label for="aboutme" class="form-label col-form-label-lg">About me</label>
                    <textarea class="form-control form-control-lg" placeholder="Describe yourself here..."
                      name="about">{{ userData.about }}</textarea>
                  </div>
                </div>
                <div class="row g-3 px-3  pt-3">
                  <div class="col-md-6">
                    <label for="Gender" class="form-label col-form-label-lg">Gender</label>
                    <select class="form-select form-select-lg mb-3" aria-label="Gender">
                      <option value="1" :selected="userData.gender === 'male'">Male</option>
                      <option value="2" :selected="userData.gender === 'female'">Female</option>
                      <option value="2" :selected="userData.gender === 'other'">Other</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="pro_type" class="form-label col-form-label-lg">Member Type</label>
                    <input type="text" class="form-control form-control-lg" name="pro_type" aria-label="pro_type"
                      :value="`${userData.subscription_plan} Member`" disabled>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-6">
                    <label for="Birthday-lable" class="form-label col-form-label-lg">Birthday</label>
                    <input type="date" class="form-control form-control-lg" name="birthday?" aria-label="birthday"
                      :value="userData.birthday">
                  </div>
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="countrySelect-lable" class="form-label col-form-label-lg">Country</label>
                    <select id="inputState" class="form-select form-select-lg Country_Seclect">
                      <option value="0">Select Country</option>
                      <option value="1">United States</option>
                      <option value="2">Canada</option>
                      <option value="3">Afghanistan</option>
                      <option value="4">Albania</option>
                      <option value="5">Algeria</option>
                      <option value="6">American Samoa</option>
                      <option value="7">Andorra</option>
                      <option value="8">Angola</option>
                      <option value="9">Anguilla</option>
                      <option value="10">Antarctica</option>
                      <option value="11">Antigua and/or Barbuda</option>
                      <option value="12">Argentina</option>
                      <option value="13">Armenia</option>
                      <option value="14">Aruba</option>
                      <option value="15">Australia</option>
                      <option value="16">Austria</option>
                      <option value="17">Azerbaijan</option>
                      <option value="18">Bahamas</option>
                      <option value="19">Bahrain</option>
                      <option value="20">Bangladesh</option>
                      <option value="21">Barbados</option>
                      <option value="22">Belarus</option>
                      <option value="23">Belgium</option>
                      <option value="24">Belize</option>
                      <option value="25">Benin</option>
                      <option value="26">Bermuda</option>
                      <option value="27">Bhutan</option>
                      <option value="28">Bolivia</option>
                      <option value="29">Bosnia and Herzegovina</option>
                      <option value="30">Botswana</option>
                      <option value="31">Bouvet Island</option>
                      <option value="32">Brazil</option>
                      <option value="34">Brunei Darussalam</option>
                      <option value="35">Bulgaria</option>
                      <option value="36">Burkina Faso</option>
                      <option value="37">Burundi</option>
                      <option value="38">Cambodia</option>
                      <option value="39">Cameroon</option>
                      <option value="40">Cape Verde</option>
                      <option value="41">Cayman Islands</option>
                      <option value="42">Central African Republic</option>
                      <option value="43">Chad</option>
                      <option value="44">Chile</option>
                      <option value="45">China</option>
                      <option value="46">Christmas Island</option>
                      <option value="47">Cocos (Keeling) Islands</option>
                      <option value="48">Colombia</option>
                      <option value="49">Comoros</option>
                      <option value="50">Congo</option>
                      <option value="51">Cook Islands</option>
                      <option value="52">Costa Rica</option>
                      <option value="53">Croatia (Hrvatska)</option>
                      <option value="54">Cuba</option>
                      <option value="55">Cyprus</option>
                      <option value="56">Czech Republic</option>
                      <option value="57">Denmark</option>
                      <option value="58">Djibouti</option>
                      <option value="59">Dominica</option>
                      <option value="60">Dominican Republic</option>
                      <option value="61">East Timor</option>
                      <option value="62">Ecuador</option>
                      <option value="63">Egypt</option>
                      <option value="64">El Salvador</option>
                      <option value="65">Equatorial Guinea</option>
                      <option value="66">Eritrea</option>
                      <option value="67">Estonia</option>
                      <option value="68">Ethiopia</option>
                      <option value="69">Falkland Islands (Malvinas)</option>
                      <option value="70">Faroe Islands</option>
                      <option value="71">Fiji</option>
                      <option value="72">Finland</option>
                      <option value="73">France</option>
                      <option value="74">France, Metropolitan</option>
                      <option value="75">French Guiana</option>
                      <option value="76">French Polynesia</option>
                      <option value="77">French Southern Territories</option>
                      <option value="78">Gabon</option>
                      <option value="79">Gambia</option>
                      <option value="80">Georgia</option>
                      <option value="81">Germany</option>
                      <option value="82">Ghana</option>
                      <option value="83">Gibraltar</option>
                      <option value="84">Greece</option>
                      <option value="85">Greenland</option>
                      <option value="86">Grenada</option>
                      <option value="87">Guadeloupe</option>
                      <option value="88">Guam</option>
                      <option value="89">Guatemala</option>
                      <option value="90">Guinea</option>
                      <option value="91">Guinea-Bissau</option>
                      <option value="92">Guyana</option>
                      <option value="93">Haiti</option>
                      <option value="94">Heard and Mc Donald Islands</option>
                      <option value="95">Honduras</option>
                      <option value="96">Hong Kong</option>
                      <option value="97">Hungary</option>
                      <option value="98">Iceland</option>
                      <option value="99">India</option>
                      <option value="100">Indonesia</option>
                      <option value="101">Iran (Islamic Republic of)</option>
                      <option value="102">Iraq</option>
                      <option value="103">Ireland</option>
                      <option value="104">Israel</option>
                      <option value="105">Italy</option>
                      <option value="106">Ivory Coast</option>
                      <option value="107">Jamaica</option>
                      <option value="108">Japan</option>
                      <option value="109">Jordan</option>
                      <option value="110">Kazakhstan</option>
                      <option value="111">Kenya</option>
                      <option value="112">Kiribati</option>
                      <option value="113">Korea, Democratic People's Republic of</option>
                      <option value="114">Korea, Republic of</option>
                      <option value="115">Kosovo</option>
                      <option value="116">Kuwait</option>
                      <option value="117">Kyrgyzstan</option>
                      <option value="118">Lao People's Democratic Republic</option>
                      <option value="119">Latvia</option>
                      <option value="120">Lebanon</option>
                      <option value="121">Lesotho</option>
                      <option value="122">Liberia</option>
                      <option value="123">Libyan Arab Jamahiriya</option>
                      <option value="124">Liechtenstein</option>
                      <option value="125">Lithuania</option>
                      <option value="126">Luxembourg</option>
                      <option value="127">Macau</option>
                      <option value="128">Macedonia</option>
                      <option value="129">Madagascar</option>
                      <option value="130">Malawi</option>
                      <option value="131">Malaysia</option>
                      <option value="132">Maldives</option>
                      <option value="133">Mali</option>
                      <option value="134">Malta</option>
                      <option value="135">Marshall Islands</option>
                      <option value="136">Martinique</option>
                      <option value="137">Mauritania</option>
                      <option value="138">Mauritius</option>
                      <option value="139">Mayotte</option>
                      <option value="140">Mexico</option>
                      <option value="141">Micronesia, Federated States of</option>
                      <option value="142">Moldova, Republic of</option>
                      <option value="143">Monaco</option>
                      <option value="144">Mongolia</option>
                      <option value="145">Montenegro</option>
                      <option value="146">Montserrat</option>
                      <option value="147">Morocco</option>
                      <option value="148">Mozambique</option>
                      <option value="149">Myanmar</option>
                      <option value="150">Namibia</option>
                      <option value="151">Nauru</option>
                      <option value="152">Nepal</option>
                      <option value="153">Netherlands</option>
                      <option value="154">Netherlands Antilles</option>
                      <option value="155">New Caledonia</option>
                      <option value="156">New Zealand</option>
                      <option value="157">Nicaragua</option>
                      <option value="158">Niger</option>
                      <option value="159">Nigeria</option>
                      <option value="160">Niue</option>
                      <option value="161">Norfork Island</option>
                      <option value="162">Northern Mariana Islands</option>
                      <option value="163">Norway</option>
                      <option value="164">Oman</option>
                      <option value="165" selected>Pakistan</option>
                      <option value="166">Palau</option>
                      <option value="167">Panama</option>
                      <option value="168">Papua New Guinea</option>
                      <option value="169">Paraguay</option>
                      <option value="170">Peru</option>
                      <option value="171">Philippines</option>
                      <option value="172">Pitcairn</option>
                      <option value="173">Poland</option>
                      <option value="174">Portugal</option>
                      <option value="175">Puerto Rico</option>
                      <option value="176">Qatar</option>
                      <option value="177">Reunion</option>
                      <option value="178">Romania</option>
                      <option value="179">Russian Federation</option>
                      <option value="180">Rwanda</option>
                      <option value="181">Saint Kitts and Nevis</option>
                      <option value="182">Saint Lucia</option>
                      <option value="183">Saint Vincent and the Grenadines</option>
                      <option value="184">Samoa</option>
                      <option value="185">San Marino</option>
                      <option value="186">Sao Tome and Principe</option>
                      <option value="187">Saudi Arabia</option>
                      <option value="188">Senegal</option>
                      <option value="189">Serbia</option>
                      <option value="190">Seychelles</option>
                      <option value="191">Sierra Leone</option>
                      <option value="192">Singapore</option>
                      <option value="193">Slovakia</option>
                      <option value="194">Slovenia</option>
                      <option value="195">Solomon Islands</option>
                      <option value="196">Somalia</option>
                      <option value="197">South Africa</option>
                      <option value="198">South Georgia South Sandwich Islands</option>
                      <option value="199">Spain</option>
                      <option value="200">Sri Lanka</option>
                      <option value="201">St. Helena</option>
                      <option value="202">St. Pierre and Miquelon</option>
                      <option value="203">Sudan</option>
                      <option value="204">Suriname</option>
                      <option value="205">Svalbarn and Jan Mayen Islands</option>
                      <option value="206">Swaziland</option>
                      <option value="207">Sweden</option>
                      <option value="208">Switzerland</option>
                      <option value="209">Syrian Arab Republic</option>
                      <option value="210">Taiwan</option>
                      <option value="211">Tajikistan</option>
                      <option value="212">Tanzania, United Republic of</option>
                      <option value="213">Thailand</option>
                      <option value="214">Togo</option>
                      <option value="215">Tokelau</option>
                      <option value="216">Tonga</option>
                      <option value="217">Trinidad and Tobago</option>
                      <option value="218">Tunisia</option>
                      <option value="219">Turkey</option>
                      <option value="220">Turkmenistan</option>
                      <option value="221">Turks and Caicos Islands</option>
                      <option value="222">Tuvalu</option>
                      <option value="223">Uganda</option>
                      <option value="224">Ukraine</option>
                      <option value="225">United Arab Emirates</option>
                      <option value="226">United Kingdom</option>
                      <option value="227">United States minor outlying islands</option>
                      <option value="228">Uruguay</option>
                      <option value="229">Uzbekistan</option>
                      <option value="230">Vanuatu</option>
                      <option value="231">Vatican City State</option>
                      <option value="232">Venezuela</option>
                      <option value="233">Vietnam</option>
                      <option value="238">Yemen</option>
                      <option value="239">Yugoslavia</option>
                      <option value="240">Zaire</option>
                      <option value="241">Zambia</option>
                      <option value="242">Zimbabwe</option>
                      <option value="243">Palestine</option>
                    </select>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-6">
                    <label for="username-lable" class="form-label col-form-label-lg">City</label>
                    <input type="text" class="form-control form-control-lg" placeholder="Enter city" name="City"
                      aria-label="User City" :value="userData.city">
                  </div>
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="zip-lable" class="form-label col-form-label-lg">Zip</label>
                    <input type="text" class="form-control form-control-lg" placeholder="Enter Zip" name="zip"
                      aria-label="zip" :value="userData.zip">
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-12">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg mb-0">Website</label>
                    <input type="text" class="form-control form-control-lg" name="Website" id="gen-Website"
                      placeholder="https://richtv.io/" aria-label="Website" :value="userData.website">
                  </div>

                </div>
                <div class="mt-4 text-center">
                  <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6 " aria-label="share-btn">Save</a>
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
              <form action="" class="mt-5 pt-3">

                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Status</p>
                  </div>
                  <div class="col-12 col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg fs-16 mb-3 status_privacy" aria-label="status_privacy"
                      id="status_privacy">
                      <option value="1" :selected="userData.status === 'active'">Online</option>
                      <option value="2" :selected="userData.status === 'inactive'">offline</option>
                    </select>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Allow search engines to index my profile and
                      posts?</p>
                  </div>
                  <div class="col-12 col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg fs-16 mb-3 post_privacy" aria-label="post_privacy"
                      id="post_privacy">
                      <option value="1" selected>Everyone</option>
                      <option value="2">Friend</option>
                      <option value="2">No body</option>
                    </select>
                  </div>
                </div>
                <div class="mt-4 text-center">
                  <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6 " aria-label="share-btn">Save</a>
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
                <form action="" class="mt-5 pt-3">
                  <div class="row g-3 px-3 pt-3">
                    <input type="text" name="username" hidden aria-hidden="true" autocomplete="username">
                    <div class="col">
                      <label for="current-password" class="form-label col-form-label-lg pb-0">Current Password</label>
                      <input type="password" class="form-control form-control-lg text-secondary"
                        placeholder="Enter current password" aria-label="currentPassword" name="currentPassword" autocomplete="current-password">
                    </div>
                  </div>
                  <div class="row g-3 px-3 pt-3">
                    <div class="col-md-6">
                      <label for="New-password" class="form-label col-form-label-lg">New
                        password</label>
                      <input type="password" class="form-control form-control-lg text-secondary"
                        placeholder="Enter new password" aria-label="New password" name="NewPassword" autocomplete="new-password">
                    </div>
                    <div class="col-md-6">
                      <label for="colFormLabelLg" class="form-label col-form-label-lg">Repeat
                        password</label>
                      <input type="password" class="form-control form-control-lg text-secondary"
                        placeholder="Enter new password" aria-label="New password" name="NewPassword" autocomplete="new-password">
                    </div>
                  </div>
                  <div class="px-3 pt-4">
                    <hr class="text-secondary">
                  </div>
                  <div class="row g-3 px-3 pt-3">
                    <div class="col">
                      <label for="authentication" class="form-label col-form-label-lg">Two-factor
                        authentication</label>
                      <select class="form-select form-select-lg mb-3 authentication text-secondary"
                        aria-label="factor authentication" name="factor-authentication">
                        <option value="1" selected>Enable</option>
                        <option value="2">Disable</option>
                      </select>
                    </div>

                  </div>
                  <div class="mt-4 text-center">
                    <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6 " aria-label="share-btn">Save</a>
                  </div>
                </form>
              </div>
            </div>
            <!-- Manages-tabs start -->
            <div class="tab-pane fade" id="v-pills-manage" role="tabpanel" aria-labelledby="v-pills-manage-tab"
              tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img :src="`/uploads/${userData.avatar}`" :alt="`${userData.name} Profile Picture`"
                      class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">{{ userData.name }}</a></h5>
                    <p class="fs-28 pt-2">Manage Session </p>
                  </div>
                </div>
                <div class="manage_main_section  mt-5 mx-2 mx-sm-0">
                  <div class="d-flex justify-content-between mt-2 mx-sm-2 p-sm-3 p-2   border-bottom mange-main">
                    <div class="d-flex gap-sm-3 g-2 ">
                      <div class="pt-sm-2 pt-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24">
                          <path fill="#00adef"
                            d="M3,12V6.75L9,5.43V11.91L3,12M20,3V11.75L10,11.9V5.21L20,3M3,13L9,13.09V19.9L3,18.75V13M20,13.25V22L10,20.09V13.1L20,13.25Z">
                          </path>
                        </svg></div>
                      <div class="manage-left-side">
                        <h4 class="fs-18 mb-1">Windows</h4>
                        <p class="mb-1 d-flex align-items-center gap-1 fs-16"><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M21,3H3A2,2 0 0,0 1,5V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V5A2,2 0 0,0 21,3M21,19H3V5H13V9H21V19Z">
                              </path>
                            </svg> Google Chrome</span><span class="middot fs-26 d-inline-block">·</span><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z">
                              </path>
                            </svg> Now</span></p>
                        <p>IP Address: 139.135.53.113</p>
                      </div>
                    </div>
                    <div class="manage_logout">
                      <button class="border-0  bg-light-grey rounded-circle"><svg xmlns="http://www.w3.org/2000/svg"
                          width="18" height="18" viewBox="0 0 24 24">
                          <path fill="currentColor"
                            d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z">
                          </path>
                        </svg></button>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between mt-2 mx-sm-2 p-sm-3 p-2   border-bottom mange-main">
                    <div class="d-flex gap-sm-3 g-2 ">
                      <div class="pt-sm-2 pt-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24">
                          <path fill="#00adef"
                            d="M3,12V6.75L9,5.43V11.91L3,12M20,3V11.75L10,11.9V5.21L20,3M3,13L9,13.09V19.9L3,18.75V13M20,13.25V22L10,20.09V13.1L20,13.25Z">
                          </path>
                        </svg></div>
                      <div class="manage-left-side">
                        <h4 class="fs-18 mb-1">Windows</h4>
                        <p class="mb-1 d-flex align-items-center gap-1 fs-16"><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M21,3H3A2,2 0 0,0 1,5V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V5A2,2 0 0,0 21,3M21,19H3V5H13V9H21V19Z">
                              </path>
                            </svg> Google Chrome</span><span class="middot fs-26 d-inline-block">·</span><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z">
                              </path>
                            </svg> Now</span></p>
                        <p>IP Address: 139.135.53.113</p>
                      </div>
                    </div>
                    <div class="manage_logout">
                      <button class="border-0  bg-light-grey rounded-circle"><svg xmlns="http://www.w3.org/2000/svg"
                          width="18" height="18" viewBox="0 0 24 24">
                          <path fill="currentColor"
                            d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z">
                          </path>
                        </svg></button>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between mt-2 mx-sm-2 p-sm-3 p-2   border-bottom mange-main">
                    <div class="d-flex gap-sm-3 g-2 ">
                      <div class="pt-sm-2 pt-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24">
                          <path fill="#00adef"
                            d="M3,12V6.75L9,5.43V11.91L3,12M20,3V11.75L10,11.9V5.21L20,3M3,13L9,13.09V19.9L3,18.75V13M20,13.25V22L10,20.09V13.1L20,13.25Z">
                          </path>
                        </svg></div>
                      <div class="manage-left-side">
                        <h4 class="fs-18 mb-1">Windows</h4>
                        <p class="mb-1 d-flex align-items-center gap-1 fs-16"><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M21,3H3A2,2 0 0,0 1,5V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V5A2,2 0 0,0 21,3M21,19H3V5H13V9H21V19Z">
                              </path>
                            </svg> Google Chrome</span><span class="middot fs-26 d-inline-block">·</span><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z">
                              </path>
                            </svg> Now</span></p>
                        <p>IP Address: 139.135.53.113</p>
                      </div>
                    </div>
                    <div class="manage_logout">
                      <button class="border-0  bg-light-grey rounded-circle"><svg xmlns="http://www.w3.org/2000/svg"
                          width="18" height="18" viewBox="0 0 24 24">
                          <path fill="currentColor"
                            d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z">
                          </path>
                        </svg></button>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between mt-2 mx-sm-2 p-sm-3 p-2   border-bottom mange-main">
                    <div class="d-flex gap-sm-3 g-2 ">
                      <div class="pt-sm-2 pt-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24">
                          <path fill="#00adef"
                            d="M3,12V6.75L9,5.43V11.91L3,12M20,3V11.75L10,11.9V5.21L20,3M3,13L9,13.09V19.9L3,18.75V13M20,13.25V22L10,20.09V13.1L20,13.25Z">
                          </path>
                        </svg></div>
                      <div class="manage-left-side">
                        <h4 class="fs-18 mb-1">Windows</h4>
                        <p class="mb-1 d-flex align-items-center gap-1 fs-16"><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M21,3H3A2,2 0 0,0 1,5V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V5A2,2 0 0,0 21,3M21,19H3V5H13V9H21V19Z">
                              </path>
                            </svg> Google Chrome</span><span class="middot fs-26 d-inline-block">·</span><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z">
                              </path>
                            </svg> Now</span></p>
                        <p>IP Address: 139.135.53.113</p>
                      </div>
                    </div>
                    <div class="manage_logout">
                      <button class="border-0  bg-light-grey rounded-circle"><svg xmlns="http://www.w3.org/2000/svg"
                          width="18" height="18" viewBox="0 0 24 24">
                          <path fill="currentColor"
                            d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z">
                          </path>
                        </svg></button>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between mt-2 mx-sm-2 p-sm-3 p-2   border-bottom mange-main">
                    <div class="d-flex gap-sm-3 g-2 ">
                      <div class="pt-sm-2 pt-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24">
                          <path fill="#00adef"
                            d="M3,12V6.75L9,5.43V11.91L3,12M20,3V11.75L10,11.9V5.21L20,3M3,13L9,13.09V19.9L3,18.75V13M20,13.25V22L10,20.09V13.1L20,13.25Z">
                          </path>
                        </svg></div>
                      <div class="manage-left-side">
                        <h4 class="fs-18 mb-1">Windows</h4>
                        <p class="mb-1 d-flex align-items-center gap-1 fs-16"><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M21,3H3A2,2 0 0,0 1,5V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V5A2,2 0 0,0 21,3M21,19H3V5H13V9H21V19Z">
                              </path>
                            </svg> Google Chrome</span><span class="middot fs-26 d-inline-block">·</span><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z">
                              </path>
                            </svg> Now</span></p>
                        <p>IP Address: 139.135.53.113</p>
                      </div>
                    </div>
                    <div class="manage_logout">
                      <button class="border-0  bg-light-grey rounded-circle"><svg xmlns="http://www.w3.org/2000/svg"
                          width="18" height="18" viewBox="0 0 24 24">
                          <path fill="currentColor"
                            d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z">
                          </path>
                        </svg></button>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between mt-2 mx-sm-2 p-sm-3 p-2   border-bottom mange-main">
                    <div class="d-flex gap-sm-3 g-2 ">
                      <div class="pt-sm-2 pt-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24">
                          <path fill="#00adef"
                            d="M3,12V6.75L9,5.43V11.91L3,12M20,3V11.75L10,11.9V5.21L20,3M3,13L9,13.09V19.9L3,18.75V13M20,13.25V22L10,20.09V13.1L20,13.25Z">
                          </path>
                        </svg></div>
                      <div class="manage-left-side">
                        <h4 class="fs-18 mb-1">Windows</h4>
                        <p class="mb-1 d-flex align-items-center gap-1 fs-16"><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M21,3H3A2,2 0 0,0 1,5V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V5A2,2 0 0,0 21,3M21,19H3V5H13V9H21V19Z">
                              </path>
                            </svg> Google Chrome</span><span class="middot fs-26 d-inline-block">·</span><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z">
                              </path>
                            </svg> Now</span></p>
                        <p>IP Address: 139.135.53.113</p>
                      </div>
                    </div>
                    <div class="manage_logout">
                      <button class="border-0  bg-light-grey rounded-circle"><svg xmlns="http://www.w3.org/2000/svg"
                          width="18" height="18" viewBox="0 0 24 24">
                          <path fill="currentColor"
                            d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z">
                          </path>
                        </svg></button>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between mt-2 mx-sm-2 p-sm-3 p-2   border-bottom mange-main">
                    <div class="d-flex gap-sm-3 g-2 ">
                      <div class="pt-sm-2 pt-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24">
                          <path fill="#00adef"
                            d="M3,12V6.75L9,5.43V11.91L3,12M20,3V11.75L10,11.9V5.21L20,3M3,13L9,13.09V19.9L3,18.75V13M20,13.25V22L10,20.09V13.1L20,13.25Z">
                          </path>
                        </svg></div>
                      <div class="manage-left-side">
                        <h4 class="fs-18 mb-1">Windows</h4>
                        <p class="mb-1 d-flex align-items-center gap-1 fs-16"><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M21,3H3A2,2 0 0,0 1,5V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V5A2,2 0 0,0 21,3M21,19H3V5H13V9H21V19Z">
                              </path>
                            </svg> Google Chrome</span><span class="middot fs-26 d-inline-block">·</span><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z">
                              </path>
                            </svg> Now</span></p>
                        <p>IP Address: 139.135.53.113</p>
                      </div>
                    </div>
                    <div class="manage_logout">
                      <button class="border-0  bg-light-grey rounded-circle"><svg xmlns="http://www.w3.org/2000/svg"
                          width="18" height="18" viewBox="0 0 24 24">
                          <path fill="currentColor"
                            d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z">
                          </path>
                        </svg></button>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between mt-2 mx-sm-2 p-sm-3 p-2   border-bottom mange-main">
                    <div class="d-flex gap-sm-3 g-2 ">
                      <div class="pt-sm-2 pt-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24">
                          <path fill="#00adef"
                            d="M3,12V6.75L9,5.43V11.91L3,12M20,3V11.75L10,11.9V5.21L20,3M3,13L9,13.09V19.9L3,18.75V13M20,13.25V22L10,20.09V13.1L20,13.25Z">
                          </path>
                        </svg></div>
                      <div class="manage-left-side">
                        <h4 class="fs-18 mb-1">Windows</h4>
                        <p class="mb-1 d-flex align-items-center gap-1 fs-16"><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M21,3H3A2,2 0 0,0 1,5V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V5A2,2 0 0,0 21,3M21,19H3V5H13V9H21V19Z">
                              </path>
                            </svg> Google Chrome</span><span class="middot fs-26 d-inline-block">·</span><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z">
                              </path>
                            </svg> Now</span></p>
                        <p>IP Address: 139.135.53.113</p>
                      </div>
                    </div>
                    <div class="manage_logout">
                      <button class="border-0  bg-light-grey rounded-circle"><svg xmlns="http://www.w3.org/2000/svg"
                          width="18" height="18" viewBox="0 0 24 24">
                          <path fill="currentColor"
                            d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z">
                          </path>
                        </svg></button>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between mt-2 mx-sm-2 p-sm-3 p-2   border-bottom mange-main">
                    <div class="d-flex gap-sm-3 g-2 ">
                      <div class="pt-sm-2 pt-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                          viewBox="0 0 24 24">
                          <path fill="#00adef"
                            d="M3,12V6.75L9,5.43V11.91L3,12M20,3V11.75L10,11.9V5.21L20,3M3,13L9,13.09V19.9L3,18.75V13M20,13.25V22L10,20.09V13.1L20,13.25Z">
                          </path>
                        </svg></div>
                      <div class="manage-left-side">
                        <h4 class="fs-18 mb-1">Windows</h4>
                        <p class="mb-1 d-flex align-items-center gap-1 fs-16"><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M21,3H3A2,2 0 0,0 1,5V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V5A2,2 0 0,0 21,3M21,19H3V5H13V9H21V19Z">
                              </path>
                            </svg> Google Chrome</span><span class="middot fs-26 d-inline-block">·</span><span><svg
                              xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z">
                              </path>
                            </svg> Now</span></p>
                        <p>IP Address: 139.135.53.113</p>
                      </div>
                    </div>
                    <div class="manage_logout">
                      <button class="border-0  bg-light-grey rounded-circle"><svg xmlns="http://www.w3.org/2000/svg"
                          width="18" height="18" viewBox="0 0 24 24">
                          <path fill="currentColor"
                            d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z">
                          </path>
                        </svg></button>
                    </div>
                  </div>
                </div>
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
              <form action="" class="mt-5 pt-3">
                <div class="row g-3 px-3 ">
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="twitter-FormLabelLg" class="form-label col-form-label-lg mb-0 ">Twitter</label>
                    <input type="text" class="form-control form-control-lg twitter fs-16" placeholder="Add twitter link"
                      aria-label="twitter" :value="userData.twitter">
                  </div>
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg mb-0">Linkedin</label>
                    <input type="text" class="form-control form-control-lg fs-16" placeholder="Add linkedin link"
                      aria-label="linkedIn" :value="userData.linkedin">
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-12 pt-3 pt-md-0">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg">YouTube</label>
                    <input type="text" class="form-control form-control-lg fs-16" placeholder="Add youtube link"
                      aria-label="youtube" :value="userData.youtube">
                  </div>
                </div>
                <div class="mt-4 text-center">
                  <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6 " aria-label="share-btn">Save</a>
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
              <div class="p-2 border-top border-bottom mx-3 notifation-main">
                <ul class="nav justify-content-around" id="pills-tab" role="tablist">
                  <li class="nav-item w-md-50 " role="presentation">
                    <button class="nav-link active w-100 bg-transparent border-0 fs-18 rounded-2" id="pills-home-tab"
                      data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab"
                      aria-controls="pills-home" aria-selected="true"><span class="pe-2"><svg
                          xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                          <path fill="currentColor"
                            d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21M19.75,3.19L18.33,4.61C20.04,6.3 21,8.6 21,11H23C23,8.07 21.84,5.25 19.75,3.19M1,11H3C3,8.6 3.96,6.3 5.67,4.61L4.25,3.19C2.16,5.25 1,8.07 1,11Z">
                          </path>
                        </svg></span>Notification Settings</button>
                  </li>
                  <li class="nav-item w-md-50 " role="presentation">
                    <button class="nav-link w-100 bg-transparent border-0 rounded-2 fs-18" id="pills-profile-tab"
                      data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab"
                      aria-controls="pills-profile" aria-selected="false"><span class="pe-2"><svg
                          xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                          <path fill="currentColor"
                            d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z">
                          </path>
                        </svg></span>Email Notification</button>
                  </li>

                </ul>

              </div>
              <div class="tab-content mx-3 pt-5" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                  <div class="row">
                    <div class="col-md-3">
                      <h5 class="text-secondary fs-16">Notify me when</h5>
                    </div>
                    <div class="col-md-9 pt-3 pt-md-0">
                      <div class="form-check round-check">
                        <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                          name="Completed-checkbox" id="notification-check-1">
                        <label class="form-check-label fs-14 text-secondary cursor-pointer" for="notification-check-1">
                          Someone liked my posts
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                          name="Completed-checkbox" id="notification-check-2">
                        <label class="form-check-label fs-14 text-secondary cursor-pointer" for="notification-check-2">
                          Someone commented on my posts
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                          name="Completed-checkbox" id="notification-check-3">
                        <label class="form-check-label fs-14 text-secondary cursor-pointer" for="notification-check-3">
                          Someone shared on my posts
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                          name="Completed-checkbox" id="notification-check-4">
                        <label class="form-check-label fs-14 text-secondary cursor-pointer" for="notification-check-4">
                          Someone followed me
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                          name="Completed-checkbox" id="notification-check-5">
                        <label class="form-check-label fs-14 text-secondary cursor-pointer" for="notification-check-5">
                          Someone mentioned me
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                          name="Completed-checkbox" id="notification-check-6">
                        <label class="form-check-label fs-14 text-secondary cursor-pointer" for="notification-check-6">
                          Someone joined my chats
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg cursor-pointer" type="checkbox" value=""
                          name="Completed-checkbox" id="notification-check-7">
                        <label class="form-check-label fs-14 text-secondary cursor-pointer" for="notification-check-7">
                          Someone accepted my friend/follow requset
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
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
            </div>
          
            <!-- Membership-tabs start -->
            <div class="tab-pane fade" id="v-pills-membership" role="tabpanel" aria-labelledby="v-pills-membership-tab"
              tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img :src="`/uploads/${userData.avatar}`" :alt="`${userData.name} Profile Picture`" class="avatar rounded-circle"></div>
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
                          <tr :key="userPaymentMethod.id">
                            <td>{{ userPaymentMethod.card.brand }}</td>
                            <td>{{ userPaymentMethod.billing_details.name }}</td> 
                            <td>************{{ userPaymentMethod.card.last4 }}</td>
                            <td>{{userPaymentMethod.card.exp_month}} / {{userPaymentMethod.card.exp_year}}</td>
                          </tr>
                        </tbody> 
                        <tfoot v-else>
                          <tr>
                            <td colspan="5" class="text-center py-6"><p class="no_payment">No payment methods to show</p></td>
                          </tr>
                        </tfoot>
                      </table>
                      <button v-if="userPaymentMethod"  class="btn btn-primary update_card" type="button" data-bs-toggle="modal" data-bs-target="#updateCard"> Update Card</button>
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
                          <td>{{ Subscription.ends_at != null && Subscription.stripe_status == 'active' ? 'Expiring Soon' : Subscription.stripe_status }}</td>
                          <td v-if="Subscription.stripe_status == 'active' && Subscription.ends_at == null">
                            <a @click="showConfirmModel"  class="subscription_cancel btn btn-primary">Cancel Subscription</a>
                      
                          </td>

                        </tr>
                      </tbody>
                      <p v-else>No Subscriptions</p>
                    </table>
                    <div class="modal fade" id="exampleModal" ref="confirm_popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure you want to cancel your subscription?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" @click="cancelSubscription(userSubscriptions[0].name)">Yes</button>
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
                        <tbody v-if="upcomingInvoices">
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
                            <td colspan="5" class="text-center py-6"><p  class="no_invoices">No upcoming invoices to show</p></td>
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
                              {{ invoice.paid ? '$' + (invoice.amount_paid / 100).toFixed(2) : '$' + (invoice.amount_remaining / 100).toFixed(2) }}
                            </td>
                            <td>{{ invoice.billing_reason }}</td>
                            <td>{{ invoice.paid ? 'Paid' : 'Pending' }}</td>
                            <td><a :href="invoice.invoice_pdf" target="_blank" class="download btn btn-primary">Download</a></td>
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
                  <a class="btn d-flex align-items-center border-0 px-3" data-bs-toggle="collapse" href="#collapseSecurity"
                    role="button" aria-expanded="false" aria-controls="collapseSecurity"><i
                      class="bi bi-shield-fill-check pe-3 fs-18"></i>
                    <span class="d-flex justify-content-between w-100"> <span>Security</span> <i
                        class="bi bi-chevron-down fs-18 align-middle"></i></span>
                  </a>
                </p>
                <div class="collapse" id="collapseSecurity">
                  <div class="card card-body p-0 shadow-none">
                    <button class="nav-link text-start" id="v-pills-privacy-tab" data-bs-toggle="pill"
                      data-bs-target="#v-pills-privacy" type="button" role="tab" aria-controls="v-pills-privacy"
                      aria-selected="false">Privacy</button>
                    <button class="nav-link text-start" id="v-pills-password-tab" data-bs-toggle="pill"
                      data-bs-target="#v-pills-password" type="button" role="tab" aria-controls="v-pills-password"
                      aria-selected="false">Password</button>
                    <button class="nav-link text-start" id="v-pills-manage-tab" data-bs-toggle="pill"
                      data-bs-target="#v-pills-manage" type="button" role="tab" aria-controls="v-pills-manage"
                      aria-selected="false">Manage Sessions</button>
                  </div>
                </div>
              </div>

              <button class="nav-link text-start" id="v-pills-social-links-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-social-links" type="button" role="tab" aria-controls="v-pills-social-links"
                aria-selected="false"><i class="bi bi-twitter-x pe-3 fs-18 align-middle"></i>Social Links</button>
              <button class="nav-link text-start" id="v-pills-notification-setting-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-notification-setting" type="button" role="tab"
                aria-controls="v-pills-notification-setting" aria-selected="false"><i
                  class="bi bi-bell-fill pe-3 fs-18 align-middle"></i>Notification Setting</button>
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
                    <input type="text" v-model="formData.cardHolderName" id="cardHolderName" name="cardHolderName" class="form-control border  shadow-sm" placeholder="Card holder name">
                </div>
                
                <!-- Payment Method Element -->
                <label for="card-element">Credit or Debit Card</label>
                <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Form submission -->
                <button type="submit" id="submit-button" data-bs-dismiss="modal" class="btn btn-primary mt-4">UPDATE CARD</button>
            </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { loadStripe } from '@stripe/stripe-js';
import { mapState } from 'vuex';
import { Modal } from 'bootstrap';

export default {
  computed: mapState(['userData']),
  data() {
    return {
      userSubscriptions: [],
      pastInvoices: [],
      upcomingInvoices: [],
      upcomingLineData:[],
      userPaymentMethod: null,
      formData: {
        cardHolderName: '',
        payment_method: '',
      },
    };
  },
  mounted() {
    this.getInvoices();
    this.stripePaymentMethod();
    console.log(this.userData);
    this.confirmModalInstance = new Modal(this.$refs.confirm_popup, { backdrop: 'static' });
  },
  methods: {
    showConfirmModel(){
      if (this.confirmModalInstance) {
        this.confirmModalInstance.show();
      } else {
        console.error('Modal instance is not initialized.');
      }
    },
    async getInvoices(){
      try {
        const response = await axios.get('/api/subscriptionInvoices');
        this.userSubscriptions = response.data.Invoices.allUserSubscriptions;
        this.pastInvoices = response.data.Invoices.previousInvoices;
        this.upcomingInvoices = response.data.Invoices.upcomingInvoice;
        this.upcomingLineData = response.data.Invoices.upcomingInvoice.lines.data;
        this.userPaymentMethod = response.data.Invoices.paymentMethods;
        console.log(response.data.Invoices);
        console.log(this.userPaymentMethod);
      } catch (error) {
        console.error('Error fetching data:', error);
        // Handle error appropriately
      }
    },
    async cancelSubscription(subscriptionName){
        try {
          const response = await axios.post(`/api/cancelSubscription/${subscriptionName}`, {
            withCredentials: true,
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
          });
          this.getInvoices();
          this.confirmModalInstance.hide();
          console.log(response.data);
        } catch (error) {
            console.error('Error removing card:', error);
            // Handle error appropriately
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
      }else{
          axios.post(`/api/updatePaymentMethod/`, this.formData)
              .then(response => {
                  // Handle response
                  console.log('Response:', response.data);
              })
          .catch(error => {
              // Handle error
              console.error('Error:', error);
          });
      }
    },
    // handleSubmit() {
    //     // Handle form submission (if needed)
    // }
  },
};
</script>
<style>
  .member_ship_card_main table,.member_ship_card_main th,.member_ship_card_main td ,.member_ship_card_main tr{
    border: 1px solid #000 !important;
    padding: 8px 12px;
  }
  .member_ship_card_main table{
    width: 100%;
  }
  .text-secondary{
    color: var(--cta-btn)!important;
  }
  .member_ship_card_main th{
    font:600 16px/28px Poppins;
    color: #000;
  }
  p.no_payment, .no_invoices{
    font:600 16px/28px Poppins;
    color: #000;
    margin: 0px;
    padding: 10px
  }
  .update_card{
    display: block;
    margin: auto;
    margin-top: 20px;
  }
  .past_invoice{
    overflow: auto;
  }
  .past_invoice table{
    min-width: 1250px
  }
  a.subscription_cancel, a.download {
    font: 600 12px /20px poppins;
    text-align: center;
    display: block;
    cursor: pointer;
    max-width: max-content;
    padding: 5px 11px;
    margin: auto;
}
  .member_ship_card_main table ul{
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 7px;
  }
  .border { border-color: #dfdfdf !important; }
</style>