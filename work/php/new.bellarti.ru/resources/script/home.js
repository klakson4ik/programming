import { hamburger, burger } from './common/header';
import { Cookie } from './common/Cookie';
import { loadPageWithAnchor, smoothScroll } from './component/smoothScroll';
import { mainSlider, productSlider } from './pages/home/slider';
import Video from './component/Video';

const blockName = 'b-home';

document.addEventListener('DOMContentLoaded', () => {
	const header = document.querySelector('.b-header');
	const block = document.querySelector(`.${blockName}`);
	if (header) {
		hamburger(header);
		burger(header);
		smoothScroll(header)
	}

	const mainBlock = block.querySelector('.b-main');
	if (mainBlock) {
		mainSlider('b-main');
	}

	const productBlock = block.querySelector('.b-product');
	if (productBlock) {
		productSlider('b-product');
	}

	new Video().load();

	const cookie = document.querySelector('.b-cookie');
	if (cookie) new Cookie('b-cookie').onActive();
})
