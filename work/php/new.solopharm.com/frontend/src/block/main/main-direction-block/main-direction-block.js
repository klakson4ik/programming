// core	version	+ navigation, pagination modules:
import Swiper, { Navigation, Pagination } from 'swiper';

import 'swiper/css/pagination';
// import Swiper and modules styles
import 'swiper/css';

let swiper_dir;
let swiper_dir_mobile;
const wrapperBlock = 'b-main-direction-wrapper-items';
const option = {
	modules: [Navigation, Pagination],
	observer: true,
	observeParents: true,
	slidesPerView: 1,
	centeredSlides: false,
	draggable: false,
	simulateTouch: false,
	pagination: {
		el: '.nav-dir',
	},
	navigation: {
		prevEl: '.arrow-left',
		nextEl: '.arrow-right',
	},

};
const option2 = {
	observer: true,
	observeParents: true,
	slidesPerView: 1,
	centeredSlides: true,
};
let svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
let path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
let circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');

svg.setAttributeNS(null, 'width', '11');
svg.setAttributeNS(null, 'height', '11');
svg.setAttributeNS(null, 'viewBox', '0 0 11 11');
path.setAttributeNS(null, 'd', 'M4.89001 3.43999V2.42999H6.11001V3.43999H4.89001ZM6.11001 4.12999V8.57999H4.89001V4.12999H6.11001Z');
circle.setAttributeNS(null, 'cx', '5.5');
circle.setAttributeNS(null, 'cy', '5.5');
circle.setAttributeNS(null, 'r', '5');
svg.appendChild(circle);
svg.appendChild(path);

let svgArrow = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
let pathArrow = document.createElementNS('http://www.w3.org/2000/svg', 'path');

svgArrow.setAttributeNS(null, 'width', '14');
svgArrow.setAttributeNS(null, 'height', '10');
svgArrow.setAttributeNS(null, 'viewBox', '0 0 14 10');
pathArrow.setAttributeNS(null, 'd', 'M12.7412 1.75391L6.87056 7.62456L0.999909 1.75391');
svgArrow.appendChild(pathArrow);

window.HideDir = function (className, el) {

	let id_product = className;
	const url = window.location.origin+'/get-products/' + id_product;
	const liAll = document.querySelectorAll('.b-main-direction-block__list ul li');

	for (let x = 0; x < liAll.length; x++) {
		liAll[x].classList.remove('active');
	}

	el.classList.add('active');

	fetch(url)
		.then(response => response.text())
		.then(items => {
			let content = document.querySelector('.b-main-direction-block .swiper-wrapper-catalog');

			content.innerHTML = items;
			swiper_dir.update();
			swiper_dir.slideTo(0, 0);

			let arrow = document.querySelector('.b-main-direction-block__slider .arrows');

			arrowNonAct(arrow);

			document.querySelectorAll(`.${wrapperBlock}__product-card`).forEach(card => {
				let imgsWrapper = card.querySelector(`.${wrapperBlock}__img .${wrapperBlock}__wrapper`);

				if(imgsWrapper.childElementCount > 1) {
					let code = card.getAttribute('data-code');
	
					createSlider(code);
				}
			});

			const allElAct = document.querySelectorAll('.dir-slider .swiper-wrapper-catalog .swiper-slide');
			const navBar = document.querySelector('.nav-dir.swiper-pagination-bullets');
			const widthNav = `${100 / allElAct.length}%`;

			if (allElAct.length > 1) {
				navBar.style.opacity = '1';
				navBar.style.setProperty('--bullet-width', widthNav);

			} else {
				navBar.style.opacity = '0';
			}
		});
};

