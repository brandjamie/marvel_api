<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComicsController extends Controller
{
    private function get_comic_by_id($id) {
        $public_key = env('MARVEL_API_PUBLIC_KEY');
        $private_key = env('MARVEL_API_PRIVATE_KEY');
        $url = "http://gateway.marvel.com/v1/public/comics/" . $id . "?";
        $ts = strval(time());
        $hash = md5($ts . $private_key . $public_key);

        // get comic if in database
        $comic = \App\Comic::find($id);
        // set headers depending on whether etag / cached is available
        if (!$comic or !$comic->etag) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET"
                )
            );
        } else {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"If-None-Match:" . $comic->etag
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
        if ($json) {
            // create new comic if it doesn't exist already
            if (!$comic) {
                $comic = new \App\Comic();
            }
            // save / update data for comic
            $comic->id = $json['data']['results'][0]['id'];
            $comic->name = $json['data']['results'][0]['title'];
            $comic->description = $json['data']['results'][0]['description'];
            $image_url = $json['data']['results'][0]['thumbnail']['path'] . "." . $json['data']['results'][0]['thumbnail']['extension'];
            $comic->thumbnail = $image_url;
            $comic->etag = $json['etag'];
            $comic->attribution = $json['attributionText'];
            // get for sale date if present
            foreach ($json['data']['results'][0]['dates'] as $date) {
                if ($date['type'] == 'onsaleDate') {
                    $thisdate=explode("T",$date['date']);
                    $comic->onsaledate = $thisdate[0];
                }
            }
            $comic->save();
            


            // add comic-characters if neccesary
            foreach ($json['data']['results'][0]['characters']['items'] as $character) {
                // get id from uri
                $character_uri_array = explode("/",$character['resourceURI']);
                $character_id = end($character_uri_array);
                $this->add_character($character_id,$comic->id,$character['name']);
            }
            //  add comic-events if neccesary
            foreach ($json['data']['results'][0]['events']['items'] as $event) {
                // get id from uri
                $event_uri_array = explode("/",$event['resourceURI']);
                $event_id = end($event_uri_array);
                $this->add_event($event_id,$comic->id,$event['name']);
            }
            // add comic-stories if neccesary
            foreach ($json['data']['results'][0]['stories']['items'] as $story) {
                // get id from uri
                $story_uri_array = explode("/",$story['resourceURI']);
                $story_id = end($story_uri_array);
                $this->add_story($story_id,$comic->id,$story['name']);
            }
            // add comic-series if neccesary
            //  foreach ($json['data']['results'][0]['series']['items'] as $series) {
            $series = $json['data']['results'][0]['series'];
                // get id from uri
                $series_uri_array = explode("/",$series['resourceURI']);
                $series_id = end($series_uri_array);
                $this->add_series($series_id,$comic->id,$series['name']);
            
        }
        return ($comic);

    }


    private function add_character($character_id,$comic_id,$character_name) {
        // get charactercharacter link if exists
        $character_comic = \App\CharacterComic::where('character_id', $character_id)->where('comic_id', $comic_id)->first();
        // create new character character if it doesn't exist
        if (!$character_comic) {
            $character_comic = new \App\CharacterComic;
            $character_comic->character_id = $character_id;
            $character_comic->comic_id = $comic_id;
            $character_comic->save();
        }
        // check if character exists
        $character_item = \App\Character::find($character_id);
        // create character if it doens't exist
        if (!$character_item) {
            $character_item = new \App\Character;
            $character_item->id = $character_id;
            $character_item->name = $character_name;
            $character_item->save();
                        
        }
                
    }

    private function add_event($event_id,$comic_id,$event_name) {
        // get comicevent link if exists
        $comic_event = \App\ComicEvent::where('comic_id', $comic_id)->where('event_id', $event_id)->first();
        // create new comic event if it doesn't exist
        if (!$comic_event) {
            $comic_event = new \App\ComicEvent;
            $comic_event->comic_id = $comic_id;
            $comic_event->event_id = $event_id;
            $comic_event->save();
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
    private function add_story($story_id,$comic_id,$story_name) {
        // get comicstory link if exists
        $comic_story = \App\ComicStory::where('comic_id', $comic_id)->where('story_id', $story_id)->first();
        // create new comic story if it doesn't exist
        if (!$comic_story) {
            $comic_story = new \App\ComicStory;
            $comic_story->comic_id = $comic_id;
            $comic_story->story_id = $story_id;
            $comic_story->save();
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
    private function add_series($series_id,$comic_id,$series_name) {
        // get comicseries link if exists
        $comic_series = \App\ComicSeries::where('comic_id', $comic_id)->where('series_id', $series_id)->first();
        // create new comic series if it doesn't exist
        if (!$comic_series) {
            $comic_series = new \App\ComicSeries;
            $comic_series->comic_id = $comic_id;
            $comic_series->series_id = $series_id;
            $comic_series->save();
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

    
    public function get_comic() {
        $id = request()->id;
        $data = $this->get_comic_by_id($id);
        return view('view_item',compact('data'));
    }
}
