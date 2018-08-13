<?php

namespace App\Policies;

use App\Models\User;
use \App\Models\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{

    use HandlesAuthorization;

    public function create(User $user, Article $article){
        return !$user->is_blocked;
    }
    public function update(User $user, Article $article)
    {
        return $article->isAuthor($user->id) && !$user->is_blocked;
    }

    public function destroy(User $user, Article $article)
    {
        return $article->isAuthor($user->id) && !$user->is_blocked;
    }

}
