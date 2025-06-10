import { scrollToPosition } from "./smoothScroll";

export default class PagSide {
	constructor(params) {
		this.block = params.block
		this.blockName = params.blockName ?? 'b-pag-side';
		this.pag = this.block.querySelector(`.${this.blockName}__list`)
		this.activeElClass = `${this.blockName}__item--active`
		this.topOffset = document.querySelector('.b-header').offsetHeight + 20
		this.currentActiveEl;
	}

	init() {
		if (window.innerWidth < 1900)
			return this;
		const anchor = this.#getAnchorFromUrl();
		let el = this.pag.querySelector(`#anchor-${anchor}`)
		if (!el) {
			el = this.pag.querySelector(`.${this.blockName}__item`);
		}
		this.#elActive(el)
		this.onClick()
		return this;
	}

	onClick() {
		this.pag.querySelectorAll(`.${this.blockName}__item`).forEach(el => {
			el.addEventListener('click', e => {
				e.preventDefault()
				const anchor = el.querySelector(`.${this.blockName}__link`).hash;
				if (anchor) {
					if (scrollToPosition(anchor, this.topOffset)) {
						this.#elInactive()
						this.#elActive(el)
						this.#addAnchorToUrl(anchor)
					}
				}
			})
		});
	}

	onScroll() {
		window.addEventListener('load', () => {
			const anchors = [];
			this.pag.querySelectorAll(`.${this.blockName}__item`).forEach(el => {
				const anchor = el.id.substring(7)
				const section = document.getElementById(anchor);
				const box = section.getBoundingClientRect()
				anchors.push(
					{
						name: anchor,
						top: box.top - this.topOffset + window.scrollY,
						bottom: box.bottom - this.topOffset + window.scrollY
					}
				)

			})

			window.addEventListener('wheel', () => {
				const pos = window.scrollY;
				let currAnchor = false

				for (let i = 0; i < anchors.length; i++) {
					if (pos > anchors[i].top && pos < anchors[i].bottom) {
						currAnchor = anchors[i].name
						break
					}
				}
				this.#elInactive();
				if (currAnchor) {
					const anchorBlock = this.pag.querySelector(`#anchor-${currAnchor}`);
					this.#elActive(anchorBlock)
				}
			})
		})
	}

	#getAnchorFromUrl() {
		return window.location.hash.substring(1);
	}

	#elActive(el) {
		this.currentActiveEl = el
		this.currentActiveEl.classList.add(this.activeElClass)
	}

	#elInactive() {
		if (this.currentActiveEl) {
			this.currentActiveEl.classList.remove(this.activeElClass)
			this.currentActiveEl = false
		}
	}

	#addAnchorToUrl(anchor) {
		const url = new URL(window.location);
		url.hash = anchor;
		window.history.pushState({}, '', url);
	}
}