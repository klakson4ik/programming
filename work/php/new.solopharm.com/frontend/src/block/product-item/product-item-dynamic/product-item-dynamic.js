document.addEventListener('DOMContentLoaded', function() {
	const blockName = 'b-product-item-dynamic';
	let linksItems = document.querySelectorAll(`.${blockName}__trades-item, .b-product-item-description__thumb`);
	let links = [];

	if(sessionStorage.getItem('scrollTop')) {
		if(checkReferer()) {
			window.scrollTo(0, sessionStorage.getItem('scrollTop'));
		} else {
			sessionStorage.removeItem('scrollTop');
		}
	}

	linksItems.forEach(link => {
		links.push(link.getAttribute('href'));
		link.addEventListener('click', function() {
			sessionStorage.setItem('scrollTop', window.scrollY);
		});
	});
});

function checkReferer() {
	const currentUrl = window.location.href;
	const parentUrl = document.referrer;
	let regexp = new RegExp('/products/([a-z-0-9]+)/.*', 'm');

	return currentUrl.match(regexp)[1] == parentUrl.match(regexp)[1] ? true : false;
}