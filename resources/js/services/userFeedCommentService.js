import { organizeReactions } from '../utils';
const userFeedCommentService = {
    async fetchComments(postId, userId) {
        try {
            const response = await axios.get(`/api/posts/${postId}/comments`);
            const data = response.data;

            const transformedComments = data.map(comment => {
                const { organizedReactions: organizedCommentReactions, userReaction: userCommentReaction } = organizeReactions(comment.reactions, userId);

                const transformedReplies = comment.replies.map(reply => {
                    const { organizedReactions: organizedReplyReactions, userReaction: userReplyReaction } = organizeReactions(reply.reactions, userId);

                    return {
                        ...reply,
                        userReaction: userReplyReaction,
                        organizedReactions: organizedReplyReactions,
                    };
                });

                return {
                    ...comment,
                    userReaction: userCommentReaction,
                    organizedReactions: organizedCommentReactions,
                    replies: transformedReplies,
                };
            });

            return transformedComments;
        } catch (error) {
            console.error('Error fetching comments:', error);
            throw error;
        }
    },
    async addOrUpdateReaction(commentId, reactionTypeId) {
        try {
            const payload = {
                comment_id: commentId,
                reaction_type_id: reactionTypeId
            };

            const response = await axios.post('/api/add-or-update-reaction', payload);

            // Return the reaction data from the API response
            return response.data.reaction;
        } catch (error) {
            console.error('Error adding/updating reaction:', error);
            throw error;
        }
    },

    async removeReaction(commentId) {
        try {
            const payload = {
                comment_id: commentId
            };

            const response = await axios.post('/api/remove-reaction', payload);
            return response;
        } catch (error) {
            console.error('Error removing reaction:', error);
            throw error;
        }
    },

	async submitComment(postId, text, parentId = null) {
	    return await axios.post('/api/submit-comment', { post_id: postId, parent_id: parentId, text: text });
	},
	async editComment(commentId, text, parentId = null) {
		return await axios.post('/api/edit-comment', { id: commentId, parent_id: parentId, text: text });
	},
	async deleteComment(commentId) {
		return await axios.post('/api/delete-comment', { id: commentId });
	}
};

export default userFeedCommentService;