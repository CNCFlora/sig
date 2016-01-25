<?php

include 'config.php';
include 'http.php';
include 'get_occurrences.php';
include 'save.php';
include 'get_species.php';

session_start();
$whole_src = false;
$src = $_POST["src"];
$family = $_POST["family"];
if (isset($_POST["spp"])){
    $spp = trim( $_POST["spp"] );
}

//if(strlen( $src ) <= 3 || strlen($family) <= 3) {
if(strlen( $src ) <= 3) {
    $msg_alerta = "Nada selecionado";
    $_SESSION['msg_alerta'] = $msg_alerta;
    session_write_close();
    header("Location: index.php");
  return;
}
// Add the official family name to array (not the one in the occurrence)
$family_spp = array();

if (is_array(json_decode($family))){
    $family = json_decode($family);
    $name = $src;
    $spp = array();
    foreach ($family as $family_item){
        $spp_fam = get_species($src, $family_item);
        $spp = array_merge($spp, $spp_fam);
        $family_array = array_fill(0, sizeof($spp_fam), $family_item);
        $family_spp = array_merge($family_spp, $family_array);
    }
} elseif (is_array(json_decode($spp))){
    $spp = json_decode($spp);
    $family_spp = array_fill(0, sizeof($spp), $family);
    $name = $family;
}
else {
    $name = $family."_".$spp;
    $spp = array($spp);
    array_push($family_spp, $family);
}
$name = str_replace(" ","_",str_replace("-","_",$name));


$data = [];
$msg_alerta = "";
$msg_warning = "";
$csv_array = array();
$can_download = true;
$fields = ["occurrenceID", "specieID","family", "acceptedNameUsage", "institutionCode",
    "collectionCode", "catalogNumber", "recordedBy", "recordNumber", "year",
    "month", "day", "stateProvince", "municipality", "locality",
    "decimalLongitude", "decimalLatitude", "coordinateUncertaintyInMeters",
    "georeferenceProtocol"];

$precisions_allowed=[
  "1 a 5 km",
  "250 a 1000 m",
  "5 a 10 km",
  "centroide de municipio",
  "centroide de uc",
  "0 a 250 m",
  "10 a 50 km",
  "50 a 100 km",
  "",
  "1 a 10 km"];

