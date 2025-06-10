export default class Validate {
	static main(form) {
		this.form = form;
		this.form.validate = {};
		this.form.validate.fields = {};
		this.#check();
		this.#setResult();
	}

 /**
  * Получение результата валидации
  * @returns {void}
  */
	static #setResult() {
		for (const field of Object.values(this.form.validate.fields)) {
			if (field.errors.length > 0) {
				this.form.validate.result = false;
				return;
			}
		}
		this.form.validate.result = true;
	}

 /**
  * Расширения методов валидации полей
  * @returns {void}
  */
	static #check() {
		this.#validateRequired(this.form.querySelectorAll("[required]"));
		this.#validatePattern(this.form.querySelectorAll("[pattern]"));
		this.#validatePhone(this.form.querySelectorAll("[type='tel']"));
		this.#validateFiles(this.form.querySelectorAll("[type='file']"));
	}

 /**
  * Iterator по полям с одинаковыми условиями
  * @param {any} fields
  * @param {any} callback
  * @returns {void}
  */
	static #iterator(fields, callback) {
		if (fields.length < 1) return;
		fields.forEach((field) => callback(field));
	}

 /**
  * Записывает ошибку в обьект поля
  * @param {any} field
  * @param {any} text
  * @returns {void}
  */
	static #fillErrors(field, text) {
		const name = field.getAttribute("name");
		this.form.validate.fields[name]
			? this.form.validate.fields[name].errors.push(text)
			: (this.form.validate.fields[name] = {
					field: field,
					errors: [text],
				});
	}

 /**
  * @param {any} fields
  * @returns {any}
  */
	static #validateRequired(fields) {
		this.#iterator(fields, (field) => {
			if (field.type === "checkbox") {
				if (!field.checked)
					this.#fillErrors(field, "Необходимо установить флажок");
				return;
			}

			if (
				field.classList.contains("b-checkbox-group") ||
				field.classList.contains("b-radio-group")
			) {
				if (field.querySelectorAll("input:checked").length === 0)
					this.#fillErrors(
						field,
						"Необходимо выбрать хотя бы один элемент",
					);
				return;
			}

			if (field.value.length < 1)
				this.#fillErrors(field, "Поле обязательно для заполнения");
		});
	}

 /**
  * @param {any} fields
  * @returns {any}
  */

	static #validatePattern(fields) {
		this.#iterator(fields, (field) => {
			const pattern = field.getAttribute("pattern");
			if (!pattern) return;
			const regex = new RegExp(pattern);
			if (!regex.test(field.value))
				this.#fillErrors(field, "Не совпадает с шаблоном");
		});
	}

	static #validatePhone(fields) {
		this.#iterator(fields, (field) => {
			if (!field.mask.validate) return;
			if (!field.mask) return;
			if (field.value.length < 1) return;
			if (
				field.mask.emptyMask.match(/#/g).length !==
				field.value.match(/\d/g).length
			)
				this.#fillErrors(field, "Не совпадает с шаблоном");
		});
	}

 /**
  * @param {any} fields
  * @returns {any}
  */
	static #validateFiles(fields) {
		this.#iterator(fields, (field) => {
			const fileSize = field.dataset.maxFileSize
				? parseFloat(field.dataset.maxFileSize) * 1048576
				: false;
			if (!field.accept) return;
			const accept = field.accept.split(",");
			for (let i = 0; i < field.files.length; i++) {
				if (
					!accept.includes(
						"." + field.files.item(i).name.split(".").pop(),
					)
				) {
					this.#fillErrors(
						field,
						"Файлы должны быть типа: " + field.accept,
					);
					break;
				}
			}
			if (fileSize) {
				for (let i = 0; i < field.files.length; i++) {
					if (field.files.item(i).size > fileSize) {
						this.#fillErrors(
							field,
							"Файлы имеют размер больший допустимого: " +
								field.dataset.maxFileSize +
								"Mb",
						);
						break;
					}
				}
			}
			return;
		});
	}
}
