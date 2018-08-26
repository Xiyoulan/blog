<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteArticleController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }
   public function favorite(Article $article){
       $currentUser =\Auth::User();
       if($currentUser->isFavorite($article->id)){
        return response('fail',400);
       }
       $currentUser->favorite($article->id);
       $currentUser->increment('favorite_count');
       $article->increment('favoriter_count');
       return response('success');

   }
    public function UnFavorite(Article $article){
        $currentUser =\Auth::User();
        if(!$currentUser->isFavorite($article->id)){
            return response('fail',400);
        }
        $currentUser->unFavorite($article->id);
        $currentUser->decrement('favorite_count');
        $article->decrement('favoriter_count');
        return response('success');

    }
    public function favoriteArticles(User $user){
          $articles=$user->favoriteArticles()->with('category', 'author', 'tags')->paginate(20);
          return view('users.favorite',compact('articles','user'));
    }
}
