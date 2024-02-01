import userFeedCommentService from '../services/userFeedCommentService';
import { organizeReactions } from '../utils';
const userFeedCommentModule = {
    namespaced: true,
    state: () => ({
        comments: [],
        error: null,
    }),
    mutations: {
        setComments(state, comments) {
            state.comments = comments;
        },
		updateReactionInComment(state, { commentId, parentId, reaction, isReply }) {
		    // Find the target comment or reply
		    if (isReply) {
		        commentId = parentId;
		    }
		    let targetComment = state.comments.find(c => c.id === commentId);
		    if (!targetComment) return;

		    let target = isReply ? targetComment.replies.find(r => r.id === reaction.comment_id) : targetComment;
		    if (!target) return;

		    // Add or update the user's reaction
		    const existingReactionIndex = target.reactions.findIndex(r => r.user_id === reaction.user_id);
		    if (existingReactionIndex !== -1) {
		        target.reactions.splice(existingReactionIndex, 1, reaction);
		    } else {
		        target.reactions.push(reaction);
		    }

		    // Reorganize reactions after update
		    const { organizedReactions, userReaction } = organizeReactions(target.reactions, reaction.user_id);
		    target.organizedReactions = organizedReactions;
		    target.userReaction = userReaction;
		},
		removeReactionFromComment(state, { commentId, parentId, userId, isReply }) {
		    let targetComment;
		    let target;

		    if (isReply) {
		        // When it's a reply, the parentId is actually the commentId and commentId is the replyId
		        targetComment = state.comments.find(c => c.id === parentId);
		        if (!targetComment) return;
		        target = targetComment.replies.find(r => r.id === commentId);
		    } else {
		        // Handling a regular comment
		        targetComment = state.comments.find(c => c.id === commentId);
		        if (!targetComment) return;
		        target = targetComment;
		    }

		    if (!target) return;

		    // Remove the user's reaction
		    target.reactions = target.reactions.filter(reaction => reaction.user_id !== userId);

		    // Reorganize reactions after the removal
		    const { organizedReactions, userReaction } = organizeReactions(target.reactions, userId);
		    target.organizedReactions = organizedReactions;
		    target.userReaction = userReaction;
		},

		submitCommentOrReply(state, { comment, isReply, parentCommentId, userId }) {

		    const { organizedReactions, userReaction } = organizeReactions(comment.reactions, userId);

		    const formattedComment = {
		        ...comment,
		        userReaction: userReaction,
		        organizedReactions: organizedReactions,
		        replies: comment.replies ? comment.replies.map(reply => ({
		            ...reply,
		            userReaction: organizeReactions(reply.reactions, userId).userReaction,
		            organizedReactions: organizeReactions(reply.reactions, userId).organizedReactions
		        })) : []
		    };
		    if (isReply) {
		        const parentIndex = state.comments.findIndex(c => c.id === parentCommentId);
		        if (parentIndex !== -1) {
		            // Find the reply within the parent comment's replies
		            const replyIndex = state.comments[parentIndex].replies.findIndex(r => r.id === comment.id);
		            if (replyIndex !== -1) {
		                // Update the existing reply
		                state.comments[parentIndex].replies.splice(replyIndex, 1, formattedComment);
		            } else {
		                // Add new reply (this case should not normally occur for edits)
		                state.comments[parentIndex].replies.push(formattedComment);
		            }
		        }
		    } else {
		        // Update or add new comment
		        const commentIndex = state.comments.findIndex(c => c.id === comment.id);
		        if (commentIndex !== -1) {
		            state.comments.splice(commentIndex, 1, formattedComment);
		        } else {
		            state.comments.unshift(formattedComment);
		        }
		    }
		},


	    removeCommentOrReply(state, { commentId, isReply }) {
	        if (isReply) {
	            state.comments.forEach(comment => {
	                comment.replies = comment.replies.filter(reply => reply.id !== commentId);
	            });
	        } else {
	            state.comments = state.comments.filter(comment => comment.id !== commentId);
	        }
	    },
        setError(state, error) {
            state.error = error;
        }
    },
    actions: {
        async fetchCommentsForPost({ commit }, {postId, userId}) {
            try {
                const comments = await userFeedCommentService.fetchComments(postId, userId);
                commit('setComments', comments);
            } catch (error) {
                commit('setError', error.message);
                console.error('Error fetching comments:', error);
            }
        },
		async addOrUpdateCommentReaction({ commit }, { commentId, reactionTypeId, parentId, isReply }) {
		  try {
		    const response = await userFeedCommentService.addOrUpdateReaction(commentId, reactionTypeId);
		    commit('updateReactionInComment', { commentId, parentId, reaction: response, isReply});
		  } catch (error) {
		    console.error('Error adding/updating reaction:', error);
		  }
		},
		async removeCommentReaction({ commit, rootState}, { commentId, parentId, isReply }) {
		  try {
		  	const userId = rootState.userData.id;
		    await userFeedCommentService.removeReaction(commentId);
		    commit('removeReactionFromComment', { commentId, parentId, userId, isReply });
		  } catch (error) {
		    console.error('Error removing reaction:', error);
		  }
		},

		async submitCommentOrReply({ commit, rootState }, {postId, commentId, parentCommentId, text, isReply }) {
		  try {
		  	const userId = rootState.userData.id;
		    const response = await userFeedCommentService.submitComment(postId, text, parentCommentId);
		    commit('submitCommentOrReply', { comment: response.data.comment, isReply: isReply, parentCommentId, userId });
		  } catch (error) {
		    console.error('Error submitting comment/reply:', error);
		  }
		},
	    async deleteCommentOrReply({ commit }, { commentId, parentCommentId, isReply }) {
	        try {
	            await userFeedCommentService.deleteComment(commentId);
	            commit('removeCommentOrReply', { commentId, isReply });
	        } catch (error) {
	            console.error('Error deleting comment/reply:', error);
	        }
	    },

	    async editCommentOrReply({ commit, rootState }, {postId, commentId, parentCommentId, text, isReply }){
	    	try{
	    		const userId = rootState.userData.id;
	    		const response = await userFeedCommentService.editComment(commentId, text, parentCommentId);
	    		commit('submitCommentOrReply', { comment: response.data.comment, isReply: isReply, parentCommentId, userId });
	    	}catch(error){
	    		console.error('Error submitting comment/reply:', error);
	    	}
	    }
    },
    getters: {
        getCommentsByPostId: (state) => (postId) => {
            return state.comments.filter(comment => comment.post_id === postId);
        }
    }
};

export default userFeedCommentModule;