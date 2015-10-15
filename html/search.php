<?php

include 'config.php';
include 'http.php';

header("Content-Type: application/json");
echo json_encode(search(ELASTICSEARCH,$_GET['src'],$_GET["type"],$_GET["query"]));

