<?php

namespace App\Observers;
use App\Models\User;

class UserObserver
{

    public function saving(User $user)
    {
        if (!$user->avatar) {
            $user->avatar = asset('img/cat' . random_int(1, 4).'.jpg');
        }
    }

}
