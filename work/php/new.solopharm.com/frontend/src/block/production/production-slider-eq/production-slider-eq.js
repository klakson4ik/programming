// core	version	+ navigation, pagination modules:
import Swiper, { Navigation, Pagination } from 'swiper';

import 'swiper/css/pagination';
// import Swiper and modules styles
import 'swiper/css';

let swiper_eq;
const option = {
	modules: [Navigation, Pagination],
	observer: true,
	observeParents: true,
	slidesPerView: 1,
	centeredSlides: false,
	navigation: {
		prevEl: '.b-production-slider-eq__nav-left',
		nextEl: '.b-production-slider-eq__nav-right',
	},

};

function sliderTitle() {
	try {
		const el = document.querySelectorAll('.header h2');

		for (let x = 0; x < el.length; x++) {
			el[x].style.display = 'none';
		}

		el[swiper_eq.activeIndex].style.display = 'block';
	} catch (error) {
		return error;
	}
}

document.addEventListener('DOMContentLoaded', () => {
	swiper_eq = new Swiper('.slider-eq', option);
	sliderTitle();

	swiper_eq.on('slideChange', () => {
		sliderTitle();
	});
});
