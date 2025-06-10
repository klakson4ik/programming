import { dropdownAction, dropdownSetSize } from "./dropdown"

export default class Carousel {
	constructor(params) {
		this.block = params.block
		this.iconClass = params.iconClass ?? 'icon'
		this.onClickClass = params.onClickClass ?? 'item'
		this.dropdownClass = params.dropdownClass ?? 'dropdown'
		this.itemClass = params.itemClass ?? 'item'
		this.event = params.event ?? 'click'
		this.padding = false
	}

	withPaddding() {
		this.padding = true;
		return this;
	}

	run() {
		this.block.querySelectorAll(`.${this.onClickClass}`).forEach(el => {
			el.item = (this.onClickClass !== this.itemClass)
				? el.closest(`.${this.itemClass}`)
				: el
			el.dropdown = el.item.querySelector(`.${this.dropdownClass}`)
			if (this.iconClass) {
				el.icon = el.item.querySelector(`.${this.iconClass}`)
			}
			this.onClick(dropdownSetSize(el, this.padding))
		})
	}

	onClick(el) {
		el.addEventListener(this.event, e => {
			const el = e.currentTarget;
			el.dropdown.classList.toggle(`${this.dropdownClass}--active`);
			el.icon.classList.toggle(`${this.iconClass}--active`)
			dropdownAction(el, this.padding)
		})
	}
}