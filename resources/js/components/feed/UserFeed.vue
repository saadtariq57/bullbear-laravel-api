<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <section class="feed-main">
                    <div>
                        <CreatePost context="feed" />
                    </div>
                    <div>
                        
                    </div>

                </section>
            </div>
            <div class="col-lg-4">
                <div>
                    <UserData />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import CreatePost from './CreatePost.vue';
import UserData from './UserData.vue';

export default {
    components: {
        CreatePost,
        UserData,
    },
};
</script>