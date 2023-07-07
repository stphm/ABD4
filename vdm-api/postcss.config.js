const autoprefixer = require('autoprefixer');
const postcssPresetEnv = require('postcss-preset-env');
const tailwindcss = require('tailwindcss');

const prod = process.env.NODE_ENV === 'production';
module.exports = {
	plugins: [
		postcssPresetEnv({
			/* use stage 3 features + css nesting rules */
			stage: 3,
			features: {
				'nesting-rules': true,
			},
		}),
		tailwindcss('./tailwind.config.js'),
		autoprefixer(),
	],
};
