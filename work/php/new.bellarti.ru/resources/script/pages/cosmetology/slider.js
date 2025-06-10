import createSlider from "../../component/slider"

export function exampleSlider(blockName) {
	createSlider({
		blockName: blockName,
		slidesPerView: 1,
		navigation: true,
		spaceBetween: 15,
		breakpoints: {
			768 : {
				slidesPerView: 2,
				spaceBetween: 30
			}
		}
	})
}

export function expertSlider(blockName) {
	createSlider({
		blockName: blockName,
		slidesPerView: 1,
		navigation: true,
		spaceBetween: 15,
		breakpoints: {
			380 : {
				slidesPerView: 2,
			},
			768 : {
				slidesPerView: 3,
				spaceBetween: 30
			},
			1024 : {
				slidesPerView: 4,
			},

		}
	})
}