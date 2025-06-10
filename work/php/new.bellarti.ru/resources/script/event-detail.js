import { hamburger, burger } from './common/header';
import Calendar from "./component/Calendar";
import { Cookie } from './common/Cookie';
import Select from "./component/Select";
import onChangeEvents from "./pages/event-detail/events";
import { loadPageWithAnchor, smoothScroll } from './component/smoothScroll';

document.addEventListener('DOMContentLoaded', () => {
	const main = document.querySelector('main');
	const header = document.querySelector('.b-header');
	if (header) {
		hamburger(header);
		burger(header);
		smoothScroll(header)
	}


	const contentBlock = main.querySelector('.b-content-event__column');
	if (contentBlock) {
		const calendarBlock = main.querySelector('.b-calendar');
		if (calendarBlock) {
			new Select({
				block: calendarBlock,
			}).run()

			const calendar = new Calendar({
				block: calendarBlock,
				url: '/ajax/calendar-detail/'
			});
			calendar.run();

			onChangeEvents(contentBlock);
		}
	}

	const cookie = document.querySelector('.b-cookie');
	if (cookie) new Cookie('b-cookie').onActive();
});