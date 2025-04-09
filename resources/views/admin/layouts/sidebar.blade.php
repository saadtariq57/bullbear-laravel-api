<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="/" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('build/images/favicon.png') }}" alt="logo-sm-dark" height="24">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('build/images/logo.png') }}" alt="logo-dark" height="22">
            </span>
        </a>

        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('build/images/favicon.png') }}" alt="logo-sm-light" height="24">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('build/images/logo.svg') }}" alt="logo-light">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn"
        id="vertical-menu-btn">
        <i class="fas fa-bars" style="line-height: 4;"></i>
    </button>

    <div data-simplebar class="vertical-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled w-100" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('admin.index') }}" class="waves-effect d-flex align-items-center">
                        <i class="fas fa-tachometer-alt me-2 menu-icon"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect d-flex align-items-center">
                        <i class="fas fa-database me-2 menu-icon"></i>
                        <span>Stock Database</span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('admin.symbols.index') }}" class="waves-effect d-flex align-items-center">
                                <span>Symbols</span>
                            </a>
                        <li>
                            <a href="{{ route('admin.symbols.profiles') }}" class="waves-effect d-flex align-items-center">
                                <span>Symbol Profiles</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect d-flex align-items-center">
                        <i class="fas fa-layer-group me-2 menu-icon"></i>
                        <span>Widgets & Symbols</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('admin.widgets.index') }}">All Widgets</a></li>
                        <li><a href="{{ route('admin.widgets.create') }}">Add New Widget</a></li>
                        <li><a href="{{ route('admin.widgets.categories.index') }}">Categories</a></li>
                        <li><a href="{{ route('admin.widgets.categories.create') }}">Add New Category</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect d-flex align-items-center">
                        <i class="fas fa-book me-2 menu-icon"></i>
                        <span>Exams</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('admin.exams.categories.index') }}">Exam Categories</a></li>
                        <li><a href="{{ route('admin.exams.index') }}">Exams</a></li>
                        <li><a href="#">Exam Results</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect d-flex align-items-center">
                        <i class="fas fa-users me-2 menu-icon"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('admin.users.index') }}">All Users</a></li>
                        <li><a href="{{ route('admin.users.create') }}">Add New User</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect d-flex align-items-center">
                        <i class="fas fa-boxes me-2 menu-icon"></i>
                        <span>Groups</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('admin.groups.index') }}">All Groups</a></li>
                        <li><a href="{{ route('admin.groups.create') }}">Add New Group</a></li>
                        <li><a href="{{ route('admin.groups.categories.index') }}">Group Categories</a></li>
                        <li><a href="{{ route('admin.groups.categories.create') }}">Add New Category</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect d-flex align-items-center">
                        <i class="fas fa-clock me-2 menu-icon"></i>
                        <span>Watchlists</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('admin.watchlists.index') }}">All Watchlists</a></li>
                        <li><a href="{{ route('admin.watchlists.create') }}">Add New Watchlist</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect d-flex align-items-center">
                        <i class="ri-line-chart-fill font-size-18"></i>
                        <span>Previous Performance</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('admin.trading_reports.index') }}">All Reports</a></li>
                        <li><a href="{{ route('admin.trading_reports.create') }}">Add New Report</a></li>
                        <li><a href="{{ route('admin.trading_reports.performance_categories.index') }}">All Reports Categories</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect d-flex align-items-center">
                        <i class="fas fa-user-clock me-2 menu-icon"></i>
                        <span>User Sessions</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('admin.sessions.index') }}">All Sessions</a></li>
                        <li><a href="{{ route('admin.sessions.create') }}">Add New Session</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.posts.index') }}" class="waves-effect d-flex align-items-center">
                        <i class="fas fa-file-alt me-2 menu-icon"></i>
                        <span>Posts</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect d-flex align-items-center">
                        <i class="fas fa-tools me-2 menu-icon"></i>
                        <span>Tools</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('admin.settings.subscription_plans.index') }}">Subscription Plans</a></li>
                        <li><a href="{{ route('admin.emails.index') }}">Manage Emails</a></li>
                        <li><a href="{{ route('admin.live.index') }}">Rich TV Live</a></li>
                        <li><a href="{{ route('admin.webinar.index') }}">Webinars</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect d-flex align-items-center">
                        <i class="fas fa-cog me-2 menu-icon"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="#">General Settings</a></li>
                        <li><a href="#">Email Settings</a></li>
                        <li><a href="#">Notification Settings</a></li>
                        <li><a href="#">Wasabi Storage Settings</a></li>
                    </ul>
                </li>
            </ul>

        </div>
        <!-- Sidebar -->
    </div>

    <div class="dropdown px-3 sidebar-user sidebar-user-info">
        <button type="button" class="btn w-100 px-0 border-0" id="page-header-user-dropdown"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center w-100">
                <div class="flex-shrink-0">
                    <img src="/uploads/{{ Auth::user()->avatar }}" class="img-fluid header-profile-user rounded-circle" alt="User Avatar">
                </div>

                <div class="flex-grow-1 ms-2 text-start">
                    <span class="ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                </div>

                <div class="flex-shrink-0 text-end">
                    <i class="fas fa-ellipsis-v font-size-16"></i> <!-- Changed to Font Awesome ellipsis -->
                </div>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end w-100">
            <!-- Profile Link -->
            <a class="dropdown-item d-flex align-items-center" href="{{ url('/profile/' . Auth::user()->name) }}">
                <i class="fas fa-user-circle text-muted font-size-16 align-middle me-2"></i> 
                <span class="align-middle">Profile</span>
            </a>
            <div class="dropdown-divider"></div>
            <!-- Settings Link -->
            <a class="dropdown-item d-flex align-items-center" href="{{ url('/profile/' . Auth::user()->name . '/settings') }}">
                <i class="fas fa-cog text-muted font-size-16 align-middle me-2"></i>
                <span class="align-middle">Settings</span>
            </a>
            <!-- Logout Link -->
            <a class="dropdown-item d-flex align-items-center" href="javascript:void();"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-lock text-muted font-size-16 align-middle me-2"></i> 
                <span class="align-middle">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

