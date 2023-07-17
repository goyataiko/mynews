<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\News;


class NewsController extends Controller
{
    public function index(Request $request)
    {
        $posts = News::all()->sortByDesc('updated_at');

        if (count($posts) > 0) {
            $headline = $posts->shift();
        } else {
            $headline = null;
        }

        // news/index.blade.php 로 보냄
        //  View템플릿에 headline、 posts、변수를 보냄
        return view('news.index', ['headline' => $headline, 'posts' => $posts]);
    }
}
