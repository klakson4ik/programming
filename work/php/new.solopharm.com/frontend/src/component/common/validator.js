import IMask from 'imask';

export default class Validator {
	constructor(form, blockName) {
		this.form = form;
		this.validateFields = form.querySelectorAll('.b-input__field[data-pattern]');
		this.phoneFields = form.querySelectorAll('.b-input__field[type="tel"]');
		this.requiredFields = form.querySelectorAll('[data-required]');
		this.checkboxFields = form.querySelectorAll('.b-checkbox__field[data-required]');
		this.phoneField = form.querySelector('.b-input__field[name="phone"]');
		this.errorClass = 'b-field--error';
		this.requiredClass = 'b-field--required';
		this.formErrorBlock = form.querySelector(`.${blockName}__error`);
		this.eventSubmit = this.eventSubmit.bind(this);
	}

	onSubmit() {
		this.form.addEventListener('submit', this.eventSubmit);
	}

	delEventSubmit() {
		this.form.removeEventListener('submit', this.eventSubmit);
	}

	eventSubmit(e) {
		this.submit(e);
	}

	onInputPhone() {
		this.phoneFields.forEach((element) => {
			let mask = '+7 (000) 000-00-00';

			IMask(element, {mask: mask});
		});
	}

	submit(e) {
		e.preventDefault();

		let is_validate = true;

		this.validateFields.forEach((element) => {
			const result = this.validate(element) ? this.hideError(element) : this.showError(element);

			is_validate = is_validate ? result : false;
		});
		this.checkboxFields.forEach((element) => {
			const result = element.checked ? this.hideError(element) : this.showError(element);

			is_validate = is_validate ? result : false;
		});
		this.requiredFields.forEach((element) => {
			if (element.dataset.required == 'false') return false;

			const result = this.required(element) ? this.hideError(element, this.requiredClass) : this.showError(element, this.requiredClass);

			is_validate = is_validate ? result : false;
		});
		if (is_validate) this.form.submit();
	}

	validate(element) {
		return !!new RegExp(element.dataset.pattern).test(element.value);
	}
	required(element) {
		return element.value.length > 0 ? true : false;
	}

	showError(element, errorClass = this.errorClass) {
		element.closest('.b-field').classList.add(errorClass);
		return false;
	}

	hideError(element, errorClass = this.errorClass) {
		element.closest('.b-field').classList.remove(errorClass);
		return true;
	}
}