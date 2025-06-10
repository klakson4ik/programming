const blockName = 'b-social-share-btn';
const init = () => {
	const share = document.querySelectorAll(`.${blockName}`);

	if (share) {
		share.forEach((item) => {
			item.addEventListener('click', () => {
				item.querySelector(`.${blockName}__socials`).classList.toggle(`${blockName}__socials--active`);
			});
		});
	}
};

document.addEventListener('DOMContentLoaded', init);
