import Swiper from 'swiper';
import 'swiper/scss';

const blockName = 'b-product-tags-mobile';
const init = () => {
	const mainLBlock = document.querySelector(`.${blockName}`);

	if (!mainLBlock) return false;
	swiperTags();

};

export const swiperTags = () => {
	new Swiper(`.${blockName}__slider`, {
		speed: 700,
		slidesPerView: 'auto',
		spaceBetween: 20,
	});
};

document.addEventListener('DOMContentLoaded', init);
