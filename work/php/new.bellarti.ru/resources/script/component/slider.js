import Swiper from 'swiper';
import { FreeMode, Navigation, Pagination } from 'swiper/modules';

export default function createSlider({
	blockName,
	slidesPerView = 1,
	spaceBetween = 0,
	loop = true,
	freeMode = false,
	pagination = false,
	navigation = false,
	breakpoints = {}
}) {
	let options = {
		slidesPerView: slidesPerView,
		spaceBetween: spaceBetween,
		wrapperClass: `${blockName}__wrapper`,
		slideClass: `${blockName}__slide`,
		loop: loop,
		freeMode: freeMode,
		breakpoints: breakpoints
	}

	if (navigation) {
		options.modules = [Navigation]
		options.navigation = {
			prevEl: `.${blockName} .nav-prev`,
			nextEl: `.${blockName} .nav-next`
		}
	}

	if (pagination) {
		if (options.modules)
			options.modules.push(Pagination)
		else
			options.modules = [Pagination]
		options.pagination = {
			el: `.${blockName} .pag`,
			bulletClass: 'bullet',
			bulletActiveClass: 'bullet--active',
			clickable: true,
			renderBullet: function (index, className) {
				return '<button class="' + className + '"></button>';
			},
		}
	}

	if (freeMode) {
		if (options.modules) {
			options.modules.push(FreeMode)
		}
		else {
			options.modules = [FreeMode]
		}
		options.freeMode = true;
	}
	

	return new Swiper(`.${blockName}__swiper`, options)
};