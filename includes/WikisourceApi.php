<?php

use \Mediawiki\Api\MediawikiApi;
use \Mediawiki\Api\SimpleRequest;

class WikisourceApi {

	private $api;

	public function __construct() {
		$this->api = MediawikiApi::newFromApiEndpoint( 'https://en.wikisource.org/w/api.php' );
	}

	public function getPageContent( $title ) {
		try {
    	$queryResponse = $this->api->getRequest( new SimpleRequest( 'query', [ 'titles' => $title, 'prop' => 'revisions', 'rvprop' => 'content', 'rvlimit' => 1, 'formatversion' => 2 ] ) );
		}
		catch ( Exception $e ) {
			throw new Exception( "The api returned an error" );
		}
		if ( isset( $queryResponse['query']['pages'][0]['revisions'][0]['content'] ) ) {
			return $queryResponse['query']['pages'][0]['revisions'][0]['content'];
		} else {
			return null;
		}
	}

	public function getPageDestination( $title ) {
		try {
    	$queryResponse = $this->api->getRequest( new SimpleRequest( 'query', [ 'titles' => $title, 'prop' => 'revisions', 'formatversion' => 2, 'redirects' => 1 ] ) );
		}
		catch ( Exception $e ) {
			throw new Exception( "The api returned an error" );
		}
		if ( isset( $queryResponse['query']['redirects'][0]['to'] ) ) {
			return $queryResponse['query']['redirects'][0]['to'];
		} else {
			return $title;
		}
	}

}
