<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookSession extends Model
{
    public function book() 
    {
       return $this->belongsTo(Book::class);
    }    
}
