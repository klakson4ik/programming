export const checkPattern = (pattern, str) => new RegExp(pattern).test(str);

export const fetchJson = async (url = '', data = {}) => {
	const response = await fetch(url, {
		method: 'POST', // *GET, POST, PUT, DELETE, etc.
		mode: 'cors', // no-cors, *cors, same-origin
		cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
		credentials: 'same-origin', // include, *same-origin, omit
		headers: {
			'Content-Type': 'application/json',
		},
		referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
		body: JSON.stringify(data), // body data type must match "Content-Type" header
	});

	return response.json(); // parses JSON response into native JavaScript objects
};

export const sliderTextHeight = (blockName, itemsName) => {
	const block = document.querySelector(`.${blockName}`);
	const items = block.querySelectorAll(`.${itemsName}`);
	const heightArray = [];

	items.forEach((element, index) => {
		heightArray.push(element.offsetHeight);

		if (index !== 0) {
			element.style.height = 0;
		}
	});

	const height = Math.max(...heightArray);

	block.style.height = `${height}px`;
};

export const phoneMask = (phone) => {
	phone.addEventListener('input', (e) => {
		const x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);

		e.target.value = !x[2] ? x[1] : `(${x[1]}) ${x[2]}${x[3] ? `-${x[3]}` : ''}${x[4] ? `-${x[4]}` : ''}`;
	});
};
