const blockName = 'b-internship-block-3';
const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (!block) return false;
	block.querySelector(`.${blockName}__btn-form`);
	block.addEventListener('click', () => {
		document.querySelector('.b-internship').classList.add('b-internship--active');
		block.querySelector(`.${blockName}__btn-form`).classList.add(`${blockName}__btn-form--hidden`);
	});
};

document.addEventListener('DOMContentLoaded', init);
