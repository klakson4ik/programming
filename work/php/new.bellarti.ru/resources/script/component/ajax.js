export function get(
	url,
	headers = {
		"content-type": "application/json",
	},
	preloader = false,
) {
	return fetch(url, {
		headers: headers
	})
		.then(response => {
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}

			return response.json();
		})
}

export function post(
	url,
	data,
	headers = {},
	preloader = false,
) {
	return fetch(url, {
		headers: headers,
		method: 'POST',
		body: data
	})
		.then(response => {
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}

			return response.json();
		})
}