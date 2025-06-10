const blockName = 'b-file';

class File {
	constructor(block) {
		this.input = block.querySelector(`.${blockName}__input`);
		this.text = block.querySelector(`.${blockName}__text`);
		this.holdText = this.text.textContent;
		this.error = block.querySelector(`.${blockName}__error`);
		this.delete = block.querySelector(`.${blockName}__delete`);
		this.errorActiveClass = `${blockName}__error--active`;
		this.deleteActiveClass = `${blockName}__delete--active`;
		this.fileSize = 1024 * 1024 * block.querySelector(`.${blockName}__size`).dataset.size;
		this.fileformats = block.querySelector(`.${blockName}__format`).dataset.format.split(',');
	}

	upload() {
		this.input.addEventListener('change', e => {
			const file = e.currentTarget.files[0];

			if (this.fileSize < file.size || !this.fileformats.includes(file.name.split('.').pop())) {
				this.input.value = '';
				this.error.classList.add(this.errorActiveClass);
			} else {
				this.text.textContent = file.name;
				this.error.classList.remove(this.errorActiveClass);
				this.delete.classList.add(this.deleteActiveClass);
				this.onClear();
			}
		});
	}

	onClear() {
		this.delete.addEventListener('click', e => {
			e.preventDefault();
			this.input.value = '';
			this.delete.classList.remove(this.deleteActiveClass);
			this.error.classList.remove(this.errorActiveClass);
			this.text.textContent = this.holdText;
		});
	}
}

const init = () => {
	const block = document.querySelector(`.${blockName}`);

	if (block) {
		new File(block).upload();
	}
};

document.addEventListener('DOMContentLoaded', init);