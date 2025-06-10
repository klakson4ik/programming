import { Popup } from 'component/models/Popup';

const blockName = 'b-club-block-1';
const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (!block) return false;

	const btnActive = block.querySelector(`.${blockName}__video`);

	if (!btnActive) return false;
	new Popup().onActive(btnActive);
};

document.addEventListener('DOMContentLoaded', init);
