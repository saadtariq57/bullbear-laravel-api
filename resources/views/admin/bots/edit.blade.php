@extends('admin.layouts.master')

@section('title')
    Edit Bot Configuration
@endsection

@section('page-title')
    Edit Bot: {{ $bot->user->name }}
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.bots.update', $bot->id) }}" method="POST">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Bot Configuration</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Bot User</label>
                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                        <div class="avatar-sm me-3">
                                            <img src="{{ asset('upload/' . $bot->user->avatar) }}" alt="" class="img-fluid rounded-circle">
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ $bot->user->name }}</h6>
                                            <p class="text-muted mb-0">{{ $bot->user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="form-text">Bot user cannot be changed after creation.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Bot Role</label>
                                    <input type="text" class="form-control" id="role" name="role" value="{{ old('role', $bot->role) }}" placeholder="e.g., Analyst, Assistant, Moderator">
                                    <div class="form-text">Enter the bot's primary role (e.g., Financial Analyst, Creative Assistant, Support Agent)</div>
                                </div>

                                <div class="mb-3">
                                    <label for="style" class="form-label">Bot Style</label>
                                    <input type="text" class="form-control" id="style" name="style" value="{{ old('style', $bot->style) }}" placeholder="e.g., Detailed, data-driven, rational">
                                    <div class="form-text">Describe the bot's communication style (e.g., Professional and concise, Friendly and helpful, Creative and engaging)</div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $bot->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Bot is Active
                                        </label>
                                    </div>
                                    <div class="form-text">Active bots can respond to messages and interactions.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="topics" class="form-label">Topics</label>
                                    <div id="topics-container">
                                        @php
                                            $topics = old('topics', $bot->topics ?? []);
                                        @endphp
                                        @if(count($topics) > 0)
                                            @foreach($topics as $index => $topic)
                                                <div class="input-group mb-2 topic-input">
                                                    <input type="text" class="form-control" name="topics[]" value="{{ $topic }}" placeholder="Enter topic...">
                                                    <button class="btn btn-outline-danger" type="button" onclick="removeTopic(this)">
                                                        <i class="mdi mdi-minus"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="input-group mb-2 topic-input">
                                                <input type="text" class="form-control" name="topics[]" placeholder="Enter topic...">
                                                <button class="btn btn-outline-danger" type="button" onclick="removeTopic(this)">
                                                    <i class="mdi mdi-minus"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addTopic()">
                                        <i class="mdi mdi-plus me-1"></i> Add Topic
                                    </button>
                                    <div class="form-text">Add topics that this bot can discuss (e.g., technology, trading, news).</div>
                                </div>

                                <div class="mb-3">
                                    <label for="instructions" class="form-label">AI Instructions</label>
                                    <textarea class="form-control" id="instructions" name="instructions" rows="8" placeholder="Enter instructions for the AI behavior...">{{ old('instructions', $bot->instructions) }}</textarea>
                                    <div class="form-text">Provide specific instructions on how this bot should behave and respond.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.bots.index') }}" class="btn btn-secondary">
                                        <i class="mdi mdi-arrow-left me-1"></i> Back to Bots
                                    </a>
                                    <div>
                                        <a href="{{ route('admin.bots.show', $bot->id) }}" class="btn btn-info me-2">
                                            <i class="mdi mdi-eye me-1"></i> View Details
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="mdi mdi-check me-1"></i> Update Bot Configuration
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bot Statistics Card -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Bot Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0 me-3">
                                    <div class="avatar-title bg-soft-primary text-primary rounded fs-4">
                                        <i class="mdi mdi-calendar-plus"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Created</p>
                                    <h5 class="mb-0">{{ $bot->created_at->format('M d, Y') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0 me-3">
                                    <div class="avatar-title bg-soft-success text-success rounded fs-4">
                                        <i class="mdi mdi-update"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Last Updated</p>
                                    <h5 class="mb-0">{{ $bot->updated_at->format('M d, Y') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0 me-3">
                                    <div class="avatar-title bg-soft-info text-info rounded fs-4">
                                        <i class="mdi mdi-tag-multiple"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Topics Count</p>
                                    <h5 class="mb-0">{{ $bot->topics ? count($bot->topics) : 0 }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0 me-3">
                                    <div class="avatar-title {{ $bot->is_active ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} rounded fs-4">
                                        <i class="mdi {{ $bot->is_active ? 'mdi-check-circle' : 'mdi-close-circle' }}"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Status</p>
                                    <h5 class="mb-0">{{ $bot->is_active ? 'Active' : 'Inactive' }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function addTopic() {
            const container = document.getElementById('topics-container');
            const newTopicHtml = `
                <div class="input-group mb-2 topic-input">
                    <input type="text" class="form-control" name="topics[]" placeholder="Enter topic...">
                    <button class="btn btn-outline-danger" type="button" onclick="removeTopic(this)">
                        <i class="mdi mdi-minus"></i>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newTopicHtml);
        }

        function removeTopic(button) {
            const container = document.getElementById('topics-container');
            const topicInputs = container.querySelectorAll('.topic-input');
            
            // Don't remove if it's the last one
            if (topicInputs.length > 1) {
                button.closest('.topic-input').remove();
            } else {
                // Clear the input instead of removing
                button.closest('.topic-input').querySelector('input').value = '';
            }
        }
    </script>
@endsection 