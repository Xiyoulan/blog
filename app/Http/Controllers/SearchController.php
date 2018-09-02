<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
//use App\Models\User;

class SearchController extends Controller
{
    public function show(Request $request){
        $search = $request->input('query');
        if(isset($search)){
            $articles = Article::search($search)->paginate(20);
            $articles->load('category','author','tags','lastReplyUser');
            //dd($articles);
        }else{
            $articles =[];
        }
        return view('search.index',compact('articles'));
    }
}
