<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm-dark.png') }}" alt="logo-sm-dark" height="24">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo.png') }}" alt="logo-dark" height="22">
            </span>
        </a>

        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm-light.png') }}" alt="logo-sm-light" height="24">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo.svg') }}" alt="logo-light" height="22">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn"
        id="vertical-menu-btn">
        <i class="ri-menu-2-line align-middle"></i>
    </button>

    <div data-simplebar class="vertical-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('admin.index') }}" class="waves-effect">
                        <i class="uim uim-airplay"></i><span class="badge rounded-pill bg-success float-end">3</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="--{ -{ route -('admin.watchlist.index') } -} --" class="waves-effect">
                        <i class="uim uim-airplay"></i><span class="badge rounded-pill bg-success float-end">1</span>
                        <span>Watchlist Management </span>
                    </a>
                </li> -->

                <li>
                    <a href="{{ route('admin.symbols.index') }}" class="waves-effect">
                        <i class="uim uim-airplay"></i>
                        <span>Stock Database</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uim uim-comment-message"></i>
                        <span>Widgets & Symbols</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.widgets.index') }}">All Widgets</a></li>
                        <li><a href="{{ route('admin.widgets.create') }}">Add New Widget</a></li>
                        <li><a href="{{ route('admin.menus.index') }}">Menus</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uim uim-window-grid"></i>
                        <span>Exams</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.exams.categories.index') }}">Exam Categories</a></li>
                                <li><a href="{{ route('admin.exams.index') }}">Exams</a></li>                              
                                <li><a href="#">Exam Results</a></li>
                    </ul>
                    
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uim uim-sign-in-alt"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.users.index') }}">All Users</a></li>
                                <li><a href="{{ route('admin.users.create') }}">Add New User</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uim uim-box"></i>
                        <span>Groups</span>
                    </a>
                     <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.groups.index') }}">All Groups</a></li>
                                <li><a href="{{ route('admin.groups.create') }}">Add New Group</a></li>
                                <li><a href="{{ route('admin.groups.categories.index') }}">Group Categories</a></li>
                                <li><a href="{{ route('admin.groups.categories.create') }}">Add New Category</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.posts.index') }}" class="waves-effect">
                        <i class="uim uim-airplay"></i><span class="badge rounded-pill bg-success float-end">3</span>
                        <span>Posts</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uim uim-layer-group"></i>
                        <span>Tools</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.settings.subscription_plans.index') }}">Subscription Plans</a></li>
                        <li><a href="{{ route('admin.emails.index') }}">Mass Emails</a></li>
                        <li><a href="ui-buttons">Mass Notification</a></li>
                        <li><a href="ui-carousel">User Invitations</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uim uim-layer-group"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="form-elements">General Settings</a></li>
                        <li><a href="form-validation">Email Settings</a></li>
                        <li><a href="form-plugins">Notification Settings</a></li>
                        <li><a href="form-editors">Wasabi Storage Settings</a></li>
                        <li><a href="form-uploads">Payment Settings</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uim uim-chart-pie"></i>
                        <span>Charts</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{ route('admin.index', 'charts-candlestick') }}">Candlestick</a></li>
                    </ul>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>

    <div class="dropdown px-3 sidebar-user sidebar-user-info">
        <button type="button" class="btn w-100 px-0 border-0" id="page-header-user-dropdown"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}"
                        class="img-fluid header-profile-user rounded-circle" alt="">
                </div>

                <div class="flex-grow-1 ms-2 text-start">
                    <span class="ms-1 fw-medium user-name-text">Steven Deese</span>
                </div>

                <div class="flex-shrink-0 text-end">
                    <i class="mdi mdi-dots-vertical font-size-16"></i>
                </div>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <a class="dropdown-item" href="pages-profile"><i
                    class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i> <span
                    class="align-middle">Profile</span></a>
            <a class="dropdown-item" href="apps-chat"><i
                    class="mdi mdi-message-text-outline text-muted font-size-16 align-middle me-1"></i> <span
                    class="align-middle">Messages</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#"><span class="badge bg-primary mt-1 float-end">New</span><i
                    class="mdi mdi-cog-outline text-muted font-size-16 align-middle me-1"></i> <span
                    class="align-middle">Settings</span></a>
            <a class="dropdown-item" href="javascript:void();"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                    class="mdi mdi-lock text-muted font-size-16 align-middle me-1"></i> <span
                    class="align-middle">Logout</span></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

</div>
<!-- Left Sidebar End -->
