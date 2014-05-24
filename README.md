# API Generator for Laravel 4

*APIgen* scaffolds restful APIs for you. If you choose to *APIgen* also sets you up with an administration interface.

## Installation

    composer require lukaskorl/apigen
    php artisan apigen:publish
    
### Recommended steps after installation

Add the `apigen:publish` command to the `post-*-cmd` scripts of your project's `composer.json` like so:

	"scripts": {
		"post-install-cmd": [
			"php artisan clear-compiled",
			"php artisan optimize",
            "php artisan apigen:publish"
		],
		"post-update-cmd": [
			"php artisan clear-compiled",
			"php artisan optimize",
            "php artisan apigen:publish"
		],
		"post-create-project-cmd": [
			"php artisan key:generate"
		]
	},