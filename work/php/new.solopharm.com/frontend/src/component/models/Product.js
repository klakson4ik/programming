export class Product {
	static updateData(data, parentName, prependTags = {}) {
		const parent = document.querySelector(`.${parentName}`);
		const child = parent.querySelector(`.${parentName} > div`);
		let dataHtml = document.createElement('div');

		dataHtml.innerHTML = data;

		const newParent = dataHtml.querySelector(`.${parentName}`);
		const newChild = newParent.querySelector(`.${parentName} > div`);

		if(prependTags.selector && prependTags.tags.length > 0) {
			const container = newChild.querySelector(prependTags.selector);
			const firstChild = container.firstChild;

			if(firstChild) {
				prependTags.tags.forEach(tag => {
					container.insertBefore(tag, firstChild);
				});
			} else {
				container.append(...prependTags.tags);
			}
		}

		child.remove();
		parent.appendChild(newChild);

		let event = new Event('updateSliders');

		parent.dispatchEvent(event);
	}
}