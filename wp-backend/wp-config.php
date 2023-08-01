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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'next-practice' );

/** Database username */
define( 'DB_USER', 'root' );

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
define( 'AUTH_KEY',         'ep5Z[&cZ1i0v$I5|DdLt(4T3S5/i`|bpI~vT=C.DXd)`794==.%z?XnArM8Q~)j5' );
define( 'SECURE_AUTH_KEY',  '/wv2$PI;&Xe)D:JK{fz@81`-&#4FYxF:>GoN{~~HY<.:FZ,=Wkmpv[Hxgt^e&:qO' );
define( 'LOGGED_IN_KEY',    'I~?=,dx[acsLyt|5d].*d~U:JATBZ=~|U3UIqK%z<kDwl-$p*Ukqdf;k8F)PhcDM' );
define( 'NONCE_KEY',        'qT[fGYW<mcBPJXbdPk9:<u?NJM[ 8-Y-RWapIZOmRjNF&pb$Ok$&LqY6S;P}lJdl' );
define( 'AUTH_SALT',        'NjQ1&yO- +dS8sL+G(C&6O(W9h_NSMCXYFAmg|vA34_2v6~$N`9j`,M1R<x~_4Wa' );
define( 'SECURE_AUTH_SALT', 'Y-_ /v?_6IcGe><S5w Z7LlFW@^XO6m/KjY>^ec0epa1E[;;nv}R!{tl(oG2_c{7' );
define( 'LOGGED_IN_SALT',   '!6eJjZ @R]{tmHVv_d({+,_PKN{J|F+4k$c i1YdGHTw^p){gPItGM9b6~1Gh0PZ' );
define( 'NONCE_SALT',       'ezkYPy.sRyTk` rm;ZMa?WIGH2a*;mhAU|^?`_hvr3C(Aw-ga9!PilBFX$KS3h%$' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
