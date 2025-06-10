import Swiper, { Navigation, Thumbs } from 'swiper';
import 'swiper/scss';

const blockName = 'b-gallery-slider';
const init = () => {
	const mainLBlock = document.querySelector(`.${blockName}`);

	if (!mainLBlock) return false;

	new Swiper(`.${blockName}__thumbs`, {
		modules: [Navigation],
		loop: true,
		speed: 700,
		slidesPerView: 3,
		spaceBetween: 10,
		slideToClickedSlide: true,
		navigation: {
			nextEl: `.${blockName}__nav-area-right, .${blockName}__nav-right`,
			prevEl: `.${blockName}__nav-area-left, .${blockName}__nav-left`
		},
		breakpoints: {
			568: {
				slidesPerView: 4,
			},
			768: {
				slidesPerView: 5,
			},
		},
	});

	new Swiper(`.${blockName}__slider`, {
		modules: [Navigation, Thumbs],
		loop: true,
		speed: 700,
		navigation: {
			nextEl: `.${blockName}__nav-area-right, .${blockName}__nav-right`,
			prevEl: `.${blockName}__nav-area-left, .${blockName}__nav-left`
		},
	});
};

document.addEventListener('DOMContentLoaded', init);
