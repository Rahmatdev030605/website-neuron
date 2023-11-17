<?php

namespace App\Models;

use App\Models\User;
use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';

    protected $fillable = [
        'title',
        'image',
        'desc',
        'body',
        'author',
        'user_id',
        'articles_categories_id'
    ];

    public function articleCategoryGroup()
    {
        return $this->hasMany(ArticleCategoryGroup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
