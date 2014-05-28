<?php
if ( ! (  defined( '_JEXEC' ) ) ) { die( 'Direct Access to this location is not allowed.' ); }
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/* rc_corephp - This is for when we have multisite enabled */
if ( isset( $_SERVER['WPPRE_SCRIPT_FILENAME'] ) ) {
	// Originals
	$_SERVER['WPPRE_SCRIPT_FILENAME_ORG'] = $_SERVER['SCRIPT_FILENAME'];
	$_SERVER['WPPRE_REQUEST_URI_ORG'] = $_SERVER['REQUEST_URI'];
	$_SERVER['WPPRE_SCRIPT_NAME_ORG'] = $_SERVER['SCRIPT_NAME'];
	$_SERVER['WPPRE_PHP_SELF_ORG'] = $_SERVER['PHP_SELF'];

	// Set for WP
	$_SERVER['SCRIPT_FILENAME'] = $_SERVER['WPPRE_SCRIPT_FILENAME'];
	$_SERVER['REQUEST_URI'] = $_SERVER['WPPRE_REQUEST_URI'];
	$_SERVER['SCRIPT_NAME'] = $_SERVER['WPPRE_SCRIPT_NAME'];
	$_SERVER['PHP_SELF'] = $_SERVER['WPPRE_PHP_SELF'];
}

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
/* rc_removed ./ before the require */
require('wp-blog-header.php');

if ( isset( $_SERVER['WPPRE_SCRIPT_FILENAME'] ) ) {
	// Reset to originals
	$_SERVER['SCRIPT_FILENAME'] = $_SERVER['WPPRE_SCRIPT_FILENAME_ORG'];
	$_SERVER['REQUEST_URI'] = $_SERVER['WPPRE_REQUEST_URI_ORG'];
	$_SERVER['SCRIPT_NAME'] = $_SERVER['WPPRE_SCRIPT_NAME_ORG'];
	$_SERVER['PHP_SELF'] = $_SERVER['WPPRE_PHP_SELF_ORG'];
}
?>