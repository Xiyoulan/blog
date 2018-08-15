<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => 'searchTags']);
    }

    public function searchTags(Request $request)
    {
        $keyword = $request->keyword;
        $tags = Tag::where('name', 'like', "%${keyword}%")->take(5)->get(['name as idField', 'name as textField']);
        return response()->json(['msg' => 'success', 'data' => $tags], 200);
    }

    public function show($name)
    {
        $tag = Tag::where('name', $name)->first();
        $articles = $tag->articles()->with('category', 'author', 'tags')->paginate(20);
        return view('articles.tag', compact('articles', 'tag'));
    }

}
