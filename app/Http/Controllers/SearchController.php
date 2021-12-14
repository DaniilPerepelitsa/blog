<?php

namespace App\Http\Controllers;

use App\Http\Services\ElasticSearch;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, ElasticSearch $elasticSearch)
    {
        $posts = $elasticSearch->search($request->get('q'))->get();

        return view('show_result', compact('posts'));
    }
}
