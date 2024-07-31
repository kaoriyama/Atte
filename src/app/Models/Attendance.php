<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Attendance extends Model
{
    protected $fillable = ['user_id', 'date', 'start_time', 'end_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rests()
    {
        return $this->hasMany(Rest::class);
    }
}