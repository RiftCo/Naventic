'use strict';

// Dependencies
// ----------------------------------------------------------------------------
var
	//cache = require('gulp-cache'),
	sourcemaps = require('gulp-sourcemaps'),
	autoprefixer = require('gulp-autoprefixer'),
	cleanCSS = require('gulp-clean-css'),
	connect = require('gulp-connect'),
	del = require('del'),
	gulp = require('gulp'),
	gulps = require("gulp-series"),
	htmlbeautify = require('gulp-html-beautify'),
	path = require('path'),
	plumber = require('gulp-plumber'),
	PrettyError = require('pretty-error'),
	rename = require('gulp-rename'),
	sass = require('gulp-sass'),
	strip = require('gulp-strip-comments'),
	util = require('gulp-util'),
	twig = require('gulp-twig'),
	uglify = require('gulp-uglify')
	;

var pe = new PrettyError();
pe.start();

var basePath = {
	src: './',
	build: '../build/',
	additional: '../setup/',
	publish: '../../public/'
};
var path = {
	style: {
		src: basePath.src + 'sass/',
		build: basePath.build + '',
		publish: basePath.publish + ''
	},
	inlineStyle: {
		src: basePath.src + 'sass/inline.scss',
		build: basePath.src + 'twig/includes/template/'
	},
	markup: {
		src: basePath.src + 'twig/',
		build: basePath.build + '',
		publish: basePath.publish + ''
	},
	image: {
		src: basePath.src + 'assets/img/',
		build: basePath.build + 'img/',
		publish: basePath.publish + 'img/'
	},
	script: {
		src: basePath.src + 'assets/js/',
		build: basePath.build + 'js/',
		publish: basePath.publish + 'js/'
	},
	other: {
		src: basePath.src + 'assets/src/',
		build: basePath.build + 'src/',
		publish: basePath.publish + 'src/'
	},
	build: {
		css: basePath.build + '**/*.css',
		js: basePath.build + '**/*.js',
		html: basePath.build + '**/*.html',
		setup: basePath.additional + '**/*',
		all: basePath.build + '**/*'
	}
};
var file = {
	style: path.style.src + '**/*.scss',
	inlineStyle: path.style.src + 'parts/_framework/**/*.scss',
	markup: path.markup.src + '**/!(_)*.twig',
	markupAll: path.markup.src + '**/*.twig',
	additional: basePath.additional + '**/*',
	image: path.image.src + '**/*',
	script: path.script.src + '**/*.js',
	other: path.other.src + '**/*'
};
var ignore = {
	markup: path.markup.src + '**/_*.twig',
	inlineStyle: path.style.inline + '*.css*',
};


/*
	** Console Log Colours **
	// Srart: 			blue
	// Completed: 		green
	// Error: 			yellow
	// Deleting: 		red
	// Server:			magenta
 */


