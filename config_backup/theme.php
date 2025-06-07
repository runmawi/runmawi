<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Theme Setting
	|--------------------------------------------------------------------------
	*/

	'name'        => 'Default Theme',
	'description' => 'Default theme of C-Real.',
	'author'      => 'John Doe',
	'version'     => '1.0.0',

	/*
	|--------------------------------------------------------------------------
	| Theme Configuration
	|--------------------------------------------------------------------------
	*/

	'layout'      => 'theme.default::layout.default',
	'parent'      => null,

	/*
	|--------------------------------------------------------------------------
	| Theme Filters
	|--------------------------------------------------------------------------
	|
	| These filters are not compatible with config caching and should be
	| moved to a service provider. The asset definitions have been moved to
	| app/Providers/ThemeServiceProvider.php
	|
	*/

	'before' => null,
	'asset'  => null,
	'beforeRenderLayout' => null,
	'afterRenderLayout' => null,

];
