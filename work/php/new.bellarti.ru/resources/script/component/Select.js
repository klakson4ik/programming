import { dropdownAction, dropdownClose, dropdownSetSize } from "./dropdown"

export default class Select {
	constructor(params) {
		this.block = params.block
		this.onClickClass = params.onClickClass ?? 'btn'
		this.iconClass = params.iconClass ?? 'icon'
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
			const select = el.closest('.b-select');
			select.btn = el
			select.dropdown = select.querySelector(`.${this.dropdownClass}`)
			select.icon = el.querySelector(`.${this.iconClass}`);
			this.onClick(dropdownSetSize(select, this.padding));
			this.onPressEsc(select);
		})
	}

	onPressEsc(select) {
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape') {
				select.dropdown.classList.remove(`${this.dropdownClass}--active`);
				select.icon.classList.remove(`${this.iconClass}--active`);
				select.dropdown.style.height = 0;
			}
		})
	}

	onClick(select) {
		select.btn.addEventListener(this.event, () => {
			select.dropdown.classList.toggle(`${this.dropdownClass}--active`);
			select.icon.classList.toggle(`${this.iconClass}--active`)
			dropdownAction(select, this.padding);
			this.onClickItem(select);
		})
	}

	onClickItem(select) {
		select.dropdown.addEventListener('click', e => {
			if (e.target.classList.contains('item')) {
				if (e.target.classList.contains('selected')) {
					return;
				}
				const selectDataset = e.target.dataset;
				select.querySelector('.b-select__value').textContent = selectDataset.caption
				select.icon.classList.remove(`${this.iconClass}--active`)
				dropdownClose(select, this.padding)
				const selected = select.dropdown.querySelector('.selected');
				if (selected) {
					selected.classList.remove('selected')
				}
				e.target.classList.add('selected')
				document.dispatchEvent(
					new CustomEvent("on-select-" + select.dataset.event, {
						detail: {
							value: selectDataset.value,
							caption: selectDataset.caption
						},
					}),
				);
			}
		})
	}
}