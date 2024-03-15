<template>
    <div class="create-watchlist-wrapper text-center">
        <h1 class="fs-2 fw-6"><span class="fw-4">Create A</span> New watchlist</h1>
        <div class="d-flex justify-content-center align-items-center watchlist-card-wrapper gap-3 flex-wrap">
            <div class="card shadow py-4 px-2 watchlist-card">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="mx-auto text-secondary">
                    <line x1="6" y1="3" x2="6" y2="15"></line>
                    <circle cx="18" cy="6" r="3"></circle>
                    <circle cx="6" cy="18" r="3"></circle>
                    <path d="M18 9a9 9 0 0 1-9 9"></path>
                </svg>
                <div class="card-body pb-1">
                    <h2 class="mb-0 fs-16 fw-5">Browse Ideas and Clone Holdings to a Watchlist</h2>
                    <p>Search through our database of famous investors portfolios and thematic groups of stocks to
                        kickstart your Watchlist.</p>
                    <button class="btn btn-primary">Select</button>
                </div>
            </div>
            <div class="card shadow py-4 px-2 watchlist-card">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="mx-auto text-secondary">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <div class="card-body pb-1">
                    <h2 class="mb-0 fs-16 fw-5">Create a Custom Watchlist</h2>
                    <p>Add any stocks you want, and your views will display fundamental and valuation metrics for each
                        stock.</p>
                    <a href="/watchlist" class="btn btn-primary">Select</a>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.watchlist-card-wrapper{
    min-height: 60vh;
}
.watchlist-card{
    width: 530px;
}
</style>