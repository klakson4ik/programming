export function contentReplace(data, block = false, replacement = 'replacement') {
	const containerBlock = !block
		? document.querySelector('.replace-container')
		: block
	if(!containerBlock){
		console.error(`Блока ${containerClass} не существует`);
		return;
	}
	remove(containerBlock, replacement)
	const fullData = `<div class="${replacement}">` + data + '</div>';
	containerBlock.insertAdjacentHTML('afterbegin', fullData)
}

export function contentRemove(block = false, replacement = 'replacement') {
	const containerBlock = !block
		? document.querySelector('.replace-container')
		: block
	if(!containerBlock){
		console.error(`Блока ${containerClass} не существует`);
		return;
	}
	remove(containerBlock, replacement)
}

function remove(block, replacement) {
	const replacementBLock = block.querySelector(`.${replacement}`)
	if(replacementBLock) replacementBLock.remove()
}