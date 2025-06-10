export default class Validate {
	static #rule = {
		text: [
			{
				pattern: /[А-Яа-яЁёA-Za-z]{1}.{1,}/,
				error:
					'Поле должно содержать не менее 2х символов и начинатсья с буквы'
			},
		],
		email: [
			{
				pattern: /^[A-Za-z0-9_.-]+@[A-Za-z0-9_.-]+\.[A-Za-z0-9_.-]+/,
				error: 'Поле должно соответсвовать шаблону почты: example@mail.ru'
			}
		]
	}

	static #requiredMsg = 'Поле обязательно для заполнения'

	static input(el) {
		const rule = this.#rule[el.type]
		if (!rule) return [];
		let errors = [];
		Object.values(rule).map((value) => {
			!new RegExp(value.pattern).test(el.value) && errors.push(value.error)
		})
		return (errors.length === 0) ? [] : errors
	}

	static required(el) {
		if(el.type === 'checkbox'){
			return el.checked ? [] : this.#requiredMsg
		}
		return (el.required && el.value.length === 0)
			? this.#requiredMsg
			: []
	}
}