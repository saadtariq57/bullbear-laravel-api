<template>
    <div class="latest-article-widget mt-4 mb-1 mx-auto text-start border-top border-2 border-warning widgets-border">
      <div class="latest-article-heading border-bottom border-2 pt-3 px-3 ">
        <h4 class="icon-heading fw-6 fs-5">LATEST ARTICLES</h4>
      </div>
      <div v-if="wordpressPosts.length > 0">
        <div v-for="(post, index) in wordpressPosts.slice(0, 6)" :key="post.id" class="border-bottom border-2 pt-3 px-3">
          <h3 class="fs-13 fw-4 mb-1"><a :href="`https://richtv.io${post.link}`" class="text-black">{{ truncate(post.title) }}</a></h3>
          <div class="d-flex mb-2">
            <a :href="post.authorLink" class="me-1 widgets-sm-heading">{{ post.author }}</a>
            <span class="border-start px-2 widgets-sm-heading">{{ post.date }}</span>
          </div>
        </div>
      </div>
      <div v-else>
        <p> Loading...</p>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        wordpressPosts: [],
      };
    },
    mounted() {
      this.fetchWordPressPosts();
    },
    methods: {
        fetchWordPressPosts() {
            const categories = ['962', '4341', '11533', '11445', '11449', '205'];
            const requests = categories.map(category => {
                return axios.get(`/api/fetch-wordpress-posts/${category}?numPosts=1`, {
                withCredentials: true,
                });
            });

            Promise.all(requests)
                .then(responses => {
                const uniquePosts = [];
                responses.forEach(response => {
                    const post = response.data[0]; 
                    if (post && !uniquePosts.some(p => p.id === post.id)) {
                    uniquePosts.push(post); 
                    }
                });
                        this.wordpressPosts = uniquePosts.slice(0, 6);
                })
                .catch(error => {
                console.error('Error fetching WordPress posts:', error);
                });
            },

      truncate(text) {
        if (text.length > 102) {
          return text.substring(0, 102) + '...';
        } else {
          return text;
        }
      }
    }
  }
  </script>
  