@extends('layouts.master')
@section('body')
<body>
  @endsection
  @section('content')
  <section class="container-fluid py-80 generel_setting_section bg-light-grey">
    <div class="container">
      <div class="row">
        <div class="col-lg-9">
          <div class="tab-content shadow-sm rounded pb-4 bg-white" id="v-pills-tabContent">
            <!-- General+setting-tabs start -->
            <div class="tab-pane fade show active" id="v-pills-setting" role="tabpanel"
              aria-labelledby="v-pills-setting-tab" tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">General Setting</p>
                  </div>
                </div>

              </div>
              <form action="" class="mt-5 pt-3">
                <div class="row g-3 px-3 ">
                  <div class="col-md-6">
                    <label for="username-lable" class="form-label col-form-label-lg">Username</label>
                    <input type="text" class="form-control form-control-lg admin" placeholder="admin" name="admin"
                      aria-label="User name" id="admin">
                  </div>
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="Phone-lable" class="form-label col-form-label-lg">Phone</label>
                    <input type="text" class="form-control form-control-lg" placeholder="0300-1234567" name="number"
                      aria-label="Phone" id="number">
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col">
                    <label for="email-lable" class="form-label col-form-label-lg">E-mail</label>
                    <input type="email" class="form-control form-control-lg email" name="email" id="email"
                      placeholder="support@richpicksdaily.com" aria-label="Email">
                  </div>

                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-6">
                    <label for="Birthday-lable" class="form-label col-form-label-lg">Birthday</label>
                    <input type="date" class="form-control form-control-lg" placeholder="1992-02-23" name="birthday?"
                      aria-label="birthday" id="birthday">
                  </div>
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="countrySelect-lable" class="form-label col-form-label-lg">Country</label>
                    <select id="inputState" class="form-select form-select-lg Country_Seclect" id="Country_Seclect">
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
                      <option value="165" selected="">Pakistan</option>
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
                <div class="row g-3 px-3  pt-3">
                  <div class="col-md-6">
                    <label for="Gender" class="form-label col-form-label-lg">Gender</label>
                    <select class="form-select form-select-lg mb-3 Gender" aria-label="Gender" id="gender">
                      <option value="1" selected="">Male</option>
                      <option value="2">Female</option>
                    </select>
                  </div>
                </div>
                <div class="row g-3 px-3  pt-3">
                  <div class="col-md-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="verified" id="verified-0"
                        value="Verified checked" checked>
                      <label class="radio-inline" for="verified-0">
                        Verified
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="verified" id="verified-1">
                      <label class="radio-inline" for="verified-1">
                        Not verified
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col">
                    <label for="pro_type" class="form-label col-form-label-lg">Member Type</label>
                    <select class="form-select form-select-lg mb-3 pro_type" aria-label="pro_type" id="pro_type">
                      <option value="free">Free Member</option>
                      <option value="ultima">Ultima Member</option>
                      <option value="vip" selected="">Vip Member</option>
                    </select>
                  </div>

                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg">Wallet</label>
                    <input type="text" class="form-control form-control-lg" name="wallet" id="wallet"
                      placeholder="103.635" aria-label="wallet">
                  </div>

                </div>
                <div class="mt-4 text-center">
                  <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6 " aria-label="share-btn">Save</a>
                </div>
              </form>
            </div>
            <!-- Profile-tabs start -->
            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"
              tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">Profile Setting</p>
                  </div>
                </div>

              </div>
              <form action="" class="mt-5 pt-3">
                <div class="row g-3 px-3 ">
                  <div class="col-md-6">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg">First
                      name</label>
                    <input type="text" class="form-control form-control-lg first-name" id="fname" name="fname"
                      placeholder="Rich TV" aria-label="fname">
                  </div>
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg">Last
                      name</label>
                    <input type="text" class="form-control form-control-lg" placeholder="" aria-label="lname">
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col">
                    <label for="aboutme" class="form-label col-form-label-lg">About me</label>
                    <div class="form-floating">
                      <textarea class="form-control aboutme" placeholder="Probably New One person is here." id="about"
                        name="about"></textarea>
                      <label for="floatingTextarea2">Probably New One person is here.</label>
                    </div>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col">
                    <label for="Location" class="form-label col-form-label-lg">Location</label>
                    <input type="text" class="form-control form-control-lg Location" name="Address" id="Address"
                      placeholder="Pakistan" aria-label="Address">

                  </div>

                </div>
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-md-6">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg">School</label>
                    <input type="text" class="form-control form-control-lg" placeholder="High School" value=""
                      aria-label="School">
                  </div>
                  <div class="col pt-md-5 pt-3 ps-md-3">
                    <div class="form-check round-check">
                      <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                        id="Completed-checkbox" name="Completed-checkbox" checked>
                      <label class="form-check-label" for="Completed">
                        Completed
                      </label>
                    </div>

                  </div>
                </div>
                <div class="row g-3 px-3  pt-3 align-items-center">
                  <div class="col-md-6">
                    <label for="working" class="form-label col-form-label-lg mb-0">Working
                      at</label>
                    <input type="text" class="form-control form-control-lg " id="Working_at" name="Working_at"
                      placeholder="" aria-label="Working-at">
                    <span class="d-inline-block pt-2 text-secondary">(e.g Apple)</span>
                  </div>
                  <div class="col-md-6">
                    <label for="Company_website_FormLabel" class="form-label col-form-label-lg mt-md-3"></label>
                    <input type="text" class="form-control form-control-lg " id="Company_website" name="Company_website"
                      placeholder="" aria-label="Company_website">
                    <span class="d-inline-block pt-2 text-secondary">Company website</span>
                  </div>
                </div>

                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-6">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg mb-0">Website</label>
                    <input type="text" class="form-control form-control-lg" name="Website" id="gen-Website"
                      placeholder="https://richtv.io/" aria-label="Website">
                  </div>
                  <div class="col-md-6">
                    <label for="Relationship-Status" class="form-label col-form-label-lg mb-0">Relationship
                      Status</label>
                    <select class="form-select form-select-lg mb-3 Relationship_Status" aria-label="Relationship_Status"
                      id="Relationship_Status">
                      <option value="0">None</option>
                      <option value="1">Single</option>
                      <option value="2">In a relationship</option>
                      <option value="3">Married</option>
                      <option value="4">Engaged</option>
                    </select>
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
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">Privacy Setting</p>
                  </div>
                </div>

              </div>
              <form action="" class="mt-5 pt-3">
                <div class="row g-3 px-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Who can message me ?</p>
                  </div>
                  <div class="col-12 col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg fs-16 mb-3 message_privacy" aria-label="message_privacy"
                      id="message_privacy">
                      <option value="1" selected="">Everyone</option>
                      <option value="2">Friend</option>
                      <option value="3">No body</option>
                    </select>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Who can see my friends?</p>
                  </div>
                  <div class="col-12 col-sm-6  mt-0 mt-sm-3">
                    <select class="form-select form-select-lg fs-16 mb-3 friend_privacy" aria-label="friend_privacy"
                      id="friend_privacy">
                      <option value="1" selected="">Everyone</option>
                      <option value="2">People I Follow</option>
                      <option value="3">People Follow me</option>
                      <option value="4">No body</option>
                    </select>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Who can post on my timeline ?</p>
                  </div>
                  <div class="col-12 col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg fs-16 mb-3 timeline_privacy" aria-label="timeline_privacy"
                      id="timeline_privacy">
                      <option value="1" selected="">Everyone</option>
                      <option value="2">Friend</option>
                      <option value="3">No body</option>
                    </select>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Who can see my birthday?</p>
                  </div>
                  <div class="col-12  col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg mb-3 fs-16 birthday_privacy" aria-label="birthday_privacy"
                      id="birthday_privacy">
                      <option value="1" selected="">Everyone</option>
                      <option value="2">My Friend</option>
                      <option value="3">No body</option>
                    </select>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Send users a notification when i visit their
                      profile?</p>
                  </div>
                  <div class="col-12 col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg fs-16 mb-sm-3 mb-2 Notification_privacy"
                      aria-label="Notification_privacy" id="Notification_privacy">
                      <option value="1" selected="">Yes</option>
                      <option value="2">No</option>
                    </select>
                    <span class="text-secondary fs-14">if you don't share your visit event , you
                      won't be able to see other people visiting your profile.</span>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Show my last seen ?</p>
                  </div>
                  <div class="col-12 col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg mb-3 fs-16 lastseen_privacy" aria-label="lastseen_privacy"
                      id="lastseen_privacy">
                      <option value="1" selected="">Yes</option>
                      <option value="2">No</option>
                      <span class="fs-14 text-secondary">if you don't share your visit event , you
                        won't be able to see other people visiting your profile.</span>
                    </select>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Show my activities ?</p>
                  </div>
                  <div class="col-12 col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg mb-3 fs-16 activites_privacy"
                      aria-label="activites_privacy" id="activites_privacy">
                      <option value="1" selected="">yes</option>
                      <option value="2">No</option>
                    </select>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Status</p>
                  </div>
                  <div class="col-12 col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg fs-16 mb-3 status_privacy" aria-label="status_privacy"
                      id="status_privacy">
                      <option value="1" selected="">Online</option>
                      <option value="2">offline</option>
                    </select>
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3 align-items-center">
                  <div class="col-12 col-sm-6">
                    <p class="fs-18 mb-2 mb-sm-4">Share my location with public?</p>
                  </div>
                  <div class="col-12 col-sm-6 mt-0 mt-sm-3">
                    <select class="form-select form-select-lg mb-3 fs-16 share_location_privacy"
                      aria-label="share_location_privacy" id="share_location_privacy">
                      <option value="1" selected="">Yes</option>
                      <option value="2">No</option>
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
                      <option value="1" selected="">Everyone</option>
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
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">Change Password</p>
                  </div>
                </div>
                <form action="" class="mt-5 pt-3">
                  <div class="row g-3 px-3 pt-3">
                    <div class="col">
                      <label for="current-password" class="form-label col-form-label-lg pb-0">Current Password</label>
                      <input type="password" class="form-control form-control-lg text-secondary" placeholder=""
                        aria-label="currentPassword" name="currentPassword" id="currentPassword">
                    </div>

                  </div>
                  <div class="row g-3 px-3 pt-3">
                    <div class="col-md-6">
                      <label for="New-password" class="form-label col-form-label-lg">New
                        password</label>
                      <input type="password" class="form-control form-control-lg text-secondary" placeholder=""
                        aria-label="New password" name="NewPassword" id="NewPassword">
                    </div>
                    <div class="col-md-6">
                      <label for="colFormLabelLg" class="form-label col-form-label-lg">Repeat
                        password</label>
                      <input type="password" class="form-control form-control-lg text-secondary" placeholder=""
                        aria-label="New password" name="NewPassword" id="New-password">
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
                        aria-label="factor authentication" id="factor-authentication" name="factor-authentication">
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
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
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
            <!-- Authentication-tabs start -->
            <div class="tab-pane fade" id="v-pills-two-factor-auth" role="tabpanel"
              aria-labelledby="v-pills-two-factor-auth-tab" tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">Two-factor authentication</p>
                  </div>
                </div>
                <form action="" class="mt-5 pt-3">

                  <div class="row g-3 px-3 pt-3">
                    <div class="col">
                      <label for="authentication" class="form-label col-form-label-lg">Two-factor
                        authentication</label>
                      <select class="form-select form-select-lg mb-3 authentication text-secondary"
                        aria-label="factor authentication" id="factor-authentication" name="factor-authentication">
                        <option value="1" selected>Enable</option>
                        <option value="2">Disable</option>
                      </select>
                      <span class="pt-1 fs-14 text-secondary d-inline-block">Turn on 2-step login
                        to level-up your account's security, Once turned on, you'll use both
                        your password and a 6-digit security code sent to your phone or email to
                        log in.</span>
                    </div>

                  </div>
                  <div class="mt-4 text-center">
                    <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6 " aria-label="share-btn">Save</a>
                  </div>
                </form>
              </div>
            </div>
            <!-- Social-tabs start -->
            <div class="tab-pane fade" id="v-pills-social-links" role="tabpanel"
              aria-labelledby="v-pills-social-links-tab" tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">Social Links</p>
                  </div>
                </div>
              </div>
              <form action="" class="mt-5 pt-3">
                <div class="row g-3 px-3 ">
                  <div class="col-md-6">
                    <label for="facebook-FormLabelLg" class="form-label col-form-label-lg mb-0">Facebook</label>
                    <input type="text" class="form-control form-control-lg facebook fs-16" id="facebook" name="facebook"
                      placeholder="https://www.facebook.com/richpicksdaily" aria-label="facebook">
                  </div>
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="twitter-FormLabelLg" class="form-label col-form-label-lg mb-0 ">Twitter</label>
                    <input type="text" class="form-control form-control-lg twitter fs-16"
                      placeholder="https://twitter.com/richpickdaily" aria-label="twitter" id="twitter">
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-6">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg mb-0">Vkontakte</label>
                    <input type="text" class="form-control form-control-lg Vk-site fs-16" id="Vk_site" name="Vk_site"
                      placeholder="www.vkontakte.com" aria-label="Vk_site">
                  </div>
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg mb-0">Linkedin</label>
                    <input type="text" class="form-control form-control-lg fs-16 linkedIn" placeholder="richpicksdaily"
                      aria-label="linkedIn" id="linkedIn">
                  </div>
                </div>
                <div class="row g-3 px-3 pt-3">
                  <div class="col-md-6">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg">Instagram</label>
                    <input type="text" class="form-control form-control-lg fs-16 Instgram" id="instgram" name="Instgram"
                      placeholder="richpicksdaily" aria-label="Instgram">
                  </div>
                  <div class="col-md-6 pt-3 pt-md-0">
                    <label for="colFormLabelLg" class="form-label col-form-label-lg">YouTube</label>
                    <input type="text" class="form-control form-control-lg Youtube fs-16"
                      placeholder="channel/UCrvJc8oOqtQf9MEs_UXsBMQ" aria-label="youtube" id="youtube">
                  </div>
                </div>
                <div class="mt-4 text-center">
                  <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6 " aria-label="share-btn">Save</a>
                </div>
              </form>
            </div>
            <!-- invitation-tabs start -->
            <div class="tab-pane fade" id="v-pills-invitation-links" role="tabpanel"
              aria-labelledby="v-pills-invitation-links-tab" tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">Invitation Links</p>
                  </div>
                </div>
                <div class="earn_point px-4 py-5">
                  <div class="d-flex align-items-center gap-4 pt-3">
                    <div
                      class="earn_point-pill width_rounded_50 rounded-circle light-green-pill d-flex align-items-center justify-content-center">
                      <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                          <path fill="#00bf78"
                            d="M10.59,13.41C11,13.8 11,14.44 10.59,14.83C10.2,15.22 9.56,15.22 9.17,14.83C7.22,12.88 7.22,9.71 9.17,7.76V7.76L12.71,4.22C14.66,2.27 17.83,2.27 19.78,4.22C21.73,6.17 21.73,9.34 19.78,11.29L18.29,12.78C18.3,11.96 18.17,11.14 17.89,10.36L18.36,9.88C19.54,8.71 19.54,6.81 18.36,5.64C17.19,4.46 15.29,4.46 14.12,5.64L10.59,9.17C9.41,10.34 9.41,12.24 10.59,13.41M13.41,9.17C13.8,8.78 14.44,8.78 14.83,9.17C16.78,11.12 16.78,14.29 14.83,16.24V16.24L11.29,19.78C9.34,21.73 6.17,21.73 4.22,19.78C2.27,17.83 2.27,14.66 4.22,12.71L5.71,11.22C5.7,12.04 5.83,12.86 6.11,13.65L5.64,14.12C4.46,15.29 4.46,17.19 5.64,18.36C6.81,19.54 8.71,19.54 9.88,18.36L13.41,14.83C14.59,13.66 14.59,11.76 13.41,10.59C13,10.2 13,9.56 13.41,9.17Z">
                          </path>
                        </svg></span>
                    </div>
                    <div>
                      <b class="text-secondary">9 Available Links</b>
                    </div>
                  </div>
                  <div class="d-flex align-items-center gap-4 pt-3">
                    <div
                      class="earn_point-pill width_rounded_50 rounded-circle light-blue-pill d-flex align-items-center justify-content-center">
                      <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                          <path fill="#2f6aff"
                            d="M10.6 13.4A1 1 0 0 1 9.2 14.8A4.8 4.8 0 0 1 9.2 7.8L12.7 4.2A5.1 5.1 0 0 1 19.8 4.2A5.1 5.1 0 0 1 19.8 11.3L18.3 12.8A6.4 6.4 0 0 0 17.9 10.4L18.4 9.9A3.2 3.2 0 0 0 18.4 5.6A3.2 3.2 0 0 0 14.1 5.6L10.6 9.2A2.9 2.9 0 0 0 10.6 13.4M23 18V20H20V23H18V20H15V18H18V15H20V18M16.2 13.7A4.8 4.8 0 0 0 14.8 9.2A1 1 0 0 0 13.4 10.6A2.9 2.9 0 0 1 13.4 14.8L9.9 18.4A3.2 3.2 0 0 1 5.6 18.4A3.2 3.2 0 0 1 5.6 14.1L6.1 13.7A7.3 7.3 0 0 1 5.7 11.2L4.2 12.7A5.1 5.1 0 0 0 4.2 19.8A5.1 5.1 0 0 0 11.3 19.8L13.1 18A6 6 0 0 1 16.2 13.7Z">
                          </path>
                        </svg></span>

                    </div>
                    <div>
                      <b class="text-secondary">1 Generated Links</b>
                    </div>
                  </div>
                  <div class="d-flex align-items-center gap-4 pt-3">
                    <div
                      class="earn_point-pill width_rounded_50 rounded-circle light-yellow-pill d-flex align-items-center justify-content-center">
                      <span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                          <path fill="rgb(255, 152, 0)"
                            d="M10.6 13.4A1 1 0 0 1 9.2 14.8A4.8 4.8 0 0 1 9.2 7.8L12.7 4.2A5.1 5.1 0 0 1 19.8 4.2A5.1 5.1 0 0 1 19.8 11.3L18.3 12.8A6.4 6.4 0 0 0 17.9 10.4L18.4 9.9A3.2 3.2 0 0 0 18.4 5.6A3.2 3.2 0 0 0 14.1 5.6L10.6 9.2A2.9 2.9 0 0 0 10.6 13.4M23 18V20H15V18M16.2 13.7A4.8 4.8 0 0 0 14.8 9.2A1 1 0 0 0 13.4 10.6A2.9 2.9 0 0 1 13.4 14.8L9.9 18.4A3.2 3.2 0 0 1 5.6 18.4A3.2 3.2 0 0 1 5.6 14.1L6.1 13.7A7.3 7.3 0 0 1 5.7 11.2L4.2 12.7A5.1 5.1 0 0 0 4.2 19.8A5.1 5.1 0 0 0 11.3 19.8L13.1 18A6 6 0 0 1 16.2 13.7Z">
                          </path>
                        </svg></span>

                    </div>
                    <div>
                      <b class="text-secondary">0 Used Links</b>
                    </div>
                  </div>
                  <div class="pt-4">
                    <hr>
                  </div>
                  <div class="mt-4 text-center">
                    <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6 " aria-label="share-btn">Generate links</a>
                  </div>
                  <table class="table border border-1 mt-5 text-secondary">
                    <thead>
                      <tr>

                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td scope="row"><button class="btn text-secondary bg-light-grey">copy</button></td>
                        <td></td>
                        <td><b>11/07/23</b></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- Design-tabs start -->
            <div class="tab-pane fade" id="v-pills-avatar-cover" role="tabpanel"
              aria-labelledby="v-pills-avatar-cover-tab" tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">Avatar & Cover</p>
                  </div>
                </div>

              </div>
              <form action="" class="my-5">
                <div class=" bg-light-grey d-flex align-items-center justify-content-center height-230 mx-3 rounded-3">
                  <a href=""
                    class="btn cover-file input-foucs position-relative cursor-pointer d-flex justify-content-center align-items-center"><svg
                      xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                      <path fill="currentColor" d="M14,6L10.25,11L13.1,14.8L11.5,16C9.81,13.75 7,10 7,10L1,18H23L14,6Z">
                      </path>
                    </svg>
                    <input type="file" name="cover " id="cover"
                      class="cover position-absolute cursor-pointer w-100 h-100" value="cover"></a>
                </div>
                <div>
                  <span
                    class="bg-light-grey rounded-circle d-flex align-items-center justify-content-center camera-width position-relative"><a
                      href="" class="btn cursor-pointer d-flex justify-content-center align-items-center cover-file"><i
                        class="bi bi-camera-fill fs-28"></i>
                      <input type="file" name="cover-camera" value="cover" id="cover-camera"
                        class="position-absolute w-100 h-100"></a></span>
                </div>
                <div class="mt-4 text-center">
                  <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6 " aria-label="share-btn">Save</a>
                </div>
              </form>
            </div>
            <!-- Blocked-tab start -->
            <div class="tab-pane fade" id="v-pills-blocked-users" role="tabpanel"
              aria-labelledby="v-pills-blocked-users-tab" tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">Blocked User</p>
                  </div>
                </div>

              </div>
              <div class="pt-3"></div>
              <div class="setting-well my-5 text-center">
                <div class="empty_state"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path fill="currentColor"
                      d="M16 17V19H2V17S2 13 9 13 16 17 16 17M12.5 7.5A3.5 3.5 0 1 0 9 11A3.5 3.5 0 0 0 12.5 7.5M15.94 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13M15 4A3.39 3.39 0 0 0 13.07 4.59A5 5 0 0 1 13.07 10.41A3.39 3.39 0 0 0 15 11A3.5 3.5 0 0 0 15 4Z">
                    </path>
                  </svg></div>
                <div class="pt-4 fs-16 text-secondary">No members to show</div>
                <div class="clear"></div>
              </div>
            </div>
            <!-- Notification-tabs start -->
            <div class="tab-pane fade" id="v-pills-notification-setting" role="tabpanel"
              aria-labelledby="v-pills-notification-setting-tab" tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">Notification</p>
                  </div>
                </div>

              </div>
              <div class="pt-5"></div>
              <div class="p-2 border-top border-bottom mx-3 notifation-main">
                <ul class="nav justify-content-around" id="pills-tab" role="tablist">
                  <li class="nav-item w-md-50 " role="presentation">
                    <button class="nav-link active w-100 bg-transparent text-secondary border-0 fs-18 rounded-2"
                      id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab"
                      aria-controls="pills-home" aria-selected="true"><span class="pe-2"><svg
                          xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                          <path fill="currentColor"
                            d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21M19.75,3.19L18.33,4.61C20.04,6.3 21,8.6 21,11H23C23,8.07 21.84,5.25 19.75,3.19M1,11H3C3,8.6 3.96,6.3 5.67,4.61L4.25,3.19C2.16,5.25 1,8.07 1,11Z">
                          </path>
                        </svg></span>Notification Settings</button>
                  </li>
                  <li class="nav-item w-md-50 " role="presentation">
                    <button class="nav-link w-100 bg-transparent text-secondary  border-0 rounded-2"
                      id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button"
                      role="tab" aria-controls="pills-profile" aria-selected="false"><span class="pe-2"><svg
                          xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                          <path fill="currentColor"
                            d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z">
                          </path>
                        </svg></span>Email notification</button>
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
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone liked my posts
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone commented on my posts
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone shared on my posts
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone followed me
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone visited my profile
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone mentioned me
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone joined my chats
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone accepted my friend/follow requset
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone posted on my timeline
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          You have remembrance on this day
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Winner is announced in reward system
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          A member signup with my affiliate link
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          someone like/dislike my watchlist
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
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone liked my posts
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone commented on my posts
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone shared on my posts
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone followed me
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone visited my profile
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone mentioned me
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone joined my chats
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone accepted my friend/follow requset
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Someone posted on my timeline
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          You have remembrance on this day
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          Winner is announced in reward system
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          A member signup with my affiliate link
                        </label>
                      </div>
                      <div class="form-check round-check pt-3">
                        <input class="form-check-input form-check-input-lg" type="checkbox" value=""
                          id="Completed-checkbox" name="Completed-checkbox" checked="">
                        <label class="form-check-label fs-14 text-secondary" for="Completed">
                          someone like/dislike my watchlist
                        </label>
                      </div>

                    </div>
                  </div>
                </div>

              </div>
            </div>
            <!-- Points-tabs start -->
            <div class="tab-pane fade" id="v-pills-my-point" role="tabpanel" aria-labelledby="v-pills-my-point-tab"
              tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">My Point</p>
                  </div>
                </div>

              </div>
              <div class="earn_point px-4 py-5">
                <div class="d-flex align-items-center gap-4 pt-3">
                  <div
                    class="earn_point-pill width_rounded_50 rounded-circle light-green-pill d-flex align-items-center justify-content-center">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#4caf50"
                          d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9Z">
                        </path>
                      </svg></span>
                  </div>
                  <div>
                    <b class="text-secondary">Earn 2 points by commenting any post</b>
                  </div>
                </div>
                <div class="d-flex align-items-center gap-4 pt-3">
                  <div
                    class="earn_point-pill width_rounded_50 rounded-circle light-blue-pill d-flex align-items-center justify-content-center">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#2196f3"
                          d="M17,7H22V17H17V19A1,1 0 0,0 18,20H20V22H17.5C16.95,22 16,21.55 16,21C16,21.55 15.05,22 14.5,22H12V20H14A1,1 0 0,0 15,19V5A1,1 0 0,0 14,4H12V2H14.5C15.05,2 16,2.45 16,3C16,2.45 16.95,2 17.5,2H20V4H18A1,1 0 0,0 17,5V7M2,7H13V9H4V15H13V17H2V7M20,15V9H17V15H20Z">
                        </path>
                      </svg></span>

                  </div>
                  <div>
                    <b class="text-secondary">Earn 3 points by creating a new post</b>
                  </div>
                </div>
                <div class="d-flex align-items-center gap-4 pt-3">
                  <div
                    class="earn_point-pill width_rounded_50 rounded-circle light-yellow-pill d-flex align-items-center justify-content-center">
                    <span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#ff9800"
                          d="M12,17.5C14.33,17.5 16.3,16.04 17.11,14H6.89C7.69,16.04 9.67,17.5 12,17.5M8.5,11A1.5,1.5 0 0,0 10,9.5A1.5,1.5 0 0,0 8.5,8A1.5,1.5 0 0,0 7,9.5A1.5,1.5 0 0,0 8.5,11M15.5,11A1.5,1.5 0 0,0 17,9.5A1.5,1.5 0 0,0 15.5,8A1.5,1.5 0 0,0 14,9.5A1.5,1.5 0 0,0 15.5,11M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z">
                        </path>
                      </svg></span>

                  </div>
                  <div>
                    <b class="text-secondary">Earn 1 points by reacting on any post</b>
                  </div>
                </div>
                <div class="pt-4">
                  <hr>
                </div>
                <div class="mt-4 text-center">
                  <div class="point_counter bg-light-grey p-3 position-relative rounded-3">
                    <span class="position-absolute"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        width="95" height="95">
                        <path fill="#ddd7d7"
                          d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-14.243L7.757 12 12 16.243 16.243 12 12 7.757z">
                        </path>
                      </svg></span>
                    <p class="text-start fs-18 fw-6 text-uppercase">points</p>
                    <h2 class="fs-22 fw-5">450</h2>
                  </div>
                </div>

              </div>
            </div>
            <!-- Transaction-tabs start -->
            <div class="tab-pane fade" id="v-pills-transactions" role="tabpanel"
              aria-labelledby="v-pills-transactions-tab" tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">Transactions</p>
                  </div>
                </div>

              </div>
              <div class="pt-3"></div>
              <div class="setting-well my-5 text-center">
                <div class="empty_state">
                  <img src="assets/imgs/no_transaction.svg" alt="" class="img-fluid">
                </div>
                <div class="pt-4 text-secondary fs-16 px-2 px-md-0">Looks like you don't have any
                  transaction yet!
                </div>
                <div class="clear"></div>
              </div>
            </div>
            <!-- Membership-tabs start -->
            <div class="tab-pane fade" id="v-pills-membership" role="tabpanel" aria-labelledby="v-pills-membership-tab"
              tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">Membership</p>
                  </div>
                </div>

              </div>
              <div class="mt-5">
                <div class="member_ship_card shadow-sm rounded p-3 bg-white m-3 border border-1">
                  <h2 class="text-secondary text-center fs-22">PAYMENT METHOD</h2>
                  <div class="border-heading m-auto my-4"></div>
                  <div class="member-card-main pt-4 pb-2">
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="d-flex flex-sm-column align-items-sm-center justify-content-between">
                          <span class="labelfr-username spn card_type fw-6 text-secondary">Card
                            Type</span>
                          <span class="card-brand fw-6 pt-1 text-secondary">22</span>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="d-flex flex-sm-column align-items-sm-center justify-content-between pt-3 pt-sm-0">
                          <span class="labelfr-username spn card_type fw-6 text-secondary">Card
                            Number</span>
                          <span
                            class="labelfr-username card-number fs-22  fw-6 pt-1 text-secondary">*************</span>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="d-flex flex-sm-column align-items-sm-center justify-content-between pt-3 pt-sm-0">
                          <span class="labelfr-username spn card_type fw-6 text-secondary">Expiration
                            Date</span>
                          <span class="labelfr-username card-number fw-6 pt-1 text-secondary">/</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="member_ship_card shadow-sm rounded p-4 bg-white m-3 border border-1">
                  <h2 class="text-secondary text-center fs-22 ">MY MEMBERSHIP</h2>
                  <div class="border-heading m-auto my-4 text-secondary"></div>
                  <div class="member-card-main pt-3">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="d-flex flex-md-column align-items-md-center justify-content-between ">
                          <span class="labelfr-username spn card_type  fw-6 text-secondary">Level</span>
                          <span class="card-brand  fw-6 pt-1 text-secondary">Basic Free</span>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="d-flex flex-md-column align-items-md-center justify-content-between pt-3 pt-md-0">
                          <span class="labelfr-username spn card_type  fw-6 text-secondary">Billing</span>
                          <span class="labelfr-username card-number  fw-6 pt-1 text-secondary"></span>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="d-flex flex-md-column align-items-md-center justify-content-between pt-3 pt-md-0">
                          <span class="labelfr-username spn card_type  fw-6 text-secondary">Expiration
                            Date</span>
                          <span class="labelfr-username card-number  fw-6 pt-1 text-secondary">Never</span>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="d-flex flex-md-column align-items-md-center justify-content-between pt-3 pt-md-0">
                          <span class="labelfr-username spn card_type  fw-6 text-secondary">Status</span>
                          <span class="labelfr-username card-number fw-6 pt-1 text-secondary">Active</span>
                        </div>
                      </div>
                    </div>
                    <div class="mt-5 mb-2 text-center">
                      <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6 " aria-label="share-btn">Cancel
                        Subscription</a>
                    </div>
                  </div>
                </div>
                <div class="member_ship_card shadow-sm rounded p-3 bg-white m-3 border border-1">
                  <h2 class="text-secondary text-center fs-22 ">PAST INVOICES</h2>
                  <div class="border-heading m-auto my-4 text-secondary"></div>
                  <div class="member-card-main pt-4 pb-2">
                    <div class="row flex-md-row flex-column justify-content-start">
                      <div class="col">
                        <div class="d-flex flex-md-column align-items-md-center justify-content-between">
                          <span class="labelfr-username spn card_type fw-6 text-secondary">Date</span>
                          <span class="card-brand fw-6 pt-1 text-secondary"></span>
                        </div>
                      </div>
                      <div class="col">
                        <div class="d-flex flex-md-column  align-items-md-center justify-content-between pt-3 pt-md-0">
                          <span class="labelfr-username spn card_type  fw-6 text-secondary">Level</span>
                          <span class="labelfr-username card-number  fw-6 pt-1 text-secondary"></span>
                        </div>
                      </div>
                      <div class="col">
                        <div class="d-flex flex-md-column  align-items-md-center justify-content-between pt-3 pt-md-0">
                          <span class="labelfr-username spn card_type  fw-6 text-secondary">Amount</span>
                          <span class="labelfr-username card-number  fw-6 pt-1 text-secondary"></span>
                        </div>
                      </div>
                      <div class="col">
                        <div class="d-flex flex-md-column  align-items-md-center justify-content-between pt-3 pt-md-0">
                          <span class="labelfr-username spn card_type  fw-6 text-secondary">Transaction
                            Type</span>
                          <span class="labelfr-username card-number  fw-6 pt-1 text-secondary"></span>
                        </div>
                      </div>
                      <div class="col">
                        <div class="d-flex flex-md-column align-items-md-center justify-content-between pt-3 pt-md-0">
                          <span class="labelfr-username spn card_type  fw-6 text-secondary">Status</span>
                          <span class="labelfr-username card-number  fw-6 pt-1 text-secondary"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- information-tab start -->
            <div class="tab-pane fade" id="v-pills-my-information" role="tabpanel"
              aria-labelledby="v-pills-my-information-tab" tabindex="0">
              <div class="wo_general_settings_page ">
                <div class="generel_avatar-holder d-flex align-items-center position-relative">
                  <div><img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                      alt="Rich TV Profile Picture" class="avatar rounded-circle"></div>
                  <div class="avatar-holder_info ps-3 pt-3">
                    <h5 class="mb-0"><a href="#" class="nav-link p-0 text-secondary fs-16">Rich
                        TV</a></h5>
                    <p class="fs-28 pt-2">Information</p>
                  </div>
                </div>

              </div>
              <div class="mt-5"></div>
              <div class="row my-3 px-4 gy-4 justify-content-center my-information_setting">
                <div class="col-sm-4 ">
                  <div
                    class="border border-1 shadow-sm rounded p-md-3 p-sm-2 p-3 d-flex flex-column align-items-center cursor-pointer position-relative my-info">
                    <input type="checkbox" class="h-100 w-100 position-absolute" name="My_Information"
                      id="My_Information" value="1">
                    <div
                      class="sr_btn_img bg-light-grey rounded-circle d-flex justify-content-center align-items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
                        <path fill="#4d91ea"
                          d="M13,9H11V7H13M13,17H11V11H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z">
                        </path>
                      </svg>
                    </div>
                    <b class="pt-3 text-secondary">My Information</b>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div
                    class="border border-1 shadow-sm rounded p-md-3 p-sm-2 p-3 d-flex flex-column align-items-center cursor-pointer position-relative my-info">
                    <input type="checkbox" class="h-100 w-100 position-absolute" name="info_post" id="info_post"
                      value="1">
                    <div
                      class="sr_btn_img bg-light-grey rounded-circle d-flex justify-content-center align-items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
                        <path fill="#f25e4e"
                          d="M17.8,20C17.4,21.2 16.3,22 15,22H5C3.3,22 2,20.7 2,19V18H5L14.2,18C14.6,19.2 15.7,20 17,20H17.8M19,2C20.7,2 22,3.3 22,5V6H20V5C20,4.4 19.6,4 19,4C18.4,4 18,4.4 18,5V18H17C16.4,18 16,17.6 16,17V16H5V5C5,3.3 6.3,2 8,2H19M8,6V8H15V6H8M8,10V12H14V10H8Z">
                        </path>
                      </svg>
                    </div>
                    <b class="pt-3 text-secondary">posts</b>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div
                    class="border border-1 shadow-sm rounded p-md-3 p-sm-2 p-3 d-flex flex-column align-items-center cursor-pointer position-relative my-info">
                    <input type="checkbox" class="h-100 w-100 position-absolute" name="info_chat" id="info_chat"
                      value="1">

                    <div
                      class="sr_btn_img bg-light-grey rounded-circle d-flex justify-content-center align-items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
                        <path fill="#03A9F4"
                          d="M12,6A3,3 0 0,0 9,9A3,3 0 0,0 12,12A3,3 0 0,0 15,9A3,3 0 0,0 12,6M6,8.17A2.5,2.5 0 0,0 3.5,10.67A2.5,2.5 0 0,0 6,13.17C6.88,13.17 7.65,12.71 8.09,12.03C7.42,11.18 7,10.15 7,9C7,8.8 7,8.6 7.04,8.4C6.72,8.25 6.37,8.17 6,8.17M18,8.17C17.63,8.17 17.28,8.25 16.96,8.4C17,8.6 17,8.8 17,9C17,10.15 16.58,11.18 15.91,12.03C16.35,12.71 17.12,13.17 18,13.17A2.5,2.5 0 0,0 20.5,10.67A2.5,2.5 0 0,0 18,8.17M12,14C10,14 6,15 6,17V19H18V17C18,15 14,14 12,14M4.67,14.97C3,15.26 1,16.04 1,17.33V19H4V17C4,16.22 4.29,15.53 4.67,14.97M19.33,14.97C19.71,15.53 20,16.22 20,17V19H23V17.33C23,16.04 21,15.26 19.33,14.97Z">
                        </path>
                      </svg>
                    </div>
                    <b class="pt-3 text-secondary">Chats</b>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div
                    class="border border-1 shadow-sm rounded p-md-3 p-sm-2 p-3 d-flex flex-column align-items-center position-relative cursor-pointer my-info">
                    <input type="checkbox" class="h-100 w-100 position-absolute" name="info_friend" id="info_friend"
                      value="1">
                    <div
                      class="sr_btn_img bg-light-grey rounded-circle d-flex justify-content-center align-items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
                        <path fill="#8d73cc"
                          d="M16,13C15.71,13 15.38,13 15.03,13.05C16.19,13.89 17,15 17,16.5V19H23V16.5C23,14.17 18.33,13 16,13M8,13C5.67,13 1,14.17 1,16.5V19H15V16.5C15,14.17 10.33,13 8,13M8,11A3,3 0 0,0 11,8A3,3 0 0,0 8,5A3,3 0 0,0 5,8A3,3 0 0,0 8,11M16,11A3,3 0 0,0 19,8A3,3 0 0,0 16,5A3,3 0 0,0 13,8A3,3 0 0,0 16,11Z">
                        </path>
                      </svg>
                    </div>
                    <b class="pt-3 text-secondary">Friends</b>
                  </div>
                </div>
              </div>
              <div class="mt-5 mb-2 text-center">
                <a href="#" class="btn btn-primary rounded-2 fs-18 fw-6 " aria-label="share-btn">Generate file</a>
              </div>
            </div>
            <!-- Repeat this structure for the rest -->

          </div>
        </div>
        <div class="col-lg-3 mt-5 mt-lg-0">
          <div class="nav flex-column  border-0 shadow-sm rounded bg-white" id="general-setting-Tab">
            <div class="nav flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <button class="nav-link active text-secondary text-start" id="v-pills-setting-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-setting" type="button" role="tab" aria-controls="v-pills-setting"
                aria-selected="true">
                <i class="bi bi-gear-fill pe-3 fs-18"></i>General Setting
              </button>
              <button class="nav-link text-secondary text-start" id="v-pills-profile-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile"
                aria-selected="false">
                <i class="bi bi-person-circle pe-3 fs-18"></i>Profile
              </button>
              <div class="collapse-tabs">
                <p class="mb-0">
                  <a class="btn text-secondary d-flex align-items-center border-0" data-bs-toggle="collapse"
                    href="#collapseSecurity" role="button" aria-expanded="false" aria-controls="collapseSecurity"><i
                      class="bi bi-shield-fill-check pe-3 fs-18"></i>
                    <span class="d-flex justify-content-between w-100"> <span>Security</span> <i
                        class="bi bi-chevron-down fs-18"></i></span>
                  </a>
                </p>
                <div class="collapse" id="collapseSecurity">
                  <div class="card card-body p-0 shadow-none">
                    <button class="nav-link text-secondary text-start" id="v-pills-privacy-tab" data-bs-toggle="pill"
                      data-bs-target="#v-pills-privacy" type="button" role="tab" aria-controls="v-pills-privacy"
                      aria-selected="false">Privacy</button>
                    <button class="nav-link text-secondary text-start" id="v-pills-password-tab" data-bs-toggle="pill"
                      data-bs-target="#v-pills-password" type="button" role="tab" aria-controls="v-pills-password"
                      aria-selected="false">Password</button>
                    <button class="nav-link text-secondary text-start" id="v-pills-manage-tab" data-bs-toggle="pill"
                      data-bs-target="#v-pills-manage" type="button" role="tab" aria-controls="v-pills-manage"
                      aria-selected="false">Manage Sessions</button>
                    <button class="nav-link text-secondary text-start" id="v-pills-two-factor-auth-tab"
                      data-bs-toggle="pill" data-bs-target="#v-pills-two-factor-auth" type="button" role="tab"
                      aria-controls="v-pills-two-factor-auth" aria-selected="false">Two-factor authentication</button>
                  </div>
                </div>
              </div>

              <button class="nav-link text-secondary text-start" id="v-pills-social-links-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-social-links" type="button" role="tab" aria-controls="v-pills-social-links"
                aria-selected="false"><i class="bi bi-twitter-x pe-3 fs-18"></i>Social Links</button>
              <button class="nav-link text-secondary text-start" id="v-pills-invitation-links-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-invitation-links" type="button" role="tab"
                aria-controls="v-pills-invitation-links" aria-selected="false"><i
                  class="bi bi bi-link pe-3 fs-18"></i>Invitation Links</button>
              <div class="collapse-tabs">
                <p class="mb-0">
                  <button class="btn  text-secondary text-start d-flex align-items-center w-100 border-0" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapseDesign" aria-expanded="false"
                    aria-controls="collapseDesign">
                    <i class="bi bi-brush-fill pe-3 fs-18"></i><span class="d-flex justify-content-between w-100">
                      <span>Design</span> <i class="bi bi-chevron-down fs-18"></i></span>
                  </button>
                </p>
                <div class="collapse" id="collapseDesign">
                  <div class="card card-body p-0 shadow-none">
                    <button class="nav-link text-secondary text-start" id="v-pills-avatar-cover-tab"
                      data-bs-toggle="pill" data-bs-target="#v-pills-avatar-cover" type="button" role="tab"
                      aria-controls="v-pills-avatar-cover" aria-selected="false">Avatar & Cover</button>
                  </div>
                </div>
              </div>

              <button class="nav-link text-secondary text-start" id="v-pills-blocked-users-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-blocked-users" type="button" role="tab" aria-controls="v-pills-blocked-users"
                aria-selected="false"><i class="bi bi-person-fill-slash pe-3 fs-18"></i>Blocked Users</button>
              <button class="nav-link text-secondary text-start" id="v-pills-notification-setting-tab"
                data-bs-toggle="pill" data-bs-target="#v-pills-notification-setting" type="button" role="tab"
                aria-controls="v-pills-notification-setting" aria-selected="false"><i
                  class="bi bi-bell-fill pe-3 fs-18"></i>Notification Setting</button>
              <button class="nav-link text-secondary text-start" id="v-pills-my-point-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-my-point" type="button" role="tab" aria-controls="v-pills-my-point"
                aria-selected="false"><i class="bi bi-bank2 pe-3 fs-18"></i>My Point</button>
              <button class="nav-link text-secondary text-start" id="v-pills-transactions-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-transactions" type="button" role="tab" aria-controls="v-pills-transactions"
                aria-selected="false"><i class="bi bi-arrow-left-right pe-3 fs-18"></i>Transactions</button>
              <button class="nav-link text-secondary text-start" id="v-pills-membership-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-membership" type="button" role="tab" aria-controls="v-pills-membership"
                aria-selected="false"><i class="bi bi-person-lines-fill pe-3 fs-18"></i>Membership</button>
              <button class="nav-link text-secondary text-start" id="v-pills-my-information-tab" data-bs-toggle="pill"
                data-bs-target="#v-pills-my-information" type="button" role="tab" aria-controls="v-pills-my-information"
                aria-selected="false"><i class="bi bi-arrow-left-right pe-3 fs-18"></i>My Information</button>
              <!-- Repeat this structure for the rest of your tabs -->
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
  @endsection
    @section('scripts')
  @endsection