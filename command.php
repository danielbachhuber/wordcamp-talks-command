<?php

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

use WP_CLI\Utils;

/**
 * Counts how many times a given topic was presented at a WordCamp.
 *
 * Uses the WordCamp Central REST API to fetch a list of all WordCamps, and then
 * searches a given topic against the sessions endpoint for WordCamp.
 *
 * ```
 * $ wp wordcamp-talks 'WP-CLI' --year=2017
 * Generating camp URL list...
 * [...]
 * https://2017.jackson.wordcamp.org : 1
 * - AJ Morris: Getting started with WP-CLI, a command-line tool to automate your life
 * [...]
 * Total camps for year specified: 120
 * Camps with WP-CLI talks: 36
 * Total talks (some camps may have multiple): 48
 * ```
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

	list( $topic ) = $args;
	$year = isset( $assoc_args['year'] ) ? $assoc_args['year'] : date( 'Y' );

	$get_all_camp_urls = function() {
		$request_url = 'https://central.wordcamp.org/wp-json/wp/v2/wordcamps?status=wcpt-closed&per_page=100';
		$camp_urls = array();
		do {
			$response = Utils\http_request( 'GET', $request_url );
			$camps = json_decode( $response->body, true );
			$camp_urls = array_merge( $camp_urls, array_column( $camps, 'URL' ) );
			$request_url = false;
			if ( ! empty( $response->headers['link'] ) ) {
				$links = explode( ', ', $response->headers['link'] );
				$hrefandrel = explode( '; ', array_pop( $links ) );
				$href = trim( $hrefandrel[0], '<>' );
				if ( 'rel="next"' === $hrefandrel[1] ) {
					$request_url = rawurldecode( $href );
				}
			}
		} while( $request_url );
		return $camp_urls;
	};

	WP_CLI::log( 'Generating camp URL list...' );
	$camp_urls = $get_all_camp_urls();

	foreach( $camp_urls as $i => $camp_url ) {
		if ( false === stripos( $camp_url, $year ) ) {
			unset( $camp_urls[ $i ] );
		}
	}

	WP_CLI::log( 'Searching sessions for each camp...' );
	$camps_with_talks = array();
	$total_talks = 0;
	foreach( $camp_urls as $camp_url ) {
		$request_url = $camp_url . '/wp-json/wp/v2/sessions?_embed&search=' . $topic;
		$response = Utils\http_request( 'GET', $request_url );
		WP_CLI::log( $camp_url . ' : ' . $response->headers['x-wp-total'] );
		if ( ! empty( $response->headers['x-wp-total'] ) ) {
			$camps_with_talks[ $camp_url ] = (int) $response->headers['x-wp-total'];
			$total_talks += $response->headers['x-wp-total'];
			$talks = json_decode( $response->body, true );
			foreach( $talks as $talk ) {
				$author = ! empty( $talk['_embedded']['speakers'][0] ) ? $talk['_embedded']['speakers'][0]['title']['rendered'] : 'Unknown';
				WP_CLI::log( ' - ' . $author . ': ' . html_entity_decode( $talk['title']['rendered'] ) );
			}
		}
	}

	WP_CLI::log( '---' );
	WP_CLI::log( 'Total camps for year specified: ' . count( $camp_urls ) );
	WP_CLI::log( 'Camps with WP-CLI talks: ' . count( $camps_with_talks ) );
	WP_CLI::log( 'Total talks (some camps may have multiple): ' . $total_talks );
});
