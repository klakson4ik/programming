import createSlider from "../../component/slider"

export function productSlider(blockName, pagination = false) {
	createSlider({
		blockName: blockName,
		slidesPerView: 1,
		navigation: true,
		loop: false,
		pagination: true,
		breakpoints: {
			540: {
				slidesPerView: 2,
				spaceBetween: 20,
			},
			768: {
				slidesPerView: 3,
				spaceBetween: 30,
			}
		}
	})
}

export function publicationsSlider(blockName) {
	return createSlider({
		blockName: blockName,
		slidesPerView: 2.5,
		spaceBetween: 30,
		loop: false,
		freeMode: true,
	})
}

export function imgNearTextSlider(blockName) {
	return createSlider({
		blockName: blockName,
		slidesPerView: 1,
		spaceBetween: 30,
		loop: false,
		pagination: true,
		navigation: true,
	})
}

export function combinedProtocolSlider(blockName) {
	return createSlider({
		blockName: blockName,
		slidesPerView: 1,
		spaceBetween: 30,
		loop: false,
		breakpoints: {
			540: {
				slidesPerView: 2,
				spaceBetween: 20,
			},
			1200: {
				slidesPerView: 3
			}
		}
	})
}