function createSlider(code) {
	let tradeLink = document.querySelector(`.${wrapperBlock}__product-card[data-code="${code}"] .${wrapperBlock}__img .${wrapperBlock}__wrapper`);
	let slidesCount = tradeLink ? tradeLink.childElementCount : 1;

	new Swiper(`.${wrapperBlock}__product-card[data-code="${code}"] .${wrapperBlock}__img`, {
		wrapperClass: `${wrapperBlock}__wrapper`,
		slideClass: `${wrapperBlock}__trade-link`,
		spaceBetween: 20,
		modules: [Navigation, Pagination],
		pagination: {
			el: `.${wrapperBlock}__product-card[data-code="${code}"] .${wrapperBlock}__pagination`,
			bulletClass: `${wrapperBlock}__bullet`,
			bulletActiveClass: `${wrapperBlock}__bullet--active`,
			currentClass: `${wrapperBlock}__bullet--current`,
			lockClass: `${wrapperBlock}__pagination--deactive`,
			modifierClass: `${wrapperBlock}__pagination--`,
			clickable: true,
			dynamicBullets: slidesCount <= 5 ? false : true,
			dynamicMainBullets: 1,
			loop: false
		},
		navigation: {
			prevEl: `.${wrapperBlock}__product-card[data-code="${code}"] .${wrapperBlock}__pic-controller--prev`,
			nextEl: `.${wrapperBlock}__product-card[data-code="${code}"] .${wrapperBlock}__pic-controller--next`,
			disabledClass: `${wrapperBlock}__pic-controller--deactive`,
			lockClass: `${wrapperBlock}__pic-controller--locked`
		}
	});
}

function resize() {
	if (window.innerWidth < 1024) {
		const allEl = document.querySelectorAll('.dir-slider .swiper-wrapper-catalog .swiper-slide');

		for (let x = 0; x < allEl.length; x++) {
			allEl[x].style.display = 'block';
		}
	} else {
		document.querySelector('.b-main-direction-block__list li').click();
	}
}

function ready() {
	swiper_dir = new Swiper('.dir-slider', option);

	swiper_dir_mobile = new Swiper('.dir-slider-mobile', option2);

	if (document.querySelector('.dir-slider-mobile .swiper-slide-active')){
		window.HideDir(document.querySelector('.dir-slider-mobile .swiper-slide-active').dataset.dir, document.querySelector('.dir-slider-mobile .swiper-slide-active'));
	}

	swiper_dir_mobile.on('slideNextTransitionEnd', function () {
		window.HideDir(document.querySelector('.dir-slider-mobile .swiper-slide-active').dataset.dir, document.querySelector('.dir-slider-mobile .swiper-slide-active'));
	});

	swiper_dir_mobile.on('slidePrevTransitionEnd', function () {
		window.HideDir(document.querySelector('.dir-slider-mobile .swiper-slide-active').dataset.dir, document.querySelector('.dir-slider-mobile .swiper-slide-active'));
	});

	window.addEventListener('resize', () => {
		resize();
	});

	swiper_dir.on('slideChange', () => {
		arrowNonAct(arrow);
	});

	let arrow = document.querySelector('.b-main-direction-block__slider .arrows');

	document.querySelector('.b-main-direction-block__slider .arrows').addEventListener('click', () => {
		arrowNonAct(arrow);
	});

	arrowNonAct(arrow);
}

function arrowNonAct(arrow) {
	const bullet = document.querySelectorAll('.nav-dir.swiper-pagination-bullets.swiper-pagination-horizontal .swiper-pagination-bullet');

	if (bullet[0].classList.contains('swiper-pagination-bullet-active')) {
		arrow.children[0].children[0].classList.add('nonact');
	} else {
		arrow.children[0].children[0].classList.remove('nonact');
	}

	if (bullet[(document.querySelectorAll('.nav-dir.swiper-pagination-bullets.swiper-pagination-horizontal .swiper-pagination-bullet').length - 1)].classList.contains('swiper-pagination-bullet-active')) {
		arrow.children[1].children[0].classList.add('nonact');
	} else {
		arrow.children[1].children[0].classList.remove('nonact');
	}
}

document.addEventListener('DOMContentLoaded', () => {
	ready();
	resize();
});
