import { Popup } from 'component/models/Popup';
import Validator from 'component/common/validator';
import AddDrugBtn from './add-drug-btn/add-drug-btn';

const blockName = 'b-reaction-medical';
const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (!block) return false;

	const reactionMedicalForm = new Validator(block, blockName);

	reactionMedicalForm.onSubmit();
	reactionMedicalForm.onInputPhone();
	new AddDrugBtn(block).onClick(reactionMedicalForm);

	if (document.querySelector('.b-popup')) {
		new Popup().open();
	}
};

document.addEventListener('DOMContentLoaded', init);
