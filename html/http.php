<?php

function http_get($url) {
  return json_decode(file_get_contents($url));
}

function http_post($url,$doc) {
  $opts = ['http'=>['method'=>'POST','content'=>json_encode($doc),'header'=>'Content-type: application/json']];
  $r = file_get_contents($url, NULL, stream_context_create($opts));
  return json_decode($r);
}

function http_put($url,$doc) {
  $opts = ['http'=>['method'=>'PUT','content'=>json_encode($doc),'header'=>'Content-type: application/json']];
  $r = file_get_contents($url, NULL, stream_context_create($opts));
  return json_decode($r);
}

function http_delete($url) {
  $opts = ['http'=>['method'=>'DELETE']];
  $r = file_get_contents($url, NULL, stream_context_create($opts));
  return json_decode($r);
}

function search($es,$db,$idx,$q) {
  $q = str_replace("=",":",$q);
  $url = $es.'/'.$db.'/'.$idx.'/_search?size=9999&q='.rawurlencode($q);
  $r = http_get($url);
  $arr =array();
  $ids = [];
  foreach($r->hits->hits as $hit) {
      $doc = $hit->_source;
      if(isset($doc->id) && !isset($doc->_id)) {
        $doc->_id = $doc->id;
        unset($doc->id);
      }
      if(isset($doc->rev) && !isset($doc->_rev)) {
        $doc->_rev = $doc->rev;
        unset($doc->rev);
      }
      $arr[] = $doc;
  }

  return $arr;
}

function search_post($es,$db,$idx,$q) {
  $q = str_replace("=",":",$q);
  $url = $es.'/'.$db.'/'.$idx.'/_search';
  $doc = array("query"=>array("query_string"=>array("query"=>$q)),
               "size"=>9999);
  $r = http_post($url, $doc);
  $arr =array();
  $ids = [];
  foreach($r->hits->hits as $hit) {
      $doc = $hit->_source;
      if(isset($doc->id) && !isset($doc->_id)) {
        $doc->_id = $doc->id;
        unset($doc->id);
      }
      if(isset($doc->rev) && !isset($doc->_rev)) {
        $doc->_rev = $doc->rev;
        unset($doc->rev);
      }
      $arr[] = $doc;
  }

  return $arr;
}

