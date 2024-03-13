import { organizeReactions } from '../utils';
const UserFeedService = {
    async fetchUserPosts(userId, context, groupId = null, lastPostId = null) {
        try {

            let url = '';
            if(context === 'feed'){
                url += '/api/user-feed';
            } else if (context === 'profile'){
                url += '/api/user-profile';
            } else if (context === 'group'){
                url += `/api/user-group/${groupId}`;
            }
            
            if (lastPostId) {

                url += `?lastPostId=${lastPostId}`;
            }
            const response = await axios.get(url);
            const data = response.data.data;

            const transformedPosts = data.map(post => {
                // Mapping reactions
                const { organizedReactions: organizedReactions, userReaction: userReaction } = organizeReactions(post.reactions, userId);
                // Mapping poll votes
                let userVoted = false;
                let userVoteOptionId = null;
                if (post.poll) {
                    userVoted = post.userVoted;
                    if (userVoted) {
                        const userVote = post.user_votes.find(vote => vote.user_id === userId);
                        userVoteOptionId = userVote ? userVote.option_id : null;
                    }
                }

                return {
                    ...post,
                    userReaction: userReaction,
                    organizedReactions: organizedReactions,
                    userVoted: userVoted,
                    userVoteOptionId: userVoteOptionId,
                };
            });

            return transformedPosts;
        } catch (error) {
            console.error('Error fetching posts:', error);
            throw error;
        }
    },
    transfromPost(post, userId){
        const transformedPost = post.map(post => {
            // Mapping reactions
            const { organizedReactions: organizedReactions, userReaction: userReaction } = organizeReactions(post.reactions, userId);
            // Mapping poll votes
            let userVoted = false;
            let userVoteOptionId = null;
            if (post.poll) {
                userVoted = post.userVoted;
                if (userVoted) {
                    const userVote = post.user_votes.find(vote => vote.user_id === userId);
                    userVoteOptionId = userVote ? userVote.option_id : null;
                }
            }

            return {
                ...post,
                userReaction: userReaction,
                organizedReactions: organizedReactions,
                userVoted: userVoted,
                userVoteOptionId: userVoteOptionId,
            };
        });

        return transformedPost;
    },
    async fetchReactionTypes() {
        try {
            const response = await axios.get('/api/reaction-types');
            return response.data;
        } catch (error) {
            console.error('Error fetching reaction types:', error);
            throw error;
        }
    },

    async addOrUpdateReaction(postId, reactionTypeId) {
        try {
            const payload = {
                post_id: postId,
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

    async removeReaction(postId) {
        try {
            const payload = {
                post_id: postId
            };
            const response = await axios.post('/api/remove-reaction', payload);
            return response;
        } catch (error) {
            console.error('Error removing reaction:', error);
            throw error;
        }
    },

    async addVote(pollId, optionId) {
        try {
            const payload = {
                poll_id: pollId,
                option_id: optionId
            };

            const response = await axios.post('/api/add-vote', payload);

            // Return the vote data from the API response
            return response.data.vote;
        } catch (error) {
            console.error('Error adding vote:', error);
            throw error;
        }
    },

    async removeVote(pollId) {
        try {
            const payload = {
                poll_id: pollId
            };

            const response = await axios.post('/api/remove-vote', payload);

            return response;
        } catch (error) {
            console.error('Error removing vote:', error);
            throw error;
        }
    },

};

export default UserFeedService;