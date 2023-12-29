<template>
    <div class="search-main">
        <button class="bg-transparent border-0 search-btn fs-3 nav-clr" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
            <i class="bi bi-search"></i>
        </button>

        <div class="offcanvas offcanvas-top bg-transparent canvas-header border-0" tabindex="-1" id="offcanvasTop"
            aria-labelledby="offcanvasTopLabel">
            <div class="offcanvas-header justify-content-end">
                <button type="button" class="btn-close btn-search-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body container">
                <form class="d-flex nav-search-main nav-link popup-form position-relative" action="https://richtv.io/"
                    method="get" id="search_form_large" style="flex-grow: 1">
                    <span class="header-serch-icon position-absolute">
                        <i class="bi bi-search nav-clr fs-4"></i></span>
                    <div class="navbar-search w-100">
                        <input class="navbar-search w-100 border-0" type="search" placeholder="Search Markets and Groups" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {

}
</script>
