const blockName = 'b-iblock-element-with-info'

const addRowWithInfo = (tableID, count, prop) => {
	const block = document.querySelector('#' + tableID);
	if (block) {
		const list = block.querySelector(`.${blockName}__list`);
		const elem = list.querySelector(`.${blockName}__elem`);
		if (elem) {
			const newRow = elem.cloneNode(true);
			const nCount = list.childNodes.length - count;

			let input = newRow.querySelector('input[type="text"]')
			input.setAttribute('id', prop + '[n' + nCount + ']')
			input.setAttribute('name', prop + '[n' + nCount + ']')
			input.value = ''
			let span = newRow.querySelector('span');
			span.setAttribute('id', 'sp_' + tableID + '_n' + nCount)
			span.textContent = ''
			let btn = newRow.querySelector('input[type="button"]')
			let oldOnclick = btn.getAttribute('onclick');
			newOnclick = oldOnclick.replace(/&k=n?\d+&/i, '&k=n' + nCount + '&');
			btn.setAttribute('onclick', newOnclick)
			list.append(newRow)
		}
	}
}

const initIblockElementWithInfo = () => {
	const blocks = document.querySelectorAll(`.${blockName}__container`);
	if (blocks.length > 0) {
		blocks.forEach(block => {
			const list = block.querySelector(`.${blockName}__list`)
			list.addEventListener('change', async e => {
				if (e.target.tagName === 'INPUT') {
					const url = '/local/lib/Bitrix/PropertyFields/IBlockElementWithInfo/ajax.php'
					data = {
						itemId: e.target.value,
						iblockId: block.dataset.iblockId,
						props: block.dataset.props,
						delimiter: block.dataset.delimiter
					}
					let result = await post(url, data)
					if (result.success) {
						e.target.closest(`.${blockName}__elem`).querySelector('span').textContent = result.data.text
					} else {
						console.error(result)
					}
				}
			})
		})
	}
}

const post = (url, data) => {
	return fetch(url, {
		method: "POST",
		headers: {
			"Content-Type": "application/json;charset=utf-8",
			"Accept": "application/json"
		},
		body: JSON.stringify(data),
	}).then((response) => response.json());
}
document.addEventListener('DOMContentLoaded', initIblockElementWithInfo)