export default class Video {
	load() {
		const videoBlocks = document.querySelectorAll('.b-video');

		videoBlocks.forEach(block => {
			const preloader = block.querySelector('.video-block');
			const videoContent = block.querySelector('.b-video__vk-video iframe') ||
				block.querySelector('.b-video__video video');

			if (!videoContent) {
				console.warn('Video content not found in block:', block);
				return;
			}

			(videoContent.readyState >= 1) ? preloader.style.display = 'none'
				:
				videoContent.addEventListener('loadeddata', () => {
					preloader.style.display = 'none';
				});


			videoContent.addEventListener('load', () => {
				preloader.style.display = 'none';
			});
		});
	}
}