const blockName = 'b-production-title-img';

function ready() {
	const numberBlocks = document.querySelectorAll(`.${blockName} p span`);

	numberBlocks.forEach(animateNumber);
}

function animateNumber(element) {
	let y = 0;
	const x = parseInt(element.textContent);

	element.textContent = '0';

	switch (true) {
		case x < 50:
			y = 50;
			break;
		case x < 200:
			y = 5;
			break;
		case x < 500:
			y = 2;
			break;
		case x < 2500:
			y = 1;
			break;
		default:
			y = 0.2;
			break;
	}

	for (let i = 0; i < x; i += 1) {
		setTimeout(() => {
			element.textContent = Number(element.textContent) + 1;
		}, y * i);
	}
}

document.addEventListener('DOMContentLoaded', () => {
	ready();
});
