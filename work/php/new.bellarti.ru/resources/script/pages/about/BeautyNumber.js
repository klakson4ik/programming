'use strict';

/**
 * @description Функция для анимации изменения числа в блоке "Solopharm сегодня". При первой отрисовке ставятся правильные значения(отрисовываются на php), потом с 0 до правильного значения делается тут
 * 
 * @param {number} duration - время анимации в миллисекундах (по умолчанию 2000 мс)
 */
export function BeautyNumber(duration = 2000) {
	const items = document.querySelectorAll('.b-more-info__item-number');

	items.forEach(item => {
		let targetNumber = +item.dataset.number.replace('>', '').trim();
		const isGreaterThan = item.dataset.number.startsWith('>');

		animate(0, targetNumber, item, isGreaterThan, duration);
	});

	/**
 * @description Функция для анимации изменения числа.
 * @param {number} currentNumber - текущее значение числа (начинается с 0)
 * @param {number} targetNumber - целевое значение числа
 * @param {HTMLElement} item - элемент, в котором отображается число
 * @param {boolean} isGreaterThan - флаг, указывающий, нужно ли добавлять '>' перед числом
 * @param {number} duration - время анимации в миллисекундах
 * @param {number} startTime - время начала анимации
 */
	function animate(currentNumber, targetNumber, item, isGreaterThan, duration, startTime = null) {
		if (startTime === null) startTime = performance.now();
		const elapsedTime = performance.now() - startTime;
		const progress = Math.min(elapsedTime / duration, 1);

		const easedProgress = progress * (2 - progress);

		const increment = Math.floor(easedProgress * targetNumber);

		item.textContent = isGreaterThan ? '>' + increment : increment;

		if (progress < 1) {
			requestAnimationFrame(() => animate(increment, targetNumber, item, isGreaterThan, duration, startTime));
		} else {
			item.textContent = isGreaterThan ? '>' + targetNumber : targetNumber;
		}
	}
}