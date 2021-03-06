<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'id',
        'title',
        'slug',
        'content',
        'media'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class,'post_categories');
    }

    public function getSearchIndex(): string
    {
        return 'posts';
    }

}
