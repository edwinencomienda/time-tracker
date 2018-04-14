<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends = ['last_time_log'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function timeLogs()
    {
        return $this->hasMany(UserTimeLog::class, 'user_id');
    }

    public function getLastTimeLog()
    {
        return $this->timeLogs()
        // ->where(DB::raw('date(created_at)'), now()->toDateString())
        ->latest()
        ->first();
    }

    public function getLastTimeLogAttribute()
    {
        return $this->getLastTimeLog();
    }
}
