@section('body')
<body>
  @endsection
  @section('content')
    <section class="container-fluid manage-watchlist">
        <div class="container-sm px-5 pt-5 pb-3 mt-5 manage-watchlist-con">
            <h2 class="mt-1 mb-1 fw-bold">Manage Watchlists</h2>
            <div class="manage-watchlist-sidebar mt-3">
                <a href="#" class="border-start border-dark px-2 text-decoration-underline fw-bold">Done</a>
            </div>
            <hr class="mt-5 divider">
            <ul class="px-0">
                <li class="d-flex align-items-center">
                    <div class="d-flex align-items-center flex-fill">
                        <div class="px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                          </svg>
                        </div>
                          <div class="Manage-list px-2">
                            <h3 class="fw-bold py-2 pe-4 w-100">My Watchlist 1</h3>
                          </div>
                    </div>
                    <div>
                        <button type="button" class="btn-close" aria-label="Close"></button>
                    </div>
                    
                </li>
            </ul>

        </div>

    </section>

    @endsection
    @section('scripts')
  @endsection