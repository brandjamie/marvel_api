<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CharactersController extends Controller
{
    // get all characters from page n
    private function get_characters_by_page($page) {
        $public_key = env('MARVEL_API_PUBLIC_KEY');
        $private_key = env('MARVEL_API_PRIVATE_KEY');
        $url = "http://gateway.marvel.com/v1/public/characters?";
        $ts = strval(time());
        $hash = md5($ts . $private_key . $public_key);
        // number of results per page
        $limit = 100;


        // get character index if in database
        $characters_index = \App\CharactersIndex::find($page);
        // set headers depending on whether etag / cached is available
        if (!$characters_index or !$characters_index->etag) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET"
                )
            );
        } else {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"If-None-Match:" . $characters_index->etag
                )
            );
        }

        // create context for headers (needed for etag)
        $context = stream_context_create($opts);
        
        $getdata = http_build_query(
            array(
                'ts' => $ts,
                'apikey' => $public_key,
                'hash'=>$hash,
                'limit'=>$limit,
                'offset'=>$page * $limit
            )
        );
        // get data from api
        $json = json_decode(file_get_contents($url . $getdata, false, $context), true);
        // if new results are recieved
        if ($json  and count($json['data']['results']) > 0) {
            // add page index for each character
            foreach ($json['data']['results'] as $result) {
                //
                $character = \App\Character::find($result['id']);
                if (!$character) {
                    $character = new \App\Character();
                    $character->id = $result['id'];
                    $character->name = $result['name'];
                }
                $character->characters_index_id = $page;
                $character->save();
            }
            $characters_index = \App\CharactersIndex::find($page);
            if (!$characters_index) {
                $characters_index = new \App\CharactersIndex();
                $characters_index->id = $page;
            }
            $characters_index->etag = $json['etag'];
            $characters_index->save();                  
        }
        return ($characters_index);
    }

    
    private function get_character_by_id($id) {
        $public_key = env('MARVEL_API_PUBLIC_KEY');
        $private_key = env('MARVEL_API_PRIVATE_KEY');
        $url = "http://gateway.marvel.com/v1/public/characters/" . $id . "?";
        $ts = strval(time());
        $hash = md5($ts . $private_key . $public_key);

        // get character if in database
        $character = \App\Character::find($id);
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

        // create context for headers (needed for etag)
        $context = stream_context_create($opts);

        $getdata = http_build_query(
            array(
                'ts' => $ts,
                'apikey' => $public_key,
                'hash'=>$hash
            )
        );
        // get data from api
        $json = json_decode(file_get_contents($url . $getdata, false, $context), true);
        // if new results are recieved
        if ($json  and count($json['data']['results']) > 0) {
            $character = $this->updateDB($json,$character);
        }
        return ($character);
    }



            
    private function get_char_by_name($name) {
        $public_key = env('MARVEL_API_PUBLIC_KEY');
        $private_key = env('MARVEL_API_PRIVATE_KEY');
        $url = "http://gateway.marvel.com/v1/public/characters?";
        $ts = strval(time());
        $hash = md5($ts . $private_key . $public_key);

        // get character if in database
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

        // create context for headers (needed for etag)
        $context = stream_context_create($opts);

        $getdata = http_build_query(
            array(
                'ts' => $ts,
                'apikey' => $public_key,
                'hash'=>$hash,
                'name'=>$name
            )
        );
        // get data from api
        $json = json_decode(file_get_contents($url . $getdata, false, $context), true);
        // if new results are recieved
        if ($json and count($json['data']['results']) > 0) {
            $character = $this->updateDB($json,$character);
        }
        return ($character);
    }


    private function add_comic($comic_id,$character_id,$comic_name) {
        // get charactercomic link if exists
        $character_comic = \App\CharacterComic::where('character_id', $character_id)->where('comic_id', $comic_id)->first();
        // create new character comic if it doesn't exist
        if (!$character_comic) {
            $character_comic = new \App\CharacterComic;
            $character_comic->character_id = $character_id;
            $character_comic->comic_id = $comic_id;
            $character_comic->save();
        }
        // check if comic exists
        $comic_item = \App\Comic::find($comic_id);
        // create comic if it doens't exist
        if (!$comic_item) {
            $comic_item = new \App\Comic;
            $comic_item->id = $comic_id;
            $comic_item->name = $comic_name;
            $comic_item->save();
                        
        }
                
    }

    private function add_event($event_id,$character_id,$event_name) {
        // get characterevent link if exists
        $character_event = \App\CharacterEvent::where('character_id', $character_id)->where('event_id', $event_id)->first();
        // create new character event if it doesn't exist
        if (!$character_event) {
            $character_event = new \App\CharacterEvent;
            $character_event->character_id = $character_id;
            $character_event->event_id = $event_id;
            $character_event->save();
        }
        // check if event exists
        $event_item = \App\Event::find($event_id);
        // create event if it doens't exist
        if (!$event_item) {
            $event_item = new \App\Event;
            $event_item->id = $event_id;
            $event_item->name = $event_name;
            $event_item->save();
                        
        }
                
    }
    private function add_story($story_id,$character_id,$story_name) {
        // get characterstory link if exists
        $character_story = \App\CharacterStory::where('character_id', $character_id)->where('story_id', $story_id)->first();
        // create new character story if it doesn't exist
        if (!$character_story) {
            $character_story = new \App\CharacterStory;
            $character_story->character_id = $character_id;
            $character_story->story_id = $story_id;
            $character_story->save();
        }
        // check if story exists
        $story_item = \App\Story::find($story_id);
        // create story if it doens't exist
        if (!$story_item) {
            $story_item = new \App\Story;
            $story_item->id = $story_id;
            $story_item->name = $story_name;
            $story_item->save();
                        
        }
                
    }

    private function updateDB($json,$character) {
        // create new character if it doesn't exist already
        if (!$character) {
            $character = new \App\Character();
        }
        // save / update data for character
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
            $this->add_comic($comic_id,$character->id,$comic['name']);
        }
        // add character-events if neccesary
        foreach ($json['data']['results'][0]['events']['items'] as $event) {
            // get id from uri
            $event_uri_array = explode("/",$event['resourceURI']);
            $event_id = end($event_uri_array);
            $this->add_event($event_id,$character->id,$event['name']);
        }
        // add character-stories if neccesary
        foreach ($json['data']['results'][0]['stories']['items'] as $story) {
            // get id from uri
            $story_uri_array = explode("/",$story['resourceURI']);
            $story_id = end($story_uri_array);
            $this->add_story($story_id,$character->id,$story['name']);
        }
        // add character-series if neccesary
        foreach ($json['data']['results'][0]['series']['items'] as $series) {
            // get id from uri
            $series_uri_array = explode("/",$series['resourceURI']);
            $series_id = end($series_uri_array);
            $this->add_series($series_id,$character->id,$series['name']);
        }
    
    
        return $character;


    }

    
    private function add_series($series_id,$character_id,$series_name) {
        // get characterseries link if exists
        $character_series = \App\CharacterSeries::where('character_id', $character_id)->where('series_id', $series_id)->first();
        // create new character series if it doesn't exist
        if (!$character_series) {
            $character_series = new \App\CharacterSeries;
            $character_series->character_id = $character_id;
            $character_series->series_id = $series_id;
            $character_series->save();
        }
        // check if series exists
        $series_item = \App\Series::find($series_id);
        // create series if it doens't exist
        if (!$series_item) {
            $series_item = new \App\Series;
            $series_item->id = $series_id;
            $series_item->name = $series_name;
            $series_item->save();
                        
        }
                
    }
    // get character from name in url
    public function show($name) {
        $data = $this->get_char_by_name($name);
        // go to characters page if data not recieved
        if ($data) {
            return view('view_item',compact('data'));
        } else {
            $data = $this->get_characters_by_page(0);
            $not_found = $name;
            return view('characters',compact('data','not_found'));
        }
    }
    // get character from post query
    public function get_character_by_name() {
        $name = request()->name;
        $data = $this->get_char_by_name($name);
        if ($data) {
        return view('view_item',compact('data'));
        } else {
            $data = $this->get_characters_by_page(0);
            $not_found = $name;
            return view('characters',compact('data','not_found'));
        }
    }

    public function get_character() {
        $id = request()->id;
        $data = $this->get_character_by_id($id);
        return view('view_item',compact('data'));
    }
    public function get_characters() {
        $page = request()->page;
        if (!$page) {
            $page = 0;
        }
        $data = $this->get_characters_by_page($page);
        return view('characters',compact('data'));
    }
}
