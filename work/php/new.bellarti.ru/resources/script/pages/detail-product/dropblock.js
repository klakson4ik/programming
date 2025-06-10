const toggleDetail = (detailContent, detailHeader) => {
	if (detailContent.classList.contains('open')) {
		detailContent.style.maxHeight = '0';
		detailContent.classList.remove('open');
		detailHeader.querySelector('svg').style.transform = 'rotate(0deg)';
	} else {
		detailContent.style.maxHeight = detailContent.scrollHeight + "px";
		detailHeader.querySelector('svg').style.transform = 'rotate(-90deg)';
		detailContent.classList.add('open');
	}
};

const handleClick = (e) => {
	const detailHeader = e.target.closest('.b-detail__detail');

	if (detailHeader) {
		const detailContent = detailHeader.nextElementSibling;
		if (detailContent && detailContent.classList.contains('b-detail__detail-content')) {
			toggleDetail(detailContent, detailHeader);
		}
	}
};

export const initDetailToggle = (parentSelector) => {
	const parent = document.querySelector(parentSelector);
	parent.addEventListener('click', handleClick);
};
