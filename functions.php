<?php
/**
 * Common ACM functions
 */

function acm_get_cron_hash($name, $timestamp, $args, $itv) {
	return substr(md5($name.$timestamp.implode(':', $args).$itv), 0, 8);
}

function acm_get_cron_arguments($args) {

	$ret = '';

	foreach ($args as $arg) {

		$ret .= $arg.'<br />';

	}

	return $ret;
}

function acm_get_next_cron_execution($timestamp) {

	if ($timestamp - time() <= 0)
		return __('At next page refresh', 'acm');

	return __('In', 'acm').' '.human_time_diff( current_time('timestamp'), $timestamp ) . acm_get_gmt_and_local_time( $timestamp );

}

function acm_get_gmt_and_local_time( $timestamp ){

	$time_offset = get_option( 'gmt_offset' ) * 3600;
	$date_format = get_option( 'date_format' );
	$time_format = get_option( 'time_format' );
	return '<br />' . date( "{$date_format} {$time_format}", $timestamp + $time_offset ) . '<br /><small><em>GMT: ' . date( "{$date_format} {$time_format}", $timestamp ) . '</small></em>';
}

function acm_format_time( $timestamp ) {

	return '<span title="' . human_time_diff( current_time('timestamp'), $timestamp ) . ' ' . __( 'ago', 'acm' ) . '">' . acm_get_gmt_and_local_time( $timestamp ) . '</span>';

}
