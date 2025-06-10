import { hamburger, burger } from './common/header';
import { Cookie } from './common/Cookie';
import { mainSlider } from './pages/home/slider';
import PagSide from './component/PagSide';
import Video from './component/Video';
import { loadPageWithAnchor, smoothScroll } from './component/smoothScroll';
import {BeautyNumber} from './pages/about/BeautyNumber'
document.addEventListener('DOMContentLoaded', () => {

	const main = document.querySelector('main');

	const header = document.querySelector('.b-header');
	if (header) {
		hamburger(header);
		burger(header);
		smoothScroll(header)
	}

	const pagSideBlock = main.querySelector('.b-pag-side');
	if (pagSideBlock) {
		new PagSide({
			block: pagSideBlock
		}).init().onScroll()
	}
	
	new BeautyNumber();
	
	const mainBlock = main.querySelector('.b-main');
	if (mainBlock) mainSlider('b-main');

	new Video().load();

	const cookie = document.querySelector('.b-cookie');
	if (cookie) new Cookie('b-cookie').onActive();
});