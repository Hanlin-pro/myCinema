<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Tmdb\Helper\ImageHelper;
use Tmdb\Repository\MovieRepository;
use Tmdb\Repository\SearchRepository;
use Tmdb\Model\Search\SearchQuery\MovieSearchQuery;

class TmdbController extends Controller
{
    private $movies;
    private $helper;

    public function __construct(MovieRepository $movies, ImageHelper $helper, SearchRepository $search)
    {
        $this->movies = $movies;
        $this->helper = $helper;
        $this->search = $search;
    }

    public function search()
    {

        $data = [
            'page_title'            => 'Search TMDB',
            'navi_group'            => 'search',
            'navi_submenu'          => 'search',
            'results'               => $this->search->searchMovie('batman', new MovieSearchQuery)
        ];

        return view('tmdb.search', $data);
    }
}
