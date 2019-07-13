<?php
/**
 * Name:          Combine Scripts
 * Description:   A simple PHP script to combine script assets
 * Version:       0.2.0
 * Author:        Daniel M. Hendricks
 * GitHub:        https://github.com/dmhendricks/php-combine-scripts
 */
use MatthiasMullie\Minify;
$version = '0.2.0';

require( __DIR__ . '/vendor/autoload.php' );

// Load environmental configuration
if( file_exists( '.env' ) ) {
    $dotenv = \Dotenv\Dotenv::create(__DIR__);
    $dotenv->load();
}

// Set variables
$basedir = rtrim( getenv( 'COMBINE_BASEDIR' ) ?: __DIR__, DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR;
$disable_file_check = filter_var( getenv( 'COMBINE_DISABLE_FILE_EXISTS' ), FILTER_VALIDATE_BOOLEAN );
$disable_minify = filter_var( getenv( 'COMBINE_DISABLE_MINIFY' ), FILTER_VALIDATE_BOOLEAN );

// Get scripts from querystring
$scripts = isset( $_GET['scripts'] ) ? $_GET['scripts'] : false;
if( !$scripts ) {
    header( 'HTTP/1.1 400 Bad Request', true, 400 );
    die( '400 Bad Request' );
} else {
    $scripts = explode( ',', $scripts );
}

// Sanitize input
$error = false;
$files = [];
$type = null;

foreach( $scripts as $script ) {
    $script = trim( $script, './' );
    $ext = explode( '.', strtolower( $script ) );
    if( $type !== null && $type != end( $ext ) ) {
        $error = true;
    } else {
        $type = end( $ext );
    }
    if( !$disable_file_check && !file_exists( $basedir . $script ) ) $error = true;
    $files[] = $basedir . $script;
}

if( $error ) {
    header( 'HTTP/1.1 400 Bad Request', true, 400 );
    die( '400 Bad Request' );
}

// Combine scripts
$output = '';
foreach( $files as $file ) {

    $output .= file_get_contents( $file ) . "\n";

}

// Minify output
if( !$disable_minify ) {

    $minifier = null;
    if( $type == 'js' ) {
        $minifier = new Minify\JS();
    } else if( $type == 'css' ) {
        $minifier = new Minify\CSS();
    }

    if( $minifier ) {
        $minifier->add( $output );
        $output = $minifier->minify();
    }

}

// Add header to result
$output = sprintf( "/**\n * %s by php-combine-scripts v%s.\n * More information: https://github.com/dmhendricks/php-combine-scripts\n */\n%s", $disable_minify ? 'Combined' : 'Minified', $version, $output );

// Set content type
$content_type = 'text/plain';
if( in_array( $type, [ 'js', 'css' ] ) ) {
    $content_type = $type == 'js' ? 'text/javascript' : 'text/css';
}

// Output to browser
header( "Content-Type: {$content_type}" );
echo $output;
