import Swiper from 'swiper/bundle';
import 'swiper/css/pagination';
import 'swiper/css';

const blockName = 'b-production-slider-block';
let swiper;
const option = {
	observer: true,
	autoHeight: true,
	observeParents: true,
	slidesPerView: 'auto',
	speed: 500,
	centeredSlides: true,
	autoplay: {
		enabled: true,
		delay: 3000,
		disableOnInteraction: true
	},
	navigation: {
		nextEl: `.${blockName}__nav-right`,
		prevEl: `.${blockName}__nav-left`,
	},
	on: {
		click(swiper, e) {
			sliderClickHandler(e.target);
		},
	},
};

window.testperv = function (n) {
	swiper.params.slidesPerView = n;
	swiper.update();
};

function sliderClickHandler(target) {

	const index = swiper.slides.indexOf(target.closest('.swiper-slide'));

	swiper.slideTo(index, option.speed);
}

function ready() {
	const sliderBlock = document.querySelector(`.${blockName}__slider`);

	if (!sliderBlock) return;

	let startSlide = 0;

	sliderBlock.querySelectorAll('.swiper-wrapper .swiper-slide').forEach((element, key) => {

		if (element.dataset.start == 1) {
			startSlide = key;
		}

	});

	option.initialSlide = startSlide;

	swiper = new Swiper(sliderBlock, option);

	let indexSwiper = swiper.activeIndex;
		const slideCountTrue = document.querySelectorAll(`.${blockName}__slider .swiper-wrapper .swiper-slide`).length - 1;
		let customLoopCounter = function() {
			if (slideCountTrue == indexSwiper) { 
				indexSwiper = 0;
				swiper.slideTo(0, 400);
			} else {
				indexSwiper++;
			}
		};
		let customLoopCounterRev = function() {
			if (0 == indexSwiper) { 
				indexSwiper = slideCountTrue;
				swiper.slideTo(slideCountTrue, 400);
			} else {
				indexSwiper--;
			}
		};

document.querySelector(`.${blockName}__nav-right`).addEventListener('click', () => {
	customLoopCounter();
});

document.querySelector(`.${blockName}__nav-left`).addEventListener('click', () => {
	customLoopCounterRev();
});
}

document.addEventListener('DOMContentLoaded', () => {
	ready();
});
