<template>
    <div class="trendingvideos-widget mt-3 shadow rounded border-top border-2 border-warning">
        <div class=" border-bottom">
            <h2 class="fs-18 fw-6 px-4">Our Latest Video</h2>
        </div>
        <div class="px-4 ltst-video-inner py-3">

            <button type="button" class="border-0 bg-transparent" data-bs-toggle="modal"
                data-bs-target="#side-bar-video">
                <div class="row border border-1 rounded-top-3">
                    <div
                        class="col-3 video-img-box bg-dark py-4 d-flex flex-column align-items-center gap-3 rounded-top-3">
                        <div class="position-relative">
                            <img src="https://i.ytimg.com/vi/MKdto5IGcXA/default.jpg"
                                class="card-img-top w-100">
                            <img src="https://dev1.richtv.io/build/images/play-icon.png"
                                class="play-btn w-50 position-absolute">
                        </div>
                    </div>
                    <div class="col-9 video-card-body ps-2 pe-0">
                        <p class="p-2 text-start">Sam Bankman-Fried found guilty on all seven counts of
                            fraud,
                            Nov 02 2023 </p>
                    </div>
                </div>
            </button>
        </div>
    </div>

    <div class="modal fade " id="side-bar-video" tabindex="-1" aria-labelledby="side-bar-videoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered video-side-bar-modal ">
        <div class="modal-content bg-transparent border-0">

            <div class="modal-body position-relative">
                <button type="button" class="btn-close position-absolute text-white "
                    data-bs-dismiss="modal" aria-label="Close"></button>
                <div><iframe width="100%" height="315"
                        src="https://www.youtube.com/embed/MKdto5IGcXA?si=FvyXY2i6aSj202Sf"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe></div>
            </div>

        </div>
    </div>
</div>

</template>