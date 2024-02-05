import UserFeedService from '../services/userFeedService';
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
        shiftNewPost(state) {
            if (state.newPostData) {
                state.posts.unshift(state.newPostData);
                state.newPostAvailable = false;
                state.newPostData = null;
            }
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
            // Add or update the user's reaction
            const existingReactionIndex = targetPost.reactions.findIndex(r => r.user_id === reaction.user_id);
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
            const targetPost = state.posts.find(post => post.id === post_id);
            if (!targetPost) return;
            // Remove the user's reaction
            targetPost.reactions = targetPost.reactions.filter(reaction => reaction.user_id !== userId);
            // Reorganize reactions after the removal
            const { organizedReactions, userReaction } = organizeReactions(targetPost.reactions, userId);
            targetPost.organizedReactions = organizedReactions;
            targetPost.userReaction = userReaction;
        },
        updateFetchedCommentsFlag(state, postId){
            state.fetchedCommentsFlags[postId] = true;
            state.visibleCommentsFlags[postId] = true;
        },
        updateFetchedCommentsVisibility(state, postId){
            state.visibleCommentsFlags[postId] = !state.visibleCommentsFlags[postId];
        }
    },
    actions: {
        async fetchPosts({ commit, rootState }) {
          commit('setLoading', true);
          try {
            const userId = rootState.userData.id;
            const posts = await UserFeedService.fetchUserPosts(userId);
            commit('setPosts', posts);
            commit('setLoading', false);
          } catch (error) {
            commit('setError', error.message);
            commit('setLoading', false);
          }
        },
        async fetchMorePosts({ commit, state, rootState}) {
            const userId = rootState.userData.id;
            if (state.isLoading) return;
            const lastPostId = state.posts[state.posts.length - 1].id;
            commit('setLoading', true);
            try {
                const morePosts = await UserFeedService.fetchUserPosts(userId, lastPostId);
                commit('appendPosts', morePosts);
            } catch (error) {
                console.error('Error fetching more posts:', error);
            } finally {
                commit('setLoading', false);
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
                commit('updateReactionInPost', { post_id, reaction});
            } catch (error) {
                // Handle the error appropriately
            }
        },
        async removeReaction({ commit, rootState}, post_id) {
            try {
                const userId = rootState.userData.id;
                const response = await UserFeedService.removeReaction(post_id);
                commit('removeReactionFromPost', { post_id, userId });
            } catch (error) {
                console.error('Error removing reaction:', error);
                // Handle the error appropriately
            }
        },
        updateFetchedCommentsFlag({commit}, postId){
            commit('updateFetchedCommentsFlag', postId);
        },
        updateFetchedCommentsVisibility({commit}, postId){
            commit('updateFetchedCommentsVisibility', postId);
        },
        initializeRealTimeUpdates({ commit, rootState }) {
          const userId = rootState.userData.id;
          if (window.Echo) {
            window.Echo.private(`feed.posts.${userId}`)
              .listen('.App\\Events\\NewPost', (event) => {
                commit('addNewPost', event.post);
              });
          } else {
            console.error('Echo is not initialized');
          }
        },
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