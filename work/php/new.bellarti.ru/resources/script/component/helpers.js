export function offScroll() {
	document.body.classList.add('c-off-scroll')
}

export function onScroll() {
	document.body.classList.remove('c-off-scroll')
}

export function toggleScroll() {
	document.body.classList.toggle('c-off-scroll')
}