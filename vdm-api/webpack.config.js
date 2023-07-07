const Encore = require('@symfony/webpack-encore');
const path = require('path');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
	Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
	// directory where compiled assets will be stored
	.setOutputPath('public/build/')
	// public path used by the web server to access the output path
	.setPublicPath('/build')
	// only needed for CDN's or sub-directory deploy
	//.setManifestKeyPrefix('build/')

	/*
	 * ENTRY CONFIG
	 *
	 * Each entry will result in one JavaScript file (e.g. app.js)
	 * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
	 */
	.addEntry('app', './assets/app.js')

	// When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
	.splitEntryChunks()

	// will require an extra script tag for runtime.js
	// but, you probably want this, unless you're building a single-page app
	.enableSingleRuntimeChunk()

	/*
	 * FEATURE CONFIG
	 *
	 * Enable & configure other features below. For a full
	 * list of features, see:
	 * https://symfony.com/doc/current/frontend.html#adding-more-features
	 */
	.cleanupOutputBeforeBuild()

	.enableSourceMaps(!Encore.isProduction())
	// enables hashed filenames (e.g. app.abc123.css)
	.enableVersioning(Encore.isProduction())

	// .configureBabel((config) => {
	// 	config.plugins = [
	// 		...config.plugins,
	// 		'@babel/plugin-proposal-class-properties',
	// 		['@babel/plugin-transform-react-jsx', { runtime: 'automatic', importSource: 'preact' }],
	// 		[
	// 			'babel-plugin-jsx-pragmatic',
	// 			{
	// 				module: 'preact',
	// 				import: 'h, Fragment',
	// 				export: 'h, Fragment',
	// 			},
	// 		],
	// 	];
	// })

	// enables @babel/preset-env polyfills
	.configureBabelPresetEnv((config) => {
		config.useBuiltIns = 'usage';
		config.corejs = 3;
	})

	// enables Sass/SCSS support
	//.enableSassLoader()

	.configureDevServerOptions((options) => {
		options.liveReload = true;
		/**
		 * Fix to current webpack-dev-server error:
		 * invalid options object. Dev Server has been initialized using an options object that does not match the API schema.
		 * - options.client has an unknown property 'host'
		 *
		 * */
		delete options['client'];
		return options;
	})

	.enablePostCssLoader((options) => {
		options = {
			...options,
			postcssOptions: {
				config: path.resolve(__dirname, 'postcss.config.js'),
			},
		};
	});

module.exports = Encore.getWebpackConfig();