//
// Tasks
//
gulps.registerTasks({

	// Styles
	"sass": (function (done) {
		setTimeout(function () {
			console.log(util.colors.bgBlue.black.bold('\nStarting SASS...\n'))

			// Source
			gulp.src([file.style, '!**/inline.scss'])
				.pipe(plumber())

				// Begin Sourcemaps
				.pipe(sourcemaps.init())

				// SASS to CSS
				.pipe(sass({
					outputStyle: 'nested', // nested, expanded, compact, compressed
					sourceComments: true
				}).on('error', sass.logError)) //compressed


				// Prefix
				.pipe(autoprefixer({
					browsers: ['last 2 versions'],
					cascade: true
				}))

				// Minify
				//.pipe(cleanCSS({compatibility: 'ie8'})) // Running the plugin

				.pipe(sourcemaps.write('/'))

				// Minify
				// .pipe(strip())
				//.pipe(rename({extname: '.min.css'}))

				// Export
				.pipe(gulp.dest(path.style.build))

				// Reload	
				.pipe(connect.reload(
					console.log(util.colors.bgGreen.black.bold('\nFinished SASS\n')))
				)


			done();
		},3500);

	}),
	"inlineSass": (function (done) {
		setTimeout(function () {
			console.log(util.colors.bgBlue.black.bold('\nStarting Inline SASS...\n'))

			// Source
			gulp.src(path.inlineStyle.src)
				.pipe(plumber())

				// Begin Sourcemaps
				.pipe(sourcemaps.init())

				// SASS to CSS
				.pipe(sass({
					outputStyle: 'nested', // nested, expanded, compact, compressed
					sourceComments: true
				}).on('error', sass.logError)) //compressed


				// Prefix
				.pipe(autoprefixer({
					browsers: ['last 2 versions'],
					cascade: true
				}))

				// Minify
				//.pipe(cleanCSS({compatibility: 'ie8'})) // Running the plugin

				.pipe(sourcemaps.write('/'))

				// Minify
				// .pipe(strip())
				//.pipe(rename({extname: '.min.css'}))

				// Export
				.pipe(gulp.dest(path.inlineStyle.build))


			done(
				(console.log(util.colors.bgGreen.black.bold('\nFinished Inline SASS\n')))
			);
		},3500);

	}),

	
	// Markup
	"twig": (function () {
		setTimeout(function () {
			console.log(util.colors.bgBlue.black.bold('\nStarting TWIG\n'))
			/*
			var options = {
				"indent_size": 1,
				"indent_char": "	",
				"eol": "\n",
				"indent_level": 0,
				"indent_with_tabs": true,
				"preserve_newlines": false,
				"max_preserve_newlines": 3,
				"jslint_happy": false,
				"space_after_anon_function": false,
				"brace_style": "collapse",
				"keep_array_indentation": false,
				"keep_function_indentation": false,
				"space_before_conditional": true,
				"break_chained_methods": false,
				"eval_code": false,
				"unescape_strings": false,
				"wrap_line_length": 0,
				"wrap_attributes": "auto",
				"wrap_attributes_indent_size": 3,
				"end_with_newline": false
			};*/
			
			// Source
			gulp.src(file.markup)
				.pipe(plumber())


				// Compile
				.pipe(twig({
					data: {
						// About Website
						title: 'Website Name',
						description: 'Description of website here',
						brand_colour: 'ff3817',

						// Contact
						author: 'Client Name',
						description: 'contact@olliejt.com',
						twitter_username: 'TheOllieJT',

						// URL
						siteUrl: 'https://riftco.github.io/Naventic/public/'
					},
					//base: path.markup.src,
					//getIncludeId: function (filePath) {
					//	return path.relative(path.markup.src, filePath);
					//}
				}))


				// Rename
				.pipe(rename({ extname: '.html' }))


				// Minify
				//.pipe(strip())
				//.pipe(htmlbeautify(options))


				// Export
				.pipe(gulp.dest(path.markup.build))

				// Reload	
				.pipe(connect.reload(
					console.log(util.colors.bgGreen.black.bold('\nFinished Twig\n')))
				)

		},3500);
	}),
	
	// Assets
	"images": (function (done) {
		setTimeout(function () {

			// Source
			gulp.src(file.image)
				// Copy Location	
				.pipe(gulp.dest(path.image.build))
				
			// Reload	
			.pipe(connect.reload(
				console.log(
					'\n' +
					util.colors.bgGreen.bold.black('[', path.image.build, ']'),
					util.colors.bgGreen.black('updated '),
					+ '\n'
				)
			))
			done();
		},2000);
	}),
	"scripts": (function (done) {
		setTimeout(function () {

			// Source
			gulp.src(file.script)
			
			.pipe(uglify())	
			
				
			// Copy Location	
			.pipe(gulp.dest(path.script.build))
				
			// Reload	
			.pipe(connect.reload(
				console.log(
					'\n' +
					util.colors.bgGreen.bold.black('[', path.script.build, ']'),
					util.colors.bgGreen.black('updated '),
					+ '\n'
				)
			))
			done();
		},2000);
	}),
	"other": (function (done) {
		setTimeout(function () {

			// Source
			gulp.src(file.other)
			
			// Copy Location	
			.pipe(gulp.dest(path.other.build))
				
			// Reload	
			.pipe(connect.reload(
				console.log(
					'\n' +
					util.colors.bgGreen.bold.black('[', path.other.build, ']'),
					util.colors.bgGreen.black('updated '),
					+ '\n'
				)
			))
			done();
		},2000);
	}),


	// Server
	"watch": (function (done) {
		setTimeout(function () {

			// Watch Locations
			gulp.watch(file.style, ["sass"])
			gulp.watch(file.inlineSass, ["inlineSass", "twig", "updated"])
			gulp.watch(file.markupAll, ["twig"])
			gulp.watch(file.image, ["images", "updated"])
			gulp.watch(file.script, ["scripts", "updated"])

			done(console.log(util.colors.bgBlack.magenta.bold('\nWatching!\n')));
		},5000);
	}),
	"connect": (function (done) {
		setTimeout(function () {

			connect.server({
				root: basePath.build,
				port: 9876,
				livereload: 'true'
			});

			done(console.log(util.colors.bgBlack.magenta.bold('\nConnected!\n')));

		},5000);
	}),
	"updated": (function () {
		setTimeout(function () {

			// Source
			gulp.src(basePath.build)

				// Reload	
				.pipe(connect.reload(
					console.log(util.colors.bgGreen.black.bold('\nUpdated\n')))
				)
		},5000);
	}),


	// Clean
	"clean": (function (done) {
		setTimeout(function () {

			//const del = require('del');
			del([basePath.build, basePath.publish, path.inlineStyle.build + '*.css'], { force: true }).then(paths => {
				console.log(
					'\n',
					util.colors.red('All files in '),
					util.colors.bold.red('[', basePath.build, ']'),
					util.colors.red('+'),
					util.colors.bold.red('[', basePath.publish, ']'),
					util.colors.red('+'),
					util.colors.bold.red('[', file.inlineStyle, ']'),
					util.colors.red('deleted!'),
					'\n'
				);
			});

			done();
		},2000);
	}),


	// Publish
	"publish": (function (done) {
		setTimeout(function () {
			
			// copy build to public
			gulp.src(path.build.setup)
				.pipe(plumber())
				.pipe(gulp.dest(basePath.publish))
				console.log('setup')
			
			gulp.src(path.build.all)
				.pipe(plumber())
				.pipe(gulp.dest(basePath.publish))
				console.log('copied build')
			
			// Minify CSS
			gulp.src(path.build.css)
				.pipe(plumber())
				//.pipe(strip())
				.pipe(cleanCSS({ compatibility: 'ie8' }))
				.pipe(gulp.dest(basePath.publish))
				console.log('minified css')
			
			// Minify HTML
			gulp.src(path.build.html)
				.pipe(plumber())
				.pipe(strip())
				.pipe(gulp.dest(basePath.publish))
				console.log('minified html')

		
			done(
				console.log(
					'\n' +
					util.colors.green('All files in '),
					util.colors.bold.green('[', basePath.build, ']'),
					util.colors.green('+'),
					util.colors.bold.green('[', basePath.additional, ']'),
					util.colors.green(' copied to '),
					util.colors.bold.green('[', basePath.publish, ']'),
					+ '\n'
				)
			);

		},8000);
	})


}),





