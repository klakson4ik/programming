import { Popup } from 'component/models/Popup';
import Validator from 'component/common/validator';

const blockName = 'b-internship';
const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (!block) return false;

	const internshipForm = new Validator(block, blockName);

	internshipForm.onSubmit();
	internshipForm.onInputPhone();

	if (document.querySelector('.b-popup')) {
		new Popup().open();
	}

	block.querySelectorAll('.b-input__field[type="file"]').forEach(input => {
		input.addEventListener('change', function() {
			let filename = input.files[0].name;

			if(filename) {
				input.style.setProperty('--file-name', `"${filename}"`);
			} else {
				input.style.removeProperty('--file-name');
			}
		});
	});
};

document.addEventListener('DOMContentLoaded', init);
