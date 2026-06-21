<?php
/**
 * Router for PHP's built-in server (php -S) so it behaves like Apache
 * for WordPress: adds the trailing slash Apache's mod_dir normally adds,
 * and serves a directory's index.php when a directory is requested.
 *
 * Usage: php -S localhost:8000 router.php
 */

$root = __DIR__;
$uri  = urldecode( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
$path = $root . $uri;

// Existing directory without trailing slash -> redirect to add the slash.
if ( is_dir( $path ) && substr( $uri, -1 ) !== '/' ) {
	$query = $_SERVER['QUERY_STRING'] ?? '';
	header( 'Location: ' . $uri . '/' . ( $query !== '' ? '?' . $query : '' ) );
	exit;
}

// Existing directory with trailing slash -> serve its index.php.
if ( is_dir( $path ) && substr( $uri, -1 ) === '/' ) {
	$index = rtrim( $path, '/' ) . '/index.php';
	if ( is_file( $index ) ) {
		chdir( dirname( $index ) );
		require $index;
		return true;
	}
}

// Existing real file (PHP script or static asset) -> let the built-in server handle it natively.
if ( is_file( $path ) ) {
	return false;
}

// Everything else (pretty permalinks, etc.) -> WordPress front controller.
chdir( $root );
require $root . '/index.php';
