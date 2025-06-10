import { loadPageWithAnchor, smoothScroll } from "./component/smoothScroll";
import { hamburger, burger } from './common/header';
import More from "./pages/news/More";
import { Cookie } from './common/Cookie';

const blockName = 'b-news';

document.addEventListener('DOMContentLoaded', () => {
	const header = document.querySelector('.b-header');
	const block = document.querySelector(`.${blockName}`);
	if (header) {
		hamburger(header);
		burger(header);
		smoothScroll(header)
	}

	const contentBlock = block.querySelector(`.${blockName}__content`);
	if (contentBlock) {
		new More({
			block: contentBlock
		}).onClick()
	}

	const cookie = document.querySelector('.b-cookie');
	if (cookie) new Cookie('b-cookie').onActive();
})
