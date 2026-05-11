<?php
/**
 * Wasmer-specific WordPress configuration.
 *
 * This keeps LocalWP settings in wp-config.php untouched while letting the
 * Wasmer deployment read its database and host settings from Edge env vars.
 */

function ea_wasmer_env( array $keys, $default = null ) {
	foreach ( $keys as $key ) {
		if ( isset( $_ENV[ $key ] ) && '' !== $_ENV[ $key ] ) {
			return $_ENV[ $key ];
		}

		if ( isset( $_SERVER[ $key ] ) && '' !== $_SERVER[ $key ] ) {
			return $_SERVER[ $key ];
		}

		$value = getenv( $key );
		if ( false !== $value && '' !== $value ) {
			return $value;
		}
	}

	return $default;
}

function ea_wasmer_bool_env( array $keys, $default = false ) {
	$value = ea_wasmer_env( $keys );

	if ( null === $value ) {
		return $default;
	}

	return filter_var( $value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE ) ?? $default;
}

$forwarded_proto = (string) ( $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '' );
$is_https        = false;

if ( '' !== $forwarded_proto ) {
	$is_https = 'https' === strtolower( trim( explode( ',', $forwarded_proto )[0] ) );
} elseif ( ! empty( $_SERVER['HTTPS'] ) && 'off' !== strtolower( (string) $_SERVER['HTTPS'] ) ) {
	$is_https = true;
} elseif ( isset( $_SERVER['SERVER_PORT'] ) && '443' === (string) $_SERVER['SERVER_PORT'] ) {
	$is_https = true;
}

if ( $is_https ) {
	$_SERVER['HTTPS'] = 'on';
}

$host = (string) ( $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? '' );
if ( '' === $host ) {
	$host = (string) ea_wasmer_env( array( 'WP_PRIMARY_DOMAIN', 'APP_DOMAIN' ), 'efficient-advt.wasmer.app' );
}

$host                  = trim( explode( ',', $host )[0] );
$_SERVER['HTTP_HOST']  = $host;
$scheme                = $is_https ? 'https' : 'http';
$default_home          = $scheme . '://' . $host;
$db_host               = (string) ea_wasmer_env( array( 'WORDPRESS_DB_HOST', 'DB_HOST' ), '127.0.0.1' );
$db_port               = ea_wasmer_env( array( 'WORDPRESS_DB_PORT', 'DB_PORT' ) );
$secret_seed           = (string) ea_wasmer_env( array( 'WP_SECRET_SEED', 'APP_SECRET_SEED', 'DB_PASSWORD', 'WORDPRESS_DB_PASSWORD' ), 'efficient-advt-wasmer' );
$secret_constants_map  = array(
	'AUTH_KEY'         => array( 'WP_AUTH_KEY', 'AUTH_KEY' ),
	'SECURE_AUTH_KEY'  => array( 'WP_SECURE_AUTH_KEY', 'SECURE_AUTH_KEY' ),
	'LOGGED_IN_KEY'    => array( 'WP_LOGGED_IN_KEY', 'LOGGED_IN_KEY' ),
	'NONCE_KEY'        => array( 'WP_NONCE_KEY', 'NONCE_KEY' ),
	'AUTH_SALT'        => array( 'WP_AUTH_SALT', 'AUTH_SALT' ),
	'SECURE_AUTH_SALT' => array( 'WP_SECURE_AUTH_SALT', 'SECURE_AUTH_SALT' ),
	'LOGGED_IN_SALT'   => array( 'WP_LOGGED_IN_SALT', 'LOGGED_IN_SALT' ),
	'NONCE_SALT'       => array( 'WP_NONCE_SALT', 'NONCE_SALT' ),
);

if ( null !== $db_port && false === strpos( $db_host, ':' ) ) {
	$db_host .= ':' . $db_port;
}

define( 'DB_NAME', (string) ea_wasmer_env( array( 'WORDPRESS_DB_NAME', 'DB_NAME' ), 'database_name_here' ) );
define( 'DB_USER', (string) ea_wasmer_env( array( 'WORDPRESS_DB_USER', 'DB_USERNAME', 'DB_USER' ), 'username_here' ) );
define( 'DB_PASSWORD', (string) ea_wasmer_env( array( 'WORDPRESS_DB_PASSWORD', 'DB_PASSWORD' ), 'password_here' ) );
define( 'DB_HOST', $db_host );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

foreach ( $secret_constants_map as $constant => $env_keys ) {
	define(
		$constant,
		(string) ea_wasmer_env(
			$env_keys,
			hash( 'sha256', $constant . '|' . $secret_seed )
		)
	);
}

define( 'WP_HOME', rtrim( (string) ea_wasmer_env( array( 'WP_HOME' ), $default_home ), '/' ) );
define( 'WP_SITEURL', rtrim( (string) ea_wasmer_env( array( 'WP_SITEURL' ), $default_home ), '/' ) );

$table_prefix = 'wp_';

define( 'WP_DEBUG', ea_wasmer_bool_env( array( 'WP_DEBUG' ), false ) );
define( 'WP_ENVIRONMENT_TYPE', (string) ea_wasmer_env( array( 'WP_ENVIRONMENT_TYPE' ), 'production' ) );
define( 'FORCE_SSL_ADMIN', true );
define( 'WP_DEBUG_LOG', ea_wasmer_bool_env( array( 'WP_DEBUG_LOG' ), false ) );
define( 'WP_DEBUG_DISPLAY', ea_wasmer_bool_env( array( 'WP_DEBUG_DISPLAY' ), false ) );
define( 'WP_AUTO_UPDATE_CORE', (string) ea_wasmer_env( array( 'WP_AUTO_UPDATE_CORE' ), 'minor' ) );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
