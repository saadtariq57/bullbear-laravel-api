<div class="search-main">
    <div class="offcanvas offcanvas-top bg-transparent canvas-header border-0" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-body offcanvas-body_nav_search_data px-0 pt-0 mb-2">
            <form class="d-flex nav-search-main nav-link popup-form position-relative" action="{{ url('/') }}" method="GET" id="search_form_large">
                @csrf
                <button type="button" class="btn-close btn-search-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close" onclick="clearSearch()"></button>
                <span class="header-serch-icon position-absolute">
                    <i class="bi bi-search nav-clr fs-4" aria-hidden="true"></i>
                </span>
                <div class="navbar-search w-100">
                    <input class="navbar-search w-100 border-0" name="search-symbol" value="{{ old('search-symbol', $searchQuery) }}" type="search" placeholder="Search Markets and Groups" aria-label="Search Markets and Groups" oninput="searchTags()" />

                    <div id="top-search-data-container2" class="rpd-search-data bg-white rounded-2 mt-2 pb-4 nav-searchbar-show-data">
                        <div id="search-search-tab" class="tabs-search">
                            <ul class="nav mb-3 nav-serach-bg py-2 px-sm-3 px-1 rounded-top-2 nav-search-symbol-categorys" id="nav-search-symbol-categorys-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ request('tab') === 'symbols' ? 'active' : '' }}" onclick="setActiveTab('symbols')" type="button">Symbols</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ request('tab') === 'groups' ? 'active' : '' }}" onclick="setActiveTab('groups')" type="button">Groups</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ request('tab') === 'people' ? 'active' : '' }}" onclick="setActiveTab('people')" type="button">Traders</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="nav-search-symbol-categorys-tabContent">
                                <!-- Symbols Tab -->
                                <div class="tab-pane fade {{ request('tab') === 'symbols' ? 'show active' : '' }}" id="nav-search-symbol" role="tabpanel" aria-labelledby="nav-search-symbol-tab" tabindex="0">
                                    <ul class="nav mb-3 nav-search-sub-symbol-categorys d-flex gap-2 px-sm-3 px-1" id="nav-search-sub-symbol-categorys-tab" role="tablist">
                                        @foreach(['All', 'Stocks', 'Crypto', 'ETF', 'Indices'] as $category)
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link {{ request('symbol_category') === $category ? 'active' : '' }}" onclick="setActiveSymbolCategory('{{ $category }}')" type="button">
                                                    {{ $category }}
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="nav-search-sub-symbol-categorys-tabContent-scroll">
                                        <div class="tab-content search-symbol-scroll-x px-4" id="nav-search-sub-symbol-categorys-tabContent">
                                            <div class="tab-pane fade {{ request('symbol_category') === 'All' ? 'active show' : '' }}" id="sub-symbol-categorys-all" role="tabpanel" aria-labelledby="sub-symbol-categorys-all-tab" tabindex="0">
                                                <ul class="nav d-flex flex-column pt-3">
                                                    <li class="nav-item py-0">
                                                        <span class="d-flex justify-content-between w-100 symbol-search-header">
                                                            <span class="col-3">Symbol</span>
                                                            <span class="col-3">Company</span>
                                                            <span class="col-2">Country</span>
                                                            <span class="col-2 text-end">Exchange</span>
                                                            @if(request('symbol_category') === 'All')
                                                                <span class="col-2 text-end">Type</span>
                                                            @endif
                                                        </span>
                                                    </li>
                                                    @foreach($symbols as $symbol)
                                                        <li class="nav-item search-nav-symbol-data py-0 d-flex flex-column justify-content-center">
                                                            <a href="/quotes/{{ $symbol->symbol }}" onclick="handleNavigation(event)" class="d-flex justify-content-between symbol-search-data position-relative align-items-center fs-14 fw-4">
                                                                <span class="col-3">{{ $symbol->symbol }}</span>
                                                                <span class="col-3">{{ $symbol->company_name ?? $symbol->name }}</span>
                                                                <span class="col-2">{{ $symbol->country }}</span>
                                                                <span class="col-2 text-end">{{ $symbol->exchange }}</span>
                                                                @if(request('symbol_category') === 'All')
                                                                    <span class="col-2 text-end">{{ ucfirst($symbol->type) }}</span>
                                                                @endif
                                                                <div class="symbol-search-hover-overview position-absolute">
                                                                    <a href="/quotes/{{ $symbol->symbol }}" class="text-white">See overview</a>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                    @if($symbols->isEmpty())
                                                        <li class="search-symbol-not-show py-3">
                                                            <span>No Results found</span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Groups Tab -->
                                <div class="tab-pane fade {{ request('tab') === 'groups' ? 'show active' : '' }}" id="nav-search-group" role="tabpanel" aria-labelledby="nav-search-group-tab" tabindex="0">
                                    <ul class="nav d-flex flex-column px-sm-3 px-1">
                                        <li class="nav-item py-0 px-3 d-flex">
                                            <span class="d-flex justify-content-between w-100 align-self-center symbol-search-header">
                                                <span class="col-3">Group Symbol</span>
                                                <span class="col-9">Group Title</span>
                                            </span>
                                        </li>
                                        @foreach($groups as $group)
                                            <li class="nav-link">
                                                <a href="/groups/{{ $group->id }}/{{ Str::slug($group->group_title) }}" class="d-flex align-items-center search-groups-data">
                                                    <div class="col-3 d-flex align-items-center gap-3">
                                                        <div class="search-group-icon">
                                                            <img src="{{ $group->avatar }}" alt="Group Icon" class="rounded-circle" width="50px" onerror="this.onerror=null;this.src='/uploads/photos/d-avatar.jpg';">
                                                        </div>
                                                        <div class="search-group-symbol-name fs-14 fw-4">
                                                            <span>{{ $group->group_name }}</span>
                                                        </div>
                                                    </div>
                                                    <span class="search-company-name fs-14 fw-4">{{ $group->group_title }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                        @if($groups->isEmpty())
                                            <li class="search-symbol-not-show py-3">
                                                <span>No Groups To Show</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                                <!-- People Tab -->
                                <div class="tab-pane fade {{ request('tab') === 'people' ? 'show active' : '' }}" id="nav-search-people" role="tabpanel" aria-labelledby="nav-search-people-tab" tabindex="0">
                                    <ul class="nav d-flex flex-column px-sm-3 px-1">
                                        @foreach($members as $member)
                                            <li class="nav-link">
                                                <a href="{{ '/profile/' . $member->name }}" class="d-flex align-items-center search-groups-data">
                                                    <div class="col-3 d-flex align-items-center gap-3">
                                                        <div class="search-group-icon">
                                                            <img src="{{ '/uploads/' . $member->avatar }}" alt="Member Avatar" class="rounded-circle" width="50" onerror="this.onerror=null;this.src='/uploads/photos/d-avatar.jpg';">
                                                        </div>
                                                        <div class="search-group-symbol-name fs-14 fw-4">
                                                            <span>{{ $member->name }}</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                        @if($members->isEmpty())
                                            <li class="search-symbol-not-show py-3">
                                                <span>No Traders To Show</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
