<template>
    <div>
        <!-- Iterate over image posts -->
        <div v-for="post in imagePosts" :key="post.id" class="post">
            <!-- Post image -->
            <div class="post-image">
                <img :src="post.imageUrl" :alt="post.title">
            </div>
        </div>
    </div>
</template>
  
<script>
import Imageposts from './Imagepost.js';
export default Imageposts;
</script>
  
<style scoped>
/* CSS styles specific to image posts */
</style>