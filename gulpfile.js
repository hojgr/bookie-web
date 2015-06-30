process.env.DISABLE_NOTIFIER = true;

var elixir = require('laravel-elixir');

var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
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
function errorHandler(err) {
	var msg = err.message;
	msg = msg.replace(err.fileName+": ", "");

	util.beep();
	util.log(util.colors.bgRed("ERROR in plugin "+err.plugin));

	if (err.showProperties) {
		util.log(util.colors.bgRed("Line "+err.lineNumber));
		util.log(util.colors.bgRed(err.fileName+":"));
	}

	util.log(util.colors.bgRed(msg));

	if (err.showStack)
		util.log(util.colors.red(err.stack));
};

// concat and minify custom JS
gulp.task('js', function(){
	gulp.src('resources/assets/js/*.js')
	       .pipe(plumber({errorHandler: errorHandler}))
		   .pipe(uglify())
		   .pipe(concat('compiled.js'))
		   .pipe(gulp.dest('public/js/'));
});
// concat and minify libraries
var specificLibs = [
	'resources/assets/js/libs/jquery/dist/jquery.min.js',
	'resources/assets/js/libs/smoothstate/jquery.smoothState.js'
];
gulp.task('libs', function(){
	gulp.src(specificLibs.concat('resources/assets/js/libs/*.js'))
		.pipe(uglify())
		.pipe(concat('libs.js'))
		.pipe(gulp.dest('public/js/'));
});
gulp.task('css_libs', function(){
	gulp.src('resources/assets/css/libs/*.css')
	    .pipe(cssmin())
	    .pipe(concat('libs.css'))
	    .pipe(gulp.dest('public/css/'));
});
// concat, prefix and minify CSS
gulp.task('css', function(){
	gulp.src('resources/assets/css/*.css')
		.pipe(plumber({errorHandler: errorHandler}))
	    .pipe(autoprefix({browsers: 'last 2 versions', cascade: false}))
	    .pipe(cssmin())
	    .pipe(concat('compiled.css'))
	    .pipe(gulp.dest('public/css/'));
});
// concat, prefix and minify CSS for administration
gulp.task('css_admin', function(){
	gulp.src('resources/assets/css/admin/*.css')
		.pipe(plumber({errorHandler: errorHandler}))
	    .pipe(autoprefix({browsers: 'last 2 versions', cascade: false}))
	    .pipe(cssmin())
	    .pipe(gulp.dest('public/css/admin/'));
});
// move images from resources to public
gulp.task('images_copy', function() {
    gulp.src(['resources/assets/images/**/*']).pipe(gulp.dest('public/images'));
});

// watch for file changes
gulp.task('_watch', function() {
	gulp.watch(['resources/assets/js/*.js'], ['js']);
	gulp.watch(['resources/assets/js/libs/*.js'], ['libs']);

	gulp.watch(['resources/assets/css/*.css'], ['css']);
	gulp.watch(['resources/assets/css/admin/*.css'], ['css_admin']);
	gulp.watch(['resources/assets/css/libs/*.css'], ['css_libs']);

	gulp.watch(['resources/assets/images/**/*'], ['images_copy']);
});
// default
gulp.task('dev', ['libs', 'js', 'css', 'css_libs', 'css_admin', 'images_copy', '_watch']);
gulp.task('watch', ['dev']);

gulp.task('default', ['libs', 'js', 'css', 'css_libs', 'css_admin', 'images_copy']);

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
