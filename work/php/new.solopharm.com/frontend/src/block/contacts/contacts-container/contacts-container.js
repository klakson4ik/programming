// core	version	+ navigation, pagination modules:
import Swiper, { Navigation, Pagination } from 'swiper';

import 'swiper/css/pagination';
// import Swiper and modules styles
import 'swiper/css';

let swiper_dir;
const option = {
	modules: [Navigation, Pagination],
	observer: true,
	observeParents: true,
	autoHeight: true,
	slidesPerView: 1,
	spacebetween: 100,
	centeredSlides: true,
	freeMode: false,
	watchSlidesVisibility: true,
	watchSlidesProgress: true,
	draggable: false,
	allowTouchMove: false,
};

function ready() { 

	document.querySelectorAll('.col').forEach(element => {
		if (element.children.length<1){
			element.style.display = 'none';
		}
	});

	swiper_dir = new Swiper('.swiper', option);

	const contactsItems = document.querySelectorAll('.b-contacts-container__item-cont');
	const tabItems = document.querySelectorAll('.b-contacts-header__city-tab');

	contactsItems.forEach((item) => {
		item.addEventListener('click', function () {
			this.classList.forEach((el) => {
				if (el != 'active') {
					hideAllCont(contactsItems);
					this.classList.add('active');
				} else {
					hideAllCont(contactsItems);
				}
			});
		});
	});

	tabItems.forEach((item) => {
		item.addEventListener('click', () => {
			tabItems.forEach((tab) => {
				tab.classList.remove('b-contacts-header__city-tab--active');
			});

			item.classList.add('b-contacts-header__city-tab--active');

			swiper_dir.slideTo(item.dataset.slide, 400);
		});
	});
}

let ymaps = window.ymaps;

ymaps.ready(init);

function init() {
	document.querySelectorAll('.ymap').forEach((element, index) => {
		const myMap = new ymaps.Map(element.id, {
			center: [59.969683, 30.446593],
			zoom: 13,
			controls: [],
		});
		const points = JSON.parse(document.getElementById(`map${index}`).dataset.points);

		points.forEach((pin) => {
			if (pin.coords) {
				addPin(myMap, pin.coords.split(','), pin.title, pin.desc);
			}
		});
	});
}

function addPin(myMap, pointArr, header, text) {
	const myPlacemark = new ymaps.Placemark(pointArr, {
		balloonContent: `<div style="font-family:'Helvetica Neue';font-size:16px;line-height:150%;width: 220px;color:#333;margin:1em;"><span style="font-weight:bold">${header}</span><br>${text}</div>`,
	}, {

		iconLayout: 'default#image',
		iconImageHref: '/images/pin.png',
		iconImageSize: [50, 50],
	});

	myMap.geoObjects.add(myPlacemark);
	myMap.setCenter(pointArr);
}

function hideAllCont(items) {
	items.forEach((item) => {
		item.classList.remove('active');
	});
}

document.addEventListener('DOMContentLoaded', () => {
	ready();
});
