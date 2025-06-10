import { get } from "./ajax";
import { contentRemove, contentReplace } from "./content";

/* global ymaps */
export default class Ymap {
	constructor(params) {
		this.block = params.block
		this.id = params.id ?? 'ymap';
		this.coords = [55.755864, 37.617698];
		this.zoom = 3;
		this.urlList = '/ajax/clinics';
		this.urlShow = '/ajax/clinic/';
		this.urlCity = '/ajax/city/';
		this.list;
		this.balloonZoom = false;
		this.pathname = window.location.pathname;
	}

	render() {
		ymaps.ready(() => {
			this.map = new ymaps.Map(
				"ymap",
				{
					center: this.coords,
					zoom: this.zoom,
					controls: ["zoomControl"],
				},
				{
					maxZoom: 20,
					minZoom: 3,
				},
			);

			this.setMarkers();
			this.map.behaviors.disable('scrollZoom')
		});
	}

	setCoords(coords) {
		this.coords = coords
		return this
	}

	setZoom(zoom) {
		this.zoom = zoom;
		return this
	}

	enableBalloonZoom() {
		this.balloonZoom = true;
		return this
	}

	onVisibleElement(element) {
		const observer = new IntersectionObserver(
			async () => {
				if (this.pathname.startsWith('/news/') || this.pathname.startsWith('/blogs/')) this.pathname = '/contacts';
				const response = await get(this.urlList + this.pathname);
				if (response.success) {
					this.list = response.data
				}
				if (this.list.length > 0) {
					this.render()
				}
				observer.disconnect()
			}, {
			threshold: 0.25,
		});
		observer.observe(element)
		return this
	}

	getMarker(id, coords) {
		const mark = new ymaps.Placemark(coords, {}, {
			iconLayout: 'default#image',
			iconImageHref: '/images/icons/common/marker.svg',
			iconImageSize: [45, 59],
			iconImageOffset: [-25, -59],
		})

		mark.storeId = id;
		return mark
	}

	getMarkers() {
		let markers = [];
		for (const [, value] of Object.entries(this.list)) {
			if (value.coords) {
				markers.push(
					this.getMarker(value.id, this.getTrueCoords(value.coords)))
			}
		}
		return markers
	}

	getCluster() {
		let clusterer = new ymaps.Clusterer({
			preset: "islands#blackClusterIcons",
			hasHint: false,
			maxZoom: 14,
			minClusterSize: 2,
			showInAlphabeticalOrder: false,
			hideIconOnBalloonOpen: false,
			openHintOnHover: false,
			clusterOpenBalloonOnClick: false,
			hasBalloon: false
		});

		clusterer.options.set({
			gridSize: 80,
		});
		return clusterer;
	}

	async setMarkers() {
		let clusterer = this.getCluster();
		clusterer.add(this.getMarkers());
		this.map.geoObjects.add(clusterer);
		this.onClickObject(clusterer);
	}

	onClickObject(clusterer) {
		clusterer.events.add("click", async (e) => {
			const object = e.get("target");
			if (object.options.getName() !== "cluster") {
				const response = await get(this.urlShow + object.storeId)
				if (this.balloonZoom) {
					this.setMapCenter(object.geometry.getCoordinates(), 17)
				}
				response.success
					? this.renderBallon(response.data)
					: console.error(response.message)
			}
		}, false);
	}

	onSelectCity(event) {
		document.addEventListener(event, async (e) => {
			contentRemove()
			if (e.detail.value == 999) {
				this.setMapCenter(this.coords, this.zoom)
				return;
			}

			if (this.pathname.startsWith('/news/') || this.pathname.startsWith('/blogs/')) this.pathname = '/contacts';
			const response = await get(this.urlCity + e.detail.value + this.pathname);

			if (response.success) {
				const city = response.data.city
				const zoom = city.zoom || 11;

				if (city.coords) {
					this.setMapCenter(city.coords, zoom, true)
						.then(() => {
							if (response.data.clinics.length > 0) {
								contentReplace(response.data.clinics)
							}
						})
					return
				}
			} else {
				console.error(response.message)
			}
			this.setMapCenter(this.coords, this.zoom)
		})
	}

	renderBallon(content) {
		const balloonContainer = this.block.querySelector('.balloon-container');
		const balloon = balloonContainer.querySelector('.b-balloon');
		if (balloon) balloon.remove();
		balloonContainer.insertAdjacentHTML("afterbegin", content);
		balloonContainer.classList.add('balloon-container--active');
		balloonContainer.querySelector('.b-balloon__close').addEventListener('click', () => balloonContainer.classList.remove('balloon-container--active'))
	}

	getTrueCoords(value) {
		return value.split(',').map(el => {
			return el.trim()
		})
	}

	setMapCenter(coords, zoom, trueCoords = false) {
		if (trueCoords) {
			coords = this.getTrueCoords(coords)
		}
		return this.map.setCenter(coords, zoom, {
			duration: 800,
		});
	}

}