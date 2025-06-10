import SimpleSlider from '../../../component/common/SimpleSlider';
import { sliderTextHeight } from '../../../component/common/common';

const blockName = 'b-club-block-2';
const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (!block) return false;
	sliderTextHeight(`${blockName}__desc`, `${blockName}__desc-item`);

	const slider = new SimpleSlider(blockName);

	if (slider) {
		slider.onActive(changeDesc);
	}
};
const changeDesc = (id) => {
	const desc = document.querySelector(`.${blockName}__desc`);
	const descActiveClass = `${blockName}__desc-item--active`;
	const oldDesc = desc.querySelector(`.${descActiveClass}`);

	oldDesc.classList.remove(descActiveClass);
	oldDesc.style.height = '0';

	const currentDesc = desc.querySelector(`.${blockName}__desc-item[data-id="${id}"]`);

	currentDesc.classList.add(descActiveClass);
	currentDesc.style.height = 'auto';
};

document.addEventListener('DOMContentLoaded', init);
