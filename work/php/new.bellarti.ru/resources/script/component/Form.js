import { post } from "./ajax";
import Modal from "./Modal";
import Validate from "./Validate";
import Preloader from "./Preloader";

export default class Form {
	constructor(params) {
		this.form = params.form
		this.excludeTypes = ['hidden', 'submit'];
		this.errors = new Map();
		this.errorClass = 'field-error';
		this.grecaptcha = false;
		this.preloader = false;
		this.formNode = document.querySelector('.b-feedback');
		this.preloaderBlock = false;
	}

	withGrecaptcha() {
		this.grecaptcha = true
	}

	withPreloader() {
		this.preloader = true;
		this.preloaderBlock = document.querySelector('.b-feedback__preloader');		
	}

	onSubmit() {
		this.form.addEventListener('submit', async e => {
			e.preventDefault();
			if (this.#validate()) {
				if (this.preloader) {
					Preloader.blockForm(this.formNode, this.preloaderBlock);
				}
				const formData = new FormData(this.form);
				if (this.grecaptcha) {
					await this.#submitWithGrecaptcha(formData)
					return;
				} else {
					const response = await post(this.form.action, formData);
					this.#renderModal(response);
				}
			} else
				this.#renderErrors();
		});

		return this;
	}


	#renderModal(response) {
		if (response) {
			Modal.addContent('success', response.message)
			Modal.open('success');
			if (this.preloader) {
				Preloader.unblockForm(this.formNode, this.preloaderBlock);
			}
			document.forms.feedback.review.value = ''
		}
	}

	#validate() {
		const countFields = this.form.elements.length;
		this.errors.clear();
		for (let i = 0; i < countFields; i++) {
			const el = this.form.elements[i];
			if (this.excludeTypes.includes(el.type)) continue;
			let errors = [];
			const inputsErros = Validate.input(el);
			inputsErros.length !== 0 && (errors = inputsErros)
			const requiredErrors = Validate.required(el);
			requiredErrors.length !== 0 && errors.push(requiredErrors);
			errors.length !== 0 && this.errors.set(el.name, errors)

		}

		return this.errors.size === 0 || false
	}

	// TODO сделал не очень
	#renderErrors() {
		const countFields = this.form.elements.length;
		for (let i = 0; i < countFields; i++) {
			const el = this.form.elements[i];
			if (this.excludeTypes.includes(el.type)) continue;
			if (!this.errors.has(el.name))
				this.errors.set(el.name, true)

		}
		this.errors.forEach((errors, field) => {
			const input = this.form[field];
			if (input) {
				const errorBlock = input.closest('.b-input').querySelector('.field-error');
				if (errorBlock) {
					if (errors !== true) {
						errorBlock.querySelector('.replacement')?.remove()
						let text = '<div class="replacement">'
						errors.forEach(error => {
							text += '<p>' + error + '</p>'
						})
						text += '</div>'
						errorBlock.insertAdjacentHTML('afterbegin', text)
						errorBlock.classList.add('field-error--active')
						input.classList.add('invalid')
					} else {
						errorBlock.classList.remove('field-error--active')
						input.classList.remove('invalid')
					}
				}
			}
		})
	}

	async #submitWithGrecaptcha(formData) {
		const publicKey = this.form.querySelector('.b-grecaptcha').dataset.publicKey
		grecaptcha.ready(() => {
			grecaptcha.execute(publicKey, { action: "submit" }).then(async (token) => {
				formData.set('recaptcha_token', token)
				const response = await post(this.form.action, formData)
				this.#renderModal(response)
			})
		});
	}
}