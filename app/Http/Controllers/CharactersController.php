<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CharactersController extends Controller
{
    public function get_char() {
        $name = request()->name;
        $public_key = env('MARVEL_API_PUBLIC_KEY');
        $private_key = env('MARVEL_API_PRIVATE_KEY');
        $url = "http://gateway.marvel.com/v1/public/characters?";
        $ts = strval(time());
        $hash = md5($ts . $private_key . $public_key);
  
        $character = \App\Character::where('name', '=', $name)->first();
        // set headers depending on whether etag / cached is available
            if (!$character or !$character->etag) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET"
                 )
             );
           
        } else {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"If-None-Match:" . $character->etag
                )
            );
        }

        /////// get data from api
        // create context for headers (needed for etag)
        $context = stream_context_create($opts);

        $getdata = http_build_query(
            array(
                'ts' => $ts,
                'apikey' => $public_key,
                'hash'=>$hash,
                'name'=>$name,
            )
        );
        
        $json = json_decode(file_get_contents($url . $getdata, false, $context), true);
        if ($json) {
            // create new character if it doesn't exist (otherwise)
            if (!$character) {
                $character = new \App\Character();
            }
            $character->id = $json['data']['results'][0]['id'];
            $character->name = $json['data']['results'][0]['name'];
            $character->description = $json['data']['results'][0]['description'];
            $image_url = $json['data']['results'][0]['thumbnail']['path'] . "." . $json['data']['results'][0]['thumbnail']['extension'];
            $character->thumbnail = $image_url;
            $character->etag = $json['etag'];
            $character->attribution = $json['attributionText'];
            $character->save();



            // add character-comics if neccesary
            foreach ($json['data']['results'][0]['comics']['items'] as $comic) {
                // get id from uri
                $comic_uri_array = explode("/",$comic['resourceURI']);
                $comic_id = end($comic_uri_array);
                
                $character_comic = \App\CharacterComic::where('character_id', $character->id)->where('comic_id', $comic_id)->first();

                if (!$character_comic) {
                    $character_comic = new \App\CharacterComic;
                    $character_comic->character_id = $character->id;
                    $character_comic->comic_id = $comic_id;
                    $character_comic->save();
                }

                $comic_item = \App\Comic::find($comic_id);
                if (!$comic_item) {
                        $comic_item = new \App\Comic;
                        $comic_item->id = $comic_id;
                        $comic_item->name = $comic['name'];
                        $comic_item->save();
                }
            }
        }
    
        
        




        // return view ('marvel');
        //$results = $json['data']['results'][0];
        return view('character',compact('character'));
        // echo $json['attributionText'];
        // echo ("<br>");
        // $results = $json['data']['results'][0];
        // echo $results['name'];
        // echo ("<br>");
        // echo $results['description'];
        // echo ("<img src='" . $results['thumbnail']['path'] . "." . $results['thumbnail']['extension'] . "' />");


    }
}
