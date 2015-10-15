<?php

include 'config.php';
include 'http.php';

$r = http_get(COUCHDB.'/_all_dbs');
$names=[];
foreach($r as $db) {
  if(!preg_match("/^_/",$db) && !preg_match('/_history$/',$db)) {
  $names[] = $db;
  }
}

$names = array_unique($names);
sort($names);
header("Content-Type: application/json");
echo json_encode($names);

