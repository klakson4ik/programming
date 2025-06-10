const blockName = 'b-vacancy';

class Vacancy {
	constructor(block) {
		this.block = block;
		this.btns = block.querySelectorAll(`.${blockName}__menu-btn`);
		this.classBtnActive = `${blockName}__menu-btn--active`;
		this.row = block.querySelector(`.${blockName}__row-middle`);
		this.classAddActive = `${blockName}-list__additional--active`;
		this.loading = ['Санкт-Петербург'];
		this.sectionPosition = new Map();
		this.previewSection = this.block.querySelector(`.${this.classAddActive}`);
		this.setPositionSection(this.previewSection);
	}

	onClickCity() {
		this.btns.forEach(el => {
			el.addEventListener('click', (e) => {
				e.preventDefault();

				if (this.loading.includes(el.name)) {
					this.changeList(el);
				} else {
					this.insert(el);
				}

				this.block.querySelector(`.${this.classBtnActive}`).classList.remove(this.classBtnActive);
				el.classList.add(this.classBtnActive);
			});
		});
		return this;
	}

	setPositionSection(block) {
		let offsetTop = this.block.querySelector(`.${blockName}__menu`).offsetTop;

		block.querySelectorAll(`.${blockName}-list__item-section`).forEach(el => {
			offsetTop += el.clientHeight;
			this.sectionPosition.set(el.dataset.id, offsetTop);
		});
	}

	onClickSection() {
		this.row.querySelector(`.${this.classAddActive}`).addEventListener('click', e => {
			if (e.target.classList.contains(`${blockName}-list__item-section--active`)) {
				const posY = this.sectionPosition.get(e.target.dataset.id);

				if (window.scrollY > posY) {
					window.scrollTo({
						top: posY,
						left: 0,
						behavior: 'smooth',
					});
				}
			}

			const item = e.target.closest(`.${blockName}-list__item`);

			item.querySelector(`.${blockName}-list__item-sub`).classList.toggle(`${blockName}-list__item-sub--active`);

			item.querySelector(`.${blockName}-list__item-section`).classList.toggle(`${blockName}-list__item-section--active`);
		});
	}

	changeList(el) {
		this.row.querySelector(`.${this.classAddActive}`).classList.remove(this.classAddActive);
		this.row.querySelector(`[data-city="${el.name}"]`).classList.add(this.classAddActive);
	}

	async insert(el) {
		const data = await this.getData('/career/get-other-region/' + el.name);

		this.row.querySelector(`.${this.classAddActive}`).classList.remove(this.classAddActive);
		this.row.insertAdjacentHTML('afterbegin', data);
		this.onClickSection();

		const activeSection = this.block.querySelector(`.${this.classAddActive}`);

		this.setPositionSection(activeSection);
		this.loading.push(el.name);
	}

	async getData(url) {
		const response = await fetch(url, {
			method: 'GET'
		});

		return await response.text();
	}
}

const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (!block || !block.querySelector(`.${blockName}__row-middle`)) return;
	new Vacancy(block).onClickCity().onClickSection();
};

document.addEventListener('DOMContentLoaded', init);