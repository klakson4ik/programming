function init(block) {
	const modalId = block.dataset.modalId;
	const flagInput = block.querySelector('input[data-flag="1"]');
	const fileInput = block.querySelector('input[data-file="1"]');
	const valueInput = block.querySelector('[data-value="1"]');
	const imageIdInput = block.querySelector('[data-image-id="1"]');
	const image = block.querySelector('[data-image="1"]');
	const removeButton = block.querySelector('[data-remove-img="1"]');
	let value = [];

	if (valueInput.value.length) {
		try {
			value = JSON.parse(valueInput.value);
		} catch (e) {}
	}

	const modalClassName = 'b-modal';
	let modal = null;

	const onSave = (data) => {
		valueInput.value = JSON.stringify(data);

		modal.close();
	}

	const dots = new Dots(image.src, onSave, value);

	modal = new BaseModal(null, {
		modalClass: modalClassName,
		modalContainerClass: `${modalClassName}__container`,
		modalOpenClass: `${modalClassName}--open`,
		closeBtnClass: `${modalClassName}__close`,
		contentClass: `${modalClassName}__content`,
		needCreate: true,
		zIndex: 10000,
		id: modalId,
		onAfterCreate: (ctx) => {
			ctx.content.append(dots.render());
		},
	});

	fileInput.addEventListener('change', () => {
		if (modal.created) {
			dots.removeAllDots();
		}

		flagInput.value = 'Y';
		valueInput.value = '';
		image.src = '';
		removeButton.remove();
	}, {once: true});

	if (removeButton) {
		removeButton.addEventListener('click', () => {
			if (modal.created) {
				dots.removeAllDots();
			}

			imageIdInput.value = '0';
			valueInput.value = '';
			image.src = '';
			removeButton.remove();
		})
	}
}

window.addEventListener('load', () => {
	document.querySelectorAll('.dots-field').forEach(block => {
		init(block);
	});
});

