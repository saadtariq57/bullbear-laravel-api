@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('css')
    <!-- jsvectormap css -->
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .custom-icon {
            color: #edb043;
        }
    </style>
@endsection

@section('page-title', 'Dashboard')

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <!-- Total Users -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                                <i class="fas fa-users custom-icon"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-4">
                            <p class="text-muted text-truncate font-size-15 mb-2">Total Users</p>
                            <h3 class="fs-4 flex-grow-1 mb-3">{{ number_format($totalUsers) }}</h3>
                            <p class="text-muted mb-0 text-truncate">
                                <span class="badge bg-subtle-success text-success font-size-12 fw-normal me-1">
                                    <i class="fas fa-arrow-up custom-icon"></i> 5% Increase
                                </span> vs last month
                            </p>
                        </div>
                        <div class="flex-shrink-0 align-self-start">
                            <div class="dropdown">
                                <a class="dropdown-toggle btn-icon border rounded-circle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v text-muted font-size-16"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Today</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Users -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                                <i class="fas fa-user-check custom-icon"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-4">
                            <p class="text-muted text-truncate font-size-15 mb-2">Active Users</p>
                            <h3 class="fs-4 flex-grow-1 mb-3">{{ number_format($activeUsers) }}</h3>
                            <p class="text-muted mb-0 text-truncate">
                                <span class="badge bg-subtle-success text-success font-size-12 fw-normal me-1">
                                    <i class="fas fa-arrow-up custom-icon"></i> 3% Increase
                                </span> vs last month
                            </p>
                        </div>
                        <div class="flex-shrink-0 align-self-start">
                            <div class="dropdown">
                                <a class="dropdown-toggle btn-icon border rounded-circle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v text-muted font-size-16"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Today</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Watchlists -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                                <i class="fas fa-list-ul custom-icon"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-4">
                            <p class="text-muted text-truncate font-size-15 mb-2">Total Watchlists</p>
                            <h3 class="fs-4 flex-grow-1 mb-3">{{ number_format($totalWatchlists) }}</h3>
                            <p class="text-muted mb-0 text-truncate">
                                <span class="badge bg-subtle-success text-success font-size-12 fw-normal me-1">
                                    <i class="fas fa-arrow-up custom-icon"></i> 4% Increase
                                </span> vs last month
                            </p>
                        </div>
                        <div class="flex-shrink-0 align-self-start">
                            <div class="dropdown">
                                <a class="dropdown-toggle btn-icon border rounded-circle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v text-muted font-size-16"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Today</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Symbols -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                                <i class="fas fa-chart-line custom-icon"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-4">
                            <p class="text-muted text-truncate font-size-15 mb-2">Active Symbols</p>
                            <h3 class="fs-4 flex-grow-1 mb-3">{{ number_format($activeSymbols) }}</h3>
                            <p class="text-muted mb-0 text-truncate">
                                <span class="badge bg-subtle-success text-success font-size-12 fw-normal me-1">
                                    <i class="fas fa-arrow-up custom-icon"></i> 8% Increase
                                </span> vs last month
                            </p>
                        </div>
                        <div class="flex-shrink-0 align-self-start">
                            <div class="dropdown">
                                <a class="dropdown-toggle btn-icon border rounded-circle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v text-muted font-size-16"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Today</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END ROW -->

    <div class="row">
        <!-- User Growth Metrics -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header border-0 align-items-center d-flex pb-0">
                    <h4 class="card-title mb-0 flex-grow-1">User Growth Metrics</h4>
                    <div>
                        <button type="button" class="btn btn-soft-secondary btn-sm">ALL</button>
                        <button type="button" class="btn btn-soft-secondary btn-sm">1M</button>
                        <button type="button" class="btn btn-soft-secondary btn-sm">6M</button>
                        <button type="button" class="btn btn-soft-primary btn-sm">1Y</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-xl-8">
                            <div id="user-growth-chart" class="apex-charts"></div>
                        </div>
                        <div class="col-xl-4">
                            <div id="exam-metrics-donut" class="apex-charts"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Users By Zip -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header border-0 align-items-center d-flex pb-1">
                    <h4 class="card-title mb-0 flex-grow-1">Live Users By Zip</h4>
                    <div>
                        <button type="button" class="btn btn-soft-primary btn-sm">Export Report</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="zip-map-markers" style="height: 346px;"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->

    <div class="row">
        <!-- Top Contributors -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header border-0 align-items-center d-flex pb-0">
                    <h4 class="card-title mb-0 flex-grow-1">Top Contributors</h4>
                    <div>
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                This Year<i class="mdi mdi-chevron-down ms-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">This Year</a>
                                <a class="dropdown-item" href="#">This Month</a>
                                <a class="dropdown-item" href="#">This Week</a>
                                <a class="dropdown-item" href="#">Today</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($topContributors as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                    <p class="mb-0 text-muted">{{ $user->email }}</p>
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $user->posts_count }} Posts</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">View All Contributors <i class="mdi mdi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Activities -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header border-0 align-items-center d-flex pb-0">
                    <h4 class="card-title mb-0 flex-grow-1">Latest Activities</h4>
                    <div>
                        <div class="dropdown">
                            <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fw-semibold">Filter:</span>
                                <span class="text-muted">Today<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Today</a>
                                <a class="dropdown-item" href="#">This Week</a>
                                <a class="dropdown-item" href="#">This Month</a>
                                <a class="dropdown-item" href="#">This Year</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <ul class="list-group list-group-flush">
                        @foreach($latestWatchlists as $watchlist)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">{{ $watchlist->user->name }} added a new watchlist</h6>
                                    <p class="mb-0 text-muted">{{ \Carbon\Carbon::parse($watchlist->created_at)->diffForHumans() }}</p>
                                </div>
                                <span class="badge bg-primary rounded-pill">Watchlist #{{ $watchlist->id }}</span>
                            </li>
                        @endforeach
                        @foreach($latestPosts as $post)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">{{ $post->user->name }} created a new post</h6>
                                    <p class="mb-0 text-muted">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
                                </div>
                                <span class="badge bg-success rounded-pill">Post #{{ $post->id }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-primary btn-sm">View All Activities <i class="mdi mdi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- END ROW -->
    <!-- Exam Metrics Section -->
    <div class="row">
        <!-- Total Exams -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                                <i class="fas fa-file-alt custom-icon"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-4">
                            <p class="text-muted text-truncate font-size-15 mb-2">Total Exams</p>
                            <h3 class="fs-4 flex-grow-1 mb-3">{{ number_format($totalExams) }}</h3>
                            <p class="text-muted mb-0 text-truncate">
                                <span class="badge bg-subtle-success text-success font-size-12 fw-normal me-1">
                                    <i class="fas fa-arrow-up custom-icon"></i> 6% Increase
                                </span> vs last month
                            </p>
                        </div>
                        <div class="flex-shrink-0 align-self-start">
                            <div class="dropdown">
                                <a class="dropdown-toggle btn-icon border rounded-circle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v text-muted font-size-16"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Today</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Exams -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                                <i class="fas fa-clipboard-check custom-icon"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-4">
                            <p class="text-muted text-truncate font-size-15 mb-2">Active Exams</p>
                            <h3 class="fs-4 flex-grow-1 mb-3">{{ number_format($activeExams) }}</h3>
                            <p class="text-muted mb-0 text-truncate">
                                <span class="badge bg-subtle-success text-success font-size-12 fw-normal me-1">
                                    <i class="fas fa-arrow-up custom-icon"></i> 7% Increase
                                </span> vs last month
                            </p>
                        </div>
                        <div class="flex-shrink-0 align-self-start">
                            <div class="dropdown">
                                <a class="dropdown-toggle btn-icon border rounded-circle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v text-muted font-size-16"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Today</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Questions -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                                <i class="fas fa-question-circle custom-icon"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-4">
                            <p class="text-muted text-truncate font-size-15 mb-2">Total Questions</p>
                            <h3 class="fs-4 flex-grow-1 mb-3">{{ number_format($totalQuestions) }}</h3>
                            <p class="text-muted mb-0 text-truncate">
                                <span class="badge bg-subtle-success text-success font-size-12 fw-normal me-1">
                                    <i class="fas fa-arrow-up custom-icon"></i> 10% Increase
                                </span> vs last month
                            </p>
                        </div>
                        <div class="flex-shrink-0 align-self-start">
                            <div class="dropdown">
                                <a class="dropdown-toggle btn-icon border rounded-circle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v text-muted font-size-16"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Today</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Questions per Exam -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                                <i class="fas fa-calculator custom-icon"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-4">
                            <p class="text-muted text-truncate font-size-15 mb-2">Avg Questions/Exam</p>
                            <h3 class="fs-4 flex-grow-1 mb-3">{{ number_format($averageQuestionsPerExam, 2) }}</h3>
                            <p class="text-muted mb-0 text-truncate">
                                <span class="badge bg-subtle-success text-success font-size-12 fw-normal me-1">
                                    <i class="fas fa-arrow-up custom-icon"></i> 1.5% Increase
                                </span> vs last month
                            </p>
                        </div>
                        <div class="flex-shrink-0 align-self-start">
                            <div class="dropdown">
                                <a class="dropdown-toggle btn-icon border rounded-circle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v text-muted font-size-16"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Today</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Top Groups -->
        <div class="col-xl-7">
            <div class="card">
                <div class="card-header border-0 align-items-center d-flex pb-0">
                    <h4 class="card-title mb-0 flex-grow-1">Top Groups</h4>
                    <div>
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                This Year<i class="mdi mdi-chevron-down ms-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">This Year</a>
                                <a class="dropdown-item" href="#">This Month</a>
                                <a class="dropdown-item" href="#">This Week</a>
                                <a class="dropdown-item" href="#">Today</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($topGroups as $group)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">{{ $group->group_name }}</h6>
                                    <p class="mb-0 text-muted">{{ $group->category->name ?? 'No Category' }}</p>
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $group->members_count }} Members</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.groups.index') }}" class="btn btn-primary btn-sm">View All Groups <i class="mdi mdi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Watchlists Over Time (Area Chart) -->
        <div class="col-xl-5">
            <div class="card">
                <div class="card-header border-0 align-items-center d-flex pb-0">
                    <h4 class="card-title mb-0 flex-grow-1">Active Watchlists Over Time</h4>
                    <div>
                        <div class="dropdown">
                            <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fw-semibold">Filter:</span>
                                <span class="text-muted">Last 12 Months<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Last 12 Months</a>
                                <a class="dropdown-item" href="#">Last 6 Months</a>
                                <a class="dropdown-item" href="#">Last 3 Months</a>
                                <a class="dropdown-item" href="#">Last Month</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="active-watchlists-chart" class="apex-charts"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->
@endsection

@section('scripts')
    <!-- apexcharts -->
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/dashboard.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
