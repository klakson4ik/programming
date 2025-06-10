import { Popup } from 'component/models/Popup';
import Validator from 'component/common/validator';

const blockName = 'b-reaction-patient';

class FormAction {
	constructor(form) {
		this.otherAdd = form.querySelector(`.${blockName}__other-add`);
		this.otherDel = form.querySelector(`.${blockName}__other-del`);
		this.otherAddActive = `${blockName}__other-add--active`;
		this.otherDelActive = `${blockName}__other-del--active`;
		this.who = form.querySelectorAll('input[name=who]');
		this.whoBlock = this.who[0].closest('.b-radio__row');
	}

	onActive() {
		this.whoBlock.addEventListener('change', e => {
			if (e.target.id == 'who-relative' || e.target.id == 'who-other') {
				this.active();
			}

			if (e.target.id == 'who-patient') {
				this.inactive();
			}
		});
	}

	active() {
		this.otherAdd.classList.add(this.otherAddActive);
		this.otherAdd.querySelectorAll('.b-input__field').forEach(el => {
			el.dataset.required = 'true';
		});
		this.otherDel.classList.remove(this.otherDelActive);
		this.otherDel.querySelectorAll('.b-input__field').forEach(el => {
			el.dataset.required = 'false';
			el.value = '';
		});
	}
	inactive() {
		this.otherAdd.classList.remove(this.otherAddActive);
		this.otherAdd.querySelectorAll('.b-input__field').forEach(el => {
			el.dataset.required = 'false';
			el.value = '';
		});
		this.otherDel.classList.add(this.otherDelActive);
		this.otherDel.querySelectorAll('.b-input__field').forEach(el => {
			el.dataset.required = 'true';
		});
	}

}

const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (!block) return false;

	const reactionPatientForm = new Validator(block, blockName);

	reactionPatientForm.onSubmit();
	reactionPatientForm.onInputPhone();

	new FormAction(block).onActive();

	if (document.querySelector('.b-popup')) {
		new Popup().open();
	}
};

document.addEventListener('DOMContentLoaded', init);
