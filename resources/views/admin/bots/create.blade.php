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
                                    <label for="post_frequency" class="form-label">Post Frequency</label>
                                    <select class="form-select" id="post_frequency" name="post_frequency">
                                        <option value="low" {{ old('post_frequency', 'low') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('post_frequency') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('post_frequency') == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                    <div class="form-text">How frequently this bot should create posts</div>
                                </div>

                                <div class="mb-3">
                                    <label for="activity_level" class="form-label">Activity Level</label>
                                    <input type="number" class="form-control" id="activity_level" name="activity_level" value="{{ old('activity_level', 3) }}" min="1" max="10" placeholder="3">
                                    <div class="form-text">Bot activity level from 1 (low) to 10 (high)</div>
                                </div>

                                <div class="mb-3">
                                    <label for="group_post_probability" class="form-label">Group Post Probability</label>
                                    <input type="number" class="form-control" id="group_post_probability" name="group_post_probability" value="{{ old('group_post_probability', 5) }}" min="1" max="10" placeholder="5">
                                    <div class="form-text">Probability scale 1-10 for posting in groups (1=rarely posts in groups, 10=always posts in groups)</div>
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
                                    <label for="topics" class="form-label">Topics & Notes</label>
                                    <div class="mb-2">
                                        <input type="text" class="form-control" id="apiSearch" placeholder="Search RichTV Content APIs by name or URL...">
                                        <div class="form-text">Search and select APIs as topics; add an optional note per topic.</div>
                                                </div>
                                    <div id="apiResults" class="list-group mb-2" style="max-height: 220px; overflow:auto;"></div>
                                    <div id="selectedTopics">
                                        <!-- Filled dynamically: each row will contain hidden inputs topics[name], topics[url], topics[note] -->
                                    </div>
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
                                                    <option value="none" {{ old('slang_level') == 'none' ? 'selected' : '' }}>None</option>
                                                    <option value="very low" {{ old('slang_level') == 'very low' ? 'selected' : '' }}>Very Low</option>
                                                    <option value="low" {{ old('slang_level') == 'low' ? 'selected' : '' }}>Low</option>
                                                    <option value="occasional" {{ old('slang_level') == 'occasional' ? 'selected' : '' }}>Occasional</option>
                                                    <option value="moderate" {{ old('slang_level') == 'moderate' ? 'selected' : '' }}>Moderate</option>
                                                    <option value="frequent" {{ old('slang_level') == 'frequent' ? 'selected' : '' }}>Frequent</option>
                                                    <option value="heavy" {{ old('slang_level') == 'heavy' ? 'selected' : '' }}>Heavy</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="emoji_use" class="form-label">Emoji Usage</label>
                                                <select class="form-select" id="emoji_use" name="emoji_use">
                                                    <option value="">Not Set</option>
                                                    <option value="none" {{ old('emoji_use') == 'none' ? 'selected' : '' }}>None</option>
                                                    <option value="very low" {{ old('emoji_use') == 'very low' ? 'selected' : '' }}>Very Low</option>
                                                    <option value="low" {{ old('emoji_use') == 'low' ? 'selected' : '' }}>Low</option>
                                                    <option value="occasional" {{ old('emoji_use') == 'occasional' ? 'selected' : '' }}>Occasional</option>
                                                    <option value="moderate" {{ old('emoji_use') == 'moderate' ? 'selected' : '' }}>Moderate</option>
                                                    <option value="frequent" {{ old('emoji_use') == 'frequent' ? 'selected' : '' }}>Frequent</option>
                                                    <option value="heavy" {{ old('emoji_use') == 'heavy' ? 'selected' : '' }}>Heavy</option>
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
                                                    <option value="none" {{ old('punctuation') == 'none' ? 'selected' : '' }}>None</option>
                                                    <option value="very low" {{ old('punctuation') == 'very low' ? 'selected' : '' }}>Very Low</option>
                                                    <option value="low" {{ old('punctuation') == 'low' ? 'selected' : '' }}>Low</option>
                                                    <option value="occasional" {{ old('punctuation') == 'occasional' ? 'selected' : '' }}>Occasional</option>
                                                    <option value="moderate" {{ old('punctuation') == 'moderate' ? 'selected' : '' }}>Moderate</option>
                                                    <option value="frequent" {{ old('punctuation') == 'frequent' ? 'selected' : '' }}>Frequent</option>
                                                    <option value="heavy" {{ old('punctuation') == 'heavy' ? 'selected' : '' }}>Heavy</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="caps_on_hype" name="caps_on_hype" value="1" {{ old('caps_on_hype') ? 'checked' : '' }}>
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
                                            @if(old('quirks'))
                                                @foreach(old('quirks') as $index => $quirk)
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
                                            @if(old('post_style'))
                                                @foreach(old('post_style') as $index => $style)
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
                                            @if(old('formats'))
                                                @foreach(old('formats') as $index => $format)
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
                                    <textarea class="form-control" id="instructions" name="instructions" rows="8" placeholder="Enter instructions for the AI behavior...">{{ old('instructions') }}</textarea>
                                    <div class="form-text">Provide specific instructions on how this bot should behave and respond.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Engagement Settings</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-2">Action Weights (sum 100%)</h6>
                                    <div class="row g-2">
                                        <div class="col-4">
                                            <label class="form-label">React %</label>
                                            <input type="number" class="form-control" name="eng_actions_react" value="{{ old('eng_actions_react', 50) }}" min="0" max="100">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Comment %</label>
                                            <input type="number" class="form-control" name="eng_actions_comment" value="{{ old('eng_actions_comment', 30) }}" min="0" max="100">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">React+Comment %</label>
                                            <input type="number" class="form-control" name="eng_actions_both" value="{{ old('eng_actions_both', 20) }}" min="0" max="100">
                                        </div>
                                    </div>

                                    <h6 class="mt-3 mb-2">Sentiment Weights (sum 100%)</h6>
                                    <div class="row g-2">
                                        <div class="col-4">
                                            <label class="form-label">Positive</label>
                                            <input type="number" class="form-control" name="eng_sentiment_positive" value="{{ old('eng_sentiment_positive', 50) }}" min="0" max="100">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Neutral</label>
                                            <input type="number" class="form-control" name="eng_sentiment_neutral" value="{{ old('eng_sentiment_neutral', 30) }}" min="0" max="100">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Skeptical</label>
                                            <input type="number" class="form-control" name="eng_sentiment_skeptical" value="{{ old('eng_sentiment_skeptical', 20) }}" min="0" max="100">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Curious</label>
                                            <input type="number" class="form-control" name="eng_sentiment_curious" value="{{ old('eng_sentiment_curious', 0) }}" min="0" max="100">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Critical</label>
                                            <input type="number" class="form-control" name="eng_sentiment_critical" value="{{ old('eng_sentiment_critical', 0) }}" min="0" max="100">
                                        </div>
                                    </div>

                                    <h6 class="mt-3 mb-2">Reaction Weights</h6>
                                    <div class="row g-2">
                                        <div class="col-4">
                                            <label class="form-label">Like</label>
                                            <input type="number" class="form-control" name="eng_reaction_like" value="{{ old('eng_reaction_like', 40) }}" min="0" max="100">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Love</label>
                                            <input type="number" class="form-control" name="eng_reaction_love" value="{{ old('eng_reaction_love', 25) }}" min="0" max="100">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Haha</label>
                                            <input type="number" class="form-control" name="eng_reaction_haha" value="{{ old('eng_reaction_haha', 10) }}" min="0" max="100">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Wow</label>
                                            <input type="number" class="form-control" name="eng_reaction_wow" value="{{ old('eng_reaction_wow', 15) }}" min="0" max="100">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Sad</label>
                                            <input type="number" class="form-control" name="eng_reaction_sad" value="{{ old('eng_reaction_sad', 5) }}" min="0" max="100">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Angry</label>
                                            <input type="number" class="form-control" name="eng_reaction_angry" value="{{ old('eng_reaction_angry', 5) }}" min="0" max="100">
                                        </div>
                                    </div>

                                    <h6 class="mt-3 mb-2">Comment Length Distribution</h6>
                                    <div class="row g-2">
                                        <div class="col-4">
                                            <label class="form-label">Short %</label>
                                            <input type="number" class="form-control" name="eng_length_short" value="{{ old('eng_length_short', 50) }}" min="0" max="100">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Medium %</label>
                                            <input type="number" class="form-control" name="eng_length_medium" value="{{ old('eng_length_medium', 35) }}" min="0" max="100">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Long %</label>
                                            <input type="number" class="form-control" name="eng_length_long" value="{{ old('eng_length_long', 15) }}" min="0" max="100">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="mb-2">Active Window</h6>
                                    <label class="form-label">Hours</label>
                                    <input type="number" class="form-control" name="eng_active_hours" value="{{ old('eng_active_hours', '') }}" min="1" max="168" placeholder="e.g., 2 or 4">

                                    <h6 class="mt-3 mb-2">Comment Templates</h6>
                                    @foreach(['positive'=>'Positive','neutral'=>'Neutral','skeptical'=>'Skeptical','curious'=>'Curious','critical'=>'Critical'] as $key=>$label)
                                        <div class="mb-2">
                                            <label class="form-label">{{ $label }} Templates</label>
                                            <div id="tmpl-{{ $key }}">
                                                @php $vals = old('eng_templates_'.$key, []); @endphp
                                                @if(count($vals) > 0)
                                                    @foreach($vals as $val)
                                                        <div class="input-group mb-1">
                                                            <input type="text" class="form-control" name="eng_templates_{{ $key }}[]" value="{{ $val }}" placeholder="Add a template seed...">
                                                            <button class="btn btn-outline-danger" type="button" onclick="this.closest('.input-group').remove()"><i class="mdi mdi-minus"></i></button>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control" name="eng_templates_{{ $key }}[]" placeholder="Add a template seed...">
                                                    <button class="btn btn-outline-danger" type="button" onclick="this.closest('.input-group').remove()"><i class="mdi mdi-minus"></i></button>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addTmpl('{{ $key }}')"><i class="mdi mdi-plus me-1"></i> Add</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function addTmpl(key){
                            const wrap = document.getElementById('tmpl-'+key);
                            wrap.insertAdjacentHTML('beforeend', `<div class="input-group mb-1"><input type="text" class="form-control" name="eng_templates_${key}[]" placeholder="Add a template..."><button class="btn btn-outline-danger" type="button" onclick="this.closest('.input-group').remove()"><i class="mdi mdi-minus"></i></button></div>`);
                        }
                    </script>

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
        // Simple client-side search over Content APIs (fetched once)
        let allApis = [];
        let selected = [];

        async function fetchApis() {
            try {
                const res = await fetch("{{ route('admin.richtv-content-apis.list.json') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                const data = await res.json();
                if (data && data.success) {
                    allApis = data.data.endpoints || [];
                }
            } catch (e) { /* ignore */ }
        }

        function renderResults(items) {
            const results = document.getElementById('apiResults');
            results.innerHTML = '';
            items.slice(0, 25).forEach((api, idx) => {
                const isAdded = selected.find(s => s.url === api.url);
                const a = document.createElement('a');
                a.href = 'javascript:void(0)';
                a.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-start';
                a.innerHTML = `<div><div class="fw-bold">${api.name}</div><small class="text-muted">${api.url}</small></div><button class="btn btn-sm ${isAdded ? 'btn-success' : 'btn-outline-primary'}">${isAdded ? 'Added' : 'Add'}</button>`;
                a.onclick = () => { if (!isAdded) addTopicFromApi(api); };
                results.appendChild(a);
            });
        }

        function addTopicFromApi(api) {
            selected.push(api);
            const wrap = document.getElementById('selectedTopics');
            const id = btoa(api.url).replace(/=/g,'');
            const row = document.createElement('div');
            row.className = 'border rounded p-2 mb-2';
            row.id = `sel-${id}`;
            row.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold">${api.name}</div>
                        <small class="text-muted">${api.url}</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSelected('${id}','${api.url}')">Remove</button>
                </div>
                <div class="mt-2">
                    <input type="hidden" name="topics[${id}][name]" value="${api.name}">
                    <input type="hidden" name="topics[${id}][url]" value="${api.url}">
                    <label class="form-label mb-1">Note (optional)</label>
                    <input type="text" class="form-control form-control-sm" name="topics[${id}][note]" placeholder="Any special input for this topic/API">
                </div>
            `;
            wrap.appendChild(row);
            const term = document.getElementById('apiSearch').value.trim().toLowerCase();
            const filtered = allApis.filter(x => x.name.toLowerCase().includes(term) || x.url.toLowerCase().includes(term));
            renderResults(filtered);
        }

        function removeSelected(id, url) {
            selected = selected.filter(s => s.url !== url);
            const el = document.getElementById(`sel-${id}`);
            if (el) el.remove();
            const term = document.getElementById('apiSearch').value.trim().toLowerCase();
            const filtered = allApis.filter(x => x.name.toLowerCase().includes(term) || x.url.toLowerCase().includes(term));
            renderResults(filtered);
        }

        document.addEventListener('DOMContentLoaded', async function() {
            await fetchApis();
            renderResults(allApis.slice(0, 25));
            const input = document.getElementById('apiSearch');
            input.addEventListener('input', function() {
                const term = input.value.trim().toLowerCase();
                const filtered = allApis.filter(x => x.name.toLowerCase().includes(term) || x.url.toLowerCase().includes(term));
                renderResults(filtered);
            });
        });

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