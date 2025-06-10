import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'
import combineMediaQuery from './resources/vite-plugins/combine-media-query';


const pathStyle = 'resources/style/';
const pathScript = 'resources/script/';

const entries = [
	'home',
	'detail-product',
	'cosmetology',
	'about',
	'contacts',
	'patient',
	'error',
	'news',
	'news-detail',
	'event',
	'feedback',
	'event-detail',
	'policy',
]

const createEntries = (entries) => {
	let result = [];
	entries.forEach(entry => {
		result.push(pathStyle + entry + '.scss');
		result.push(pathScript + entry + '.js');
	});

	return result;
}


export default defineConfig({
	css: { preprocessorOptions: { scss: { api: 'modern-compiler' } } },
	resolve: {
		alias: {
			'fonts': path.resolve(__dirname, './resources/fonts'),
			'libs': path.resolve(__dirname, './resources/style/libs'),
			'base': path.resolve(__dirname, './resources/style/libs/base.scss'),
			'layout': path.resolve(__dirname, './resources/style/layouts/default.scss'),
			'common': path.resolve(__dirname, './resources/style/common/common.scss'),
			'component': path.resolve(__dirname, './resources/style/component')
		},
	},
	plugins: [
		laravel({
			input: createEntries(entries),
			refresh: true,
		}),
		combineMediaQuery(),
	],
});



