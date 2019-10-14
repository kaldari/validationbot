<?php

require_once("../vendor/autoload.php");
require_once("../includes/WikisourceApi.php");

$api = new WikisourceApi();
$result = $api->getPageContent( "Alice's Adventures in Wonderland" );
var_dump( $result );
