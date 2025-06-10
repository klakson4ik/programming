import { get } from "../../component/ajax";

export default class More {
	constructor(param) {
		this.block = param.block
		this.btn = this.block.querySelector(param.btnClass ? `.${param.btnClass}` : '.more');
		this.cardsClass = param.cardsClass ?? 'cards'
		this.currentPage = 1;
		this.url = '/ajax/pages/'
	}

	onClick() {
		if (!this.btn) return;
		const active = this.btn.dataset.active;
		this.btn.addEventListener('click', async () => {
			const response = await get(this.url + active + '?page=' +(++this.currentPage))
			if (response.success) {
				if (response.data.cards.length > 0) {
					this.addNews(response.data.cards)
				}
				if (!response.data.isMore) {
					this.inactiveBtn()
				}
			} else {
				console.error(response.message);

			}
		})
	}

	addNews(data) {
		const cards = this.block.querySelector(`.${this.cardsClass}`)
		cards.insertAdjacentHTML('beforeEnd', data)
	}

	inactiveBtn() {
		this.btn.closest('div').classList.add('b-content__more--inactive')
	}
}