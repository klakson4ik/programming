const script = document.createElement('script');
let blockName = 'b-product-buy-popup';

script.src = 'https://cdn.uteka.ru/static/widgets/widget.simple.compiled.js?l=' + Date.now();
script.async = true;

document.addEventListener('DOMContentLoaded', function() {
	let block = document.querySelector(`.${blockName}`);
	let button = document.querySelector(`.${blockName}__links-button`);
	let links = block.querySelector(`.${blockName}__links-container`);
	let utekaLink = document.querySelector(`.${blockName}__link--uteka`);
	
	document.head.appendChild(script);

	if(links.childElementCount <= 1) {
		block.classList.add('inactive');
	} else {
		button.addEventListener('click', function() {
			links.classList.toggle('active');
			button.classList.toggle('active');
		});

		document.addEventListener('click', e=> {
			if((e.target != button) && (e.target != links)) {
				links.classList.remove('active');
				button.classList.remove('active');
			}
		});
	}

	if(utekaLink) {
		utekaLink.addEventListener('click', function(e) {
			if(document.readyState !== 'complete') {
				e.preventDefault();
			}
		});
	}
});