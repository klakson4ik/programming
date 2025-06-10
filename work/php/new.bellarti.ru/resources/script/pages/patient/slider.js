import createSlider from "../../component/slider"

export function blogSlider(blockName) {
	createSlider({
		blockName: blockName,
		slidesPerView: 1,
		navigation: true,
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