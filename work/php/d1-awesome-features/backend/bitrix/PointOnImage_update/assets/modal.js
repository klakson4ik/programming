const lockBody = () => {
	const scrollPosition = window.scrollY;

	document.body.dataset.scrollPosition = scrollPosition;
	document.body.dataset.lock = '1';

	Object.assign(document.body.style, {
		left: 0,
		position: 'fixed',
		top: `-${scrollPosition}px`,
		paddingRight: 'var(--scrollbar-width, 0)'
	});
}

const unlockBody = () => {
	const scrollPosition = parseInt(document.body.dataset.scrollPosition);
	document.body.dataset.lock = '0';

	document.body.removeAttribute('style');

	window.scrollTo({
		left: 0,
		top: scrollPosition,
		behavior: 'instant'
	});
}

class BaseModal {
	constructor(modal, params) {
		this.modal = modal;

		this.modalClass = params.modalClass;
		this.modalContainerClass = params.modalContainerClass;
		this.modalOpenClass = params.modalOpenClass;
		this.closeBtnClass = params.closeBtnClass;
		this.contentClass = params.contentClass;
		this.id = modal?.id || params.id;

		this.modalOpenZIndex = params.zIndex ?? '17';
		this.modalCloseZIndex = `-${params.zIndex}`;

		this.openTimeout = params.openTimeout ?? 100;
		this.closeTimeout = params.closeTimeout ?? 350;

		this.needCreate = params.needCreate ?? false;

		this.onBeforeOpen = params.onBeforeOpen ?? (() => {});
		this.onBeforeClose = params.onBeforeClose ?? (() => {});
		this.onBeforeCreate = params.onBeforeCreate ?? (() => {});
		this.onAfterOpen = params.onAfterOpen ?? (() => {});
		this.onAfterClose = params.onAfterClose ?? (() => {});
		this.onAfterCreate = params.onAfterCreate ?? (() => {});

		this.isOpen = false;
		this.created = !this.needCreate;
		this.currentEvent = null;

		this.crossIcon = `
			<svg width="14" height="15" viewBox="0 0 14 15" fill="none">
				<path d="M1.36719 1.86719L12.632 13.132" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
				<path d="M12.6328 1.86719L1.36796 13.132" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
			</svg>
		`;

		this.close = this.close.bind(this);

		if (this.created) {
			this.setModalElements();
		}

		this.setEvents();
	}

	setModalElements() {
		this.closeBtn = this.modal?.querySelector(`.${this.closeBtnClass}`);
		this.content = this.modal?.querySelector(`.${this.contentClass}`);
	}

	setEvents() {
		if (this.created) {
			this.setModalEvents();
		}

		this.setOtherEvents();
	}

	setModalEvents() {
		this.modal.addEventListener('click', e => {
			this.close(e)
		});

		this.closeBtn.addEventListener('click', e => {
			e.stopPropagation();
			this.close(e)
		});

		this.content.addEventListener('click', e => {
			e.stopPropagation();
		});
	}

	setOtherEvents() {
		document.addEventListener('click', e => {
			if (e.target.closest(`[aria-controls="${this.id}"]`)) {
				if (!this.created) {
					this.create();
				}

				this.open(e);
			}
		});

		document.addEventListener('keyup', e => {
			if (e.code === 'Escape' && this.isOpen) {
				this.close(e);
			}
		})
	}

	open(e = null, callEvents = true) {
		this.currentEvent = e;

		if (callEvents) {
			const prevent = this.onBeforeOpen(this) === false;

			if (prevent) {
				this.currentEvent = null;
				return;
			}
		}

		this.modal.style.zIndex = this.modalOpenZIndex;

		lockBody();

		setTimeout(() => {
			this.modal.classList.add(this.modalOpenClass);
			this.isOpen = true;

			if (callEvents) {
				this.onAfterOpen(this);
			}
		}, this.openTimeout)
	}

	close(e = null, callEvents = true) {
		this.currentEvent = e;

		if (callEvents) {
			this.onBeforeClose(this);
		}

		unlockBody();
		this.modal.classList.remove(this.modalOpenClass);
		this.isOpen = false;

		setTimeout(() => {
			this.modal.style.zIndex = this.modalCloseZIndex;

			if (callEvents) {
				this.onAfterClose(this);
			}
		}, this.closeTimeout)
	}

	create() {
		this.onBeforeCreate(this);

		const modal = document.createElement('div');
		modal.id = this.id;
		modal.classList.add(this.modalClass);
		modal.setAttribute('role', 'dialog');
		modal.setAttribute('aria-modal', 'true');

		modal.innerHTML = `
			<div class="${this.modalContainerClass}">
				<button
					class="${this.closeBtnClass}"
					aria-label="Закрыть"
					type="button"
				>
					${this.crossIcon}
				</button>

				<div class="${this.contentClass}">
				</div>
			</div>
		`;

		document.body.append(modal);
		this.modal = modal;
		this.created = true;

		this.setModalElements();
		this.setModalEvents();
		this.onAfterCreate(this);
	}
}