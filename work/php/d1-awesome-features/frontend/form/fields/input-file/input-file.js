export default class InputFile {
	constructor(form, params = {}) {
		this.form = form;
		this.class = params.class ?? "b-input-file";
		this.btnClass = params.btnClass ?? "b-input-file__button";
		this.inputClass = params.inputClass ?? "b-input-file__input";
		this.labelClass = params.labelClass ?? "b-input-file__label";
		this.listClass = params.listClass ?? "b-input-file__list";
		this.itemClass = params.itemClass ?? "b-input-file__item";
	}

	main() {
		this.form.querySelectorAll(`.${this.btnClass}`).forEach((btn) =>
			btn.addEventListener("click", (e) => {
				e.preventDefault();
				const field = btn.closest(`.${this.class}`);
				field.input = field.querySelector(`.${this.inputClass}`);
				field.input.click();
				this.onChange(field);
			}),
		);
	}

	onChange(field) {
		field.input.addEventListener(
			"change",
			() => {
				this.clearList(field);
				this.setList(field);
			},
			{ once: true },
		);
	}

	async setList(field) {
		let list = false;
		if (field.classList.contains("preview")) this.#listPreview(field);
		else list = this.#listDefault(field);

		if (list) {
			field.insertAdjacentHTML("beforeend", list);
			this.onClickRemoveFiles(field);
		}
	}

	clearList(field) {
		field.querySelector(`.${this.listClass}`)?.remove();
	}

	onClickRemoveFiles(field) {
		field.querySelectorAll(`.${this.class}-item__remove`).forEach(
			(removeBtn) => {
				this.onClickRemoveFile(field, removeBtn);
			},
			{ once: true },
		);
	}

	onClickRemoveFile(field, removeBtn) {
		removeBtn.addEventListener("click", (e) => {
			e.preventDefault();
			this.removeFile(field, removeBtn.dataset.fileName);
			removeBtn.closest(`.${this.itemClass}`).remove();
		});
	}

	removeFile(field, removedfileName) {
		const dataTransfer = new DataTransfer();
		const files = Array.from(field.input.files);
		const newFiles = files.filter((file) => file.name !== removedfileName);
		newFiles.forEach((file) => dataTransfer.items.add(file));
		field.input.files = dataTransfer.files;
	}

	#listDefault(field) {
		let list = `<ul class="${this.listClass}">`;
		for (let i = 0; i < field.input.files.length; i++) {
			list += `<li class="${this.itemClass}"><span class="${this.class}-item__caption" href="">${field.input.files.item(i).name}</span><button class="${this.class}-item__remove" data-file-name="${field.input.files.item(i).name}">x</button></li>`;
		}
		return list + "</ul>";
	}

	#listPreview(field) {
		let listStr = `<ul class="${this.listClass}"></ul>`;
		field.insertAdjacentHTML("beforeend", listStr);
		const list = field.querySelector(`.${this.listClass}`);
		for (let i = 0; i < field.input.files.length; i++) {
			let reader = new FileReader();
			const file = field.input.files.item(i);
			reader.readAsDataURL(file);
			reader.onloadend = () => {
				const fileBlock = `<li class="${this.itemClass}"><img class="${this.class}-item__img" src="${reader.result}"><p class="${this.class}-item__caption">${file.name}</p><button class="${this.class}-item__remove" data-file-name="${file.name}">x</button></li>`;
				list.insertAdjacentHTML("beforeend", fileBlock);
				const removeBtn = list.querySelector(
					`.${this.class}-item__remove[data-file-name="${file.name}"]`,
				);
				this.onClickRemoveFile(field, removeBtn);
			};
		}
	}
}
