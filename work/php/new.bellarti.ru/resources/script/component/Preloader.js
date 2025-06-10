/**
 * Класс Preloader для управления состоянием прелоадера.
 */
export default class Preloader {
	/**
	 * Блокирует форму, добавляя эффект размытия и активируя прелоадер.
	 * 
	 * @param {HTMLElement} node - Элемент формы, который нужно заблокировать.
	 * @param {HTMLElement} preloader - Элемент прелоадера, который нужно активировать.
	 * @param {boolean} - Флаг, на проверку нужды прелодера.
	 */
	static blockForm(node, preloader) {
		node.style.filter = 'blur(5px)';
		preloader.classList.add('b-feedback__preloader-active');
	}
	/**
	* Разблокирует форму, убирая эффект размытия и деактивируя прелоадер.
	* 
	* @param {HTMLElement} node - Элемент формы, который нужно разблокировать.
	* @param {HTMLElement} preloader - Элемент прелоадера, который нужно деактивировать.
	* @param {boolean} - Флаг, на проверку нужды прелодера.
	*/
	static unblockForm(node, preloader) {
		node.style.filter = 'blur(0)';
		preloader.classList.remove('b-feedback__preloader-active');
	}

}