import {swiperTags} from 'block/product/product-tags-mobile/product-tags-mobile';
import {Product} from 'component/models/Product';
import {FilterMobile} from 'component/models/FilterMobile';

const blockName = 'b-product-filter';

export class Filter {
	constructor(block, mobile = false) {
		const path = window.location.pathname;
		const to = path.search('/products');

		this.mobile = mobile;
		this.blockName = block.className;
		this.urlProduct = `${path.substring(0, to)}/products`;
		this.block = block;
		this.filtersBlock = block.querySelector(`.${this.blockName}__filters`);
		this.additionalFiltersBlock = block.querySelector(`.${this.blockName}__additional-fields`);
		this.btnReset = block.querySelector('.b-button[name="reset"]');
		this.btnFind = block.querySelector('.b-button[name="find"]');
		this.search = block.querySelector(`.${this.blockName}__search`);
		this.filterMobile = new FilterMobile(document.querySelector('.b-product'));
	}

	onDelTag() {
		document.querySelectorAll('.b-product-tags, .b-product-tags-mobile').forEach(el => {
			if (!el) {
				return false;
			} else {
				this.delTag(el);
			}
		});
	}

	delTag(block) {
		block.querySelectorAll('.b-product-tags__del, .b-product-tags-mobile__del').forEach((item) => {
			item.addEventListener('click', async () => {
				const checkbox = this.block.querySelector(`input[name=${item.name}]`);

				if(checkbox) {
					checkbox.checked = false;
				}

				await this.filtersAction();
				this.onDelTag();
			});
		});
	}

	onActive() {
		this.setDropdownContainers();

		window.addEventListener('resize', function () {
			this.setDropdownContainers();
		}.bind(this));

		if (this.mobile) {
			this.mobileActive();
		} else {
			this.deskActive();
		}

		return this;
	}

	mobileActive() {
		this.filtersBlock.querySelectorAll(`.${this.blockName}__item input[data-parent]`).forEach(parent => {
			let parentClass = parent.parentNode.className;
			let label = parent.parentNode.querySelector(`.${parentClass} > label`);

			label.addEventListener('click', function () {

				label.classList.toggle('active');
				label.querySelector('i').classList.toggle('show');

				const tagsContainer = document.querySelector('.b-product-tags');
				const code = parent.getAttribute('name');

				if(label.classList.contains('active')) {
					const text = label.querySelector('span').innerHTML;
					const tag = this.createParentTag(text, code);

					this.updateTags(tagsContainer, tag);
				} else {
					this.removeTagAndContainer(tagsContainer, code);
				}

				label.parentNode.querySelector(`.${this.blockName}__dropdown-list`)
					.classList.toggle('show');
			}.bind(this));
		});
	}

	deskActive() {
		this.filtersBlock.addEventListener('change', async () => {
			this.filtersAction();
		});
		this.additionalFiltersBlock.addEventListener('change', async () => {
			this.filtersAction();
		});
		this.filtersBlock.querySelectorAll(`.${this.blockName}__item .b-parent-li`).forEach(parent => {

			parent.addEventListener('click', () => {
				parent.classList.toggle('show');

				const tagsContainer = document.querySelector('.b-product-tags');
				const code = parent.dataset.code;

				if(parent.classList.contains('show')) {
					const text = parent.querySelector('.b-parent-li__text').innerHTML;
					const tag = this.createParentTag(text, code);

					this.updateTags(tagsContainer, tag);
				} else {
					this.removeTagAndContainer(tagsContainer, code);
				}

				parent.closest(`.${blockName}__item`)
					.querySelector(`.${blockName}__dropdown-list`).classList
					.toggle('show');
			});
		});
	}

	setDropdownContainers() {
		this.filtersBlock.querySelectorAll(`.${this.blockName}__dropdown-container`).forEach(item => {
			let list = item.querySelector(`.${this.blockName}__dropdown-list`);

			item.style.setProperty('--item-height', list.clientHeight + 1 + 'px');
		});
	}

	isChildsAllChecked(children) {
		let allChecked = true;

		children.forEach(child => {
			if (child.checked == false) {
				allChecked = false;
			}
		});
		return allChecked;
	}

	onFind() {
		this.btnFind.addEventListener('click', () => {
			this.filtersAction();
			document.querySelectorAll('input[name="search"]').forEach(item => {
				item.value = this.search.value;
			});
		});
		return this;
	}

	async filtersAction() {
		const filters = [];
		const boolFilters = [];
		const choiceFilters = this.block.querySelectorAll('input:checked:not([data-parent])');

		document.querySelectorAll('input[type="checkbox"]:not([data-parent])').forEach(element => {
			element.checked = false;
		});

		choiceFilters.forEach((item) => {
			if (
				(this.additionalFiltersBlock && this.additionalFiltersBlock.contains(item))
				||
				item.dataset.mod === 'bool'
			) {
				boolFilters.push(item.name);
			} else {
				filters.push(item.name);
			}

			document.querySelectorAll(`input[name=${item.name}]`).forEach(item => {
				if (item.checked == false) {
					item.checked = true;
				}
			});
		});

		let url = this.createUrl(filters, boolFilters);
		const data = await this.getData(url);
		const prependTags = [...document.querySelectorAll('.b-product-tags__tag--folder')];

		Product.updateData(data, 'b-product__column-right', {
			selector: '.b-product-tags',
			tags: prependTags
		});

		if (this.mobile) {
			swiperTags();
			this.filterMobile.closeFilter();

		}

		history.replaceState(null, null, url);
		this.onDelTag();
	}

