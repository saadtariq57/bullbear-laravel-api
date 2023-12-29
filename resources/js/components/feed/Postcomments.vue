<template>
<div class="post-footer post-comments p-3">
                    <div class="comment-lists">
                        <div v-for="comment in post.comments" :key="comment.id" class="comment comment-container mb-3">
                            <!-- Individual Comment -->
                            <!-- ... -->
                        </div>
                    </div>
                </div>
</template>
<script>
import Postcomments from "./js/Postcomments.js";
export default Postcomments;
</script>