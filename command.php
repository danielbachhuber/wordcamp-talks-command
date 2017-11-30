<?php

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

/**
 * Count how many times a given topic was presented at a WordCamp.
 *
 * ## OPTIONS
 *
 * <topic>
 * : Topic to search for.
 *
 * [--year=<year>]
 * : Limit results to a specific year. Defaults to current year.
 *
 * @when before_wp_load
 */
WP_CLI::add_command( 'wordcamp-talks', function( $args, $assoc_args ){
	
});