	createUrl(filters, boolFilters) {
		let url = this.urlProduct;

		if (filters.length > 0 || boolFilters.length > 0) {
			url += '/filter';

			if (filters.length > 0) {
				url += '/direction-is-';
				filters.forEach((item, index) => {
					if (index > 0) {
						url += '-or-';
					}

					url += item;
				});
			}

			if (boolFilters.length > 0) {
				boolFilters.forEach((item) => {
					url += `/${item}-is-true`;
				});
			}

			url += '/apply';
		}

		const search = new URLSearchParams(window.location.search).get('search');

		url += `${search ? `?search=${search}` : ''}`;

		return url;
	}

	onReset(mobile = false) {
		this.btnReset.addEventListener('click', async () => {
			const url = window.origin + this.urlProduct;
			const data = await this.getData(url);

			if (data) {
				Product.updateData(data, 'b-product__column-right');
				history.pushState(null, null, url);
			}

			document.querySelectorAll('input:checked').forEach((item) => {
				item.checked = false;
			});
			document.querySelectorAll('input[name="search"]').forEach(item => {
				item.value = '';
			});

			if (mobile) {
				new FilterMobile(document.querySelector('.b-product')).closeFilter();
			}

		});

		return this;
	}

	async getData(url) {
		const response = await fetch(url, {
			method: 'GET',
		});

		return await response.text();
	}

	sectionsImitation() {
		const filterItems = document.querySelectorAll('.' + this.blockName + '__item input');

		filterItems.forEach((filterItem) => {
			filterItem.addEventListener('click', () => {
				let checkedInputs = document.querySelectorAll('.' + this.blockName + '__item input:checked');

				checkedInputs.forEach((checkedInput) => {
					if (checkedInput !== filterItem) {
						checkedInput.checked = false;
					}
				});

				this.filtersAction();
			});
		});

		return this;
	}

	createParentTag(tagText, code) {
		const tagClass = 'b-product-tags';
		const li = document.createElement('li');

		li.classList.add(`${tagClass}__tag`, `${tagClass}__tag--folder`);

		const text = document.createElement('span');
		const cross = document.createElement('button');
		const crossIcon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
		const imageRef = document.createElementNS('http://www.w3.org/2000/svg', 'use');

		text.innerHTML = '#' + tagText;

		cross.classList.add(`${tagClass}__del`);
		cross.setAttribute('name', code);

		crossIcon.classList.add('icon', 'icon--close');
		imageRef.setAttribute('href', '/images/icons/Sprite.svg#close');
		crossIcon.appendChild(imageRef);
		cross.appendChild(crossIcon);

		cross.addEventListener('click', function() {
			const filterClass = 'b-product-filter-mobile';
			const name = cross.getAttribute('name');
			const filterBtn = this.filtersBlock.querySelector(`.b-parent-li.show[data-code="${name}"]`);
			const filterBtnMobile = this.block.querySelector(`.${filterClass} input[name="${name}"]`)?.parentNode;

			cross.parentNode.remove();

			if(filterBtn) {
				filterBtn.classList.remove('show');
				
				const dropdown = filterBtn.parentNode.querySelector(`.${this.blockName}__dropdown-list`);

				if(dropdown && dropdown.classList.contains('show')) {
					dropdown.classList.remove('show');
				}
			}

			if(filterBtnMobile) {
				filterBtnMobile.querySelector('label').classList.remove('active');
				filterBtnMobile.querySelector('.b-checkbox-mobile__dropdown-icon').classList.remove('show');
				filterBtnMobile.querySelector(`.${filterClass}__dropdown-list`).classList.remove('show');
			}
		}.bind(this));

		li.appendChild(text);
		li.appendChild(cross);
		return li;
	}

	updateTags(tagsContainer, tag) {
		if(tagsContainer) {
			if(tagsContainer.firstChild) {
				tagsContainer.insertBefore(tag, tagsContainer.firstChild);
			} else {
				tagsContainer.appendChild(tag);
			}
		} else {
			const newTagsContainer = document.createElement('ul');
			const productsListClass = 'b-products-list';
			const productsList = document.querySelector(`.${productsListClass} > div`);

			newTagsContainer.classList.add('b-product-tags');

			newTagsContainer.appendChild(tag);
			productsList.insertBefore(newTagsContainer, productsList.firstChild);
		}
	}

	removeTagAndContainer(tagsContainer, code) {
		tagsContainer.querySelector(`.b-product-tags__del[name="${code}"]`).parentNode.remove();

		if(tagsContainer.childElementCount == 0) {
			tagsContainer.remove();
		} 
	}
}
