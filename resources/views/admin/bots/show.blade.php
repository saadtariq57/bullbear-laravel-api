@extends('admin.layouts.master')

@section('title')
    Bot Details: {{ $bot->user->name }}
@endsection

@section('page-title')
    Bot Details
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <!-- Bot Information Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Bot Configuration Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Bot User</h6>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-md me-3">
                                        <img src="{{ asset('upload/' . $bot->user->avatar) }}" alt="" class="img-fluid rounded-circle">
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $bot->user->name }}</h5>
                                        <p class="text-muted mb-0">{{ $bot->user->email }}</p>
                                        <small class="text-muted">User ID: {{ $bot->user->id }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Bot Role</h6>
                                @if($bot->role)
                                    <span class="badge bg-primary fs-6 px-3 py-2">{{ ucfirst($bot->role) }}</span>
                                @else
                                    <span class="text-muted fst-italic">No role assigned</span>
                                @endif
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Bot Style</h6>
                                @if($bot->style)
                                    <span class="badge bg-info fs-6 px-3 py-2">{{ ucfirst($bot->style) }}</span>
                                @else
                                    <span class="text-muted fst-italic">No style defined</span>
                                @endif
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Post Frequency</h6>
                                @if($bot->post_frequency)
                                    <span class="badge bg-{{ $bot->post_frequency == 'high' ? 'warning' : ($bot->post_frequency == 'medium' ? 'info' : 'secondary') }} fs-6 px-3 py-2">
                                        {{ ucfirst($bot->post_frequency) }}
                                    </span>
                                @else
                                    <span class="text-muted fst-italic">Not set</span>
                                @endif
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Activity Level</h6>
                                @if($bot->activity_level)
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-primary fs-6 px-3 py-2 me-2">{{ $bot->activity_level }}</span>
                                        <small class="text-muted">out of 10</small>
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">Not set</span>
                                @endif
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Group Post Probability</h6>
                                @if($bot->group_post_probability)
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-info fs-6 px-3 py-2 me-2">{{ $bot->group_post_probability }}</span>
                                        <small class="text-muted">out of 10 ({{ $bot->group_post_probability <= 3 ? 'Rarely' : ($bot->group_post_probability <= 6 ? 'Sometimes' : 'Often') }} posts in groups)</small>
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">Not set</span>
                                @endif
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Status</h6>
                                @if($bot->is_active)
                                    <span class="badge bg-success fs-6 px-3 py-2">
                                        <i class="mdi mdi-check-circle me-1"></i> Active
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6 px-3 py-2">
                                        <i class="mdi mdi-close-circle me-1"></i> Inactive
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Topics</h6>
                                @if($bot->topics && count($bot->topics) > 0)
                                    <div class="d-flex flex-column gap-2">
                                        @foreach($bot->topics as $topic)
                                            @php
                                                $name = is_array($topic) ? ($topic['name'] ?? ($topic['url'] ?? 'Topic')) : (string) $topic;
                                                $url = is_array($topic) ? ($topic['url'] ?? null) : null;
                                                $note = is_array($topic) ? ($topic['note'] ?? null) : null;
                                            @endphp
                                            <div class="border rounded p-2">
                                                <div class="fw-bold">{{ $name }}</div>
                                                @if($url)
                                                    <small class="text-muted"><a href="{{ $url }}" target="_blank">{{ $url }}</a></small>
                                                @endif
                                                @if($note)
                                                    <div><small class="text-muted">Note: {{ $note }}</small></div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">No topics defined</span>
                                @endif
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Created Date</h6>
                                <p class="mb-0">{{ $bot->created_at->format('F d, Y \a\t h:i A') }}</p>
                                <small class="text-muted">{{ $bot->created_at->diffForHumans() }}</small>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Last Updated</h6>
                                <p class="mb-0">{{ $bot->updated_at->format('F d, Y \a\t h:i A') }}</p>
                                <small class="text-muted">{{ $bot->updated_at->diffForHumans() }}</small>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Last Active</h6>
                                @if($bot->last_active)
                                    <p class="mb-0">{{ $bot->last_active->format('F d, Y \a\t h:i A') }}</p>
                                    <small class="text-muted">{{ $bot->last_active->diffForHumans() }}</small>
                                @else
                                    <span class="text-muted fst-italic">Never active</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Human-like Behavior Settings -->
                    @if($bot->slang_level || $bot->emoji_use || $bot->punctuation || $bot->caps_on_hype || 
                        ($bot->quirks && count($bot->quirks) > 0) || 
                        ($bot->post_style && count($bot->post_style) > 0) || 
                        ($bot->formats && count($bot->formats) > 0))
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">Human-like Behavior Settings</h5>
                                
                                <div class="row">
                                    @if($bot->slang_level || $bot->emoji_use || $bot->punctuation || $bot->caps_on_hype)
                                        <div class="col-md-6">
                                            @if($bot->slang_level)
                                                <div class="mb-3">
                                                    <h6 class="text-muted mb-2">Slang Level</h6>
                                                    <span class="badge bg-secondary fs-6 px-3 py-2">{{ ucfirst($bot->slang_level) }}</span>
                                                </div>
                                            @endif

                                            @if($bot->emoji_use)
                                                <div class="mb-3">
                                                    <h6 class="text-muted mb-2">Emoji Usage</h6>
                                                    <span class="badge bg-secondary fs-6 px-3 py-2">{{ ucfirst($bot->emoji_use) }}</span>
                                                </div>
                                            @endif

                                            @if($bot->punctuation)
                                                <div class="mb-3">
                                                    <h6 class="text-muted mb-2">Punctuation Style</h6>
                                                    <span class="badge bg-secondary fs-6 px-3 py-2">{{ ucfirst($bot->punctuation) }}</span>
                                                </div>
                                            @endif

                                            @if($bot->caps_on_hype)
                                                <div class="mb-3">
                                                    <h6 class="text-muted mb-2">Hype Behavior</h6>
                                                    <span class="badge bg-warning fs-6 px-3 py-2">
                                                        <i class="mdi mdi-format-letter-case-upper me-1"></i> ALL CAPS on Hype
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="col-md-6">


                                        @if($bot->quirks && count($bot->quirks) > 0)
                                            <div class="mb-3">
                                                <h6 class="text-muted mb-2">Behavioral Quirks</h6>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($bot->quirks as $quirk)
                                                        <span class="badge bg-info text-white">{{ $quirk }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        @if($bot->post_style && count($bot->post_style) > 0)
                                            <div class="mb-3">
                                                <h6 class="text-muted mb-2">Post Styles</h6>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($bot->post_style as $style)
                                                        <span class="badge bg-success text-white">{{ $style }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        @if($bot->formats && count($bot->formats) > 0)
                                            <div class="mb-3">
                                                <h6 class="text-muted mb-2">Special Formats</h6>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($bot->formats as $format)
                                                        <span class="badge bg-primary text-white">{{ $format }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($bot->instructions)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="text-muted mb-2">AI Instructions</h6>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0 pre-wrap">{{ $bot->instructions }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.bots.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left me-1"></i> Back to Bots
                        </a>
                        <div>
                            <a href="{{ route('admin.bots.edit', $bot->id) }}" class="btn btn-primary">
                                <i class="mdi mdi-pencil me-1"></i> Edit Configuration
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Statistics Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="avatar-sm mx-auto mb-2">
                                    <div class="avatar-title bg-soft-primary text-primary rounded-circle fs-4">
                                        <i class="mdi mdi-tag-multiple"></i>
                                    </div>
                                </div>
                                <h5 class="mb-1">{{ $bot->topics ? count($bot->topics) : 0 }}</h5>
                                <p class="text-muted mb-0 fs-13">Topics</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="avatar-sm mx-auto mb-2">
                                    <div class="avatar-title {{ $bot->is_active ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} rounded-circle fs-4">
                                        <i class="mdi {{ $bot->is_active ? 'mdi-check-circle' : 'mdi-close-circle' }}"></i>
                                    </div>
                                </div>
                                <h5 class="mb-1">{{ $bot->is_active ? 'Active' : 'Inactive' }}</h5>
                                <p class="text-muted mb-0 fs-13">Status</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="avatar-sm mx-auto mb-2">
                                    <div class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                                        <i class="mdi mdi-clock-outline"></i>
                                    </div>
                                </div>
                                <h6 class="mb-1">{{ $bot->created_at->diffForHumans() }}</h6>
                                <p class="text-muted mb-0 fs-13">Created</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Associated User Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Associated User Details</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar-lg mx-auto mb-3">
                            <img src="{{ asset('upload/' . $bot->user->avatar) }}" alt="" class="img-fluid rounded-circle">
                        </div>
                        <h5 class="mb-1">{{ $bot->user->name }}</h5>
                        <p class="text-muted mb-0">{{ $bot->user->email }}</p>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted">User Type:</td>
                                    <td><span class="badge bg-warning">{{ ucfirst($bot->user->type) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Status:</td>
                                    <td><span class="badge bg-{{ $bot->user->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($bot->user->status) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Joined:</td>
                                    <td>{{ $bot->user->created_at->format('M d, Y') }}</td>
                                </tr>
                                @if($bot->user->email_verified_at)
                                    <tr>
                                        <td class="text-muted">Email:</td>
                                        <td><span class="badge bg-success">Verified</span></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('admin.users.edit', $bot->user->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="mdi mdi-account-edit me-1"></i> Edit User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .pre-wrap {
            white-space: pre-wrap;
        }
    </style>
@endsection 