<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'vJ KWgS^n|=K#L fK4_lrqzLYK%p7Q}g>`{,s(k{6dV_b1&64hM#Moi{.rhHKI#L');
define('SECURE_AUTH_KEY',  '&i=ym&uf?/.g6,+e:Ov!-4X3h{dN_(%Bf#xHrma$.^P8}Z[z&w#6;)f NmCcB>)Z');
define('LOGGED_IN_KEY',    'ZStb4dKZOi( M_|qQXFdP[LFmZ~n|eZr/jaYcvtaTkh+tM&PZ]gIT,(Si>S+]}Y)');
define('NONCE_KEY',        '?D][%pkR(hGq.4;%Jdefctw9:3*hUAnj,_;W>*:??TaYr0K,u@)nD<:%4|D~E. e');
define('AUTH_SALT',        '}yl,,xm3hO]pk]}]^Cm>}Wr4bO-tDa({8i6qvpR/DTHeeOa?p|*i4$w=[Tv} <><');
define('SECURE_AUTH_SALT', '#BMc9P_+i5*=elDV.|K7t{Z@3jd.U3+l3~+@G 0xe]AvK7tBNG<H,MgiQ#GamC3s');
define('LOGGED_IN_SALT',   'bU<5O/WUhu!*ld[%8A]fan*l.E!Q-a^hlJ,l4dM;Dt[g+3uC534t&3W ?1tBn<LR');
define('NONCE_SALT',       'u_V[AHsPXCe_i/{XJtzzT x+{9<4G%*%Iu`[G4[_Goeu95.c;CTmHt-5iw?:^DL<');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