//
// Execute Tasks
//
gulp.task('default', function () {
	console.log(util.colors.green.bold('OllieJT Quickstart: ') + util.colors.red.bold('Learn more here ') + util.colors.blue('https://github.com/OllieJT/quickstart'))
});

// Deletes all genetated files
gulps.registerSeries("clean", ["clean"], function () { });

// Starts the development enviroment
gulps.registerSeries('serve',
	[
		// CLEAN
		//"clean",
		// CSS
		"sass",
		//"inlineSass",
		// HTML
		"twig",
		// Assets
		"images",
		"scripts",
		"other",
		// Localhost
		"connect",
		"watch",
		"updated"

	], function () {
		console.log(util.colors.green.bold('DEV MODE: ') + util.colors.white.bold('ENABLED') + util.colors.red.bold(' Watching...'))
	});

	gulps.registerSeries('dev',
	[
		// Localhost
		"connect",
		"watch",
		"updated"

	], function () {
		console.log(util.colors.green.bold('DEV MODE: ') + util.colors.white.bold('ENABLED') + util.colors.red.bold(' Watching...'))
	});
	
// Generates all development files
gulps.registerSeries("build",
	[
		// CLEAN
		//"clean",
		//CSS
		"sass",
		//"inlineSass",
		// HTML
		"twig",
		// Assets
		"images",
		"scripts",
		"other"

	], function () {
		console.log(util.colors.green.bold('BUILD: ') + util.colors.white.bold('COMPLETED') + util.colors.white('&') + util.colors.white.bold('COMPRESSED'))
});

// Generates all development files
gulps.registerSeries("twig",
[
	"twig"

], function () {
	console.log(util.colors.green.bold('BUILD: ') + util.colors.white.bold('COMPLETED') + util.colors.white('&') + util.colors.white.bold('COMPRESSED'))
});

// Generates and bundles all files
gulps.registerSeries('publish',
	[
		// CLEAN
		//"clean",
		//CSS
		"sass",
		//"inlineSass",
		// HTML
		"twig",
		// Assets
		"images",
		"scripts",
		"other",
		// Publish
		"publish"

	], function () {
		console.log(util.colors.green.bold('PUBLISH: ') + util.colors.white.bold('COMPLETED') + util.colors.red.bold('Watching...'))
	});
	
	

// Pretty Error
pe.appendStyle({
	// this is a simple selector to the element that says 'Error'
	'pretty-error > header > title > kind': {
		// which we can hide:
		display: 'none'
	},

	// the 'colon' after 'Error':
	'pretty-error > header > colon': {
		// we hide that too:
		display: 'none'
	},

	// our error message
	'pretty-error > header > message': {
		// let's change its color:
		color: 'bright-white',

		// we can use black, red, green, yellow, blue, magenta, cyan, white,
		// grey, bright-red, bright-green, bright-yellow, bright-blue,
		// bright-magenta, bright-cyan, and bright-white

		// we can also change the background color:
		background: 'yellow',

		// it understands paddings too!
		padding: '0 1' // top/bottom left/right
	},

	// each trace item ...
	'pretty-error > trace > item': {
		// ... can have a margin ...
		marginLeft: 2,

		// ... and a bullet character!
		bullet: '"<grey>o</grey>"'

		// Notes on bullets:
		//
		// The string inside the quotation mark gets used as the character
		// to show for the bullet point.
		//
		// You can set its color/background color using tags.
		//
		// This example sets the background color to white, and the text color
		// to cyan, the character will be a hyphen with a space character
		// on each side:
		// example: '"<bg-white><cyan> - </cyan></bg-white>"'
		//
		// Note that we should use a margin of 3, since the bullet will be
		// 3 characters long.
	},

	'pretty-error > trace > item > header > pointer > file': { color: 'bright-magenta' },
	'pretty-error > trace > item > header > pointer > colon': { color: 'yellow' },
	'pretty-error > trace > item > header > pointer > line': { color: 'bright-blue' },
	'pretty-error > trace > item > header > what': { color: 'bright-white' },
	'pretty-error > trace > item > footer > addr': { display: 'none' }
});