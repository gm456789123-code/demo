<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'data' );

/** Database username */
define( 'DB_USER', 'mysql' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'S^gsYj:d5%*4K [)$05:8H[}XNSRNUDR`zGe$)Akit,j#r3PHrRiRb9Tle3Ok;=#' );
define( 'SECURE_AUTH_KEY',  'ZoH4Mx[_@O`/[D:^.:|OotI#q:Xlu=/Us`/AasT>U{Gf-v>YfPcCaAGc9aM#Jdgi' );
define( 'LOGGED_IN_KEY',    '5[<#hs{is9:xw8?YBHBP6fcll*C+l,8!&HIw@oYn4cvJleMOhmZZ)6-m=,ij]+aN' );
define( 'NONCE_KEY',        '};&:f;h(l.)RMvAEJ%x,y{J!r2E)=Ch6{!(Ukh~9SAxOEU>cGG;[biVR #RwCapY' );
define( 'AUTH_SALT',        'a%[!_VL9yD|aNI|LCz&n`[9OV!,3ye@tLLYMxzD-AAitM/kvYV%W0#vQiI1jv{7?' );
define( 'SECURE_AUTH_SALT', 'k-r?2oJR$YK2.^Tc7(:;tP2Qefrr=g25sc1SPzWo<ff/szTFGdarYu_TQ!4937Q ' );
define( 'LOGGED_IN_SALT',   'mYT`1{Gf*I#|>UR5tXm?9*?1{g)lXfSVX@Pmem/3KXaa0AoHhvvbu!sZzC(5rC~U' );
define( 'NONCE_SALT',       ']owRsw-@FN`NYH.TzJ8LPY6k}A*|lt,m;eN1nC6@HZ~^Je#KI%~?/CUJv&n6j89,' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
