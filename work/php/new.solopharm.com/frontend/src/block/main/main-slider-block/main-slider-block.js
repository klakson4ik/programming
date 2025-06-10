// core	version	+ navigation, pagination modules:
import Swiper, { Navigation, Pagination } from 'swiper';

import 'swiper/css/pagination';
// import Swiper and modules styles
import 'swiper/css';

let swiper1;
let swiper2;
let swiper3;
const option = {
	modules: [Navigation, Pagination],
	observer: true,
	observeParents: true,
	loop: true,
	spaceBetween: 0,
	slidesPerView: 1,
	freeMode: false,
	watchSlidesVisibility: true,
	watchSlidesProgress: true,
	draggable: false,
	allowTouchMove: false,
};

window.testSlideNext = function () {
	swiper1.slideNext(500, false);
	swiper2.slideNext(500, false);
	swiper3.slideNext(500, false);
};

window.testSlidePrev = function () {
	swiper1.slidePrev(500, false);
	swiper2.slidePrev(500, false);
	swiper3.slidePrev(500, false);
};

function ready() {
	swiper1 = new Swiper('.swiperBWLeft', option);
	swiper2 = new Swiper(
		'.swiperCenter',
		option,
	);
	swiper3 = new Swiper('.swiperBWRight', option);
}

document.addEventListener('DOMContentLoaded', () => {
	ready();

	swiper1.slideTo(0, 1);
	swiper2.slideTo(1, 1);
	swiper3.slideTo(2, 1);

	try {
		const elPag = document.querySelectorAll('.heverArea .nav .swiper-pagination-news .swiper-pagination-bullet');
		const width = 100 / elPag.length;
		const sliderMainBlock = document.querySelector('.b-main-slider-block__swiperArea');
		const links = sliderMainBlock.querySelectorAll('.b-arrow');

		links.forEach((link) => {
			link.addEventListener('click', (e) => e.preventDefault());
		});

		for (let x = 0; x < elPag.length; x++) {
			elPag[x].style.width = `${width}%`;
		}
	} catch (error) {
		return;
	}
});
