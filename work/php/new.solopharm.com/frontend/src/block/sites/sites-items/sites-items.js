import Swiper, { Navigation } from 'swiper';
import 'swiper/css';

const blockName = 'b-sites-items';
const init = () => {
	const mainLBlock = document.querySelector(`.${blockName}`);

	if (!mainLBlock) return false;

	new Swiper(`.${blockName}__slider`, {
		direction: 'horizontal',
		loop: false,
		speed: 700,
		spaceBetween: 20,
		slidesPerView: 4,
		slideToClickedSlide: true,
		modules: [Navigation],
		navigation: {
			nextEl: `.${blockName}__nav-right`,
			prevEl: `.${blockName}__nav-left`,
		},
		breakpoints: {
			320: {
				slidesPerView: 1,
			},
			568: {
				slidesPerView: 2,
			},
			768: {
				slidesPerView: 3,
			},
			1030: {
				slidesPerView: 4,
			},
		},

	});
};

document.addEventListener('DOMContentLoaded', init);
