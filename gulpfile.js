var gulp = require('gulp'),
    coffee = require('gulp-coffee'),
    plumber = require('gulp-plumber'),
    uglify = require('gulp-uglify'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat');

// Compile main styles
gulp.task('styles', function() {
    return gulp.src([
        'src/assets/bower_components/bootstrap/dist/css/bootstrap.min.css',
        'src/assets/bower_components/bootstrap/dist/css/bootstrap-theme.min.css',
        'src/assets/sass/main.sass'
    ])
        .pipe(plumber())
        .pipe(sass({ style: 'expanded' }))
        .pipe(concat('main.css'))
        .pipe(autoprefixer('last 10 version', 'safari 5', 'ie 9', 'ios 6', 'android 4'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(minifycss())
        .pipe(gulp.dest('public/styles'));
});

// Compile overwrite styles for Laravel Administrator
gulp.task('admin-styles', function() {
    return gulp.src([
        'src/assets/sass/admin.sass'
    ])
        .pipe(plumber())
        .pipe(sass({ style: 'expanded' }))
        .pipe(autoprefixer('last 10 version', 'safari 5', 'ie 9', 'ios 6', 'android 4'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(minifycss())
        .pipe(gulp.dest('public/styles'));
});

// Compile scripts directly loaded from HTML <head>
gulp.task('head-scripts', function() {
    return gulp.src([
        'src/assets/bower_components/modernizr/modernizr.js',
        'src/assets/bower_components/respond/src/respond.js'
    ])
        .pipe(concat('head.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/scripts'));
});

// Compile vendor scripts
gulp.task('vendor-scripts', function() {
    return gulp.src([
        'src/assets/bower_components/jquery/dist/jquery.min.js',
        'src/assets/bower_components/bootstrap/dist/js/bootstrap.min.js',
        'src/assets/bower_components/angular/angular.min.js',
        'src/assets/bower_components/angular-bootstrap/ui-bootstrap.min.js'
    ])
        .pipe(concat('vendor.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/scripts'));
});

// Compile legacy scripts
gulp.task('legacy-scripts', function() {
    return gulp.src([
        'src/assets/bower_components/html5shiv/dist/html5shiv.min.js'
    ])
        .pipe(concat('legacy.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/scripts'));
});

// Compile scripts
gulp.task('scripts', function() {
    return gulp.src([
        'src/assets/coffee/**/*.coffee'
    ])
        .pipe(plumber())
        .pipe(coffee())
        .pipe(concat('core.js'))
        .pipe(gulp.dest('public/scripts'));
});

// Watch for changes in assets
gulp.task('watch', function() {
    gulp.watch(['src/assets/sass/**/*.sass'], ['styles'])
    gulp.watch([
        'src/assets/**/*.coffee',
        'src/assets/**/*.js'
    ], ['scripts']);
});

// Build all assets
gulp.task('build', ['styles', 'admin-styles', 'head-scripts', 'legacy-scripts', 'vendor-scripts', 'scripts']);