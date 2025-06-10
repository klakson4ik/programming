import { offScroll, onScroll } from "./helpers";

export default class Modal {
	static open(id, dialog = false) {
		!dialog
			? document.getElementById(id).showModal()
			: dialog.showModal()
		offScroll()
		this.onClickOut(id, dialog);
		this.onClose(id, dialog);
	}

	static close(id, dialog = false) {
		!dialog
			? document.getElementById(id).close()
			: dialog.close()
		onScroll();
	}

	static onClose(id, dialog = false, button = false) {
		!dialog && (dialog = document.getElementById(id));
		(button || dialog.querySelector('.close'))
			.addEventListener('click', () => {
				this.close(id, dialog);
			});		
	}

	static onClickOut(id, dialog = false,) {
		!dialog && (dialog = document.getElementById(id));
		dialog.addEventListener('click', e => {
			if (e.target === e.currentTarget) {
				this.close(id, dialog);
			}
		})
	}

	static onClick(id, button, dialog = false) {
		dialog = document.getElementById(id);
		button.addEventListener('click', () => {
			this.open(id, dialog)
		})
	}

	static addContent(id, content) {
		const dialog = document.getElementById(id)
		if (dialog) {
			dialog.querySelector('.addable').textContent = content
		}
	}
}