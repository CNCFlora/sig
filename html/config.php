<?php

include_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;
$raw = Yaml::parse(file_get_contents(__DIR__."/../config.yml"));

$env = getenv("PHP_ENV");
if($env == null) {
    $env = 'development';
}

if(isset($_SERVER) && isset($_SERVER['HTTP_HOST'])) {
    if($_SERVER['HTTP_HOST'] == 'test.localhost') {
        $env = "test";
    }
}

$data["PHP_ENV"] = $env;

$array = $raw[$env];

foreach($array as $key=>$value) {
    preg_match_all('/\$([a-zA-Z]+)/',$value,$reg);
    if(count($reg[0]) >= 1) {
      $e = getenv($reg[1][0]);
      $data[strtoupper($key)] = str_replace($reg[0][0],$e,$value);
    } else {
      $data[strtoupper($key)] = $value;
    }
}

foreach($data as $k=>$v) {
    if(!defined($k)) {
        define(strtoupper($k),$v);
    }
}

