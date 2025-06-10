import {Filter} from 'component/models/Filter';

const blockName = 'b-product-filter-mobile';
const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (block) {
		let filter = new Filter(block, true);

		filter.onActive().sectionsImitation().onDelTag();
	}
};

document.addEventListener('DOMContentLoaded', init);
