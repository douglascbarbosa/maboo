<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    public $fillable = ['title', 'author', 'rate', 'pages', 'marker', 'future_read', 'planning_date', 'start_date', 'finish_date', 'cover', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookSessions()
    {
        return $this->hasMany(BookSession::class);
    }

    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

}
