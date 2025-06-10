import fs from 'fs';
import postcss from 'postcss';
import cssnano from 'cssnano';
import combineMediaQuery from 'postcss-combine-media-query';
import sortMediaQueries from 'postcss-sort-media-queries';

async function combineMediaQueries(filePath, cssnanoConfig) {
	const css = fs.readFileSync(filePath, 'utf8');

	const result = await postcss()
		.use(combineMediaQuery())
		.use(sortMediaQueries({
			sort: 'desktop-first'
		}))
		.use(cssnano(cssnanoConfig))
		.process(css, { from: filePath });

	fs.writeFileSync(filePath, result.css, 'utf8');
}

export default function ({
	paths2css = ['public/build/assets'],
	cssnanoConfig = { preset: 'advanced' },
} = {}) {
	return {
		name: 'vite-join-media-queries',
		enforce: 'post',
		closeBundle: {
			order: 'post',
			sequential: true,
			async handler() {
				paths2css.forEach((path) => {
					fs.readdirSync(path)
						.filter((filename) => /\.css$/.test(filename))
						.map((filename) =>
							combineMediaQueries(`${path}/${filename}`, cssnanoConfig)
						);
				});
			},
		},
	};
};