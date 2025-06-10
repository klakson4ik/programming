export function smoothScroll(header) {
	const topOffset = header.offsetHeight + 20
	document.querySelectorAll('.smooth-scroll').forEach(element => {
		element.addEventListener('click', e => {
			e.stopPropagation()
			const anchor = element.hash;
			if (window.location.href.split('#')[0] != element.href.split('#')[0]) return
			if (!anchor) return;
			e.preventDefault();
			scrollToPosition(anchor, topOffset)
		})
	});
}

export function loadPageWithAnchor(header) {
	const topOffset = header.offsetHeight + 20
	const anchor = window.location.hash;
	if (anchor) {
		window.addEventListener('load', e => {
			e.preventDefault()
			window.scrollTo(0, 0);
			scrollToPosition(anchor, topOffset)
		})
	}

}

export function scrollToPosition(anchor, topOffset = 0) {
	const scrollTarget = document.querySelector(anchor);
	if (scrollTarget) {
		const elementPosition = scrollTarget.getBoundingClientRect().top;
		const offsetPosition = elementPosition - topOffset;

		window.scrollBy({
			top: offsetPosition,
			behavior: 'smooth'
		});
		return true;
	}
	return false;
}