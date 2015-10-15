<?php

include 'config.php';
include 'http.php';

$db = trim($_GET["db"]);

$result = search(ELASTICSEARCH,$db,'taxon',"*");
$names=[];
foreach($result as $taxon) {
  $names[] = strtoupper( trim( $taxon->family ) );
}

$names = array_unique($names);
sort($names);
header("Content-Type: application/json");
echo json_encode($names);

