<?php


$public_key = env('MARVEL_API_PUBLIC_KEY');
$private_key = env('MARVEL_API_PRIVATE_KEY');

$url = "http://gateway.marvel.com/v1/public/characters?";

$ts = strval(time());
$hash = md5($ts . $private_key . $public_key);
$getdata = http_build_query(
array(
    'ts' => $ts,
    'apikey' => $public_key,
     'hash'=>$hash,
      'name'=>"Spider-Man"
 )
);

$json = json_decode(file_get_contents($url . $getdata), true);
echo $json['attributionText'];
echo ("<br>");
$results = $json['data']['results'][0];
echo $results['name'];
echo ("<br>");
echo $results['description'];
echo ("<img src='" . $results['thumbnail']['path'] . "." . $results['thumbnail']['extension'] . "' />");
?>