export default class YCaptcha {
	#sctiptSrc = "https://smartcaptcha.yandexcloud.net/captcha.js";
	#capthcaWidgetId = false;

	constructor(form, params = {}) {
		this.form = form;
		this.invisible = params.invisible ?? true;
	}

	onClickForm() {
		this.form.addEventListener(
			"click",
			() => {
				if (!window.smartCaptcha) {
					this.load();
					return;
				}
				this.#init();
			},
			{ once: true },
		);
	}

	check() {
		const container = document.getElementById("captcha-container");
		if (!container) return false;
		const key = container.dataset.sitekey;
		if (!key) {
			console.error("Не указан ключ для yandex captcha");
			return false;
		}
		return true;
	}

	setToken(token) {
		this.form["smart-token"].value = token;
	}

	subscribe(callback) {
		window.smartCaptcha.subscribe(
			this.#capthcaWidgetId,
			"success",
			(token) => callback(token),
		);
	}

	execute() {
		window.smartCaptcha.execute(this.#capthcaWidgetId);
	}

	load() {
		if (!window.smartCaptcha) {
			const script = document.createElement("script");
			script.async = true;
			script.defer = true;
			script.addEventListener("load", () => this.#init());
			script.src = this.#sctiptSrc;
			document.head.appendChild(script);
			return;
		}
	}

	#init() {
		if (this.#capthcaWidgetId) {
			return;
		}
		const container = this.form.querySelector(".smart-captcha");

		this.#capthcaWidgetId = window.smartCaptcha.render(container, {
			invisible: this.invisible,
			sitekey: container.dataset.sitekey,
		});

		this.#subscribes();
	}

	#subscribes() {
		window.smartCaptcha.subscribe(
			this.#capthcaWidgetId,
			"token-expired",
			() => console.error("Возникла сетевая ошибка"),
		);
		window.smartCaptcha.subscribe(
			this.#capthcaWidgetId,
			"network-error",
			() => console.error("Токен прохождения проверки стал невалидным"),
		);
		window.smartCaptcha.subscribe(
			this.#capthcaWidgetId,
			"javascript-error",
			() => console.error("Возникла критическая ошибка JS"),
		);
	}
}
