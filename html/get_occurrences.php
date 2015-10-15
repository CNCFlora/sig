<?php

include_once 'config.php';
include_once 'http.php';

function get_occurrences($es, $db, $spp) {
    $synonyms = search($es,$db,"taxon","acceptedNameUsage:\"".$spp."*\" AND taxonomicStatus:\"synonym\"");

    $q = '"'.$spp.'*" ';
    foreach($synonyms as $syn) {
        $q .= " OR \"".$syn->scientificNameWithoutAuthorship."*\"";
    }
    $docs = [];

    $hits = search(ELASTICSEARCH,$db,'occurrence',$q);
    foreach($hits as $hit){
        unset($hit->_rev);
        $docs[]=$hit;
    }

    return $docs;
}
?>
