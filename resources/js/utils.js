export function formatDateTime(dateTime) {
	const now = new Date();
	const postedDate = new Date(dateTime);
	const diffInSeconds = Math.floor((now - postedDate) / 1000);
	const minute = 60, hour = 3600, day = 86400, week = 604800, month = 2629800, year = 31557600;

	if (diffInSeconds < minute) {
	return 'Just now';
	} else if (diffInSeconds < hour) {
	const mins = Math.floor(diffInSeconds / minute);
	return mins + (mins === 1 ? ' min ago' : ' mins ago');
	} else if (diffInSeconds < day) {
	const hrs = Math.floor(diffInSeconds / hour);
	return hrs + (hrs === 1 ? ' hour ago' : ' hours ago');
	} else if (diffInSeconds < week) {
	const days = Math.floor(diffInSeconds / day);
	return days + (days === 1 ? ' day ago' : ' days ago');
	} else if (diffInSeconds < month) {
	const weeks = Math.floor(diffInSeconds / week);
	return weeks + (weeks === 1 ? ' week ago' : ' weeks ago');
	} else if (diffInSeconds < year) {
	const months = Math.floor(diffInSeconds / month);
	return months + (months === 1 ? ' month ago' : ' months ago');
	} else {
	const years = Math.floor(diffInSeconds / year);
	return years + (years === 1 ? ' year ago' : ' years ago');
	}
}

export const organizeReactions = (reactions, userId) => {
    let organizedReactions = {};
    let userReaction = null;

    reactions.forEach(reaction => {
        const reactionKey = reaction.reaction_type.name;

        if (!organizedReactions[reactionKey]) {
            organizedReactions[reactionKey] = {
                count: 0,
                details: [],
            };
        }

        if (reaction.user_id === userId) {
            userReaction = reaction.reaction_type_id;
        }

        organizedReactions[reactionKey].count++;
        organizedReactions[reactionKey].details.push({
            userId: reaction.user_id,
            userName: reaction.user.name,
            userImage: reaction.user.avatar,
            reactionImage: reaction.reaction_type.icon,
            reactionType: reactionKey,
        });
    });

    return { organizedReactions, userReaction };
};