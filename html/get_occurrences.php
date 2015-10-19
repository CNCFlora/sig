<?php

include_once 'config.php';
include_once 'http.php';

function get_occurrences($es, $db, $spp) {
    $synonyms = search($es,$db,"taxon","acceptedNameUsage:\"".$spp."*\" AND taxonomicStatus:\"synonym\"");

    $q = "acceptedNameUsage:\"$spp*\" OR scientificName:\"$spp*\" OR scientificNameWithoutAuthorship: \"$spp*\"";
    foreach($synonyms as $syn) {
        $spp_syn = $syn->scientificNameWithoutAuthorship;
        $q .= " OR acceptedNameUsage:\"$spp_syn*\" OR scientificName:\"$spp_syn*\" OR scientificNameWithoutAuthorship:\"$spp_syn*\"";
        $spp_syn = $syn->scientificName;
        $q .= " OR acceptedNameUsage:\"$spp_syn*\" OR scientificName:\"$spp_syn*\" OR scientificNameWithoutAuthorship:\"$spp_syn*\"";
    }
    $docs = [];

    $hits = search_post(ELASTICSEARCH,$db,'occurrence',$q);
    foreach($hits as $hit){
        unset($hit->_rev);
        $docs[]=$hit;
    }

    return $docs;
}
?>
