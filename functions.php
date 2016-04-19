<?php

/**
 * Return 8 Char Unique Hash for Cron
 *
 * The returned value is used to create a unique HTML element class
 * that is used in jQuery to locate and identify specific crons.
 *
 *
 * @since @@version
 *
 * @param $name
 * @param $timestamp
 * @param $args
 * @param $itv
 *
 * @return string
 */
function acm_get_cron_hash( $name, $timestamp, $args, $itv) {
	$args = acm_get_hash_from_args( $args );
	return substr(md5($name.$timestamp.$args.$itv), 0, 8);
}

/**
 * Return Args from HTML Friendly Hash
 *
 *
 * @since @@version
 *
 * @param   string   $hash
 *
 * @return  array|string
 */
function acm_get_args_from_hash( $hash ){

	$hash_bin = hex2bin( $hash );
	$args = maybe_unserialize( $hash_bin );

	return $args;
}

/**
 * Return HTML Friendly Hash from Args
 *
 *
 * @since @@version
 *
 * @param   array|string    $args
 * @return  string
 */
function acm_get_hash_from_args( $args ){

	$serialized_args = maybe_serialize( $args );
	$hash = bin2hex( $serialized_args );

	return $hash;
}

/**
 * Format and Return HTML Friendly Args Output
 *
 *
 * @since @@version
 *
 * @param $args
 *
 * @return string
 */
function acm_get_cron_arguments( $args) {

	$ret = '';

	foreach ($args as $arg) {

		if( is_array( $arg ) ){
			$ret .= print_r( $arg, TRUE ) . '<br />';
		} else {
			$ret .= $arg . '<br />';
		}

	}

	return $ret;
}

/**
 * Get next cron execution based on timestamp
 *
 *
 * @since @@version
 *
 * @param $timestamp
 *
 * @return mixed|string|void
 */
function acm_get_next_cron_execution( $timestamp) {

	if ($timestamp - time() <= 0)
		return __('At next page refresh', 'acm');
	
	$time_offset = get_option( 'gmt_offset' ) * 3600;

	return __('In', 'acm').' '.human_time_diff( current_time('timestamp'), $timestamp + $time_offset ) . acm_get_gmt_and_local_time( $timestamp );

}

/**
 * Format Timestamp into GMT and Local Timestamps
 *
 *
 * @since @@version
 *
 * @param $timestamp
 *
 * @return string
 */
function acm_get_gmt_and_local_time( $timestamp ){

	$time_offset = get_option( 'gmt_offset' ) * 3600;
	$date_format = get_option( 'date_format' );
	$time_format = get_option( 'time_format' );
	return '<br />' . date( "{$date_format} {$time_format}", $timestamp + $time_offset ) . '<br /><small><em>GMT: ' . date( "{$date_format} {$time_format}", $timestamp ) . '</small></em>';
}

/**
 * Format Timestamp for Output
 *
 *
 * @since @@version
 *
 * @param $timestamp
 *
 * @return string
 */
function acm_format_time( $timestamp ) {

	return '<span title="' . human_time_diff( current_time('timestamp'), $timestamp ) . ' ' . __( 'ago', 'acm' ) . '">' . acm_get_gmt_and_local_time( $timestamp ) . '</span>';

}

if( ! function_exists( 'hex2bin' ) ) {
	/**
	 * PHP <5.4 hex2bin Compatibility Function
	 *
	 *
	 * @since @@version
	 *
	 * @param $str
	 *
	 * @return string
	 */
	function hex2bin( $str ) {

		$sbin = "";
		$len  = strlen( $str );
		for( $i = 0; $i < $len; $i += 2 ) {
			$sbin .= pack( "H*", substr( $str, $i, 2 ) );
		}

		return $sbin;
	}
}