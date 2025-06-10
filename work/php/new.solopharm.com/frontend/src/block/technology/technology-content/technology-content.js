import { Popup } from 'component/models/Popup';

const blockName = 'b-technology-content';

export class TechnologyContent {
	static update() {
		const block = document.querySelector(`.${blockName}`);
		const btnActive = block.querySelector('.b-button');

		if (!btnActive) return false;
		new Popup().onActive(btnActive);
	}
}
