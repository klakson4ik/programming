export default class PhoneMask {
	static #protectSymbols = ["(", ")", "-", "+"];
	static #ruMask = "(3)3-2-2";
	static #phoneCodes = [];
	static #fields = [];
	static #codesDB = {};

	/**
	 * Обработка ввода
	 * @param {any} form
	 * @returns {void}
	 */
	static async onInput(form) {
		this.#fields = form.querySelectorAll('input[type="tel"]');
		if (this.#fields.length > 0) {
			let isOnlyRy = true;
			this.#fields.forEach((field) => {
				if (!field.dataset.maskRu) isOnlyRy = false;
				field.addEventListener("input", (e) => {
					if (field.dataset.maskDisable) return;
					if (
						e.inputType === "deleteContentBackward" ||
						e.inputType === "deleteContentForward"
					)
						this.#del(field);
					else if (e.inputType === "insertText") this.#input(field);
					else if (e.inputType === "insertFromPaste")
						this.#paste(field);
				});
			});
			if (!isOnlyRy) this.#codesDB = await import("./codes/codes.json");
			else this.#codesDB = { 7: this.#ruMask };
			this.#phoneCodes = Object.keys(this.#codesDB).map((el) => el);
		}
	}

	/**
	 * Форматирование значения поля в соответствии с условием
	 * @param {any} formData
	 * @returns {any}
	 */
	static beforeResponse(formData) {
		this.#fields.forEach((field) => {
			switch (field.mask.props.save) {
				case "full":
					break;
				case "full-without-plus":
					formData.set(field.name, field.value.replace(/^\+/, ""));
					break;
				case "raw":
					formData.set(field.name, field.value.replace(/\D/g, ""));
					break;
				default:
					formData.set(
						field.name,
						field.value.replace(/[^+0-9]/g, ""),
					);
					break;
			}
		});
	}

	/**
	 * Событие ввода символа
	 * @param {object} field
	 * @returns {void}
	 */
	static #input(field) {
		this.#initField(field);
		if (this.#isInsert(field)) {
			this.#insertInput(field);
		} else {
			this.#setValue(field);
			this.#setCaret(field);
		}
	}

	/**
	 * Событие удаление символа
	 * @param {object} field
	 * @returns {void}
	 */
	static #del(field) {
		this.#initField(field);
		if (this.#isInsert(field)) {
			this.#insertDel(field);
		} else {
			this.#setValue(field);
			this.#setCaret(field, true);
		}
	}

	/**
	 * Событие вставки номера
	 * @param {object} field
	 * @returns {void}
	 */
	static #paste(field) {
		if (this.#initField(field)) this.#clearMask(field);
		this.#setClearValue(field);
		let value = "";

		for (let i = 0; i < field.mask.clearValue.length; i++) {
			value += field.mask.clearValue[i];
			if (this.#setPhoneCode(field, value)) break;
		}
		if (field.mask.code) {
			if (this.#setMask(field)) {
				field.value = this.#getValue(field);
			}
		}
		this.#setCaret(field);
	}

	/**
	 * Получение настроек и подготовка поля 
	 * @param {any} field
	 * @returns {any}
	 */
	static #initField(field) {
		if (field.mask) return true;
		else {
			field.mask = {};
			field.mask.props = {
				sign: field.dataset.maskSign
					? this.#checkSign(field.dataset.maskSign)
						? field.dataset.maskSign
						: "_"
					: "_",
				plus: field.dataset.maskPlus === "" ? false : true,
				allow:
					field.dataset.maskAllowCodes &&
						field.dataset.maskAllowCodes !== ""
						? field.dataset.maskAllowCodes
						: false,
				disallow:
					field.dataset.maskDisallowCodes &&
						field.dataset.maskDisallowCodes !== ""
						? field.dataset.maskDisallowCodes
						: false,
				ru: field.dataset.maskRu ? true : false,
				save: field.dataset.maskSave ?? "raw-with-plus",
				validate: field.dataset.maskNoValidate ? false : true,
			};
		}
	}

	/**
	 * Удаление символа не последнего символа значения
	 * @param {any} field
	 * @returns {any}
	 */
	static #insertDel(field) {
		let caret = field.selectionStart;
		const prevCaret = caret - 1;
		if (caret <= field.mask.code.length + (field.mask.props.plus ? 1 : 0)) {
			field.value = this.#isPlus(field);
			return;
		}
		const currCaret = field.mask.props.plus ? prevCaret : caret;
		if (this.#protectSymbols.includes(field.mask.emptyMask[currCaret])) {
			field.value = this.#replaceChar(
				field.value,
				prevCaret,
				field.mask.emptyMask[currCaret],
			);
			field.value = this.#insertChar(
				field.value,
				prevCaret,
				field.mask.props.sign,
			);
			--caret;
		} else {
			field.value = this.#insertChar(
				field.value,
				caret,
				field.mask.props.sign,
			);
		}
		field.setSelectionRange(caret, caret);
	}

	/**
	 * Вставка символа в разрез поля
	 * @param {any} field
	 * @returns {any}
	 */
	static #insertInput(field) {
		let caret = field.selectionStart;
		if (caret <= field.mask.code.length + (field.mask.props.plus ? 1 : 0)) {
			field.value =
				this.#isPlus(field) +
				field.value[caret - (field.mask.props.plus ? 1 : 0)];
			return;
		}
		if (this.#protectSymbols.includes(field.value[caret])) {
			const prevCaret = caret - 1;
			const prevValue = field.value[prevCaret];
			field.value = this.#removeChar(field.value, prevCaret);
			field.value = this.#replaceChar(field.value, caret, prevValue);
			++caret;
		} else {
			field.value = this.#removeChar(field.value, caret);
			if (this.#protectSymbols.includes(field.value[caret])) {
				++caret;
			}
		}
		field.setSelectionRange(caret, caret);
	}

	/**
	 * @param {any} field
	 * @returns {any}
	 */
	static #setValue(field) {
		this.#setClearValue(field);
		if (this.#isChangeCode(field)) {
			this.#clearValue(field);
		}
		if (!field.mask.code) {
			this.#setPhoneCode(field);
		}
		if (field.mask.code) {
			if (this.#setMask(field)) {
				field.value = this.#getValue(field);
			}
		}
	}

	/**
	 * @param {any} field
	 * @returns {any}
	 */
	static #setMask(field) {
		if (!field.mask.mask) {
			field.mask.mask =
				field.mask.code.length + this.#codesDB[field.mask.code];
			if (field.mask.mask) {
				field.mask.emptyMask = field.mask.mask.replace(/\d/g, (m) =>
					field.mask.props.sign.repeat(m),
				);
				return true;
			} else {
				return false;
			}
		}
		return true;
	}

	/**
	 * Определение кода страны 
	 * @param {any} field
	 * @param {any} clearValue=false
	 * @returns {any}
	 */
	static #setPhoneCode(field, clearValue = false) {
		const pattern = new RegExp(
			"^" + (clearValue || field.mask.clearValue),
			"g",
		);
		let code = this.#getAllowCodes(field).filter((el) => el.match(pattern));
		if (field.mask.props.ru) {
			this.#setRuPhoneCode(field, code[0]);
			return;
		}
		if (code.length === 0) {
			if (field.mask.clearValue[0] === "8") {
				field.value =
					this.#isPlus(field) + "7" + field.mask.clearValue.slice(1);
				field.mask.clearValue = field.mask.clearValue.replace(
					/^\d/,
					"7",
				);
				field.mask.code = "7";
			} else {
				field.value =
					this.#isPlus(field) + field.mask.clearValue.slice(0, -1);
			}
		} else if (code.length > 1) {
			return false;
		} else {
			field.mask.code = code[0];
		}

		return true;
	}

	/**
	 * Установка каретки
	 * @param {any} field
	 * @param {any} isDel=false
	 * @returns {any}
	 */
	static #setCaret(field, isDel = false) {
		let countSymbols = field.value.indexOf(field.mask.props.sign);
		const codeLength =
			field.mask.code.length + (field.mask.props.plus ? 1 : 0);

		if (countSymbols < codeLength && field.value.length < codeLength) {
			countSymbols = codeLength;
		}

		if (isDel && field.mask.emptyMask) {
			const prevSymbols =
				field.mask.emptyMask[
				countSymbols - (field.mask.props.plus ? 2 : 1)
				];
			if (this.#protectSymbols.includes(prevSymbols)) --countSymbols;
		}
		field.setSelectionRange(countSymbols, countSymbols);
	}

	/**
	 * Запись читсого значения, только цифры
	 * @param {any} field
	 * @returns {any}
	 */
	static #setClearValue(field) {
		field.mask.clearValue = field.value.replace(/\D/g, "");
	}

	/**
	 * @param {any} field
	 * @returns {any}
	 */
	static #setRuPhoneCode(field) {
		const value = field.value;
		field.value = this.#isPlus(field) + "7" + value;
		field.mask.clearValue = "7" + value;
		field.mask.code = "7";
	}

 /**
  * Получение доступных кодов стран из настроек поля
  * @param {any} field
  * @returns {Array}
  */
	static #getAllowCodes(field) {
		if (field.mask.props.ru) return ["7"];
		let tmpArr = [];
		if (field.mask.props.allow) tmpArr = field.mask.props.allow.split(",");
		if (field.mask.props.disallow) {
			const disallow = field.mask.props.disallow.split(",");
			if (tmpArr.length > 0) {
				tmpArr = tmpArr.filter((x) => !disallow.includes(x));
			} else {
				tmpArr = this.#phoneCodes.filter((x) => !disallow.includes(x));
			}
		}

		return tmpArr.length === 0 ? this.#phoneCodes : tmpArr;
	}

 /**
  * Получение значения поля в сопоставление c маской
  * @param {any} field
  * @returns {string}
  */
	static #getValue(field) {
		let tmpValue = "";
		let count = 0;
		for (let i = 0; i < field.mask.emptyMask.length; i++) {
			if (field.mask.emptyMask[i] !== field.mask.props.sign) {
				tmpValue += field.mask.emptyMask[i];
			} else {
				tmpValue += field.mask.clearValue[count]
					? field.mask.clearValue[count++]
					: field.mask.emptyMask[i];
			}
		}
		return this.#isPlus(field) + tmpValue;
	}

 /**
  * Проверка на допустимость знака маска 
  * @param {any} sign
  * @returns {boolean}
  */
	static #checkSign(sign) {
		if (sign.length > 1) return false;
		if (/\d/.test(sign)) return false;
		if (this.#protectSymbols.includes(sign)) return false;
		return true;
	}

 /**
  * Определяет, символ вставляется в разрез или вводится по порядку
  * @param {string} field
  * @returns {boolean}
  */
	static #isInsert(field) {
		const lastNumber = field.value.search(/\d{1}[^0-9]*$/);
		const caret = field.selectionStart;
		return caret < lastNumber ? true : false;
	}

 /**
  * Определяет изменчивость кода страны
  * @param {object} field
  * @returns {boolean}
  */
	static #isChangeCode(field) {
		const pattern = new RegExp("^" + field.mask.code);
		const result = field.mask.clearValue.match(pattern);
		return !result || result.length > 1 ? true : false;
	}

 /**
  * Устанавлимость плюса
  * @param {object} field
  * @returns {string}
  */
	static #isPlus(field) {
		return field.mask.props.plus ? "+" : "";
	}

 /**
  * @param {object} field
  * @returns {void}
  */
	static #clearMask(field) {
		field.mask.code = false;
		field.mask.mask = false;
	}

 /**
  * @param {object} field
  * @returns {void}
  */
	static #clearValue(field) {
		this.#clearMask(field);
		field.value = field.mask.clearValue;
	}

	static #insertChar(str, index, char) {
		return str.substring(0, index) + char + str.substring(index);
	}

	static #removeChar(str, index) {
		return str.substring(0, index) + "" + str.substring(index + 1);
	}

	static #replaceChar(str, index, char) {
		return str.substring(0, index) + char + str.substring(index + 1);
	}
}
