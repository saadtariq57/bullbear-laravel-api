<template>
    <!-- Comment box -->
    <div class="comment-box p-2 px-3 d-flex gap-2 align-items-center">
        <div class="user-icon">
            <img class="avatar rounded-circle" src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                width="48" height="48">
        </div>
        <div class="comment-form w-100">
            <form action="">
                <textarea name="" id="" rows="1" placeholder="Write a comment and press enter"
                    class="rounded-5 w-100 d-block p-3 border-opacity-25 border-secondary "></textarea>
            </form>
        </div>
    </div>
    <div class="comment-elements py-2 px-3 d-flex justify-content-between">
        <div class="comment-count">
            <span id="count-comment">640</span>
        </div>
        <div class="comment-elements-wrapper d-flex justify-content-end gap-4">
            <div class="gif">
                <span class="cursor-pointer">
                    <i class="bi bi-filetype-gif"></i>
                </span>
            </div>
            <div class="emojey">
                <span class="cursor-pointer">
                    <i class="bi bi-emoji-laughing"></i>
                </span>
            </div>
            <div class="upload-img">
                <span class="cursor-pointer">
                    <i class="bi bi-images"></i>
                </span>
            </div>
            <div class="send-msg">
                <span class="cursor-pointer">
                    <i class="bi bi-send"></i>
                </span>
            </div>
        </div>

    </div>

    <!-- Comments Section -->
    <div class="post-footer post-comments p-3">
        <div class="comment-lists">
            <div class="comment comment-container mb-3" id="">
                <div class="d-flex gap-3">
                    <div class="user-icon">
                        <a class="pull-left" href="/Daniel55"> <img width="40" height="40" class="rounded-circle"
                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                alt="avatar"> </a>
                    </div>
                    <div class="comment-body position-relative  w-100">
                        <div class="comment-heading">
                            <span class="user-popover d-flex gap-1 align-items-center mb-2">
                                <a href="" class="text-black ">
                                    <h4 class="user fs-14 fw-bold m-0"> Daniel55</h4>
                                </a>
                                <span class="time-comment fs-10">
                                    29 m
                                </span>
                            </span>
                            <div class="comment-eidt position-absolute d-flex gap-2">
                                <span class="edit-comment cursor-pointer fs-10">
                                    <i class="bi bi-pencil"></i>
                                </span>
                                <span class="delete-comment cursor-pointer fs-10">
                                    <i class="bi bi-trash3"></i>
                                </span>
                            </div>
                            <div class="comment-text">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel, cupiditate.</p>
                            </div>
                            <div class="comment-options">
                                <div class="like-comment-count d-flex gap-3">
                                    <div class="like-count"><span> <i class="bi bi-hand-thumbs-up"></i></span></div>
                                    <div class="comment-count"><span><i class="bi bi-chat pe-2"></i>0</span></div>
                                </div>
                            </div>
                            <div class="comment-reply">
                                <div class="comment-replies-text">
                                    <div class="reply reply-container mt-3">
                                        <div class="d-flex gap-3">
                                            <div class="user-icon">
                                                <a class="pull-left" href="/Daniel55"> <img width="40" height="40"
                                                        class="rounded-circle"
                                                        src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                                        alt="avatar"> </a>
                                            </div>
                                            <div class="comment-body position-relative  w-100">
                                                <div class="comment-heading">
                                                    <span class="user-popover d-flex gap-1 align-items-center mb-2">
                                                        <a href="" class="text-black ">
                                                            <h4 class="user fs-14 fw-bold m-0"> Daniel55</h4>
                                                        </a>
                                                        <span class="time-comment fs-10">
                                                            11 m
                                                        </span>
                                                    </span>
                                                    <div class="comment-eidt position-absolute d-flex gap-2">
                                                        <span class="edit-comment cursor-pointer fs-10">
                                                            <i class="bi bi-pencil"></i>
                                                        </span>
                                                        <span class="delete-comment cursor-pointer fs-10">
                                                            <i class="bi bi-trash3"></i>
                                                        </span>
                                                    </div>
                                                    <div class="comment-text">
                                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel,
                                                            cupiditate.</p>
                                                    </div>
                                                    <div class="comment-options">
                                                        <div class="like-comment-count d-flex gap-3">
                                                            <div class="like-count"><span> <i
                                                                        class="bi bi-hand-thumbs-up"></i></span></div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment-box py-3 d-flex gap-2 align-items-center">
                                    <div class="user-icon">
                                        <img class="avatar rounded-circle"
                                            src="https://s3.wasabisys.com/rpdapp1/upload/photos/d-avatar.jpg?cache=0"
                                            width="30" height="30">
                                    </div>
                                    <div class="comment-form w-100">
                                        <form action="" class="position-relative">
                                            <textarea name="" id="" rows="1" placeholder="Write a comment and press enter"
                                                class="rounded-5 w-100 d-block px-2 py-1 border-opacity-25 border-secondary "></textarea>
                                            <div
                                                class="reply-comment-elements-wrapper d-flex justify-content-end gap-2 position-absolute">
                                                <div class="gif">
                                                    <span class="cursor-pointer">
                                                        <i class="bi bi-filetype-gif"></i>
                                                    </span>
                                                </div>
                                                <div class="emojey">
                                                    <span class="cursor-pointer">
                                                        <i class="bi bi-emoji-laughing"></i>
                                                    </span>
                                                </div>
                                                <div class="upload-img">
                                                    <span class="cursor-pointer">
                                                        <i class="bi bi-images"></i>
                                                    </span>
                                                </div>
                                                <div class="send-msg">
                                                    <span class="cursor-pointer">
                                                        <i class="bi bi-send"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="comment comment-container mb-3" id="">
                <div class="d-flex gap-3">
                    <div class="user-icon">
                        <a class="pull-left" href="/Daniel55"> <img width="40" height="40" class="rounded-circle"
                                src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/04/OunEMElBroAedJnBzMIT_27_b4b1f85c9ae27dbb1137390df78b23ba_avatar.png?cache=0"
                                alt="avatar"> </a>
                    </div>
                    <div class="comment-body position-relative  w-100">
                        <div class="comment-heading">
                            <span class="user-popover d-flex gap-1 align-items-center mb-2">
                                <a href="" class="text-black ">
                                    <h4 class="user fs-14 fw-bold m-0"> Daniel55</h4>
                                </a>
                                <span class="time-comment fs-10">
                                    29 m
                                </span>
                            </span>
                            <div class="comment-eidt position-absolute d-flex gap-2">
                                <span class="edit-comment cursor-pointer fs-10">
                                    <i class="bi bi-pencil"></i>
                                </span>
                                <span class="delete-comment cursor-pointer fs-10">
                                    <i class="bi bi-trash3"></i>
                                </span>
                            </div>
                            <div class="comment-text">
                                <p>adipisicing elit. Vel, cupiditate.</p>
                            </div>
                            <div class="comment-options">
                                <div class="like-comment-count d-flex gap-3">
                                    <div class="like-count"><span><i class="bi bi-suit-heart-fill red"></i> 1</span>
                                    </div>
                                    <div class="like-count"><span> <i class="bi bi-hand-thumbs-up"></i></span></div>
                                    <div class="comment-count"><span><i class="bi bi-chat pe-2"></i>0</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {


};
</script>