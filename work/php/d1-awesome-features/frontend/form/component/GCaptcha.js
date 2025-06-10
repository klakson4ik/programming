/* global grecaptcha */
export default class GCaptcha {
	#sctiptSrc = "https://www.google.com/recaptcha/api.js?render=";

	constructor(form, params = {}) {
		this.form = form;
		this.sitekey = params.sitekey ?? "";
		this.gcaptchaInit = false;
	}

	onClickForm() {
		this.form.addEventListener(
			"click",
			() => {
				if (!this.gcaptchaInit) this.load();
			},
			{ once: true },
		);
	}

	check() {
		const container = document.getElementById("gcaptcha");
		if (!container) return false;
		this.sitekey = container.dataset.sitekey;
		if (!this.sitekey) {
			console.error("Не указан ключ для google captcha");
			return false;
		}
		return true;
	}

	setToken(token) {
		this.form["recaptcha-token"].value = token;
	}

	subscribe(callback) {
		grecaptcha
			.execute(this.sitekey, { action: this.form.action })
			.then(async (token) => callback(token));
	}

	execute() {}

	load() {
		const script = document.createElement("script");
		script.async = true;
		script.defer = true;
		script.src = this.#sctiptSrc + this.sitekey;
		document.head.appendChild(script);
		this.gcaptchaInit = true;
	}
}
