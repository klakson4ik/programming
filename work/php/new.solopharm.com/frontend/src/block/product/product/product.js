import { FilterMobile } from 'component/models/FilterMobile';

const blockName = 'b-product';
const init = () => {
	const mainBlock = document.querySelector(`.${blockName}`);

	if (!mainBlock) return false;

	const filterMobile = new FilterMobile(mainBlock).onActive().onInactive();

	if (window.innerWidth < 1024) {
		if (!new URL(window.location.href).searchParams.get('page')) filterMobile.openFilter();
	}

};

document.addEventListener('DOMContentLoaded', init);
