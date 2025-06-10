const blockName = 'b-add-drug-btn';

export default class AddDrugBtn {
	constructor(form) {
		this.form = form;
		this.btns = this.form.querySelectorAll(`.${blockName}`);
	}

	onClick(formClass) {
		this.btns.forEach(el => {
			el.addEventListener('click', (e) => {
				e.preventDefault();
				this.action(el);
				formClass.delEventSubmit();
				formClass.onSubmit();
			});
		});
	}

	action(el) {
		const count = ++el.dataset.count;
		const additional = this.form.querySelector(`.${el.name}`).cloneNode(true);

		additional.querySelectorAll('input').forEach(el => {
			const name = el.name.replace(/_\d{1,2}$/, '') + '_' + count;

			el.name = name;
			el.id = name;
			el.closest('.b-input').querySelector('.b-input__label').setAttribute('for', name);
		});

		const title = `<p class="${additional.classList[0]}-title">Препарат - №${count}</p>`;

		el.insertAdjacentHTML('beforebegin', title + additional.outerHTML);
		this.form.querySelector(`input[name=${el.name}_count]`).value++;
	}
}