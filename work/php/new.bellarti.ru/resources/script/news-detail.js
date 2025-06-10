import { loadPageWithAnchor, smoothScroll } from "./component/smoothScroll";
import { productSlider, imgNearTextSlider } from './pages/detail-product/slider';
import { blogSlider } from './pages/patient/slider';
import { Cookie } from './common/Cookie';
import { hamburger, burger } from './common/header';
import Select from './component/Select';
import Ymap from './component/Ymap';

document.addEventListener('DOMContentLoaded', () => {
	const header = document.querySelector('.b-header');
	const main = document.querySelector('main');

	if (header) {
		hamburger(header);
		burger(header);
		smoothScroll(header)
	}

	const productBlock = main.querySelector('.b-product');
	if (productBlock) productSlider('b-product');

	const blogBlock = main.querySelector('.b-blog');
	if (blogBlock) blogSlider('b-blog');

	const sliderNearTextBlock = main.querySelector('.b-text');
	if (sliderNearTextBlock) imgNearTextSlider('b-text');


	const ymapBlock = main.querySelector('.b-ymap');
	if (ymapBlock) {
		new Select({
			block: ymapBlock,
		}).run()

		const visibleElement = main.querySelector('.b-news-detail__product');

		new Ymap({
			block: ymapBlock,
			blockName: 'b-ymap'
		}).onVisibleElement(visibleElement).enableBalloonZoom().onSelectCity('on-select-ymap-city')
	}

	const cookie = document.querySelector('.b-cookie');
	if (cookie) new Cookie('b-cookie').onActive();
})
