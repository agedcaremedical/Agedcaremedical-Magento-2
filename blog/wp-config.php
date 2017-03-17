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
define('DB_NAME', 'agedcare_liveagedcare');

/** MySQL database username */
define('DB_USER', 'agedcare_liveage');

/** MySQL database password */
define('DB_PASSWORD', 'FreerOresAssignHaunch57');

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
define('AUTH_KEY',         'AA>|dJ.b})O>R2_p2i6,P74ATa+0rv>~}2lxhp%~eve,=BOKT26tzZfL4u`|6/C ');
define('SECURE_AUTH_KEY',  'l%wlmI<V[O_S&-wQWye>~$CRRGu]#ZiHZU/oW_@Kzv<q/%raD{rneEDmFAaefxsv');
define('LOGGED_IN_KEY',    'fc*Z,I)<.Zll!5lVRU1jz3i6KyG^4u>9K<;BZT,uv`1E{~+LwK~F<rPe~k17jpJo');
define('NONCE_KEY',        'lQ[d0Xn8ETFw9p3G0DqQLs#:^kRom9^32dbSq/os%,3m$Hgpn7^3y.O8KO,cK<1+');
define('AUTH_SALT',        '>+y+06kzULuX!?3jS>E?~kt-a:QS+{b/:y?(6`3j]a;e=hb#K$SJ^ExF!{vAGdq|');
define('SECURE_AUTH_SALT', 'ohxkyw8R.*x=(5LM&,)rB.mjid5HGPyI!13^aszYsrqmm$6Xh-Wv~ c6M)uAM;cz');
define('LOGGED_IN_SALT',   'J@>:;>t&F=my*/LA]6Gl^q$E;(N-G[<E(+)1eQ;A ]x^NqgQ{LkTz2*b8u=zoD~I');
define('NONCE_SALT',       'MU^EE+QjZhc=]NsKrks6wX2qU~N9.*LPp6#&2`<CJEY=Cum)v.OGWP;_,iIQ<myg');

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
