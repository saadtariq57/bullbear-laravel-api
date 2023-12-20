<template>
    <div class="container-sm px-5 pt-5 pb-3 mt-5 manage-watchlist-con">
            <div class="Manage-list pl-1">
                <h3 class="fw-bold py-2 px-2">{{ watchlistData.title }}</h3>
            </div>
            <div class="manage-watchlist-sidebar mt-3 mb-5 pb-5 d-flex">
                <div>
                    <a href="/watchlist" class="px-2 text-decoration-underline fw-bold">Done</a>
                </div>
                <div class="add-symbol">
                <a href="javascript:void(0)" class="border-start border-dark px-3 text-decoration-underline fw-bold add-symbol-btn">Add Symbol
                        <svg width="10" height="10" viewBox="0 0 8 8" fill="#fff" role="img" data-analytic-id="add-icon"
                            xmlns="http://www.w3.org/2000/svg" class="Watchlist-navicon">
                            <path
                                d="M3.36842 8V4.63158H0V3.36842H3.36842V0H4.63158V3.36842H8V4.63158H4.63158V8H3.36842Z">
                            </path>
                        </svg>
                    </a>
                    <div class="symbol-search-form  position-reletive">
                        <form action="" class="position-relative">
                            <input class="form-control form-control-lg" type="search" placeholder="Search"
                                aria-label=".form-control-lg example" v-model="search" @input="searchTags">
                            <button type="submit" class="btn btn-primary px-3 py-2 position-absolute">ADD</button>
                        </form>
                        <ul v-show="search">
                            <li v-for="symbol in symbols" v-on:click="addWatchlistSymbol(symbol.id)">{{ symbol.name }}</li>
                            <li v-show="error">{{ error }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="mt-5 divider">
      <ul class="px-0">
        <li class="d-flex align-items-center" v-for="item in watchlistData.watchlist_symbols">
          <div class="d-flex align-items-center flex-fill">
            <div class="px-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                  d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
              </svg>
            </div>
            <div class="Manage-list px-2">
              <h3 class="fw-bold py-2 pe-4 w-100">{{ item.symbol.name }}</h3>
            </div>
          </div>
          <div>
            <button class="border-0 fs-2 bg-transparent" type="button" data-bs-toggle="modal" data-bs-target="#delete-list" v-on:click="deleteWatchlistSymbol(item.id)">X</button>
          </div>

        </li>
      </ul>
            <div class="border mt-5 mb-5">
                <p class="w-75 text-center m-auto py-3 text-dark">Name your Watchlist, then use Add Symbol+ above to
                    start watching your favorite stocks and investments. Click Done to return to your Watchlist view.
                </p>
            </div>
        </div>
</template>

<script>
import Searchsymbols from "./Searchsymbols.js";

export default Searchsymbols;
</script>
