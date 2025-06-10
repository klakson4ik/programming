import { Popup } from 'component/models/Popup';
import Validator from 'component/common/validator';

const blockName = 'b-supplier';
const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (!block) return false;

	const supplierForm = new Validator(block, blockName);

	supplierForm.onSubmit();
	supplierForm.onInputPhone();

	if (document.querySelector('.b-popup')) {
		new Popup().open();
	}
};

document.addEventListener('DOMContentLoaded', init);
