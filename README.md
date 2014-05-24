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
	
## Contributions

### Making changes to JavaScript & CSS

JavaScript and CSS files are pre-compiled using gulp. If you make changes to the source you will need to recompile them. The gulp tasks are all set-up. Make sure you have gulp and bower.io installed.

    npm install -g bower
    bower install
    
    npm install gulp -g
    npm install gulp gulp-util --save-dev
    gem install sass
    npm install gulp-ruby-sass gulp-autoprefixer gulp-minify-css gulp-notify gulp-rename gulp-cache gulp-concat gulp-coffee gulp-plumber gulp-uglify --save-dev
    
If you have the necessary software installed execute the gulp tasks to build the JS & CSS

    gulp build
    
    