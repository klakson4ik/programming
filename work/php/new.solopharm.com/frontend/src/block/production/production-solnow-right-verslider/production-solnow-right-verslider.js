import Swiper from 'swiper/bundle';

import 'swiper/css';

const blockName = 'b-production-solnow-right-verslider';
const option = {
	direction: 'vertical',
	mousewheelControl: true,
	slidesPerView: 5,
	slidesPerGroup: 1,
	freeMode: true,
	freeModeSticky: true,
	autoHeight: true,
	spaceBetween: 30,
	pagination: {
		el: `.${blockName}__pagination`,
	},
	navigation: {
		nextEl: `.${blockName}__arrow--right`,
		prevEl: `.${blockName}__arrow--left`,
	},
	on: {
		init: function(swiper) {
			let indexSwiper = swiper.activeIndex;
			let customLoopCounter = function () {
				if (swiper.pagination.bullets.length - 1 == indexSwiper) {
					indexSwiper = 0;
					swiper.slideTo(0, 400);
				} else {
					indexSwiper++;
				}
			};
			let customLoopCounterRev = function () {
				if (0 == indexSwiper) {
					indexSwiper = swiper.pagination.bullets.length - 1;
					swiper.slideTo(swiper.pagination.bullets.length - 1, 400);
				} else {
					indexSwiper--;
				}
			};

			document.querySelector(`.${blockName}__arrow--right`).addEventListener('click', () => {
				customLoopCounter();
			});

			document.querySelector(`.${blockName}__arrow--left`).addEventListener('click', () => {
				customLoopCounterRev();
			});
		}
	}
};

function ready() {
	const media = window.matchMedia('(min-width: 768px)');
	let slider = null;

	if (media.matches) {
		console.log('inited');
		slider = new Swiper(`.${blockName}__slider`, option);
	}

	media.addEventListener('change', (event) => {
		if (event.target.matches) {
			if (!slider) {
				slider = new Swiper(`.${blockName}__slider`, option);
			}
		} else {
			slider.destroy();
			slider = null;
		}
	});
}

document.addEventListener('DOMContentLoaded', () => {
	ready();
});
