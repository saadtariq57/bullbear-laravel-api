@extends('admin.layouts.master')

@section('title')
    Add New Bot
@endsection

@section('page-title')
    Add New Bot Configuration
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.bots.store') }}" method="POST">
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Bot Configuration</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Select Bot User <span class="text-danger">*</span></label>
                                    <select class="form-select" id="user_id" name="user_id" required>
                                        <option value="">Choose a bot user...</option>
                                        @forelse($availableBotUsers as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @empty
                                            <option value="" disabled>No available bot users found</option>
                                        @endforelse
                                    </select>
                                    <div class="form-text">Only users with type "bot" that don't have bot configuration are shown.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Bot Role</label>
                                    <input type="text" class="form-control" id="role" name="role" value="{{ old('role') }}" placeholder="e.g., Analyst, Assistant, Moderator">
                                    <div class="form-text">Enter the bot's primary role (e.g., Financial Analyst, Creative Assistant, Support Agent)</div>
                                </div>

                                <div class="mb-3">
                                    <label for="style" class="form-label">Bot Style</label>
                                    <input type="text" class="form-control" id="style" name="style" value="{{ old('style') }}" placeholder="e.g., Detailed, data-driven, rational">
                                    <div class="form-text">Describe the bot's communication style (e.g., Professional and concise, Friendly and helpful, Creative and engaging)</div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
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
                                        @if(old('topics'))
                                            @foreach(old('topics') as $index => $topic)
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
                                    <textarea class="form-control" id="instructions" name="instructions" rows="8" placeholder="Enter instructions for the AI behavior...">{{ old('instructions') }}</textarea>
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
                                    <button type="submit" class="btn btn-primary">
                                        <i class="mdi mdi-check me-1"></i> Create Bot Configuration
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(count($availableBotUsers) === 0)
        <div class="row mt-3">
            <div class="col-12">
                <div class="alert alert-info">
                    <h6 class="alert-heading">No Available Bot Users</h6>
                    <p class="mb-0">
                        You need to create users with type "bot" first. 
                        <a href="{{ route('admin.users.create') }}" class="alert-link">Create a bot user here</a>.
                    </p>
                </div>
            </div>
        </div>
    @endif
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

        // Focus on user selection if no users available
        document.addEventListener('DOMContentLoaded', function() {
            const userSelect = document.getElementById('user_id');
            const options = userSelect.querySelectorAll('option[value!=""]');
            
            if (options.length === 0) {
                userSelect.disabled = true;
            }
        });
    </script>
@endsection 