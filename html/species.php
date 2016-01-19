<?php

include 'get_species.php';

$db = trim($_GET["db"]);
$family = trim($_GET["family"]);

$names = get_species($db, $family);

header("Content-Type: application/json");
echo json_encode($names);
