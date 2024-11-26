<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'file_path',
        'image',
        'Publisher_id',
        'description',
        'accepted',
        'book_audio',
        'edition',
        'size_Book',
        'size_audio_Book',
        'category_id'
   ];

    public function category()
    {
        return $this->belongsTo(category::class);
    }
    public function Publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
    public function Authors()
    {
        return $this->belongsToMany(Author::class,'author_books');
    }
}
