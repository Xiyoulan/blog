<?php

namespace App\Policies;

use App\Models\User;
use \App\Models\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Article $article)
    {
        return $article->isAuthor($user->id);
    }

    public function destroy(User $user, Article $article)
    {
        return $article->isAuthor($user->id);
    }

}
