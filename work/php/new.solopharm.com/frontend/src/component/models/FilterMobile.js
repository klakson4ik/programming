const blockName = 'b-product';

export class FilterMobile {
	constructor(block) {
		this.filterInactive = `${blockName}__filter-mobile--inactive`;
		this.filter = block.querySelector(`.${blockName}__filter-mobile`);
		this.body = document.querySelector('body');
		this.openBtn = block.querySelector(`.${blockName}__filter-mobile-btn`);
		this.closeBtn = block.querySelector('.b-product-filter-mobile__close');
		this.returnCheckbox;
		this.returnSearchValue;
	}

	disableScroll() {
		this.body.classList.add('disable-scroll');
	}

	enableScroll() {
		this.body.classList.remove('disable-scroll');
	}

	onActive() {
		this.openBtn.addEventListener('click', () => {
			this.openFilter();
		});
		return this;
	}

	openFilter() {
		this.filter.classList.remove(this.filterInactive);
		this.disableScroll();
	}

	closeFilter() {
		this.filter.classList.add(this.filterInactive);
		this.enableScroll();
	}

	onInactive() {
		this.closeBtn.addEventListener('click', () => {
			this.closeFilter();
		});
		return this;
	}
}
