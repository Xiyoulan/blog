<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class SimplePageController extends Controller
{

    public function index()
    {
        $articles = Article::with('author')->recent()->paginate(4);
        return view('index', compact('articles'));
    }

}
