<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Program extends Model
{
    use HasFactory;
    use FilterQueryString;
    protected $filters = ['like','category_id'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'File_path',
        'Name',
        'Description',
        'image',
        'Accepted',
        'Version',
        'size_Program',
        'category_id'
    ];
    public function category()
    {
        return $this->belongsTo(category::class);
    }

}
