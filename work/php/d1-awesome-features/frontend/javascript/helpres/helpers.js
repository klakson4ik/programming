/**
 * Фиксирует страницу, так что бы нельзя было скролить.
 * @type {() => void}
 * @see unlockBody
 */
export const lockBody = () => {
	const scrollPosition = window.scrollY;

	document.body.dataset.scrollPosition = scrollPosition;
	document.body.dataset.lock = '1';

	Object.assign(document.body.style, {
		left: 0,
		position: 'fixed',
		top: `-${scrollPosition}px`,
		paddingRight: 'var(--scrollbar-width, 0)'
	});
}

/**
 * Убирает фиксирование страницы, сделанное с помощью хелпера lockBody
 * @type {() => void}
 * @see lockBody
 */
export const unlockBody = () => {
	const scrollPosition = parseInt(document.body.dataset.scrollPosition);
	document.body.dataset.lock = '0';

	document.body.removeAttribute('style');

	window.scrollTo({
		left: 0,
		top: scrollPosition,
		behavior: 'instant'
	});
}

/**
 * Получить cookie по имени
 *
 * @param name
 * @returns {string|null}
 * @type {(name: string) => string|null}
 */
export const getCookie = (name) => {
	const matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([$?*|{}\]\\^])/g, '\\$1') + "=([^;]*)"
	));

	return matches ? decodeURIComponent(matches[1]) : null;
}

/**
 * Установить cookie
 *
 * @param data
 * @type {(data: {age: string|int|null|undefined, path: string|null|undefined, name: string, value: string}) => void}
 */
export const setCookie = (data) => {
	if (!data.age) {
		data.age = '2419200'; // 4 недели
	}

	if (!data.path) {
		data.path = '/';
	}

	document.cookie = `${data.name}=${data.value}; max-age=${data.age}; path=${data.path};`;
}

/**
 * Декторатор для отложенного вызова функции полсе последнего вызова,
 * Функция выполняется только после времени, прошедшего с последнего вызова
 *
 * @param callback
 * @param time - время после вызова, через которое функция должна выполниться
 * @returns {(function(...[*]): void)|*}
 */
export const debounce = (callback, time) => {
	let timerID = 0;

	return function (...args) {
		clearTimeout(timerID);
		timerID = setTimeout(() => callback(...args), time);
	}
}

/**
 * Начинает загрузку файла по переаднной ссылке
 *
 * @param  fileUrl
 * @type {(fileUrl: string) => void}
 */
export const downloadFile = (fileUrl) => {
	const a = document.createElement('a');
	a.setAttribute('download', '');
	a.href = fileUrl;
	a.click();
}
