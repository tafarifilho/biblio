var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix
		.less('biblioteca.less')
		.copy(
			'vendor/materialize/dist/js/materialize.min.js',
			'public/js/vendor/materialize.min.js'
		)
		.copy(
			'vendor/materialize/dist/css/materialize.min.css',
			'public/css/materialize.min.css'
		)
		.copy(
			'vendor/materialize/dist/fonts/material-design-icons',
			'public/fonts/material-design-icons'
		)
		.copy(
			'vendor/materialize/dist/fonts/roboto',
			'public/fonts/roboto'
		);

});
