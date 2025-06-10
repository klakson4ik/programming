/* eslint-disable max-classes-per-file */
const blockName = 'b-header';

class Search {
	constructor(block) {
		this.searchActiveClass = `${blockName}__search-form--active`;
		this.btnActive = block.querySelector(`.${blockName}__search-icon`);
		this.form = block.querySelector(`.${blockName}__search-form`);
		this.btnSubmit = this.form.querySelector(`.${blockName}__search-icon`);
	}

	onActive() {
		this.btnActive.addEventListener('click', (e) => {
			if (window.innerWidth < 1024) {
				window.location.href = 'search';
			} else {
				e.stopPropagation();
				this.form.classList.add(this.searchActiveClass);
				this.form.query.addEventListener('click', (e) => e.stopPropagation());
				this.form.query.focus();
				this.onSubmit();
				this.onInactive();
			}
		});
	}

	onInactive() {
		document.addEventListener('click', () => {
			this.form.query.value = '';
			this.form.classList.remove(this.searchActiveClass);
		});
	}

	onSubmit() {
		this.btnSubmit.addEventListener('click', (e) => {
			e.stopPropagation();
			this.form.submit();
		});
	}
}

class Hamnburger {
	constructor(block) {
		this.hamburgerActiveClass = `${blockName}__hamburger--active`;
		this.burgerActiveClass = `${blockName}__burger--active`;
		this.hamburger = block.querySelector(`.${blockName}__hamburger`);
		this.burger = block.querySelector(`.${blockName}__burger`);
	}

	onActive() {
		this.hamburger.addEventListener('click', () => {
			this.hamburger.classList.toggle(this.hamburgerActiveClass);

			const body = document.querySelector('body');

			if (this.burger.classList.toggle(this.burgerActiveClass)) {
				body.classList.add('disable-scroll');
			} else if (!document.querySelector('.b-product__filter-mobile--active')) {
				body.classList.remove('disable-scroll');
			}
		});
	}
}

class HeaderTransparent {
	constructor(block) {
		this.headerWhiteClass = 'b-wrapper__header--white';
		this.header = block.querySelector('.b-wrapper__header');
	}

	onActive() {
		this.scroll();
		document.addEventListener('scroll', () => {
			this.scroll();
		});
	}

	scroll() {
		const pos = this.header.getBoundingClientRect().top + window.pageYOffset;

		pos > 35 ? this.header.classList.add(this.headerWhiteClass) : this.header.classList.remove(this.headerWhiteClass);
	}
}

const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (!block) return;
	new Search(block).onActive();

	new Hamnburger(block).onActive();

	const wrapperHeader = document.querySelector('.b-wrapper--main');

	if (wrapperHeader) new HeaderTransparent(wrapperHeader).onActive();
};

document.addEventListener('DOMContentLoaded', init);
