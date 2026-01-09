import UserFeedService from '../services/userFeedService';
import ablyService from '../services/ablyService.js';
import { organizeReactions } from '../utils';
const userFeedModule = {
    namespaced: true,
    state: () => ({
        posts: [],
        isLoading: false,
        error: null,
        reactionTypes: [],
        newPostAvailable: false,
        fetchedCommentsFlags: {},
        visibleCommentsFlags: {},
        isFetchingMore:false,
        hasMorePosts: true,
    }),
    mutations: {
        setPosts(state, posts) {
          state.posts = posts;
        },
        appendPosts(state, newPosts) {
          state.posts = [...state.posts, ...newPosts];
        },
        addNewPost(state, newPost) {
            const existingPost = state.posts.find(post => post.id === newPost.id);
            if (!existingPost) {
                state.newPostAvailable = true;
                state.newPostData = newPost;
            }
        },
        updatePost(state, post) {
            const index = state.posts.findIndex(p => p.id === post.id);
            if (index !== -1) {
                state.posts[index] = { ...state.posts[index], ...post };
            }
        },
        removePost(state, postId){
            state.posts = state.posts.filter(post => post.id !== postId);
        },
        shiftNewPost(state) {
            if (state.newPostData) {
                state.posts.unshift(state.newPostData);
                state.newPostAvailable = false;
                state.newPostData = null;
            }
        },
        setIsFetchingMore(state, isFetching) {
            state.isFetchingMore = isFetching;
        },
        setHasMorePosts(state, hasMore) {
            state.hasMorePosts = hasMore;
        },
        setLoading(state, isLoading) {
          state.isLoading = isLoading;
        },
        setError(state, error) {
          state.error = error;
        },
        setReactionTypes(state, reactionTypes) {
            state.reactionTypes = reactionTypes;
        },
        addVoteToPost(state, { pollId, optionId, userId }) {
            const postIndex = state.posts.findIndex(post => post.poll && post.poll.id === pollId);
            if (postIndex !== -1) {
                const post = state.posts[postIndex];
                const optionIndex = post.poll.options.findIndex(option => option.id === optionId);
                
                // Increment the votes count and add to user_votes
                if (optionIndex !== -1) {
                    post.poll.options[optionIndex].votes++;
                    post.poll.user_votes.push({ user_id: userId, option_id: optionId });
                }

                post.poll.userVoted = true;
                post.poll.userVoteOptionId = optionId;
            }
        },

        removeVoteFromPost(state, { pollId, userId }) {
            const postIndex = state.posts.findIndex(post => post.poll && post.poll.id === pollId);
            if (postIndex !== -1) {
                const post = state.posts[postIndex];
                const voteIndex = post.poll.user_votes.findIndex(vote => vote.user_id === userId);
                if (voteIndex !== -1) {
                    const optionIndex = post.poll.options.findIndex(option => option.id === post.poll.user_votes[voteIndex].option_id);
                    
                    // Decrement the votes count and remove from user_votes
                    if (optionIndex !== -1) {
                        post.poll.options[optionIndex].votes--;
                    }

                    post.poll.user_votes.splice(voteIndex, 1);
                    post.poll.userVoted = false;
                    post.poll.userVoteOptionId = null;
                }
            }
        },
        updateReactionInPost(state, { post_id, reaction }) {
            const targetPost = state.posts.find(post => post.id === post_id);
            if (!targetPost) return;
            if (!Array.isArray(targetPost.reactions)) {
                targetPost.reactions = [];
            }
            // Add or update the user's reaction
            const existingReactionIndex = targetPost.reactions.findIndex(r => r && r.user_id === reaction.user_id);
            if (existingReactionIndex !== -1) {
                targetPost.reactions.splice(existingReactionIndex, 1, reaction);
            } else {
                targetPost.reactions.push(reaction);
            }
            const { organizedReactions, userReaction } = organizeReactions(targetPost.reactions, reaction.user_id);
            targetPost.organizedReactions = organizedReactions;
            targetPost.userReaction = userReaction;
        },
        removeReactionFromPost(state, { post_id, userId }) {
            // Ensure both values are compared as numbers to handle type mismatches
            const postIndex = state.posts.findIndex(post => Number(post.id) === Number(post_id));
            if (postIndex === -1) {
                return;
            }
            
            const targetPost = state.posts[postIndex];
            
            // Ensure reactions array exists
            if (!Array.isArray(targetPost.reactions)) {
                targetPost.reactions = [];
            }
            
            // Remove the user's reaction
            const filteredReactions = targetPost.reactions.filter(reaction => Number(reaction.user_id) !== Number(userId));
            
            // Reorganize reactions after the removal
            const { organizedReactions, userReaction } = organizeReactions(filteredReactions, userId);
            
            // Update the post properties - Vue should detect these changes
            targetPost.reactions = filteredReactions;
            targetPost.organizedReactions = organizedReactions;
            targetPost.userReaction = userReaction;
        },
        updateFetchedCommentsFlag(state, postId){
            state.fetchedCommentsFlags[postId] = true;
            state.visibleCommentsFlags[postId] = true;
        },
        updateFetchedCommentsVisibility(state, postId){
            state.visibleCommentsFlags[postId] = !state.visibleCommentsFlags[postId];
        },
    },
    actions: {
        async fetchPosts({ commit, state, rootState }, { context, groupId = null, userName = null, singlePostID }) {
            commit('setLoading', true);
            try {
                const userId = rootState.userData.id;
                let posts;
                let lastPostId;
                posts = await UserFeedService.fetchUserPosts(userId, context, groupId, userName, lastPostId, singlePostID);
                // For feed context, avoid wiping existing posts on empty responses after actions like sharing
                if (context === 'feed') {
                    if (posts.length > 0 || state.posts.length === 0) {
                        commit('setPosts', posts);
                    }
                } else {
                    // For non-feed contexts (group/profile/single), always reflect server state
                    commit('setPosts', posts);
                }
                if (posts.length < 10) {
                    commit('setHasMorePosts', false);
                }
            } catch (error) {
                commit('setError', error.message);
                // Do not clear existing posts on error
            } finally {
                commit('setLoading', false);
            }
        },
        addPost({commit, rootState}, post){
            const transformedPost = UserFeedService.transfromPost([post], post.user.id);
            commit('addNewPost', transformedPost[0]);
        },
        updatePost({commit, rootState}, post){
            const transformedPost = UserFeedService.transfromPost([post], post.user.id);
            commit('updatePost', transformedPost[0]);
        },
        removePost({commit, rootState}, postId){
            commit('removePost', postId);
        },
        async fetchMorePosts({ commit, state, rootState }, { context, groupId = null, userName = null }) {
            if (state.isLoading || state.isFetchingMore || !state.hasMorePosts) return;

            const userId = rootState.userData.id;
            const lastPostId = state.posts.length ? state.posts[state.posts.length - 1].id : null;
            console.log('User Profile Last ID:', lastPostId);
            commit('setIsFetchingMore', true);
            try {
                const morePosts = await UserFeedService.fetchUserPosts(userId, context, groupId, userName, lastPostId);
                if (morePosts.length === 0) {
                    commit('setHasMorePosts', false);
                } else {
                    commit('appendPosts', morePosts);
                     if (morePosts.length < 9) {
                         commit('setHasMorePosts', false);
                     }
                }
            } catch (error) {
                console.error('Error fetching more posts:', error);
            } finally {
                commit('setIsFetchingMore', false);
            }
        },
        async addVote({ commit, rootState }, { pollId, optionId }) {
            const userId = rootState.userData.id;
            try {
                const response = await UserFeedService.addVote(pollId, optionId);
                commit('addVoteToPost', { pollId, optionId, userId });
            } catch (error) {
                console.error('Error adding vote:', error);
                // Handle the error appropriately
            }
        },

        async removeVote({ commit, rootState}, pollId) {
            const userId = rootState.userData.id;
            try {
                const response = await UserFeedService.removeVote(pollId);
                commit('removeVoteFromPost', { pollId, userId });
            } catch (error) {
                console.error('Error removing vote:', error);
                // Handle the error appropriately
            }
        },
        async fetchReactionTypes({ commit }) {
            try {
                const reactionTypes = await UserFeedService.fetchReactionTypes();
                commit('setReactionTypes', reactionTypes);
            } catch (error) {
                console.error('Error fetching reaction types:', error);
            }
        },
        async addOrUpdateReaction({ commit }, { post_id, reactionTypeId }) {
            try {
                const reaction = await UserFeedService.addOrUpdateReaction(post_id, reactionTypeId);
                console.log('response reaction:', reaction);
                commit('updateReactionInPost', { post_id, reaction});
            } catch (error) {
                // Handle the error appropriately
            }
        },
        async removeReaction({ commit, rootState}, post_id) {
            try {
                const userId = rootState.userData.id;
                // Convert post_id to number to ensure type consistency
                const numericPostId = Number(post_id);
                await UserFeedService.removeReaction(numericPostId);
                
                // Commit the mutation - if axios didn't throw an error, the request succeeded
                commit('removeReactionFromPost', { post_id: numericPostId, userId });
            } catch (error) {
                console.error('Error removing reaction:', error);
                // Don't re-throw - just log the error so UI doesn't break
            }
        },
        updateFetchedCommentsFlag({commit}, postId){
            commit('updateFetchedCommentsFlag', postId);
        },
        updateFetchedCommentsVisibility({commit}, postId){
            commit('updateFetchedCommentsVisibility', postId);
        },
        initializeRealTimeUpdates({ commit, rootState }, { context, groupId = null }) {
            if (rootState.loggedIn && rootState.userData) {
              const userId = rootState.userData.id;
              ablyService.initializeAbly().then(() => {
                if (context === 'group' && groupId) {
                  ablyService.subscribeToGroupPostsUpdates(groupId, message => {
                      let transformedPost = UserFeedService.transfromPost([message.post], userId);
                      console.log(`Hello From callBack ${transformedPost}`);
                      commit('addNewPost', transformedPost[0]);
                  });
                } else {
                  ablyService.subscribeToFeedPostsUpdates(userId, message => {
                      let transformedPost = UserFeedService.transfromPost([message.post], userId);
                      commit('addNewPost', transformedPost[0]);
                  });
                }
              });
            }
        }
    },
    getters: {
        allPosts(state) {
            return state.posts;
        },
        isLoading(state) {
            return state.isLoading;
        },
        errorMessage(state) {
            return state.error;
        },
        reactionTypes(state){
            return state.reactionTypes
        },
        fetchedCommentsFlags(state){
            return state.fetchedCommentsFlags
    }
  },
};

export default userFeedModule;