import { Popup } from 'component/models/Popup';

const blockName = 'b-main-img-block';

document.addEventListener('DOMContentLoaded', () => {
	if (document.querySelectorAll('.b-main-img-block__text h1').length > 0) {
		document.querySelector('.b-main-img-block__text h1').style.bottom = 0;
		document.querySelector('.b-main-img-block__text h1').style.opacity = 1;

		document.querySelector('.b-main-img-block p').style.top = '30%';
		document.querySelector('.b-main-img-block p').style.opacity = 1;

		document.querySelector('.b-main-img-block__text h2').style.top = 0;
		document.querySelector('.b-main-img-block__text h2').style.opacity = 1;

		document.querySelector('.b-main-img-block__text div').style.top = 0;
		document.querySelector('.b-main-img-block__text div').style.opacity = 1;

		document.querySelector('.b-main-img-block__text').classList.add('iconSMove');

	}

	const block = document.querySelector(`.${blockName}`);

	if (!block) return false;

	const btnActive = block.querySelector('.b-button[name=youtube]');

	if (!btnActive) return false;
	new Popup().onActive(btnActive);
});
