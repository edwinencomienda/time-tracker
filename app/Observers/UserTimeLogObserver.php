<?php

namespace App\Observers;

use App\User;
use App\UserTimeLog;

class UserTimeLogObserver
{
    public function saving(UserTimeLog $userTimeLog)
    {
        $user = User::find($userTimeLog->user_id);

        if ($userTimeLog->type == 'logout') {
            $userTimeLog->start_at = $user->getLastTimeLog()->created_at;
            $user->is_login = 0;
        } else {
            $user->is_login = 1;
        }
        
        $user->save();
    }
}
