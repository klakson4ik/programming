class Dot {
	constructor(x, y, wrapper, text = '1', onMove = (() => {})) {
		this.x = x;
		this.y = y;
		this.text = text;
		this.wrapper = wrapper;
		this.onMove = onMove;
		this.active = false;
		this.wrapperRects = null;

		this.initialX = x;
		this.initialY = y;

		this.dragStart = this.dragStart.bind(this);
		this.drag = this.drag.bind(this);
		this.dragEnd = this.dragEnd.bind(this);

		this.createElement();
	}

	createElement() {
		this.el = document.createElement('span');
		this.el.className = 'dot';
		this.el.style.top = `${this.y}%`;
		this.el.style.left = `${this.x}%`;
		this.el.textContent = this.text;

		this.el.addEventListener('mousedown', this.dragStart);
		window.addEventListener('mousemove', this.drag);
		window.addEventListener('mouseup', this.dragEnd);
	}

	dragStart(e) {
		if (this.wrapperRects === null) {
			this.wrapperRects = this.wrapper.getBoundingClientRect();
		}

		this.active = true;
		this.initialX = parseInt(this.el.style.left||'0')/100 - e.x/this.wrapperRects.width;
		this.initialY = parseInt(this.el.style.top||'0')/100 - e.y/this.wrapperRects.height;
	}

	dragEnd() {
		this.active = false;
	}

	drag(e) {
		if (!this.active || !this.el) {
			return;
		}

		let x = Math.ceil((this.initialX + e.x/this.wrapperRects.width)*100);
		let y = Math.ceil((this.initialY + e.y/this.wrapperRects.height)*100);

		if (x > 100) x = 100;
		if (x < 0) x = 0;

		if (y > 100) y = 100;
		if (y < 0) y = 0;

		this.x = x;
		this.y = y;

		this.el.style.left = this.x + '%';
		this.el.style.top = this.y + '%';
		this.onMove(this);
	}

	remove() {
		this.el.removeEventListener('mousedown', this.dragStart);
		window.removeEventListener('mousemove', this.drag);
		window.removeEventListener('mouseup', this.dragEnd);

		this.el.remove();
	}
}

class Dots {
	constructor(image, onSave, data = null) {
		this.image = image;
		this.onSave = onSave;
		this.data = [];
		this.dots = new Map();

		this.initalData = data;
	}

	appendDotsByData(data) {
		if (!data || !Array.isArray(data)) return;

		data.forEach(item => {
			this.appendDot(item.text, item.pos.x, item.pos.y)
		});
	}

	render() {
		const el = this.createElement();

		this.appendDotsByData(this.initalData);

		return el;
	}

	createElement() {
		const html = `
			<div class="dots-image-wrapper">
					<img class="dots-image" src="${this.image}">
				</div>
				<div class="dots-points">
					<div class="dots-points-container">
						
					</div>
					<div class="dots-points-controll">
						<button class="ui-btn ui-btn-primary append" type="button">Добавить</button>
					</div>
				</div>
				<div class="dots-footer">
					<button class="popup-window-button popup-window-button-accept save" type="button">Сохранить</button>
					<button class="popup-window-button popup-window-button-link popup-window-button-link-cancel remove-all" type="button">Стереть</button>
				</div>
		`;

		const el = document.createElement('div');
		el.classList.add('dots');
		el.innerHTML = html;

		this.el = el;
		this.dotsWrapper = el.querySelector('.dots-image-wrapper');
		this.dotsLabelsWrapper = el.querySelector('.dots-points-container');

		this.setEvents();

		return el;
	}

	setEvents() {
		this.el.addEventListener('click', e => {
			const append = e.target.closest('.append');

			if (append) {
				this.appendDot();
				return;
			}

			const del = e.target.closest('.delete');

			if (del) {
				this.removeDot(parseInt(del.parentElement.dataset.dot));
				return;
			}

			const delAll = e.target.closest('.remove-all');

			if (delAll) {
				this.removeAllDots();
				return;
			}

			const save = e.target.closest('.save');

			if (save) {
				this.save();
			}

			const image = e.target.closest('.dots-image');

			if (image) {
				const x = Math.ceil(e.offsetX / (image.offsetWidth / 100));
				const y = Math.ceil(e.offsetY / (image.offsetHeight / 100));

				this.appendDot('', x, y);
			}
		})
	}

	appendDot(inputText = '', x = 10, y = 10) {
		let id = Math.floor(Math.random() * 1001);
		let n = this.dots.size + 1;

		while (this.dots.has(id)) {
			id = Math.floor(Math.random() * 1001);
		}

		const block = document.createElement('div');
		block.dataset.dot = id;
		block.classList.add('dots-dot');
		block.innerHTML = `
			<label class="dots-dot-label">
				<span>Точка ${n}</span>
				<input class="ui-ctl ui-ctl-textbox ui-ctl-w100" name="dot-desc-${id}" type="text" value="${inputText}">
			</label>
			<button class="ui-btn ui-btn-danger delete" type="button">
				Удалить
			</button>
		`;

		this.dotsLabelsWrapper.append(block);

		const label = block.querySelector('span');

		const dot = new Dot(x, y, this.dotsWrapper, n, (ctx) => {
			label.textContent = `Точка ${n}. x: ${ctx.x}, y: ${ctx.y}`
		});

		this.dots.set(id, {
			block,
			dot,
			input: block.querySelector('input'),
		});

		this.dotsWrapper.append(dot.el);
	}

	removeDot(id) {
		const item = this.dots.get(id);

		item.dot.remove();
		item.block.remove();
		this.dots.delete(id);
	}

	removeAllDots() {
		this.dotsLabelsWrapper.textContent = '';
		this.dots.forEach(item => {
			item.dot.remove();
			item.block.remove();
		});
		this.dots.clear();
	}

	save() {
		this.data = [];

		this.dots.forEach(item => {
			this.data.push({
				text: item.input.value,
				pos: {
					x: item.dot.x,
					y: item.dot.y
				}
			})
		});

		this.onSave(this.data);
	}
}