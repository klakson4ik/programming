let dotsInterVal = 0;
let block;
const blockName = 'b-countries-map';

function ready() {
	block = document.querySelector(`.${blockName}`);
	if (!block) return;

	const dots = block.querySelectorAll(`.${blockName}__map-dot`);

	block.addEventListener('mouseover', (e) => {
		const dot = e.target.closest('.b-countries-map__map-dot');

		if (dot) {
			clearDotsInterval();
			activeDots(dots, Array.from(dots).indexOf(dot));
		}
	});

	block.addEventListener('mouseout', (e) => {
		const dot = e.target.closest(`.${blockName}__map-dot`);

		if (dot) {
			clearDotsInterval();
			startDotsInterval();
		}
	});

	activeDots(dots);
	startDotsInterval();
}

function startDotsInterval() {
	const dots = block.querySelectorAll(`.${blockName}__map-dot`);

	dotsInterVal = setInterval(() => {
		activeDots(dots);
	}, 2000);
}

function clearDotsInterval() {
	clearInterval(dotsInterVal);
}

function activeDots(dots, current = -1) {
	const activeDot = block.querySelector(`.${blockName}__map-dot.active`);
	const dotNames = block.querySelectorAll(`.${blockName}__name`);
	let index = activeDot ? Array.from(dots).indexOf(activeDot) + 1 : 0;

	if (index >= dots.length) {
		index = 0;
	}

	if (current >= 0) {
		index = current;
	}

	dots.forEach((dot) => {
		dot.classList.remove('active');
	});

	dotNames.forEach((name) => {
		name.classList.remove('active');
	});

	dots[index].classList.add('active');
	block.querySelector(`.${blockName}__name[data-country-id="${dots[index].dataset.countryId}"]`)
		.classList.add('active');
}

document.addEventListener('DOMContentLoaded', () => {
	ready();
});
