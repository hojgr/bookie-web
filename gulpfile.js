process.env.DISABLE_NOTIFIER = true;

var elixir = require('laravel-elixir');

var gulp = require('gulp'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	util = require('gulp-util'),
	cssmin = require('gulp-minify-css'),
	autoprefix = require('gulp-autoprefixer');
/*
 |--------------------------------------------------------------------------
 | Gulp Tasks
 |--------------------------------------------------------------------------
 |
 | Custom gulp tasks, for building JS/CSS files
 |
 */

// concat and minify custom JS
gulp.task('js', function(){
	gulp.src('dev/js/*.js')
		   .pipe(uglify())
		   .pipe(concat('compiled.js'))
		   .pipe(gulp.dest('public/js/'));
});
// concat and minify libraries
var specificLibs = [
	'dev/js/libs/jquery/dist/jquery.min.js',
	'dev/js/libs/smoothstate/jquery.smoothState.js'
];
gulp.task('libs', function(){
	gulp.src(specificLibs.concat('dev/js/libs/*.js'))
		.pipe(uglify())
		.pipe(concat('libs.js'))
		.pipe(gulp.dest('public/js/'));
});
gulp.task('css_libs', function(){
	gulp.src('dev/css/libs/*.css')
	    .pipe(cssmin())
	    .pipe(concat('libs.css'))
	    .pipe(gulp.dest('public/css/'));
});
// concat, prefix and minify CSS
gulp.task('css', function(){
	gulp.src('dev/css/*.css')
	    .pipe(autoprefix({browsers: 'last 2 versions', cascade: false}))
	    .pipe(cssmin())
	    .pipe(concat('compiled.css'))
	    .pipe(gulp.dest('public/css/'));
});
// watch for file changes
gulp.task('watch', function() {
	gulp.watch(['dev/js/*.js'], ['js']);
	gulp.watch(['dev/js/libs/*.js'], ['libs']);

	gulp.watch(['dev/css/*.css'], ['css']);
	gulp.watch(['dev/css/libs/*.css'], ['css_libs']);
});
// default
gulp.task('dev', ['libs', 'js', 'css', 'css_libs', 'watch']);

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

/*elixir(function(mix) {
  mix.less(['app.less', 'beta.less', 'site.less', 'admin.less', 'admin_bootstrap_override.less'])
      .copy('resources/assets/images', 'public/images')
      .version(['css/app.css', 'css/beta.css', 'css/site.css', 'css/admin.css', 'css/admin_bootstrap_override.css'])
});*/
