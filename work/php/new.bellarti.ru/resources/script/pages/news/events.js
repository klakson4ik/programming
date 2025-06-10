export default function onChangeEvents(block) {
	document.addEventListener('on-change-calendar-date', e => {
		const events = e.detail.events;
		if (events) {
			const replacement = block.querySelector('.b-cards-event');
			if (!replacement) return
			const insertBlock = replacement.parentNode;
			replacement.remove();
			insertBlock.insertAdjacentHTML('afterbegin', events)
		}
	})
}