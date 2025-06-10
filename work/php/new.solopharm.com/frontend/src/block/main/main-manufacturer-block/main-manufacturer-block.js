// core	version	+ navigation, pagination modules:
import Swiper, { Navigation, Pagination } from 'swiper';

import 'swiper/css/pagination';
// import Swiper and modules styles
import 'swiper/css';

const option = {
	modules: [Navigation, Pagination],
	observer: true,
	observeParents: true,
	loop: true,
	spaceBetween: 10,
	slidesPerView: 1,
	freeMode: false,
	watchSlidesVisibility: true,
	watchSlidesProgress: true,
	pagination: {
		el: '.swiper-pagination',
	},
	navigation: {
		prevEl: '.b-main-manufacturer-block__nav-left',
		nextEl: '.b-main-manufacturer-block__nav-right',
	},
	breakpoints: {
		// when window width is >= 320px
		500: {
			slidesPerView: 2,
			spaceBetween: 20,
		},
		// when window width is >= 480px
		1024: {
			slidesPerView: 4,
			spaceBetween: 30,
		},
	},

};

function ready() {
	new Swiper('.swiperMf', option);

	const elPag = document.querySelectorAll('.swiperMf .swiper-pagination .swiper-pagination-bullet');
	const width = 100 / elPag.length;

	for (let x = 0; x < elPag.length; x++) {
		elPag[x].style.width = `${width}%`;
	}
}

document.addEventListener('DOMContentLoaded', () => {
	ready();
});
