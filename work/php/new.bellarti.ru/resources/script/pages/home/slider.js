import createSlider from "../../component/slider"

export function mainSlider(blockName) {
	createSlider({
		blockName: blockName,
		pagination: true,
		navigation: true
	})
}

export function productSlider(blockName) {
	createSlider({
		blockName: blockName,
		slidesPerView: 1,
		navigation: true,
		pagination: true,
		spaceBetween: 30,
		breakpoints: {
			540 : {
				slidesPerView: 2,
				spaceBetween: 20,
			},
			1024 : {
				slidesPerView: 3
			}
		}
	})
}