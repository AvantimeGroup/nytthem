<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'nytthem23' );
//define( 'DB_NAME', 'nytthemdev_db' );

/** Database username */
define( 'DB_USER', 'nytthem23' );

/** Database password */
define( 'DB_PASSWORD', '?LisA#49kate' );

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
define( 'AUTH_KEY',         '(RvB(Yl|nfBycAj1_bFn-Q3@?b57Fp8XC-}YJdBs[Z%CK`AyL0&P: (dz<|jy7k_' );
define( 'SECURE_AUTH_KEY',  'ROIs#|~L.@pxhsx:Sj0Hj(z><sE?6I~GP`H+ /wsItMj>`NM7OXkE`3V?HZBUsRZ' );
define( 'LOGGED_IN_KEY',    '{0#hD%!MXlRUZmChU]k[ ^3F]h[fqZ;]sZi)f#D<-jO$@[~xcZ*7%0`W(>ln(e2f' );
define( 'NONCE_KEY',        'GxueZo@5}W^ed4%1o-h`sZ~xD-aMq+P4-uXc%?AVc}~v0id*=:z[Kg25VsJZx}%6' );
define( 'AUTH_SALT',        '`EReDb/8{PEDk1v|J1y=)[,Din4%uf.vOD9}{g8hD;/Q#7>Kzv&OCPM xB6-<gn%' );
define( 'SECURE_AUTH_SALT', 'U2g%AH2<Kk{bX:XiA:Cwn^kyc{^d>/+o^sMPIk*-illi$wYJ=:]ldDO!Lxjmno1z' );
define( 'LOGGED_IN_SALT',   '5w*gMlhtnUq05)X8{[UhzCX,x[@?olC08V;M2?{bK*IO,)xb2H{n<]u-6ItIFow/' );
define( 'NONCE_SALT',       'r:}IB},)vE..}MlD|!h(I0,T1X&lrlfh.G8$!V/bmF?5/Q{-q; =. 7mB.(r05Z(' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */

define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );
define( 'SCRIPT_DEBUG', false );

 /* That's all, stop editing! Happy publishing. */
 /** Absolute path to the WordPress directory. */
 if ( !defined('ABSPATH') ) 
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');