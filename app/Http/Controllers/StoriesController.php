<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoriesController extends Controller
{
     private function get_story_by_id($id) {
        $public_key = env('MARVEL_API_PUBLIC_KEY');
        $private_key = env('MARVEL_API_PRIVATE_KEY');
        $url = "http://gateway.marvel.com/v1/public/stories/" . $id . "?";
        $ts = strval(time());
        $hash = md5($ts . $private_key . $public_key);

        // get story if in database
        $story = \App\Story::find($id);
        // set headers depending on whether etag / cached is available
        if (!$story or !$story->etag) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET"
                )
            );
        } else {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"If-None-Match:" . $story->etag
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
            // create new story if it doesn't exist already
            if (!$story) {
                $story = new \App\Story();
            }
            // save / update data for story
            $story->id = $json['data']['results'][0]['id'];
            $story->name = $json['data']['results'][0]['title'];
            $story->description = $json['data']['results'][0]['description'];
            $image_url = $json['data']['results'][0]['thumbnail']['path'] . "." . $json['data']['results'][0]['thumbnail']['extension'];
            $story->thumbnail = $image_url;
            $story->etag = $json['etag'];
            $story->attribution = $json['attributionText'];
            $story->save();
            


            // add story-characters if neccesary
            foreach ($json['data']['results'][0]['characters']['items'] as $character) {
                // get id from urix
                $character_uri_array = explode("/",$character['resourceURI']);
                $character_id = end($character_uri_array);
                $this->add_character($character_id,$story->id,$character['name']);
            }
            //  add story-comics if neccesary
            foreach ($json['data']['results'][0]['comics']['items'] as $comic) {
                // get id from uri
                $comic_uri_array = explode("/",$comic['resourceURI']);
                $comic_id = end($comic_uri_array);
                $this->add_comic($comic_id,$story->id,$comic['name']);
            }
            // add series-stories if neccesary
            foreach ($json['data']['results'][0]['series']['items'] as $series) {
                // get id from uri
                $series_uri_array = explode("/",$series['resourceURI']);
                $series_id = end($series_uri_array);
                $this->add_series($series_id,$story->id,$series['name']);
            }
            // add story-event if neccesary
            foreach ($json['data']['results'][0]['events']['items'] as $event) {
                // get id from uri
                $event_uri_array = explode("/",$event['resourceURI']);
                $event_id = end($event_uri_array);
                $this->add_event($event_id,$story->id,$event['name']);
            }
        }
        return ($story);

    }


    private function add_character($character_id,$story_id,$character_name) {
        // get charactercharacter link if exists
        $character_story = \App\CharacterStory::where('character_id', $character_id)->where('story_id', $story_id)->first();
        // create new character character if it doesn't exist
        if (!$character_story) {
            $character_story = new \App\CharacterStory;
            $character_story->character_id = $character_id;
            $character_story->story_id = $story_id;
            $character_story->save();
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

    private function add_comic($comic_id,$story_id,$comic_name) {
        // get storycomic link if exists
        $story_comic = \App\ComicStory::where('story_id', $story_id)->where('comic_id', $comic_id)->first();
        // create new story comic if it doesn't exist
        if (!$story_comic) {
            $story_comic = new \App\ComicStory;
            $story_comic->story_id = $story_id;
            $story_comic->comic_id = $comic_id;
            $story_comic->save();
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
    private function add_series($series_id,$story_id,$series_name) {
        // get storyseries link if exists
        $story_series = \App\SeriesStory::where('story_id', $story_id)->where('series_id', $series_id)->first();
        // create new story series if it doesn't exist
        if (!$story_series) {
            $story_series = new \App\SeriesStory;
            $story_series->story_id = $story_id;
            $story_series->series_id = $series_id;
            $story_series->save();
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
    private function add_event($event_id,$story_id,$event_name) {
        // get storyevent link if exists
        $story_event = \App\EventStory::where('story_id', $story_id)->where('event_id', $event_id)->first();
        // create new story event if it doesn't exist
        if (!$story_event) {
            $story_event = new \App\EventStory;
            $story_event->story_id = $story_id;
            $story_event->event_id = $event_id;
            $story_event->save();
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

    
    public function get_story() {
        if (request()->id) {
            $id = request()->id;
            $data = $this->get_story_by_id($id);
            return view('view_item',compact('data'));
        } else {
            return redirect('/');
        }

    }
}
