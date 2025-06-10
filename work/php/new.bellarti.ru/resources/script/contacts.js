import { hamburger, burger } from './common/header';
import Select from './component/Select';
import { Cookie } from './common/Cookie';
import { loadPageWithAnchor, smoothScroll } from './component/smoothScroll';
import PagSide from './component/PagSide';
import Ymap from './component/Ymap';

const blockName = 'b-contacts';

document.addEventListener('DOMContentLoaded', () => {
	const header = document.querySelector('.b-header');
	const block = document.querySelector(`.${blockName}`);
	if (header) {
		hamburger(header);
		burger(header);
		smoothScroll(header)
	}
	// правая пагинация
	const pagSideBlock = document.querySelector('.b-pag-side');
	if (pagSideBlock) {
		new PagSide({
			block: pagSideBlock
		}).init().onScroll()
	}

	// блок Яндекс Карт
	const ymapBlock = block.querySelector('.b-ymap');
	if (ymapBlock) {
		new Select({
			block: ymapBlock,
		}).run()

		const visibleElement = block.querySelector('.b-partners__wrapper');

		new Ymap({
			block: ymapBlock,
			blockName: 'b-ymap'
		}).onVisibleElement(visibleElement).enableBalloonZoom().onSelectCity('on-select-ymap-city');
	}

	const representativesBlock = block.querySelector('.b-representatives');
	if (representativesBlock) {
		new Select({
			block: representativesBlock,
		}).run()
	}

	const humanElement = document.querySelectorAll('.b-representatives__human');
	document.addEventListener('on-select-districts', (e) => {
		const humanId = e.detail.value;

		humanElement.forEach(el => {
			const data = el.dataset.caption.split('|');
			toggleHumanActiveClass(el, data, humanId);
		})
	})

	const cookie = document.querySelector('.b-cookie');
	if (cookie) new Cookie('b-cookie').onActive();


	// Функция для добавления или удаления класса
	function toggleHumanActiveClass(el, data, humanId) {
		data.includes(humanId) ?
			el.classList.add('b-representatives__human-active')
			:
			el.classList.remove('b-representatives__human-active');
	}
})
