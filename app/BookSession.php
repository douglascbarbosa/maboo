<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookSession extends Model
{
    public $fillable = [
        'read_pages',
        'time',
        'date',
        'book_id'
    ]; 
    
    public function book() 
    {
       return $this->belongsTo(Book::class);
    }    
}
