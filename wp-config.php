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
define( 'DB_NAME', 'narmadaone' );

/** Database username */
define( 'DB_USER', 'admin123' );

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
define( 'AUTH_KEY',         'V[}^SJ?5RuhT_(FM9+[qC=D`hg52-Q^Q<b,}&6UZOdVA,U3fbK>-7S-x~xNfeBJ7' );
define( 'SECURE_AUTH_KEY',  '@(j?YpnBKp`lI__D:ik6gko$n1h;Rlr3C DrI#&,# jQ$4Y *!Q<x KZ ?M~XKgh' );
define( 'LOGGED_IN_KEY',    '$T?L6^7ZGjgY.AerwSa[4omp=~?>6fkvrma9 QU>J6X?$0@2yseOuaH8#<WgvR!s' );
define( 'NONCE_KEY',        ')Hy~0J8aH)3%we{Pa+X{XUlW]Ere;^v6}nN%%#[n:#}uY-Y$3P#BpWlj~?R9z,:`' );
define( 'AUTH_SALT',        '^31`dNW4cYe%]:8g:6<F!;4*VpD[F1L7hCNXe*qYcMIkUqyc%.*J^@34-xbGj6nl' );
define( 'SECURE_AUTH_SALT', 'zg]0@D}p<xDPP!X4XqoV5e6l^4iv}:8K!z{Yj}kc$4[y7/kc$?z/EM|$n1 6uHC=' );
define( 'LOGGED_IN_SALT',   'ZETxA%I?F](H(@g< dCP&fLR7=&~^=Qja1=9bvQx4@L#/J_ bttqaFN)l^Kr^/K&' );
define( 'NONCE_SALT',       '/<VIJef)h7EkKW1D{p]+(wQ,}R_-kOU:{]y[^R):IY,Jqj>!I[)zR<-u$~EQJfAj' );

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
