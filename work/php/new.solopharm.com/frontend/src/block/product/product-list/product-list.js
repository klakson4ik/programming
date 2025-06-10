import { Swiper } from 'swiper/bundle';

const blockName = 'b-product-list-item';

document.addEventListener('DOMContentLoaded', function() {
	setSliders();

	document.querySelector('.b-product__column-right').addEventListener('updateSliders', function() {
		setSliders();
	});

	function setSliders() {
		document.querySelectorAll(`.${blockName}`).forEach(item => {
			let code = item.getAttribute('data-code');
	
			createSlider(code);
		});
	}

	function createSlider(code) {
		new Swiper(`.${blockName}[data-code="${code}"] .${blockName}__img`, {
			wrapperClass: `${blockName}__pics-wrapper`,
			slideClass: `${blockName}__trade-link`,
			spaceBetween: 20,
			pagination: {
				el: `.${blockName}[data-code="${code}"] .${blockName}__pagination`,
				bulletClass: `${blockName}__bullet`,
				bulletActiveClass: `${blockName}__bullet--active`,
				currentClass: `${blockName}__bullet--current`,
				lockClass: `${blockName}__pagination--deactive`,
				clickable: true,
				dynamicBullets: true,
				dynamicMainBullets: 5
			},
			navigation: {
				prevEl: `.${blockName}[data-code="${code}"] .${blockName}__pic-controller--prev`,
				nextEl: `.${blockName}[data-code="${code}"] .${blockName}__pic-controller--next`,
				disabledClass: `${blockName}__pic-controller--deactive`,
				lockClass: `${blockName}__pic-controller--locked`
			},
			on: {
				afterInit: function() {
					let pagination = document.querySelector(`.${blockName}__pagination`);

					if(pagination.childElementCount < 5) {
						pagination.classList.add('centered');
					}
				}
			}
		});
	}
});