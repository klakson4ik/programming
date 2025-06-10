import { hamburger, burger } from './common/header';
import Carousel from './component/Carousel';
import { Cookie } from './common/Cookie';
import PagSide from './component/PagSide';
import Select from './component/Select';
import { loadPageWithAnchor, smoothScroll } from './component/smoothScroll';
import Ymap from './component/Ymap';
import { exampleSlider } from './pages/cosmetology/slider';
import { productSlider } from './pages/home/slider';
import { blogSlider } from './pages/patient/slider';

const blockName = 'b-patient';
let block = null;

document.addEventListener('DOMContentLoaded', () => {
	const header = document.querySelector('.b-header');
	block = document.querySelector(`.${blockName}`);

	if (header) {
		hamburger(header);
		burger(header);
		smoothScroll(header);
	}

	const pagSideBlock = block.querySelector('.b-pag-side');
	if (pagSideBlock) {
		new PagSide({
			block: pagSideBlock
		}).init().onScroll();
	}

	const productBlock = block.querySelector('.b-product');
	if (productBlock) {
		productSlider('b-product');
	}

	const faqBlock = block.querySelector('.b-faq');
	if (faqBlock) {
		new Carousel({
			block: faqBlock
		}).run();
	}

	const blogBlock = block.querySelector('.b-blog');
	if (blogBlock) blogSlider('b-blog');

	const cookie = document.querySelector('.b-cookie');
	if (cookie) new Cookie('b-cookie').onActive();
});

window.addEventListener('load', () => {
	const ymapBlock = block.querySelector('.b-ymap');
	if (ymapBlock) {
		new Select({
			block: ymapBlock,
		}).run();

		const visibleElement = block.querySelector(`.${blockName}__blog`);

		new Ymap({
			block: ymapBlock,
			blockName: 'b-ymap'
		}).onVisibleElement(visibleElement).enableBalloonZoom().onSelectCity('on-select-ymap-city')
	}

	const exampleBlock = block.querySelector('.b-example');
	if (exampleBlock) {
		exampleSlider('b-example');
		new Carousel({
			block: exampleBlock
		}).withPaddding().run()
	}
});