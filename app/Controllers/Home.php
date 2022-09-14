<?php

namespace App\Controllers;

use App\Models\Common\FilmzinetoModule;
use App\Models\Common\TestimonialModel;
use App\Models\Events\Events;

class Home extends BaseController
{
    public function __construct()
    {
    }
    public function index()
    {
        // return print_r($this->data);

        $this->data['optionalJs'] = true;

        $filmzineSelect = 'filmzinetomodules.news_id, filmzinetomodules.data_id, filmzine.title,, filmzine.summary, filmzine.slug, filmzine.featured, filmzine.media_url, filmzine.media_type, filmzine.video_type, filmzine.topic_id, filmzine.topic_name, filmzine.total_likes, filmzine.total_dislikes, filmzine.movie_rating, filmzine.total_views, filmzine.created_at';
        $filmzineModule = new FilmzinetoModule();
        $filmzineHeadlines = $filmzineModule->distinct()
            ->select($filmzineSelect)
            ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
            ->where('filmzinetomodules.table_name', 'homepage')
            ->whereNotIn('filmzine.type_id', [3, 4])
            ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll(3);
        $filmzineTrailers = $filmzineModule->distinct()
            ->select($filmzineSelect)
            ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
            ->where('filmzinetomodules.table_name', 'homepage')
            ->where('filmzine.type_id', '4')
            ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll(6);
        $filmzineInterviews = $filmzineModule->distinct()
            ->select($filmzineSelect)
            ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
            ->where('filmzinetomodules.table_name', 'homepage')
            ->where('filmzine.type_id', '3')
            ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll(6);

        $this->data['headlines'] = $filmzineHeadlines;
        $this->data['trailers'] = $filmzineTrailers;
        $this->data['interviews'] = $filmzineInterviews;

        $eventDb = new Events();
        $events = $eventDb->distinct()
            ->select('events.*, events_categories.name as categoryName, states.name as stateName')
            ->join('events_categories', 'events_categories.id = events.category')
            ->join('states', 'states.id = events.state')
            ->where('events.type', 'global')
            ->orderBy('events.id', 'desc')->findAll();
        $this->data['events'] = $events;

        $testimonialsDb = new TestimonialModel();
        $testimonials = $testimonialsDb->where(['type' => 'global'])->orderBy('id', 'RANDOM')->findAll(6);
        $this->data['testimonials'] = $testimonials;
        // return print_r($this->data);

        // print_r(json_encode(getUri()->getSegment(1)));
        // return view('welcome_message');
        return view('Web/homepage', $this->data);
    }
}
