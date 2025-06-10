import { toggleScroll } from "../component/helpers";

export function hamburger(block) {
	const hamburger = block.querySelector('.b-header__hamburger');
	const menu = block.querySelector('.b-header__mobile-menu');
	const menuActiveClass = 'b-header__mobile-menu--active';
	const hamburgerActvieClass = 'b-header__hamburger--active';
	hamburger.addEventListener('click', () => {
		hamburger.classList.toggle(hamburgerActvieClass);
		menu.classList.toggle(menuActiveClass)
		toggleScroll();
	})
}

export function burger(block) {
	const activeClass = 'b-menu--active';
	const btnOpenChildRotate = 'icon--active';
	const btnOpenChild = block.querySelectorAll('.b-header__mobile-menu .b-menu__arrow');

	btnOpenChild.forEach((el) => {
		el.addEventListener('click', (e) => {
			e.currentTarget.classList.toggle(btnOpenChildRotate);
			const li = e.currentTarget.closest('li')
			const ul = li.querySelector('ul')
			if (ul) {
				ul.classList.toggle(activeClass);
			}
		});
	});
}

export function jsScroll(main = false) {
	if (!main) return;
	const header = document.querySelector('.header')
	const hamburger = header.querySelector('.header__hamburger');
	const menu = header.querySelector('.header__menu');
	const menuActiveClass = 'header__menu--active';
	const hamburgerActvieClass = 'header__hamburger--active';
	const topOffset = header.offsetHeight + 15
	document.querySelectorAll('.js-scroll').forEach(element => {
		element.addEventListener('click', e => {
			e.preventDefault();
			menu.classList.remove(menuActiveClass)
			hamburger.classList.remove(hamburgerActvieClass)
			let href = element.getAttribute('href').substring(1);
			const scrollTarget = document.querySelector(href);
			const elementPosition = scrollTarget.getBoundingClientRect().top;
			const offsetPosition = elementPosition - topOffset;

			window.scrollBy({
				top: offsetPosition,
				behavior: 'smooth'
			});
		})
	});
}