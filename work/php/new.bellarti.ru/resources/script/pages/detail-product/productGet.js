'use strict';

import Video from '../../component/Video';

const dataAttrId = (document.querySelector('.b-videoInstructions')?.dataset?.id)?.split(',') ?? false;
const videoBlock = document.querySelector('.b-videoInstructions__wrapper');
const addBtn = document.querySelector('.b-videoInstructions__link') ?? false;
const baseUrl = '/products/videos';
const fetchedIds = [];
const videoComponent = new Video();

if (dataAttrId) {
	dataAttrId.forEach(element => {
		fetchedIds.push(element);
	});
}

const productGet = () => {
	if (dataAttrId && addBtn) {

		addBtn.addEventListener('click', function (e) {
			e.preventDefault();

			let url = baseUrl;

			if (fetchedIds.length > 0) {
				const fetchedIdsString = fetchedIds.join(',');
				url += `?ids=${(fetchedIdsString)}`;
			}

			fetch(url, {
				method: 'GET',
				headers: {
					'Content-Type': 'application/json',
				}
			})
				.then(response => {
					if (!response.ok) {
						throw new Error('Network response was not ok');
					}

					return response.json();
				})
				.then(data => {
					if (!data['success']) {
						addBtn.remove();
						videoBlock.insertAdjacentHTML('beforeend', data['html']);
						videoComponent.load();

						return;
					}
					videoBlock.insertAdjacentHTML('beforeend', data['html']);

					data['video'].forEach(product => {
						fetchedIds.push(product.id);
					});
					videoComponent.load();
				})
				.catch(error => {
					console.error('There was a problem with the fetch operation:', error);
				});
		});
	}
};

export { productGet };
