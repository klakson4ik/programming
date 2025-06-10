import { hamburger, burger } from './common/header';
import Carousel from './component/Carousel';
import PagSide from './component/PagSide';
import Select from './component/Select';
import { Cookie } from './common/Cookie';
import { smoothScroll, loadPageWithAnchor } from './component/smoothScroll';
import Calendar from './pages/cosmetology/Calendar';
import { exampleSlider, expertSlider } from './pages/cosmetology/slider';
import { productSlider } from './pages/home/slider';
import { combinedProtocolSlider } from './pages/detail-product/slider';

const blockName = 'b-cosmetology';

document.addEventListener('DOMContentLoaded', () => {

	const block = document.querySelector(`.${blockName}`);
	const header = document.querySelector('.b-header');

	if (header) {
		hamburger(header);
		burger(header);
		smoothScroll(header)
	}

	const pagSideBlock = block.querySelector('.b-pag-side');
	if (pagSideBlock && header) {
		new PagSide({
			block: pagSideBlock
		}).init().onScroll()
	}

	const productBlock = block.querySelector('.b-product');
	if (productBlock) {
		productSlider('b-product');
	}

	const publicationsBlock = block.querySelector('.b-publications');
	if (publicationsBlock) productSlider('b-publications');

	const exampleBlock = block.querySelector('.b-example');
	if (exampleBlock) {
		exampleSlider('b-example');
		new Carousel({
			block: exampleBlock
		}).run()
	}

	const expertBlock = block.querySelector('.b-expert');
	if (expertBlock) {
		expertSlider('b-expert');
	}

	const educationBlock = block.querySelector('.b-education');
	if (educationBlock) {
		new Select({
			block: educationBlock,
		}).run()

		new Calendar({
			block: educationBlock
		}).run()
	}

	const cookie = document.querySelector('.b-cookie');
	if (cookie) new Cookie('b-cookie').onActive();

})


window.addEventListener('load', () => {

	const block = document.querySelector(`.${blockName}`);
	const protocolBlock = block.querySelector('.b-protocol');
	
	const combinedProtocol = block.querySelector('.b-protocol');
	if (combinedProtocol) combinedProtocolSlider('b-protocol');

	if (protocolBlock) new Carousel({ block: protocolBlock }).run();

});