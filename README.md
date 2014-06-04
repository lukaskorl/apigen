# API Generator for Laravel 4

*APIgen* scaffolds restful APIs for you. If you choose to *APIgen* also sets you up with an administration interface.

__Be aware__: *APIgen* is currently under heavy development. I strongly advise against using the current version of *APIgen* in a production environment. I'm working on getting *APIgen* to a stable release as soon as possible.

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

## Usage

### Note on namespace

By default *APIgen* uses the namespace `Api`. You need to register this namespace for autoloading in your `composer.json` file if you don't use your own namespace. To register the `Api` namespace merge this snippet into your `composer.json` file:

    {
        "autoload": {
            "psr-4": {
                "Api\\": "app/Api"
            }
        }
    }

### Generating a resources

When generating a resource *APIgen* will generate for you:
 * Migration
 * [Eloquent](http://laravel.com/docs/eloquent) Model
 * [Repositoy](https://github.com/lukaskorl/repository)
 * [RESTful](https://github.com/lukaskorl/restful) Controller leveraging repository
 * Laravel route
 * [Administration backend](https://github.com/lukaskorl/administrator)
 
To create a new resource simply run an [Artisan](http://laravel.com/docs/artisan) command:

    php artisan apigen:resource dog --fields="name:string, age:integer"
    
Optionally you can specify a namespace by adding the `--namespace` option:

    php artisan apigen:resource dog --fields="name:string, age:integer" --namespace="Zoo\Animals"
    
There are switches to skip some generators:

 * `--no-admin` Prevents the setup of the administration backend.
 * `--no-route` Prevents adding the route to the application's `routes.php` file.
 * `--no-controller` Prevents the generation of the API controller. So you can selectively create the migration, model and repository only. Beware that if no controller is generated also the route setup is skipped.
 * `--no-migration` Prevents the generation of the migration file if you decide to set it up manually.
 
### Generating a repository

When generating a repository *APIgen* will generate for you:
 * __Interface for your repository__: Implementing your repository against an interface makes it easily possible to switch out implementations.
 * __Transformer for your entities__: A transformer filters the output before sending an entity to the client. So you have granularly control the visibility, aliases and types of entity attributes in the response.
 * __Eloquent CRUD implementation of your repository__: The default implementation of the generated repository uses Eloquent to access the database layer.

### Generating a model

*APIgen* can generate will generate an Eloquent model for you.

### Setting up an administration backend

*APIgen* ships out of the box with support for FrozenNode/Laravel-Administrator. However *APIgen* uses a more advanced fork [lukaskorl/administrator](https://github.com/lukaskorl/administrator). 
	
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
    
    