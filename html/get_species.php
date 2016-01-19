<?php

include_once 'config.php';
include_once 'http.php';

function get_species($db, $family){
    $result = search(ELASTICSEARCH,$db,'taxon',"family:\"".$family."\" AND taxonomicStatus:\"accepted\"");
    $names=[];
    foreach($result as $taxon) {
      $names[] = trim($taxon->scientificNameWithoutAuthorship);
    }

    $names = array_unique($names);
    sort($names);
    return $names;
}
?>
