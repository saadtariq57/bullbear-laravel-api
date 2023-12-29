<template>
    <div>

        <!-- Iterate over text posts -->
        <div v-for="post in textPosts" :key="post.id" class="post">
            <!-- Post content -->
            <div class="post-content">
                <p>{{ post.content }}</p>
            </div>
        </div>
    </div>
</template>
  
<script>
import Textposts from "./js/Textposts.js";

export default Textposts;
</script>
  
<style scoped>
/* CSS styles specific to text posts */
</style>