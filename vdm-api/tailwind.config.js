module.exports = {
	mode: 'jit',
	purge: ['./public/**/*.html', './assets/**/*.{js,jsx,ts,tsx,vue}', './templates/**/*.html.twig'],
	darkMode: false, // or 'media' or 'class'
	theme: {
		extend: {},
	},
	variants: {
		extend: {},
	},
	plugins: [],
};
