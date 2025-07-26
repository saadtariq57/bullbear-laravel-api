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
                                    <label for="post_frequency" class="form-label">Post Frequency</label>
                                    <select class="form-select" id="post_frequency" name="post_frequency">
                                        <option value="low" {{ old('post_frequency', $bot->post_frequency ?? 'low') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('post_frequency', $bot->post_frequency) == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('post_frequency', $bot->post_frequency) == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                    <div class="form-text">How frequently this bot should create posts</div>
                                </div>

                                <div class="mb-3">
                                    <label for="activity_level" class="form-label">Activity Level</label>
                                    <input type="number" class="form-control" id="activity_level" name="activity_level" value="{{ old('activity_level', $bot->activity_level ?? 3) }}" min="1" max="10" placeholder="3">
                                    <div class="form-text">Bot activity level from 1 (low) to 10 (high)</div>
                                </div>

                                <div class="mb-3">
                                    <label for="group_post_probability" class="form-label">Group Post Probability</label>
                                    <input type="number" class="form-control" id="group_post_probability" name="group_post_probability" value="{{ old('group_post_probability', $bot->group_post_probability ?? 5) }}" min="1" max="10" placeholder="5">
                                    <div class="form-text">Probability scale 1-10 for posting in groups (1=rarely posts in groups, 10=always posts in groups)</div>
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

                                <!-- Human-like Behavior Section -->
                                <div class="mb-4">
                                    <h6 class="text-primary mb-3">Human-like Behavior Settings</h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="slang_level" class="form-label">Slang Level</label>
                                                <select class="form-select" id="slang_level" name="slang_level">
                                                    <option value="">Not Set</option>
                                                    <option value="none" {{ old('slang_level', $bot->slang_level) == 'none' ? 'selected' : '' }}>None</option>
                                                    <option value="very low" {{ old('slang_level', $bot->slang_level) == 'very low' ? 'selected' : '' }}>Very Low</option>
                                                    <option value="low" {{ old('slang_level', $bot->slang_level) == 'low' ? 'selected' : '' }}>Low</option>
                                                    <option value="occasional" {{ old('slang_level', $bot->slang_level) == 'occasional' ? 'selected' : '' }}>Occasional</option>
                                                    <option value="moderate" {{ old('slang_level', $bot->slang_level) == 'moderate' ? 'selected' : '' }}>Moderate</option>
                                                    <option value="frequent" {{ old('slang_level', $bot->slang_level) == 'frequent' ? 'selected' : '' }}>Frequent</option>
                                                    <option value="heavy" {{ old('slang_level', $bot->slang_level) == 'heavy' ? 'selected' : '' }}>Heavy</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="emoji_use" class="form-label">Emoji Usage</label>
                                                <select class="form-select" id="emoji_use" name="emoji_use">
                                                    <option value="">Not Set</option>
                                                    <option value="none" {{ old('emoji_use', $bot->emoji_use) == 'none' ? 'selected' : '' }}>None</option>
                                                    <option value="very low" {{ old('emoji_use', $bot->emoji_use) == 'very low' ? 'selected' : '' }}>Very Low</option>
                                                    <option value="low" {{ old('emoji_use', $bot->emoji_use) == 'low' ? 'selected' : '' }}>Low</option>
                                                    <option value="occasional" {{ old('emoji_use', $bot->emoji_use) == 'occasional' ? 'selected' : '' }}>Occasional</option>
                                                    <option value="moderate" {{ old('emoji_use', $bot->emoji_use) == 'moderate' ? 'selected' : '' }}>Moderate</option>
                                                    <option value="frequent" {{ old('emoji_use', $bot->emoji_use) == 'frequent' ? 'selected' : '' }}>Frequent</option>
                                                    <option value="heavy" {{ old('emoji_use', $bot->emoji_use) == 'heavy' ? 'selected' : '' }}>Heavy</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="punctuation" class="form-label">Punctuation Style</label>
                                                <select class="form-select" id="punctuation" name="punctuation">
                                                    <option value="">Not Set</option>
                                                    <option value="none" {{ old('punctuation', $bot->punctuation) == 'none' ? 'selected' : '' }}>None</option>
                                                    <option value="very low" {{ old('punctuation', $bot->punctuation) == 'very low' ? 'selected' : '' }}>Very Low</option>
                                                    <option value="low" {{ old('punctuation', $bot->punctuation) == 'low' ? 'selected' : '' }}>Low</option>
                                                    <option value="occasional" {{ old('punctuation', $bot->punctuation) == 'occasional' ? 'selected' : '' }}>Occasional</option>
                                                    <option value="moderate" {{ old('punctuation', $bot->punctuation) == 'moderate' ? 'selected' : '' }}>Moderate</option>
                                                    <option value="frequent" {{ old('punctuation', $bot->punctuation) == 'frequent' ? 'selected' : '' }}>Frequent</option>
                                                    <option value="heavy" {{ old('punctuation', $bot->punctuation) == 'heavy' ? 'selected' : '' }}>Heavy</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="caps_on_hype" name="caps_on_hype" value="1" {{ old('caps_on_hype', $bot->caps_on_hype) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="caps_on_hype">
                                                        ALL CAPS on Hype Posts
                                                    </label>
                                                </div>
                                                <div class="form-text">Use ALL CAPS when posting about exciting or hype content.</div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="mb-3">
                                        <label for="quirks" class="form-label">Behavioral Quirks</label>
                                        <div id="quirks-container">
                                            @php
                                                $quirks = old('quirks', $bot->quirks ?? []);
                                            @endphp
                                            @if(count($quirks) > 0)
                                                @foreach($quirks as $index => $quirk)
                                                    <div class="input-group mb-2 quirk-input">
                                                        <input type="text" class="form-control" name="quirks[]" value="{{ $quirk }}" placeholder="e.g., Always says 'WAGMI', Uses 'NFA' frequently">
                                                        <button class="btn btn-outline-danger" type="button" onclick="removeQuirk(this)">
                                                            <i class="mdi mdi-minus"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="input-group mb-2 quirk-input">
                                                    <input type="text" class="form-control" name="quirks[]" placeholder="e.g., Always says 'WAGMI', Uses 'NFA' frequently">
                                                    <button class="btn btn-outline-danger" type="button" onclick="removeQuirk(this)">
                                                        <i class="mdi mdi-minus"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addQuirk()">
                                            <i class="mdi mdi-plus me-1"></i> Add Quirk
                                        </button>
                                        <div class="form-text">Catchphrases, habits, or unique behavioral patterns.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="post_style" class="form-label">Post Styles</label>
                                        <div id="post-style-container">
                                            @php
                                                $postStyles = old('post_style', $bot->post_style ?? []);
                                            @endphp
                                            @if(count($postStyles) > 0)
                                                @foreach($postStyles as $index => $style)
                                                    <div class="input-group mb-2 post-style-input">
                                                        <input type="text" class="form-control" name="post_style[]" value="{{ $style }}" placeholder="e.g., one-liner, short rant, bullet points">
                                                        <button class="btn btn-outline-danger" type="button" onclick="removePostStyle(this)">
                                                            <i class="mdi mdi-minus"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="input-group mb-2 post-style-input">
                                                    <input type="text" class="form-control" name="post_style[]" placeholder="e.g., one-liner, short rant, bullet points">
                                                    <button class="btn btn-outline-danger" type="button" onclick="removePostStyle(this)">
                                                        <i class="mdi mdi-minus"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addPostStyle()">
                                            <i class="mdi mdi-plus me-1"></i> Add Style
                                        </button>
                                        <div class="form-text">Preferred post formats and styles.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="formats" class="form-label">Special Formats</label>
                                        <div id="formats-container">
                                            @php
                                                $formats = old('formats', $bot->formats ?? []);
                                            @endphp
                                            @if(count($formats) > 0)
                                                @foreach($formats as $index => $format)
                                                    <div class="input-group mb-2 format-input">
                                                        <input type="text" class="form-control" name="formats[]" value="{{ $format }}" placeholder="e.g., reaction only, stat dump, meme comment">
                                                        <button class="btn btn-outline-danger" type="button" onclick="removeFormat(this)">
                                                            <i class="mdi mdi-minus"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="input-group mb-2 format-input">
                                                    <input type="text" class="form-control" name="formats[]" placeholder="e.g., reaction only, stat dump, meme comment">
                                                    <button class="btn btn-outline-danger" type="button" onclick="removeFormat(this)">
                                                        <i class="mdi mdi-minus"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addFormat()">
                                            <i class="mdi mdi-plus me-1"></i> Add Format
                                        </button>
                                        <div class="form-text">Special post types like reactions, stats, or memes.</div>
                                    </div>
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



        // Quirks functions
        function addQuirk() {
            const container = document.getElementById('quirks-container');
            const newQuirkHtml = `
                <div class="input-group mb-2 quirk-input">
                    <input type="text" class="form-control" name="quirks[]" placeholder="e.g., Always says 'WAGMI', Uses 'NFA' frequently">
                    <button class="btn btn-outline-danger" type="button" onclick="removeQuirk(this)">
                        <i class="mdi mdi-minus"></i>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newQuirkHtml);
        }

        function removeQuirk(button) {
            const container = document.getElementById('quirks-container');
            const inputs = container.querySelectorAll('.quirk-input');
            if (inputs.length > 1) {
                button.closest('.quirk-input').remove();
            } else {
                button.closest('.quirk-input').querySelector('input').value = '';
            }
        }

        // Post Style functions
        function addPostStyle() {
            const container = document.getElementById('post-style-container');
            const newStyleHtml = `
                <div class="input-group mb-2 post-style-input">
                    <input type="text" class="form-control" name="post_style[]" placeholder="e.g., one-liner, short rant, bullet points">
                    <button class="btn btn-outline-danger" type="button" onclick="removePostStyle(this)">
                        <i class="mdi mdi-minus"></i>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newStyleHtml);
        }

        function removePostStyle(button) {
            const container = document.getElementById('post-style-container');
            const inputs = container.querySelectorAll('.post-style-input');
            if (inputs.length > 1) {
                button.closest('.post-style-input').remove();
            } else {
                button.closest('.post-style-input').querySelector('input').value = '';
            }
        }

        // Formats functions
        function addFormat() {
            const container = document.getElementById('formats-container');
            const newFormatHtml = `
                <div class="input-group mb-2 format-input">
                    <input type="text" class="form-control" name="formats[]" placeholder="e.g., reaction only, stat dump, meme comment">
                    <button class="btn btn-outline-danger" type="button" onclick="removeFormat(this)">
                        <i class="mdi mdi-minus"></i>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newFormatHtml);
        }

        function removeFormat(button) {
            const container = document.getElementById('formats-container');
            const inputs = container.querySelectorAll('.format-input');
            if (inputs.length > 1) {
                button.closest('.format-input').remove();
            } else {
                button.closest('.format-input').querySelector('input').value = '';
            }
        }
    </script>
@endsection 