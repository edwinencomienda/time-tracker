<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserTimeLog extends Model
{
    protected $fillable = ['user_id', 'type', 'time_start', 'time_end'];
    
    const TYPE_LOGIN = 'login', TYPE_LOGOUT = 'logout';

    protected $appends = ['time_covered'];
    
    public static function getTypes()
    {
        return [
            self::TYPE_LOGIN,
            self::TYPE_LOGOUT
        ];
    }

    public function saveTimeLog(array $attributes)
    {
        $this->user_id = $attributes['user_id'];
        $this->type = $attributes['type'];
        $this->created_at = now()->addMinutes(3600 * 1)->toDateTimeString();
        $this->save();
    }

    public function getTimeCoveredAttribute()
    {
        if ($this->type == 'login') {
            return null;
        }
        
        $start = Carbon::parse($this->start_at);
        $end = Carbon::parse($this->created_at);
        return [
            'minutes_covered' => $start->diffInMinutes($end),
            'hours_covered' => $start->diffInHours($end)
        ];
    }
}
