import { hamburger, burger } from './common/header';
import Form from './component/Form';
import { Cookie } from './common/Cookie';
import { loadPageWithAnchor, smoothScroll } from './component/smoothScroll';

document.addEventListener('DOMContentLoaded', () => {
	const header = document.querySelector('.b-header');
	if (header) {
		hamburger(header);
		burger(header);
		smoothScroll(header)
	}

	const formFeedback = document.forms.feedback;
	if (formFeedback) {
		const formInstance = new Form({
			form: formFeedback
		});
		formInstance.withPreloader();
		formInstance.withGrecaptcha();
		formInstance.onSubmit();
	}

	const cookie = document.querySelector('.b-cookie');
	if (cookie) new Cookie('b-cookie').onActive();
});