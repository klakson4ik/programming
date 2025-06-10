export default class Errors {
	static update(form) {
		this.clear(form);
		this.set(form);
	}

	static set(form) {
		Object.values(form.validate.fields).map((el) => {
			let content = `<ul class="${form.fieldErrorsClass}">`;
			el.errors.forEach((err) => {
				content += `<li>${err}</li>`;
			});
			content += "</ul>";
			const field = el.field.closest(`.${form.fieldClass}`);
			field.insertAdjacentHTML("beforeEnd", content);
			field.classList.add(`${form.fieldClass}--invalid`);
		});
	}

	static clear(form) {
		form.querySelectorAll(`.${form.fieldErrorsClass}`).forEach((err) => {
			err.closest(`.${form.fieldClass}`).classList.remove(
				`${form.fieldClass}--invalid`,
			);
			err.remove();
		});
	}
}
