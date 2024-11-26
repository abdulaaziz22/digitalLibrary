<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Name'];

    /**
     * The roles that belong to the Author
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Books()
    {
        return $this->belongsToMany(Book::class,'author_books');
    }
    public function scopeRand_Pag($query){
        return $query->inRandomOrder()->paginate(10);
    }
}
