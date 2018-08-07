<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function show(Category $category,Request $request)
    {
        $articles =Article::where('category_id',$category->id)->withOrder($request->order)->with('category','author','lastReplyUser')->paginate(20);
        return view('articles.index', compact('articles','category'));
    }

}
