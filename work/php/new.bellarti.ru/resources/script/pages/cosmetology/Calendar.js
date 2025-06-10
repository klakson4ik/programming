import { get } from "../../component/ajax"

export default class Calendar {
	constructor(params) {
		this.block = params.block
		this.blockName = params.blockName ?? 'b-education'
		this.url = '/ajax/full-calendar/';
		this.pathname = window.location.pathname;
		this.next = this.block.querySelector(`.${this.blockName}__next`)
		this.prev = this.block.querySelector(`.${this.blockName}__prev`)
		this.dateDropdown = this.block.querySelector(`.${this.blockName}__date-select .dropdown`)
		this.cityDropdown = this.block.querySelector(`.${this.blockName}__column--city .dropdown`)
		this.currentDate = this.dateDropdown.querySelector('.selected').dataset.value
		this.currentCity = this.cityDropdown.querySelector('.selected').dataset.value
		this.selectDateValue = this.block.querySelector(`.${this.blockName}__date-select .b-select__value`)
		this.calendar = this.block.querySelector(`.${this.blockName}__calendar`)
		this.currentDropdown;
	}

	run() {
		this.onSelectCity();
		this.onSelectDate();
		this.onNext();
		this.onPrev();
		this.onClickItem();
	}

	onSelectCity() {
		document.addEventListener('on-select-education-city', e => {
			this.currentCity = e.detail.value
			this.onAction('select');
		})
	}

	onSelectDate() {
		document.addEventListener('on-select-education-date', e => {
			this.currentDate = e.detail.value;
			this.onAction('select');
		})
	}

	onNext() {
		this.next.addEventListener('click', () => {
			this.onAction('next');
		})
	}

	onPrev() {
		this.prev.addEventListener('click', () => {
			this.onAction('prev');
		})
	}

	async onAction(type) {
		const url = this.url + type + '/' + this.currentCity + '/' + this.currentDate + this.pathname;
		const result = await get(url);

		if (result.success) {
			this.fillDateSelect(result.data)
		} else {
			console.error(result.message)
		}
	}

	fillDateSelect(data) {
		this.currentDate = data.currentDate
		this.setSelectDateValue(data.currentDateFormat)
		const dateObj = Object.entries(data.date)
		let count = 0;
		this.dateDropdown.querySelectorAll('.item').forEach(el => {
			el.dataset.value = dateObj[count][0];
			el.dataset.caption = dateObj[count][1];
			el.textContent = dateObj[count][1]
			if (el.classList.contains('selected')) {
				el.classList.remove('selected');
			}
			if (this.currentDate == dateObj[count][0]) {
				el.classList.add('selected')
			}
			++count
		});
		this.replaceCalendarContent(data.calendar);
		this.onClickItem();

	}

	replaceCalendarContent(data) {
		this.calendar.querySelector('.replace-content').remove()
		const fullData = '<div class="replace-content">' + data + '</div>';
		this.calendar.insertAdjacentHTML('afterbegin', fullData);
	}

	setSelectDateValue(value) {
		this.selectDateValue.textContent = value;
	}

	onClickItem() {
		if (window.innerWidth < 769) {
			const items = this.calendar.querySelector('.b-calendar__items');
			const dropdownActiveClass = 'b-calendar__dropdown--active';
			items.addEventListener('click', e => {
				const el = e.target.closest('.b-calendar__item');
				if (this.currentDropdown) {
					this.currentDropdown.classList.remove(dropdownActiveClass);
				}
				if (el.classList.contains('b-calendar__item')) {
					this.currentDropdown = el.querySelector(`.b-calendar__dropdown`);
					if (this.currentDropdown) {
						this.currentDropdown.classList.add(dropdownActiveClass);
						this.currentDropdown.addEventListener('click', onDropdown);
					}
				}
			})
			const onDropdown = (e) => {
				e.stopPropagation();
				e.currentTarget.classList.remove(dropdownActiveClass)
				this.currentDropdown.removeEventListener('click', onDropdown)
			}
		}
	}
}