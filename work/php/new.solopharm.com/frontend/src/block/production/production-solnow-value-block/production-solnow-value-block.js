// core	version	+ navigation, pagination modules:
import Swiper, { Navigation, EffectFade } from 'swiper';

import 'swiper/css/effect-fade';
// import Swiper and modules styles
import 'swiper/css';

let swiperValNow;
const optionVal = {
	modules: [Navigation, EffectFade],
	observer: true,
	observeParents: true,
	spaceBetween: 0,
	slidesPerView: 1,
	centeredSlides: true,
	freeMode: false,
	watchSlidesVisibility: true,
	watchSlidesProgress: true,
	draggable: false,
	allowTouchMove: false,
	effect: 'fade',
	fadeEffect: {
		crossFade: true,
	},
	navigation: {
		nextEl: '.link',
	},
};

function ready() {  

	try {

		swiperValNow = new Swiper('.swiperSolnow', optionVal);

		let indexSwiper = swiperValNow.activeIndex;
		const slideCount = document.querySelectorAll('.swiperSolnow .swiper-wrapper .swiper-slide').length - 1;
		let customLoopCounter = function() {
			if (slideCount == indexSwiper) {
				indexSwiper = 0;
				swiperValNow.slideTo(0, 400);
			} else {
				indexSwiper++;
			}
		};

		setInterval(() => {
			try {
			swiperValNow.slideNext();
			customLoopCounter();
		} catch { return 0; }
		}, 5000);

		document.querySelector('.link').addEventListener('click', () => {
			customLoopCounter();
		});

		document.querySelector('.navinfo .text h3').innerText = document.getElementById(`index${swiperValNow.activeIndex}`).dataset.title;
		document.querySelector('.navinfo .text p').innerText = document.getElementById(`index${swiperValNow.activeIndex}`).dataset.text;

		swiperValNow.on('slideChange', () => {
			document.querySelector('.navinfo .text h3').innerText = document.getElementById(`index${swiperValNow.activeIndex}`).dataset.title;
			document.querySelector('.navinfo .text p').innerText = document.getElementById(`index${swiperValNow.activeIndex}`).dataset.text;
		});
	} catch { return 0; }
}

document.addEventListener('DOMContentLoaded', () => {
	ready();
});
