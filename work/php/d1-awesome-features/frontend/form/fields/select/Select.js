export default class Select {
	constructor(form, params = {}) {
		this.form = form;
		this.selectClass = params.selectClass ?? "b-select";
		this.selectListClass = params.selectListClass ?? "b-select__list";
		this.inputClass = params.inputClass ?? "b-select__input";
		this.valueClass = params.valueClass ?? "b-select__value";
		this.dropdownClass = params.dropdownClass ?? "b-select__dropdown";
		this.itemClass = params.itemClass ?? "b-select__item";
		this.event = params.event ?? "click";
		this.selects;
	}

	main() {
		this.selects = this.form.querySelectorAll(`.${this.selectClass}`);
		this.selects.forEach((select) => {
			select.btn = select.querySelector(`.${this.inputClass}`);
			select.dropdown = select.querySelector(`.${this.dropdownClass}`);
			select.list = select.querySelector(`.${this.selectListClass}`);
			select.value = "";

			select.dropdown.style.setProperty(
				"--dropdown-height",
				select.list.offsetHeight + "px",
			);
			this.onClick(select);
			this.onEsc();
			this.onOutside();
		});
	}

	onOutside() {
		document.addEventListener("click", (e) => {
			const selectClosest = e.target.closest(`.${this.selectClass}`);
			if (!selectClosest) {
				this.selects.forEach((select) => {
					if (select.dataset.outsideClickClose === "") return;
					this.close(select);
				});
			} else {
				this.selects.forEach((select) => {
					if (select.dataset.otherClickClose === "") return;
					if (selectClosest.btn.name !== select.btn.name) {
						this.close(select);
					}
				});
			}
		});
	}

	onEsc() {
		document.addEventListener("keydown", (e) => {
			if (e.code === "Escape")
				this.selects.forEach((select) => this.close(select));
		});
	}

	onClick(select) {
		select.btn.addEventListener(this.event, (e) => {
			e.preventDefault();
			this.toggle(select);
			this.onClickItem(select);
		});
	}

	onClickItem(select) {
		select.list.addEventListener("click", (e) => {
			if (e.target.classList.contains(this.itemClass)) {
				if (e.target.hasAttribute("selected")) return;
				this.setValue(select, e.target);
				this.clearSelected(select);
				e.target.setAttribute("selected", "selected");
				this.close(select);

				this.sendEvent(select, e.target);
			}
		});
	}

	sendEvent(select, item) {
		if (select.dataset.event) {
			document.dispatchEvent(
				new CustomEvent("on-select-" + select.dataset.event, {
					detail: {
						value: item.value,
						caption: item.outerText,
					},
				}),
			);
		}
	}

	setValue(select, item) {
		this.form[select.btn.name].value = item.value;
		select.querySelector(`.${this.valueClass}`).textContent =
			item.outerText;
	}

	clearSelected(select) {
		select.list
			.querySelector(`.${this.itemClass}[selected='selected']`)
			?.removeAttribute("selected");
	}

	toggle(select) {
		select.classList.toggle("hidden");
		const expand = select.btn.getAttribute("aria-expanded");
		select.btn.setAttribute(
			"aria-expanded",
			expand === "false" || expand === null ? true : false,
		);
	}

	open(select) {
		select.classList.remove("hidden");
		select.btn.setAttribute("aria-expanded", true);
	}

	close(select) {
		select.classList.add("hidden");
		select.btn.setAttribute("aria-expanded", false);
	}

	static beforeResponse(form, formData) {
		form.querySelectorAll(`button[type="select"]`).forEach((el) => {
			formData.set(el.name, el.value);
		});
	}
}
