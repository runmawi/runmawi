process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');

elixir(function(mix) {

	mix.styles( [
				'./assets/css/style.css'
				], './assets/dist/css/styles.css'
	);
	

	
});
