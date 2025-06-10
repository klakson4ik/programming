const blockName = 'b-main-popup';

document.addEventListener('DOMContentLoaded', function() {
	let block = document.querySelector(`.${blockName}`);

	if(!block) {
		return;
	}

	let cross = block.querySelector(`.${blockName}__cross`);

	document.body.style.overflow = 'hidden';

	if(block.classList.contains('active')) {
		block.addEventListener('click', function(e) {
			if(e.target == block || e.target == cross || cross.contains(e.target)) {
				block.classList.remove('active');
				document.body.style.overflow = '';
				document.cookie = 'closePopup=1';
			}
		});
	}
});