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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
define( 'WP_MEMORY_LIMIT', '5G' );

/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'ATiourS[oM?2.;-SiM:sj8;[Y%Ye0!E1G@`05l7EptJ|uAOe%Alum9E~c(&4Q!9 ' );
define( 'SECURE_AUTH_KEY',   'Tk%?]w]W7EG}WfT,tgLMD!O [$sz||}M[GMVX}qq=43qKk!)CEwKWX!uPLrz~RC*' );
define( 'LOGGED_IN_KEY',     'a%o.8k>5FZ{ao*H_xMs@B;V4Bk%]/3oO,l=Y9vbGryV]azJD4qr}Z.{>sIA|lWVH' );
define( 'NONCE_KEY',         '+YnZ``M&1%Yb`%e(ba8Y:gQ<x+w1.XECC{L]v+S (;{{=P!/SvsN@-][<F!k!ds[' );
define( 'AUTH_SALT',         '7OuWM]Bj#y4Z`7A5uI@E.d?g0 e4%+!9C5UN;$TUuy@QDZr)>LWn7ssE5|]UgZ(y' );
define( 'SECURE_AUTH_SALT',  'x8Oi[{DLIc+-QIWb#vrJODA[IFwn7~wIsH]3/_7w(rD)LE-F.rh+NnQ>`#jMNlhG' );
define( 'LOGGED_IN_SALT',    '9v:8nv6y(_OqUyvb/-fmxQL=416}YQ4?$n_u;_W[_[1+o*mxs5Hj{5+z PG9S%u6' );
define( 'NONCE_SALT',        'N_W{c)DIgnqx<%RdAPq^5z#+aCe0! ng3/8X)`<bw6Pvq^Y2Snl#^Ouj,Ma5a]_0' );
define( 'WP_CACHE_KEY_SALT', 'i9c6gTe&pwe)kje>9(2HYEAO?Vr`#Hj8Ui-IW_f_+?v_fF]mz^4.9Rcmx+4RlFO^' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
