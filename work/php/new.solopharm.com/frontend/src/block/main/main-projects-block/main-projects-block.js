window.swipeProj1 = function (id) {
	const elem = document.getElementById(`right-p-${id}`);
	const elemH = document.getElementById(`left-p-${id}`);

	elem.style.left = '0%';
	elem.style.opacity = '1';
	elem.style.zIndex = '2';

	elemH.style.opacity = '0';
	elemH.style.zIndex = '0';
	elemH.style.left = '-26%';
};

window.swipeProj2 = function (id) {
	const elemH = document.getElementById(`right-p-${id}`);
	const elem = document.getElementById(`left-p-${id}`);

	elem.style.left = '0%';
	elem.style.opacity = '1';
	elem.style.zIndex = '2';
	elemH.style.opacity = '0';
	elemH.style.zIndex = '0';
	elemH.style.left = '26%';
	document.querySelector(`#right-p-${id} .text-block`).style.opacity = '1';
};
