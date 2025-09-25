import { format, parseISO, formatDistanceToNow } from 'date-fns';

export function formatNotificationTime(isoDateString) {
    if (!isoDateString) {
        return '';
    }

    let date;
    try {
        date = parseISO(isoDateString);
    } catch (e) {
        return '';
    }

    const now = new Date();

    // If the date is today
    if (format(date, 'yyyy-MM-dd') === format(now, 'yyyy-MM-dd')) {
        return format(date, 'hh:mm a');
    }

    // If the date is yesterday
    if (format(date, 'yyyy-MM-dd') === format(new Date(now.setDate(now.getDate() - 1)), 'yyyy-MM-dd')) {
        return 'Yesterday';
    }

    // If the date is within this week
    if (now.getTime() - date.getTime() < 7 * 24 * 60 * 60 * 1000) {
        return format(date, 'EEEE');
    }

    // Otherwise, return the date
    return format(date, 'EEE, dd MMM');
}


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
    const safeArray = Array.isArray(reactions) ? reactions : [];
    const organizedReactions = {};
    let userReaction = null;

    for (const reaction of safeArray) {
        if (!reaction) continue;

        // Support both snake_case and camelCase relation keys from API
        const reactionTypeRel = reaction.reaction_type || reaction.reactionType || {};
        const userRel = reaction.user || {};

        const reactionKey = reactionTypeRel.name || 'like';

        if (!organizedReactions[reactionKey]) {
            organizedReactions[reactionKey] = { count: 0, details: [] };
        }

        if (reaction.user_id === userId) {
            userReaction = reaction.reaction_type_id ?? userReaction;
        }

        organizedReactions[reactionKey].count += 1;
        organizedReactions[reactionKey].details.push({
            userId: reaction.user_id,
            userName: userRel.name || 'Unknown',
            userImage: userRel.avatar || 'default.png',
            reactionImage: reactionTypeRel.icon || 'uploads/icons/like.png',
            reactionType: reactionKey,
        });
    }

    return { organizedReactions, userReaction };
};