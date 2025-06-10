const blockName = 'b-burger';

class BurgerMenu {
	constructor(block) {
		this.activeClass = `${blockName}__menu--active`;
		this.btnOpenChildRotate = `${blockName}__menu-btn--rotate`;
		this.btnOpenChild = block.querySelectorAll(`.${blockName}__menu-btn`);
		this.burger = block.querySelector(`.${blockName}__burger`);
	}

	onActive() {
		this.btnOpenChild.forEach((el) => {
			el.addEventListener('click', (e) => {
				e.currentTarget.classList.toggle(this.btnOpenChildRotate);
				e.currentTarget.closest('li').querySelector('ul').classList.toggle(this.activeClass);
			});
		});
	}
}

const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (!block) return;

	new BurgerMenu(block).onActive();
};

document.addEventListener('DOMContentLoaded', init);
