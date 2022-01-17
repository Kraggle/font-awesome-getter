const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.disableSuccessNotifications()
	.sourceMaps(true, 'source-map')
	.webpackConfig({
		devtool: 'source-map'
	})
	.browserSync({
		watch: true,
		proxy: 'http://font-awesome-getter.test', // update for current proxy
		port: 3008,
		files: [
			'**/*.js',
			'*.js',
			'**/*.css',
			'**/*.php',
			'*.php'
		],
		reloadDelay: 1000
	})