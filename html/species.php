<?php

include 'config.php';
include 'http.php';

$db = trim($_GET["db"]);
$family = trim($_GET["family"]);

$result = search(ELASTICSEARCH,$db,'taxon',"family:\"".$family."\" AND taxonomicStatus:\"accepted\"");
$names=[];
foreach($result as $taxon) {
  $names[] = trim($taxon->scientificNameWithoutAuthorship);
}

$names = array_unique($names);
sort($names);
header("Content-Type: application/json");
echo json_encode($names);

