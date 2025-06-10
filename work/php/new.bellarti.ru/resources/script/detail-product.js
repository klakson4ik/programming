import { hamburger, burger } from './common/header';
import { initDetailToggle } from './pages/detail-product/dropblock';
import { Cookie } from './common/Cookie';
import { productSlider, publicationsSlider } from './pages/detail-product/slider';
import { productGet } from './pages/detail-product/productGet';
import PagSide from './component/PagSide';
import Video from './component/Video';
import { loadPageWithAnchor, smoothScroll } from './component/smoothScroll';

document.addEventListener('DOMContentLoaded', () => {
	const main = document.querySelector('main');
	const header = document.querySelector('.b-header');
	if (header) {
		hamburger(header);
		burger(header);
		smoothScroll(header)
	}

	const pagSideBlock = document.querySelector('.b-pag-side');
	if (pagSideBlock) {
		new PagSide({
			block: pagSideBlock
		}).init().onScroll()
	}

	const cookie = document.querySelector('.b-cookie');
	if (cookie) new Cookie('b-cookie').onActive();

	const detailBlock = main.querySelector('.b-detail__detail-main');
	if (detailBlock) initDetailToggle('.b-detail__detail-main');

	const techniquesBlock = main.querySelector('.b-techniques');
	if (techniquesBlock) productSlider('b-techniques');

	const publicationsBlock = main.querySelector('.b-publications');
	if (publicationsBlock) productSlider('b-publications');

	const productBlock = main.querySelector('.b-product');
	if (productBlock) productSlider('b-product');

	const offerBlock = main.querySelector('.b-detail');
	if (offerBlock) {
		const swiper = publicationsSlider('b-detail');
		const countTo = main.querySelector('.b-detail__swiper-container .c-border-purple-dark img').dataset.slidename;
		swiper.slideTo(countTo);
	}

	productGet();

	new Video().load();
});