foreach ($spp as $index=>$specie){
    //print_r($index);
    //print_r($specie);
    //print_r($family_spp[$index]);
    // Get occurrence
    $occurrences = get_occurrences(ELASTICSEARCH, $src, $specie);
    // Record per specie
    $data[$specie]= new StdClass;
    $data[$specie]->acceptedNameUsage = $specie;
    //$data[$specie]->family = $family;
    $data[$specie]->family = $family_spp[$index];
    $data[$specie]->total = 0;
    $data[$specie]->valid = 0;
    $data[$specie]->invalid = 0;
    $data[$specie]->validated = 0;
    $data[$specie]->not_validated = 0;
    $data[$specie]->sig_ok = 0;
    $data[$specie]->sig_nok = 0;
    $data[$specie]->no_sig = 0;
    $data[$specie]->used = 0;
    $data[$specie]->unused = 0;
    $data[$specie]->precision_ok=0;
    $data[$specie]->precision_nok=0;
    $row = [];
    $d = $data[$specie];
    //Record per occurrence
    foreach($occurrences as $doc) {
        $doc->specieID = strtoupper( $family_spp[$index] )."_".str_Replace(" ","_",str_replace("-","_",$specie));
        $occ = [];
        if(isset($doc->georeferenceVerificationStatus)) {
            if($doc->georeferenceVerificationStatus == "1" || $doc->georeferenceVerificationStatus == "ok") {
                $doc->georeferenceVerificationStatus = "ok";
                $d->sig_ok++;

                $f='coordinateUncertaintyInMeters';
                if(!isset($doc->$f) || is_null($doc->$f) || in_array($doc->$f,$precisions_allowed)) {
                  $d->precision_ok++;
                } else {
                  $d->precision_nok++;
                }
            } else {
                $d->sig_nok++;
                $doc->valid = 'false';

            }
        } else {
            $d->no_sig++;
            $doc->georeferenceVerificationStatus = '';
            $doc->valid = "";
        }

        // Recorte Pan Bacia Alto Tocantins has verbatimValidation field
        // instead of validation
        if (isset($doc->verbatimValidation) && !isset($doc->validation)) {
            $doc->validation = $doc->verbatimValidation;
        }

        if(isset($doc->validation) && (!isset($doc->valid))) {
            if(is_object($doc->validation)) {
                if(isset($doc->validation->status)) {
                    if($doc->validation->status == "valid") {
                        $doc->valid="true";
                    } else if($doc->validation->status == "invalid") {
                        $doc->valid="false";
                    } else {
                        $doc->valid="";
                    }
                } else {
                    if (array_key_exists("taxonomy", $doc->validation)){
                        if(
                            (
                                $doc->validation->taxonomy == null
                                || $doc->validation->taxonomy == 'valid'
                            )
                            &&
                            (
                                $doc->validation->georeference == null
                                || $doc->validation->georeference == 'valid'
                            )
                            &&
                            (
                                !isset($doc->validation->native)
                                || $doc->validation->native != 'non-native'
                            )
                            &&
                            (
                                !isset($doc->validation->presence)
                                || $doc->validation->presence != 'absent'
                            )
                            &&
                            (
                                !isset($doc->validation->cultivated)
                                || $doc->validation->cultivated != 'yes'
                            )
                            &&
                            (
                                !isset($doc->validation->duplicated)
                                || $doc->validation->duplicated != 'yes'
                            )
                        ) {
                            $doc->valid="true";
                        } else {
                            $doc->valid="false";
                        }
                    } else { $doc->valid = ""; }
                }
            } else {
                $doc->valid = "";
            }
        } else {
            if (!isset($doc->valid)) {
                $doc->valid = "";

            }
        }

        if($doc->valid == 'true') {
            $d->valid++;
            $d->validated++;
        } else if($doc->valid == 'false') {
            $d->invalid++;
            $d->validated++;
        } else {
            $d->not_validated++;
        }

        if($doc->valid == 'true' && $doc->georeferenceVerificationStatus == 'ok') {
            $d->used++;
            foreach($fields as $f) {
                //Hack because some occurrences don't have the correct
                //acceptedNameUsage, although they have scientificName
                //pointing to the correct specie. Always use the searched
                //specie name
                if ($f == 'acceptedNameUsage') {
                        $doc->$f = $specie;
                }
                if(isset($doc->$f)) {
                    // Keep family uppercase
                    if ($f == 'family') {
                        $doc->$f = strtoupper($doc->$f);
                    }
                    //if ($f == 'decimalLatitude' || $f == 'decimalLongitude') {
                        //$doc->$f = number_format($doc->$f, 6);
                    //}
                    $occ[] = str_replace(";", " ", $doc->$f);
                } else {
                    $occ[] = "";
                }
            }
            $row[] = $occ;
        } else {
            $d->unused++;
        }
    }
    // If there is still any occurrence not validated for that specie,
    // can't download CSV
    if ($d->not_validated > 0) {
        $occ_miss = $d->not_validated;
        $msg_alerta = $msg_alerta."Espécie <b>$specie</b> ainda não foi inteiramente validada. Falta(m) <b>$occ_miss</b> registro(s) de ocorrência.<br>";
        $can_download = false;
    }
    elseif (count($occurrences) == 0) {
        $msg_warning = $msg_warning."Não foram encontradas ocorrências para a espécie <b>$specie</b>.<br>";
    }
    elseif ($d->valid == 0 && $d->invalid > 0) {
        $msg_warning = $msg_warning."Todas as ocorrências para a espécie <b>$specie</b> são inválidas.<br>";
    }
    elseif ($d->precision_nok > 0) {
        $occ_precision = $d->precision_nok;
        $msg_alerta = $msg_alerta."Espécie <b>$specie</b> possui <b>$occ_precision</b> ocorrência(s) com precisão fora do padrão.<br />";
        $can_download = false;
    }
    else {
        $csv_array = array_merge($csv_array, $row);
    }
}

if ($can_download && count($csv_array) > 0) {
    //Add header as first row
    $columns = ["id","specieID", "family", "specie", "inst_code", "col_code", "catalog_n",
        "recordedby", "record_n", "year", "month", "day", "state", "city",
        "locality", "longitude", "latitude", "precision", "protocol"];
    array_unshift($csv_array, $columns);
    //convert_to_csv($csv_array, "sig_$name.csv", ',');
    convert_to_csv($csv_array, "sig_$name.csv", ';');
} else {
    $_SESSION['msg_alerta'] = $msg_alerta;
    $_SESSION['msg_warning'] = $msg_warning;
    session_write_close();
    header("Location: index.php");
}
