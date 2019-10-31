<?php

require_once("../vendor/autoload.php");
require_once("../includes/WikisourceApi.php");
require_once("./pages.php");

$api = new WikisourceApi();
$x = 1;

foreach ( $pages as $indexTitle ) {
	$indexTitle = "Index:" . $indexTitle;
	if ( $x < 4000 ) {
		$pageContents = $api->getPageContent( $indexTitle );
		if ( preg_match( "/{{[iI]ndex validated date\|.+\|transcluded=yes}}/", $pageContents ) ||
			preg_match( "/{{[iI]ndex validated date\|.+\|transcluded=notadv}}/", $pageContents ) ||
			preg_match( "/{{[iI]ndex validated date\|.+\|yes}}/", $pageContents ) ||
			preg_match( "/{{[iI]ndex validated date\|.+\|notadv}}/", $pageContents )
		) {
			preg_match( "/\|Title='?'?\[\[(.+)\]\]/", $pageContents, $matches );
			if ( !empty( $matches ) ) {
				$transcludedTitle = $matches[1];
				if ( strpos ( $transcludedTitle, "]]" ) !== false ) {
					echo "Malformed link: " . $indexTitle . "\n";
				} else {
					// Account for piped links
					$pieces = explode( "|", $transcludedTitle, 2 );
					$transcludedTitle = $pieces[0];
					echo $transcludedTitle . "\n";
				}
			} else {
				echo "No title detected: " . $indexTitle . "\n";
			}
		} else {
			echo "Not transcluded: " . $indexTitle . "\n";
		}
	}
	$x++;
	sleep( 1 );
}
