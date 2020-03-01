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
define('DB_NAME', 'collin_fannin');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost:8889');

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
define('AUTH_KEY',         '|me:)!wFMqpr@~HIg25sSES<9B]7RhN@G-+Wy$+JBOSL]hKe#)MpC88POz,2 k&!');
define('SECURE_AUTH_KEY',  'W2a]iA89(a.5^&@z?<Y~;u<|+`uA52C1-/xMH9T^Ce@qc@Fpt.7d9&=-;G8jZrgS');
define('LOGGED_IN_KEY',    '@[6G4`ck@<0rCgQ!}(x5+JM3|ujRjEO13R#u_D)l%4l%+LIcVEh2G+RXvI02}=Av');
define('NONCE_KEY',        'NT+8{?d9VTV&+!>pO97c3M&:Q.cQ4>tz606-_5N|#Dvb-8?iaZpe=1,qH,K![^~,');
define('AUTH_SALT',        'o![I/MZAvK6!lqOWT1O5e|s{+8bVJe-4gt5D^{%n[7Xr64()B7AE:dBDU;>L=&Dl');
define('SECURE_AUTH_SALT', '*q(7?A[7g<;!|M1B4meBx1`R78I5hqs+FJd5=<U9/cK]:|-=KE&7.ki/;W25Er@)');
define('LOGGED_IN_SALT',   'AR=]M+C(?|d..]ltsmZ3SwW jI,wIQzG?Z$6<-D$s)KGkax{V{(Szz)Ut`7< b=Q');
define('NONCE_SALT',       'gO-hBu!NQl{|+,-m j{EZ5)->*L+Yjz0sbv&a)]{#U=1fX>q$,}#{@qi |P^8Tpz');

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
