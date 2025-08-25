import MarkdownIt from 'markdown-it';
import DOMPurify from 'dompurify';

let markdownEngine = null;

function getMarkdownEngine() {
	if (!markdownEngine) {
		markdownEngine = new MarkdownIt({
			html: false,
			linkify: true,
			breaks: true,
			typographer: true,
		});
	}
	return markdownEngine;
}

export function renderMarkdownToHtml(markdownText) {
	const md = getMarkdownEngine();
	const unsafeHtml = md.render(markdownText || '');
	return DOMPurify.sanitize(unsafeHtml);
}


