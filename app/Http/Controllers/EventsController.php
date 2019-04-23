<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventsController extends Controller
{
     private function get_event_by_id($id) {
        $public_key = env('MARVEL_API_PUBLIC_KEY');
        $private_key = env('MARVEL_API_PRIVATE_KEY');
        $url = "http://gateway.marvel.com/v1/public/events/" . $id . "?";
        $ts = strval(time());
        $hash = md5($ts . $private_key . $public_key);

        // get event if in database
        $event = \App\Event::find($id);
        // set headers depending on whether etag / cached is available
        if (!$event or !$event->etag) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET"
                )
            );
        } else {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"If-None-Match:" . $event->etag
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
            // create new event if it doesn't exist already
            if (!$event) {
                $event = new \App\Event();
            }
            // save / update data for event
            $event->id = $json['data']['results'][0]['id'];
            $event->name = $json['data']['results'][0]['title'];
            $event->description = $json['data']['results'][0]['description'];
            $image_url = $json['data']['results'][0]['thumbnail']['path'] . "." . $json['data']['results'][0]['thumbnail']['extension'];
            $event->thumbnail = $image_url;
            $event->etag = $json['etag'];
            $event->attribution = $json['attributionText'];
            $event->save();
            


            // add event-characters if neccesary
            foreach ($json['data']['results'][0]['characters']['items'] as $character) {
                // get id from urix
                $character_uri_array = explode("/",$character['resourceURI']);
                $character_id = end($character_uri_array);
                $this->add_character($character_id,$event->id,$character['name']);
            }
            //  add event-comics if neccesary
            foreach ($json['data']['results'][0]['comics']['items'] as $comic) {
                // get id from uri
                $comic_uri_array = explode("/",$comic['resourceURI']);
                $comic_id = end($comic_uri_array);
                $this->add_comic($comic_id,$event->id,$comic['name']);
            }
            // add event-stories if neccesary
            foreach ($json['data']['results'][0]['stories']['items'] as $story) {
                // get id from uri
                $story_uri_array = explode("/",$story['resourceURI']);
                $story_id = end($story_uri_array);
                $this->add_story($story_id,$event->id,$story['name']);
            }
            // add event-series if neccesary
            foreach ($json['data']['results'][0]['series']['items'] as $series) {
                // get id from uri
                $series_uri_array = explode("/",$series['resourceURI']);
                $series_id = end($series_uri_array);
                $this->add_series($series_id,$event->id,$series['name']);
            }
        }
        return ($event);

    }


    private function add_character($character_id,$event_id,$character_name) {
        // get charactercharacter link if exists
        $character_event = \App\CharacterEvent::where('character_id', $character_id)->where('event_id', $event_id)->first();
        // create new character character if it doesn't exist
        if (!$character_event) {
            $character_event = new \App\CharacterEvent;
            $character_event->character_id = $character_id;
            $character_event->event_id = $event_id;
            $character_event->save();
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

    private function add_comic($comic_id,$event_id,$comic_name) {
        // get eventcomic link if exists
        $event_comic = \App\ComicEvent::where('event_id', $event_id)->where('comic_id', $comic_id)->first();
        // create new event comic if it doesn't exist
        if (!$event_comic) {
            $event_comic = new \App\ComicEvent;
            $event_comic->event_id = $event_id;
            $event_comic->comic_id = $comic_id;
            $event_comic->save();
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
    private function add_story($story_id,$event_id,$story_name) {
        // get eventstory link if exists
        $event_story = \App\EventStory::where('event_id', $event_id)->where('story_id', $story_id)->first();
        // create new event story if it doesn't exist
        if (!$event_story) {
            $event_story = new \App\EventStory;
            $event_story->event_id = $event_id;
            $event_story->story_id = $story_id;
            $event_story->save();
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
    private function add_series($series_id,$event_id,$series_name) {
        // get eventseries link if exists
        $event_series = \App\EventSeries::where('event_id', $event_id)->where('series_id', $series_id)->first();
        // create new event series if it doesn't exist
        if (!$event_series) {
            $event_series = new \App\EventSeries;
            $event_series->event_id = $event_id;
            $event_series->series_id = $series_id;
            $event_series->save();
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

    
    public function get_event() {
        $id = request()->id;
        $data = $this->get_event_by_id($id);
        return view('view_item',compact('data'));
    }
}
