import Calendar from "./component/Calendar";
import Select from "./component/Select";
import { Cookie } from './common/Cookie';
import { loadPageWithAnchor, smoothScroll } from "./component/smoothScroll";
import onChangeEvents from "./pages/news/events";
import { hamburger, burger } from './common/header';

const blockName = 'b-event';

document.addEventListener('DOMContentLoaded', () => {
	const header = document.querySelector('.b-header');
	const block = document.querySelector(`.${blockName}`);
	if (header) {
		hamburger(header);
		burger(header);
		smoothScroll(header)
	}

	const contentBlock = block.querySelector(`.${blockName}__content`);
	if (contentBlock) {
		const calendarBlock = contentBlock.querySelector('.b-calendar');
		if (calendarBlock) {
			new Select({
				block: calendarBlock,
			}).run()

			new Calendar({
				block: calendarBlock
			}).run()

			onChangeEvents(contentBlock);
		}
	}

	const cookie = document.querySelector('.b-cookie');
	if (cookie) new Cookie('b-cookie').onActive();
})
