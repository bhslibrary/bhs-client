<?php

namespace BHS\Client;

class APIClient {
	protected $api_base = 'http://assets.brooklynhistory.org/wp-json/bhs/v1/';

	public function __construct() {
		if ( defined( 'BHS_API_BASE' ) ) {
			$this->api_base = trailingslashit( BHS_API_BASE );
		}
	}

	/**
	 * Fetch by an identifier.
	 *
	 * Assumes the BHS URL base.
	 */
	public function fetch_by_identifier( $identifier ) {
		$url = $this->api_base . 'record/' . urlencode( $identifier );
		$result = wp_remote_get( $url );
		$status = wp_remote_retrieve_response_code( $result );

		if ( 200 != $status ) {
			return new \WP_Error( 'bhsc_no_remote_record_found', __( 'No remote record found by that identifier', 'bhs-client' ), $identifier );
		}

		$body = json_decode( wp_remote_retrieve_body( $result ) );
		return $body;
	}
}