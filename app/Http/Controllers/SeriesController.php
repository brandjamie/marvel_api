<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeriesController extends Controller
{
  private function get_series_by_id($id) {
        $public_key = env('MARVEL_API_PUBLIC_KEY');
        $private_key = env('MARVEL_API_PRIVATE_KEY');
        $url = "http://gateway.marvel.com/v1/public/series/" . $id . "?";
        $ts = strval(time());
        $hash = md5($ts . $private_key . $public_key);

        // get series if in database
        $series = \App\Series::find($id);
        // set headers depending on whether etag / cached is available
        if (!$series or !$series->etag) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET"
                )
            );
        } else {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"If-None-Match:" . $series->etag
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
            // create new series if it doesn't exist already
            if (!$series) {
                $series = new \App\Series();
            }
            // save / update data for series
            $series->id = $json['data']['results'][0]['id'];
            $series->name = $json['data']['results'][0]['title'];
            $series->description = $json['data']['results'][0]['description'];
            $image_url = $json['data']['results'][0]['thumbnail']['path'] . "." . $json['data']['results'][0]['thumbnail']['extension'];
            $series->thumbnail = $image_url;
            $series->etag = $json['etag'];
            $series->attribution = $json['attributionText'];
            $series->save();
            


            // add series-characters if neccesary
            foreach ($json['data']['results'][0]['characters']['items'] as $character) {
                // get id from urix
                $character_uri_array = explode("/",$character['resourceURI']);
                $character_id = end($character_uri_array);
                $this->add_character($character_id,$series->id,$character['name']);
            }
            //  add series-comics if neccesary
            foreach ($json['data']['results'][0]['comics']['items'] as $comic) {
                // get id from uri
                $comic_uri_array = explode("/",$comic['resourceURI']);
                $comic_id = end($comic_uri_array);
                $this->add_comic($comic_id,$series->id,$comic['name']);
            }
            // add series-stories if neccesary
            foreach ($json['data']['results'][0]['stories']['items'] as $story) {
                // get id from uri
                $story_uri_array = explode("/",$story['resourceURI']);
                $story_id = end($story_uri_array);
                $this->add_story($story_id,$series->id,$story['name']);
            }
            // add series-event if neccesary
            foreach ($json['data']['results'][0]['events']['items'] as $event) {
                // get id from uri
                $event_uri_array = explode("/",$event['resourceURI']);
                $event_id = end($event_uri_array);
                $this->add_event($event_id,$series->id,$event['name']);
            }
        }
        return ($series);

    }


    private function add_character($character_id,$series_id,$character_name) {
        // get charactercharacter link if exists
        $character_series = \App\CharacterSeries::where('character_id', $character_id)->where('series_id', $series_id)->first();
        // create new character character if it doesn't exist
        if (!$character_series) {
            $character_series = new \App\CharacterSeries;
            $character_series->character_id = $character_id;
            $character_series->series_id = $series_id;
            $character_series->save();
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

    private function add_comic($comic_id,$series_id,$comic_name) {
        // get seriescomic link if exists
        $series_comic = \App\ComicSeries::where('series_id', $series_id)->where('comic_id', $comic_id)->first();
        // create new series comic if it doesn't exist
        if (!$series_comic) {
            $series_comic = new \App\ComicSeries;
            $series_comic->series_id = $series_id;
            $series_comic->comic_id = $comic_id;
            $series_comic->save();
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
    private function add_story($story_id,$series_id,$story_name) {
        // get seriesstory link if exists
        $series_story = \App\SeriesStory::where('series_id', $series_id)->where('story_id', $story_id)->first();
        // create new series story if it doesn't exist
        if (!$series_story) {
            $series_story = new \App\SeriesStory;
            $series_story->series_id = $series_id;
            $series_story->story_id = $story_id;
            $series_story->save();
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
    private function add_event($event_id,$series_id,$event_name) {
        // get seriesevent link if exists
        $series_event = \App\EventSeries::where('series_id', $series_id)->where('event_id', $event_id)->first();
        // create new series event if it doesn't exist
        if (!$series_event) {
            $series_event = new \App\EventSeries;
            $series_event->series_id = $series_id;
            $series_event->event_id = $event_id;
            $series_event->save();
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

    
    public function get_series() {
        $id = request()->id;
        $data = $this->get_series_by_id($id);
        return view('view_item',compact('data'));
    }
}
