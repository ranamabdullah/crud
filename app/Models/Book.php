<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $fillable = ['name','arrival_date','no_of_copies','category_id','description'];
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
