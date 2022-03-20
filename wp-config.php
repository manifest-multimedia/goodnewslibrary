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
define( 'DB_NAME', 'goodnewslibrary' );

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
define( 'AUTH_KEY',         '{~swA~T,xL.L:t^ug{l~K,MRdI~<542q&Ib&#?= [)[$N;d@F_YFiKE;`qdH{G>Z' );
define( 'SECURE_AUTH_KEY',  'yFXhJ:3sy^+Ss%|AHJl$iPql{EWyAfB,=e;D{%#)qC7/0E%y-]u!VHt.txDPdtnr' );
define( 'LOGGED_IN_KEY',    'on?J8zdfEP+b%Kin}J?]9:MLv}b+Gc(_= F=;fJYfDh<$?8OLgSOiI]q=ao;+D2)' );
define( 'NONCE_KEY',        ';~~*3@U0q+=w =[tINC9b6Mtof1>LG(uYCbW=y{&m(1)/~Yi2+HyD;:<jbY4fB@6' );
define( 'AUTH_SALT',        '%<9$d+jv~a2z; V1QRn(OV|of&j.K<OnlJlhZgFEL9MvE|/Of>H5waGnnc,+mR_4' );
define( 'SECURE_AUTH_SALT', ';lyJ/N}R3LI}$s{O}r Zy7Zr#0g6kCm6g,LZ$@VdcWlre&z>sl=/Tk&+0t?`4y1o' );
define( 'LOGGED_IN_SALT',   'qvF+F;7|W4Ughis0nFv@u;<GTt6xN.Qu.M6zY;@tm~{gHh*h/r.14o&_hAa.Y_99' );
define( 'NONCE_SALT',       '0tk41On-_u{B>}r$RH!/0Ao$O(-wCzXzEy;U3?g]Nrv(gyZceuFu(ZqO:l8Uv48/' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpg_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
