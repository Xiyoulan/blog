<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
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

    public function create(User $user, Reply $reply)
    {
        return !$user->is_blocked;
    }

    public function destroy(User $user, Reply $reply)
    {
        return $user->id == $reply->from && !$user->is_blocked;
    }

}
