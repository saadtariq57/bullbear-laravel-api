<template>
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog share-popup-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header share-popup-header text-center">
                    <h1 class="modal-title fs-5 text-white justify-content-center" id="shareModalLabel">
                        <i class="bi bi-share pe-2"></i>Share The Post On
                    </h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-around gap-5 flex-wrap border-bottom pb-3 pt-2">
                        <a href="" class="text-center text-black">
                            <div class="bg-smoke share-social-icons rounded-circle d-flex justify-content-center m-auto">
                                <i class="bi bi-twitter-x align-self-center fs-4"></i>
                            </div>
                            <div>Twitter</div>
                        </a>
                        <a href="" class="text-center text-black">
                            <div class="bg-smoke share-social-icons rounded-circle d-flex justify-content-center m-auto">
                                <i class="bi bi-facebook align-self-center fs-4"></i>
                            </div>
                            <div>Facebook</div>
                        </a>
                        <a href="" class="text-center text-black">
                            <div class="bg-smoke share-social-icons rounded-circle d-flex justify-content-center m-auto">
                                <i class="bi bi-whatsapp align-self-center fs-4"></i>
                            </div>
                            <div>Whatsapp</div>
                        </a>
                        <a href="" class="text-center text-black">
                            <div class="bg-smoke share-social-icons rounded-circle d-flex justify-content-center m-auto">
                                <i class="bi bi-pinterest align-self-center fs-4"></i>
                            </div>
                            <div>Pinterest</div>
                        </a>
                        <a href="" class="text-center text-black">
                            <div class="bg-smoke share-social-icons rounded-circle d-flex justify-content-center m-auto">
                                <i class="bi bi-linkedin align-self-center fs-4"></i>
                            </div>
                            <div>Linkedin</div>
                        </a>
                        <a href="" class="text-center text-black">
                            <div class="bg-smoke share-social-icons rounded-circle d-flex justify-content-center m-auto">
                                <i class="bi bi-telegram align-self-center fs-4"></i>
                            </div>
                            <div>Telegram</div>
                        </a>
                    </div>
                    <div class="my-3">
                        <textarea class="form-control p-2 rounded-0 share-popup-textarea"
                            placeholder="What's going on? #Hashtag.. @Mention.. Link.." rows="4"></textarea>
                    </div>
                    <div>
                        <h4 class="fs-5 fw-6 text-start">Share the post on</h4>
                        <div class="d-flex justify-content-center">
                            <a class="text-black p-3 border border-info rounded-2 d-flex justify-content-center align-items-center fw-5"
                                 data-bs-toggle="collapse" href="#share-popup-chat" role="button"
                                aria-expanded="false" aria-controls="share-popup-chat">
                                <span class="bg-smoke rounded-3 align-self-center chat-popup-icon me-2"><i
                                        class="bi bi-people-fill fs-4" fill="#03A9F4"></i></span> Chat
                            </a>
                        </div>
                        <div class="collapse" id="share-popup-chat">
                            <div class="card card-body shadow-none">
                                <div class="mb-3">
                                    <input type="text" class="form-control bg-smoke rounded-5" id="exampleFormControlInput1"
                                        placeholder="Please write the chat name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-smoke px-3 py-2 my-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2">
                                <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/06/oOAjH6QnKWn3guFugJSI_07_c83f8e518f67ef583d3b53936abb7cd8_avatar.jpg?cache=0"
                                    class="rounded-circle" alt="Rich TV profile picture" width="50px" height="50px">
                                <div>
                                    <h5>Rich TV <span><i class="bi bi-patch-check-fill" fill="#55acee"></i></span></h5>
                                    <div class="text-secondary text-start">3 w</div>
                                </div>
                            </div>
                            <p class="m-0">
                                <a data-bs-toggle="collapse" href="#profile-popup-disc" role="button" aria-expanded="false"
                                    aria-controls="profile-popup-disc">
                                    <i class="bi bi-arrows-angle-expand fs-4 text-black"></i>
                                </a>
                            </p>
                        </div>
                        <div class="collapse" id="profile-popup-disc">
                            <div class="card card-body shadow-none bg-transparent text-start">
                                SOS up about 9%. Might have another run. worth keeping an eye on it. It
                                did have a run to $9 before so it will be interesting to see if it can
                                do
                                it again.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Share</button>
                </div>
            </div>
        </div>
    </div>
</template>