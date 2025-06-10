export class Cookie {
	constructor(block) {
		this.classBlock = block;
		this.time = 3000;
		this.block = document.querySelector(`.${block}`);
		this.btn = document.querySelector(`.${block}__btn`);
		this.blockHideClass = `${block}--hidden`;
	}

	onActive() {
		setTimeout(() => {
			this.block.classList.add(`${this.classBlock}-animate`)
		}, this.time);

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