<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index()
    {
        $articles = Article::with('author')->paginate(4);
        return view('index', compact('articles'));
    }

}