</div>

<!-- Custom Styles -->
<style>
    /* General Sidebar Styles */
    .vertical-menu {
        width: 250px;
        background-color: #ffffff;
        border-right: 1px solid #e0e0e0;
        height: 100vh;
        position: fixed;
        overflow: hidden;
        transition: width 0.3s;
    }

    /* Logo Styling */
    .navbar-brand-box {
        padding: 15px;
        text-align: center;
    }

    /* Menu Icon Styling */
    .menu-icon {
        color: #edb043;
        min-width: 24px;
        font-size: 18px;
    }

    /* Menu Items */
    #side-menu > li > a {
        padding: 12px 20px;
        color: #333333;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        transition: background-color 0.3s, color 0.3s;
    }

    /* Hover Effects */
    #side-menu > li > a:hover,
    #side-menu > li > a.active {
        background-color: #edb043;
        color: #ffffff;
    }

    /* Sub-menu Items */
    .sub-menu a {
        padding: 10px 40px;
        color: #555555;
        font-weight: 400;
        display: block;
        transition: background-color 0.3s, color 0.3s;
    }

    /* Sub-menu Hover */
    .sub-menu a:hover {
        background-color: #a3854f;
        color: #edb043;
    }

    /* Arrow Indicators */
    .has-arrow {
        position: relative;
    }

    .has-arrow::after {
        content: '\f078';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: 20px;
        font-size: 0.8rem;
        transition: transform 0.3s;
        color: #fff;
    }

    .has-arrow.collapsed::after {
        transform: rotate(-90deg);
        color: #ffffff;
    }

    /* Active Menu Styling */
    .metismenu .mm-active > a {
        background-color: #edb043;
        color: #ffffff;
    }

    /* Sidebar User Info */
    .sidebar-user-info {
        position: absolute;
        bottom: 0;
        width: 100%;
        background-color: #0f2c32;
        padding: 15px;
        border-top: 1px solid #e0e0e0;
    }

    .sidebar-user-info img {
        width: 40px;
        height: 40px;
    }

    .sidebar-user-info .dropdown-menu {
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    }

    /* Dropdown Menu Items */
    .dropdown-item i {
        width: 20px;
        text-align: center;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .vertical-menu {
            width: 100%;
            height: auto;
            position: relative;
        }
    }
</style>
