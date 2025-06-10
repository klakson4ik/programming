export function dropdownSetSize(el, padding = false) {
	el.dropdownHeight = el.dropdown.offsetHeight + 'px';
	el.dropdown.style.height = 0;

	if (padding) {
		const style = getComputedStyle(el.dropdown);
		el.dropdownPadding = {
			top: style.paddingTop,
			right: style.paddingRight,
			bottom: style.paddingBottom,
			left: style.paddingLeft
		};
		el.dropdown.style.padding = 0;
	}

	return el;
}

export function dropdownAction(el, padding = false) {
	if (el.dropdown.style.height !== el.dropdownHeight) {
		if (padding) {
			el.dropdown.style = {
				paddingTop: el.dropdownPadding.top,
				paddingBottom: el.dropdownPadding.bottom,
				paddingLeft: el.dropdownPadding.left,
				paddingRight: el.dropdownPadding.right,
			}
		}
		el.dropdown.style.height = el.dropdownHeight;
	} else {
		dropdownClose(el, padding)
	}
}

export function dropdownClose(el, padding = false) {
	el.dropdown.style.height = 0;
	if (padding) {
		el.dropdown.style.padding = 0;
	}
}