export default function onChangeEvents(block) {
	document.addEventListener('on-change-calendar-date', e => {
		const events = e.detail.events;
		const forDetail = e.detail.forDetail != undefined;

		if (events && forDetail) {
			const replacement = block.querySelector('.b-other-events .one-blog__wrapper');

			if (!replacement) return
			const insertBlock = block.querySelector('.b-other-events');
			replacement.remove();
			insertBlock.insertAdjacentHTML('beforeend', events)
		}
	})
}