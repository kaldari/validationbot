<?php

require_once("../vendor/autoload.php");
require_once("../includes/WikisourceApi.php");

$api = new WikisourceApi();
$indexTitle = "Index:The Life of the Spider.djvu";
$pageContents = $api->getPageContent( $indexTitle );
if ( preg_match( "/{{index validated date\|.+\|transcluded=yes}}/", $pageContents ) ||
	preg_match( "/{{index validated date\|.+\|transcluded=notadv}}/", $pageContents )
) {
	preg_match( "/\|Title=\[\[(.+)\]\]/", $pageContents, $matches );
	if ( !empty( $matches ) ) {
		$transcludedTitle = $matches[0];
	} else {
		echo "No title detected: " . $indexTitle . "\n";
	}
} else {
	echo "Not transcluded: " . $indexTitle . "\n";
}
