<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    public $fillable = ['title', 'author', 'pages', 'marker', 'future_read', 'planning_date', 'start_date', 'finish_date', 'cover', 'user_id'];

    public function user()
    {
        $this->belongsTo(Book::class);
    }

    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
