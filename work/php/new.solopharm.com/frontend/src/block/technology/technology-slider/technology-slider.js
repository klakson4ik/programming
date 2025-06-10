import { TechnologyContent } from '../technology-content/technology-content';

const blockName = 'b-technology-slider';

class Technology {
	constructor(block) {
		this.slideActiveClass = `${blockName}__slide--active`;
		this.slider = block.querySelector(`.${blockName}__slider`);
		this.slides = this.slider.querySelectorAll(`.${blockName}__slide`);
		this.slideActive = this.slider.querySelector(`.${this.slideActiveClass}`);
		this.idAcitve = this.slideActive.dataset.id;
		this.btnNext = block.querySelector(`.${blockName}__nav-right`);
		this.btnPrev = block.querySelector(`.${blockName}__nav-left`);
		this.widthSlide = this.slideActive.offsetWidth;
		this.containerWidth = this.slider.offsetWidth;
		this.currentWidth = 0;
		this.currentShift = 0;
	}

	onActive() {
		TechnologyContent.update();
		this.btnNext.addEventListener('click', () => {
			this.next();
		});
		this.btnPrev.addEventListener('click', () => {
			this.prev();
		});
		this.slider.addEventListener('click', (e) => {
			this.click(e.target);
		});
	}

	click(target) {
		this.slideActive.classList.remove(this.slideActiveClass);

		const nextSlide = target.closest(`.${blockName}__slide`);

		nextSlide.classList.add(this.slideActiveClass);
		this.idAcitve = nextSlide.dataset.id;
		this.slideActive = nextSlide;

		this.change(nextSlide.dataset.technology);
		this.currentWidth = this.idAcitve * this.widthSlide;
		this.currentShift = (this.currentWidth + 2 * this.widthSlide) - this.containerWidth;
	}

	next() {
		this.slideActive.classList.remove(this.slideActiveClass);

		let nextSlide = this.slider.querySelector(`.${blockName}__slide[data-id="${++this.idAcitve}"]`);

		if (!nextSlide) {
			nextSlide = this.slider.querySelector(`.${blockName}__slide[data-id="0"]`);
			this.idAcitve = 0;
		}

		nextSlide.classList.add(this.slideActiveClass);
		this.slideActive = nextSlide;

		this.change(nextSlide.dataset.technology);

		if (this.idAcitve == 0) {
			this.slider.style.right = '0px';
			this.currentWidth = 0;
			this.currentShift = 0;
			return;
		}

		this.currentWidth += this.widthSlide;

		if (this.currentWidth > (this.containerWidth -  this.widthSlide)) {
			this.currentShift += this.widthSlide;
			this.slider.style.right = `${this.currentShift}px`;
		}
	}

	prev() {
		this.slideActive.classList.remove(this.slideActiveClass);

		let nextSlide = this.slider.querySelector(`.${blockName}__slide[data-id="${--this.idAcitve}"]`);

		if (!nextSlide) {
			this.idAcitve = this.slides.length - 1;
			nextSlide = this.slider.querySelector(`.${blockName}__slide[data-id="${this.idAcitve}"]`);
		}

		nextSlide.classList.add(this.slideActiveClass);
		this.slideActive = nextSlide;
		this.change(nextSlide.dataset.technology);

		if (this.idAcitve == this.slides.length - 1) {
			let shiftCount = 0;

			if(window.innerWidth > 568){
				shiftCount = 1;
			}

			this.slider.style.right = `${((this.slides.length + shiftCount) * this.widthSlide) - this.containerWidth}px`;
			this.currentWidth = (this.slides.length - 1) * this.widthSlide;
			this.currentShift = (this.currentWidth + 2 * this.widthSlide) - this.containerWidth;
			return;
		}

		this.currentWidth -= this.widthSlide;

		if ((this.containerWidth + 20) < this.containerWidth + this.currentShift) {
			this.currentShift -= this.widthSlide;
			this.slider.style.right = `${this.currentShift}px`;
		}
	}

	async change(id) {
		let url = window.location.origin + '/production/get-technology/' + id;
		// линтер ругался
		//console.log(url);
		const data = await this.getData(url);

		for (const [key, value] of Object.entries(data)) {
			this.updateData(value, `b-technology__${key}`);
		}
	}

	async getData(url) {
		const response = await fetch(url, {
			method: 'GET'
		});

		return await response.json();
	}

	updateData(data, parentName) {
		const parent = document.querySelector(`.${parentName}`);
		const child = parent.querySelector(`.${parentName} > div`);

		child.remove();
		parent.insertAdjacentHTML('afterBegin', data);
		TechnologyContent.update();
	}
}

const init = () => {
	const mainLBlock = document.querySelector(`.${blockName}`);

	if (!mainLBlock) return false;
	new Technology(mainLBlock).onActive();
};

document.addEventListener('DOMContentLoaded', init);
