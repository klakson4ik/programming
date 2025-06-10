import InputFile from "../../block/fields2/input-file/input-file";
import Select from "../../block/fields2/select/Select";
import Errors from "./Errors";
import GCaptcha from "./GCaptcha";
import PhoneMask from "./PhoneMask";
import Validate from "./Validate";
import YCaptcha from "./YCaptcha";

export default class Form {
	constructor(form, params = {}) {
		this.form = form;

		this.submit = params.submit ?? false;
		this.beforeSubmit = params.beforeSubmit ?? (() => {});
		this.afterSubmit = params.afterSubmit ?? (() => {});

		this.afterValidate = params.afterValidate ?? false;
		this.afterValidateFail = params.afterValidateFail ?? false;

		this.beforeResponse = params.beforeResponse ?? false;
		this.afterResponse = params.afterResponse ?? false;
		this.afterResponseFail = params.afterResponseFail ?? false;

		this.dataAction = params.dataAction ?? false;

		this.form.fieldClass = params.fieldClass ?? "b-field";
		this.form.fieldErrorsClass = params.fieldErrorsClass ?? "b-errors";

		this.form.isValidate = params.isValidate ?? true;

		this.headers = params.headers ?? {};

		this.captcha = false;
		this.captchaInitImmediately = params.captchaInitImmediately ?? false;

		this.init();

		this.events();
	}

	init() {
		new Select(this.form).main();
		new InputFile(this.form).main();
	}

	events() {
		this.form.addEventListener("submit", (e) => this.#onSubmit(e));
		PhoneMask.onInput(this.form);
		const captcha = document.querySelector(".b-gcaptcha, .b-ycaptcha");

		if (captcha) {
			this.captcha =
				captcha.id == "gcaptcha"
					? new GCaptcha(this.form)
					: new YCaptcha(this.form);
			if (this.captcha.check()) {
				this.captchaInitImmediately
					? this.captcha.load()
					: this.captcha.onClickForm();
			}
		}
	}

	async #onSubmit(e) {
		if (this.submit) {
			this.submit(e);
			return;
		}
		e.preventDefault();
		this.beforeSubmit();
		if (this.form.isValidate) {
			if (this.#validate()) this.#action();
		} else this.afterSubmit();
	}

	#validate() {
		Validate.main(this.form);

		if (!this.form.validate.result) {
			this.afterValidateFail
				? this.afterValidateFail(this.form)
				: Errors.update(this.form);
			return false;
		} else {
			if (this.afterValidate) this.afterValidate(this.form);
			Errors.clear(this.form);
			return true;
		}
	}

	#action() {
		if (this.dataAction) this.dataAction(this.form);
		else {
			if (this.captcha) {
				this.captcha.subscribe((token) => {
					this.captcha.setToken(token);
					this.#send();
				});
				this.captcha.execute();
			} else this.#send();
		}
	}

	async #send() {
		let formData = new FormData(this.form);

		if (this.beforeResponse) {
			this.beforeResponse(this.form, formData);
		} else {
			this.#beforeResponse(formData);
		}
		console.log(formData);

		let response = await this.ajax(formData);
		if (response.success) {
			this.afterResponse
				? this.afterResponse(response, formData)
				: console.log(response.msg);
		} else {
			this.afterResponseFail
				? this.afterResponseFail(response, formData)
				: console.error(response.msg);
		}
	}

	async ajax(formData, form = this.form) {
		return fetch(form.action, {
			headers: this.headers,
			method: "POST",
			body: formData,
		}).then((response) => {
			if (!response.ok) throw new Error("Network response was not ok");
			return response.json();
		});
	}

	#beforeResponse(formData) {
		PhoneMask.beforeResponse(formData);
		Select.beforeResponse(this.form, formData);
	}
}
