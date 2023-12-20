@extends('layouts.master')
@section('body')

<body>
  @endsection
  @section('content')
  <section class="container-fluid manage-watchlist py-80">
    <div class="container-sm px-5 pt-5 pb-3 mt-5 manage-watchlist-con">
      <h2 class="mt-1 mb-1 fw-bold">Manage Watchlists</h2>
      <div class="manage-watchlist-sidebar mt-3">
        <a href="/watchlist" class="border-start border-dark px-2 text-decoration-underline fw-bold">Done</a>
      </div>
      <hr class="mt-5 divider">
      <ul class="px-0">
      @foreach($watchlists as $watchlist)
        <li class="d-flex align-items-center">
          <div class="d-flex align-items-center flex-fill">
            <div class="px-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                  d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
              </svg>
            </div>
            <div class="Manage-list px-2">
              <a href="edit/{{ $watchlist->id }}" class="fw-bold py-2 pe-4 w-100">{{ $watchlist->title }}</a>
            </div>
          </div>
          <div>
            <button class="border-0 fs-2 bg-transparent" type="button" data-bs-toggle="modal" data-bs-target="#delete-list">X</button>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
    <!-- Delete Model start -->
    <!-- Modal -->
    <div class="modal fade" id="delete-list" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="delete-listLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="delete-listLabel">NVDA</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
                    <div class="modal-body">
          Are you sure you want to delete NVDA from your watchlist?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary border-btn" data-bs-dismiss="modal">DON’T DELETE</button>
            <button type="button" class="btn btn-primary">DELETE</button>
          </div>
                  </div>
      </div>
    </div>
    <!-- Delete Model end -->
  </section>

  @endsection
  @section('scripts')
    @endsection