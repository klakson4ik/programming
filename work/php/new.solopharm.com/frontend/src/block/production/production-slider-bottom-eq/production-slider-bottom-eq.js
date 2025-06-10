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
	slidesPerView: 1,
	centeredSlides: false,
	navigation: {
		prevEl: '.b-production-slider-bottom-eq__nav-left',
		nextEl: '.b-production-slider-bottom-eq__nav-right',
	},
	breakpoints: {
	},

};

function ready() {
	new Swiper('.slider-eq-bottom', option);
}

document.addEventListener('DOMContentLoaded', () => {
	ready();
});
