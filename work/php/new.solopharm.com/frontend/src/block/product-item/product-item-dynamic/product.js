export class Product {
	static updateData(data, parentName) {
		const parent = document.querySelector(`.${parentName}`);
		const child = parent.querySelector(`.${parentName} > div`);

		child.remove();
		parent.insertAdjacentHTML('afterBegin', data);
	}
}
