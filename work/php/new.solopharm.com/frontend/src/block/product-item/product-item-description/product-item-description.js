import Swiper, { Navigation } from 'swiper';
import { Popup } from 'component/models/Popup';
import 'swiper/css';

const blockName = 'b-product-item-description';
const init = () => {
	const mainLBlock = document.querySelector(`.${blockName}`);

	if (!mainLBlock) return false;

	new Swiper(`.${blockName}__slider`, {
		direction: 'horizontal',
		loop: false,
		speed: 700,
		spaceBetween: 10,
		slidesPerView: 3,
		slideToClickedSlide: true,
		modules: [Navigation],
		navigation: {
			nextEl: `.${blockName}__nav-right`,
			prevEl: `.${blockName}__nav-left`,
		},
	});

	const btnActive = mainLBlock.querySelector(`.${blockName}__action-link--youtube`);

	if (!btnActive) return false;
	new Popup().onActive(btnActive);
};

document.addEventListener('DOMContentLoaded', init);
