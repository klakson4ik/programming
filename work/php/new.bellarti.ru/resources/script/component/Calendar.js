import { get } from "./ajax";

export default class Calendar {
	constructor(params) {
		this.block = params.block
		this.blockName = 'b-calendar'
		this.url = params.url ?? '/ajax/calendar/';
		this.pathname = null;
		this.next = this.block.querySelector(`.${this.blockName}__next`)
		this.prev = this.block.querySelector(`.${this.blockName}__prev`)
		this.dropdown = this.block.querySelector(`.${this.blockName} .dropdown`)
		this.currentDate = this.dropdown.querySelector('.selected').dataset.value
		this.selectDateValue = this.block.querySelector(`.${this.blockName}__select .b-select__value`);
	}

	run() {
		this.onSelectDate();
		this.onNext();
		this.onPrev();
		this.onClickItem();
	}

	onSelectDate() {
		document.addEventListener('on-select-date', e => {
			this.currentDate = e.detail.value;
			this.onAction('select');
		})
	}

	onNext() {
		this.next.addEventListener('click', () => {
			this.onAction('next')
		})
	}

	onPrev() {
		this.prev.addEventListener('click', () => {
			this.onAction('prev')
		})
	}

	// выполняет AJAX-запрос для получения данных о календаре в зависимости 
	// от типа действия (выбор даты, навигация вперед или назад).
	async onAction(type) {
		this.pathname = '/' + window.location.pathname.split('/')[1];

		const url = this.url + type + '/' + this.currentDate + this.pathname;
		// const url = this.url + type + '/' + this.currentDate;

		const result = await get(url);
		if (result.success) {
			this.fillDateSelect(result.data);
			document.dispatchEvent(
				new CustomEvent("on-change-calendar-date", {
					detail: {
						'events': result.data.events,
					},
				}),
			);
		} else {
			console.error(result.message);
		}
	}

	// Обновляет выпадающий список дат и содержимое календаря на основе данных, полученных из AJAX-запроса.
	fillDateSelect(data) {
		this.currentDate = data.currentDate
		this.setSelectDateValue(data.currentDateFormat)
		const dateObj = Object.entries(data.date)
		let count = 0;
		this.dropdown.querySelectorAll('.item').forEach(el => {
			el.dataset.value = dateObj[count][0];
			el.dataset.caption = dateObj[count][1];
			el.textContent = dateObj[count][1];
			if (el.classList.contains('selected')) {
				el.classList.remove('selected');
			}
			if (this.currentDate == dateObj[count][0]) {
				el.classList.add('selected');
			}
			++count;
		});
		this.replaceCalendarContent(data.content)
	}

	// Заменяет содержимое календаря новыми данными.
	replaceCalendarContent(data) {
		const replacement = this.block.querySelector('.b-content');
		const insertBlock = replacement.parentNode;
		replacement.remove();
		insertBlock.insertAdjacentHTML('afterbegin', data)
		this.onClickItem();
	}

	// Обновляет текстовое содержимое элемента, отображающего выбранную дату, на переданное значение.
	setSelectDateValue(value) {
		this.selectDateValue.textContent = value
	}

	// Добавляет обработчик кликов на элементы событий в календаре.
	onClickItem() {
		this.block.querySelector('.b-content').addEventListener('click', async e => {
			if (e.target.classList.contains('b-content__item--event')) {

				this.pathname = '/' + window.location.pathname.split('/')[1];
				const url = this.url + e.target.dataset.day + this.pathname;

				if (this.day && this.day.dataset.day === e.target.dataset.day)
					return;
				const result = await get(url);

				if (result.success) {
					if (this.day)
						this.day.classList.remove('b-content__item--selected');

					this.day = e.target;
					this.day.classList.add('b-content__item--selected');

					document.dispatchEvent(
						new CustomEvent("on-change-calendar-date", {
							detail: {
								'events': result.data.events,
								'forDetail': true,
							},
						}),
					);
				} else {
					console.error(result.message)
				}
			}
		})
	}
}