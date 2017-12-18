const gulp     = require( 'gulp' );
const rename   = require( 'gulp-rename' );
const uglify   = require( 'gulp-uglify' );

// Location of the JS input and output.
var jsInput  = 'js/**/*.js';
var jsOutput = 'js';

gulp.task( 'scripts', function() {

	gulp.src( jsInput )
		.pipe( rename( { suffix : '.min' } ) )
		.pipe( uglify().on('error', function( e ) { console.log( e ); } ) )
		.pipe( gulp.dest( jsOutput ) );
} );

// Creates the POT file.
gulp.task( 'i18n', function() {

	return gulp.src( '**/*.php' )
		.pipe( wpPot( {
			'domain'  : 'toot',
			'package' : 'toot',
			'metadataFile' : 'toot.php'
		} ) )
		.pipe( gulp.dest( 'lang/toot.pot' ) );
} );

// Set up a watch task.
gulp.task( 'watch', [ 'scripts' ], function() {

	gulp.watch( jsInput, [ 'scripts' ] );
} );
