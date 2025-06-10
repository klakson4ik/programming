const blockName = 'b-cookie';

class Cookie {
	constructor(block) {
		this.block = block;
		this.blockHideClass = `${blockName}--hidden`;
		this.btn = this.block.querySelector(`.${blockName}__btn`);
	}

	onActive() {
		this.btn.addEventListener('click', () => {
			this.hide();
			this.addCookie();
		});
	}

	hide() {
		this.block.classList.add(this.blockHideClass);
	}

	addCookie() {
		const age = 3600 * 24 * 365;

		document.cookie = `acceptCookie=1; max-age=${age}`;
	}
}

const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (!block) return;
	new Cookie(block).onActive();
};

document.addEventListener('DOMContentLoaded', init);
