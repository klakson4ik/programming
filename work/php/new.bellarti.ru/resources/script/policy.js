import { hamburger, burger } from './common/header';
import { Cookie } from './common/Cookie';
import { loadPageWithAnchor, smoothScroll } from './component/smoothScroll';

document.addEventListener('DOMContentLoaded', () => {
	const header = document.querySelector('.b-header');
	if (header) {
		hamburger(header);
		burger(header);
		smoothScroll(header)
	}

	const cookie = document.querySelector('.b-cookie');
	if (cookie) new Cookie('b-cookie').onActive();
});