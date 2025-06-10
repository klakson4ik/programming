window.openTab = function (elem) {
	const activeNow = document.querySelectorAll('.tabHeader.active');

	if (elem.classList.contains('active')) {
		elem.classList.remove('active');
	} else {
		for (let x = 0; x < activeNow.length; x++) {
			activeNow[x].classList.remove('active');
		}

		elem.classList.add('active');
	}
};
