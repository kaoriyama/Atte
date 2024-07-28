<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceStatus extends Model
{
    protected $fillable = ['user_id', 'is_working', 'is_on_break'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}