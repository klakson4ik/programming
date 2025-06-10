import { Product } from 'component/models/Product';
import {Filter} from 'component/models/Filter';

const blockName = 'b-product-filter';

class Search {
	constructor(block) {
		this.block = block;
		this.search = block.querySelector(`.${block.className}__search`);
		this.filter = new Filter(this.block);
	}

	onActive() {
		this.active();
	}

	active() {
		let active = this.search.value.length > 2;

		this.search.addEventListener('input', async (e) => {
			if (e.target.value.length > 2) {
				const url = `${window.location.pathname}?search=${e.target.value}`;

				this.action(url);
				active = true;
			} else if (e.target.value.length < 3 && active) {
				const url = window.location.pathname;

				this.action(url);
				active = false;
			}

			document.querySelectorAll('input[name="search"]').forEach(item => {
				item.value = e.target.value;
			});
		});
	}

	async action(url) {
		const data = await this.getData(url);

		if (data) {
			Product.updateData(data, 'b-product__column-right');
			history.pushState(null, null, url);
			this.filter.onDelTag();
		}
	}

	async getData(url) {
		const response = await fetch(url, {
			method: 'GET',
		});

		return await response.text();
	}
}

const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (block) {
		new Filter(block).onActive().onReset().onDelTag();
		new Search(block).onActive();
	}
};

document.addEventListener('DOMContentLoaded', init);
