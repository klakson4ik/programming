import * as THREE from 'three';

import WebGPU from 'three/addons/capabilities/WebGPU.js';
import WebGL from 'three/addons/capabilities/WebGL.js';

import WebGPURenderer from 'three/addons/renderers/webgpu/WebGPURenderer.js';

import { RGBELoader } from 'three/addons/loaders/RGBELoader.js';

import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

//Основные переменные
let camera, scene, renderer;

//Источники света
let pLight;
let pos = 0;
let dir = true;

init();
render();

function init() {

	//Обработчик ошибок
	if (WebGPU.isAvailable() === false && WebGL.isWebGL2Available() === false) {

		document.body.appendChild(WebGPU.getErrorMessage());

		throw new Error('No WebGPU or WebGL2 support');

	}

	//Элемент в котором отображается канвас
	const container = document.querySelector(".b-test3d");
	document.body.appendChild(container);

	//Камера - радиус обзора в углах, соотношение сторон, хз, хз
	camera = new THREE.PerspectiveCamera(45, container.offsetWidth / container.offsetHeight, 0.25, 20);
	//Коложение камеры
	camera.position.set(0.19, 2, 9.5);

	//Создание сцены
	scene = new THREE.Scene();

	//Наполнение сцены
	new RGBELoader()
		.setPath('/')
		.load('royal_esplanade_1k.hdr', function (texture) {

			texture.mapping = THREE.EquirectangularReflectionMapping;
			//texture.minFilter = THREE.LinearMipmapLinearFilter;
			//texture.generateMipmaps = true;

			//Фон сцены
			//scene.background = texture;
			//ХЗ
			scene.environment = texture;

			

			//Свет
			pLight = new THREE.AmbientLight(0xFFFFFF, 1);
			pLight.position.set(0, 5, 0);
			scene.add(pLight);


			//Кубик 
			const geometry = new THREE.BoxGeometry( 1, 1, 1 );
			const material = new THREE.MeshBasicMaterial( { color: 0xff0000 } );
			const cube = new THREE.Mesh( geometry, material );
			cube.position.set(0,2,0)
			scene.add( cube );

			const material2 = new THREE.MeshBasicMaterial( { color: 0x0ff000 } );
			const cube2 = new THREE.Mesh( geometry, material2 );
			cube2.position.set(2,0,0)
			scene.add( cube2 );


			// pLight2 = new THREE.PointLight(0xFF0000, 30);
			// pLight2.position.set(2, 2, 0);
			// scene.add(pLight2);


			//Хелпер света
			// const helper = new THREE.PointLightHelper(pLight2);
			// scene.add(helper);

			render();

			

			// Загрузка модели
			const loader = new GLTFLoader().setPath('/');
			loader.load('1.glb', function (gltf) {
				//Позиционирование и добавленние на сцену
				gltf.scene.position.set(0, -2.5, 0);
				// gltf.scene.rotation.y = 1.5;
				// gltf.scene.rotation.x = 1;
				// gltf.scene.rotation.z = 1.5;

				gltf.scene.scale.set(0.3,0.3,0.3);

				scene.add(gltf.scene);

				render();

			});


			// Клик по объекту
			//Массив кликабельных объектов 
			let objects = [];
			objects[0] = cube;
			objects[1] = cube2;
			

			// создаём вспомогательные объекты для поиска щелчка
			let raycaster = new THREE.Raycaster();
			let mouse = new THREE.Vector2();
		
			document.querySelector(".b-test3d").addEventListener("click", function () {
				// задаём размер игрового бокса
				const ww = container.offsetWidth;
				const hh = container.offsetHeight;
		
				// выводим на экран то, что видит камера
				renderer.render(scene, camera);
		
				// получить позицию мышки относительно игрового бокса
				const xMouse = event.offsetX;
				const yMouse = event.offsetY;
		
				mouse.x = ( xMouse / ww ) * 2 - 1;
				mouse.y = - ( yMouse / hh ) * 2 + 1;
				raycaster.setFromCamera( mouse, camera );
		
				// получаем массив объектов, по которым был сделан щелчок
				let intersects = raycaster.intersectObjects( objects );

				
		
				// если этот массив не пустой
				if ( intersects.length > 0 ) {
		
					// получаем самый первый объект, по которому щёлкнули
					let answer = intersects[0];
		
					if(answer.object === objects[0]){
						alert("Красный кубик");
					}
		
					if(answer.object === objects[1]){
						alert("Зеленый кубик");
					}
				}
			});
		});

	//Рендер сцены
	renderer = new WebGPURenderer({antialias: true, alpha: true });
	renderer.setPixelRatio(window.devicePixelRatio);
	renderer.setSize(container.offsetWidth, container.offsetHeight);
	renderer.toneMapping = THREE.ACESFilmicToneMapping;

	//Добавляет в блок канвас
	container.appendChild(renderer.domElement);


	//Управление камерой
	const controls = new OrbitControls(camera, renderer.domElement);

	//Лок зума
	controls.minDistance = 10;
	controls.maxDistance = 10;

	//Лок Просмотра верх-низ
	controls.minPolarAngle = Math.PI / 2;
	controls.maxPolarAngle = Math.PI / 2;

	//Координаты сцены
	controls.target.set(0, 0, - 0.2);

	//Лок перемещения 
	controls.maxTargetRadius = 0;
	controls.minTargetRadius = 0;
	controls.update();

	window.addEventListener('resize', onWindowResize);

}

function onWindowResize() {

	//Получить контейнер блока
	const container = document.querySelector(".b-test3d");

	//Соотношение сторон камеры
	camera.aspect = container.offsetWidth / container.offsetHeight;
	camera.updateProjectionMatrix();

	//Размеры рендера сцены
	renderer.setSize(container.offsetWidth, container.offsetHeight);

	render();

}


function render() {
	renderer.render(scene, camera);
}

function animate() {
	requestAnimationFrame(animate);


	//Анимация полета

	if (pos<150 && dir){
		scene.position.y-=0.003;
		pos++;
	}

	if (pos>=150 && dir){
		dir = false;
	}

	if (pos>=150 && dir==false){
		scene.position.y+=0.003;
		pos--;
	}

	if (pos<150 && dir==false){
		scene.position.y+=0.003;
		pos--;
	}

	if (pos<= -150 && dir==false){
		dir = true;
	}

	renderer.render(scene, camera);
}

animate();