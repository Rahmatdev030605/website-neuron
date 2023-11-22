<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ArticleCategory;
use App\Models\Article;

class ArticleCategoryGroup extends Model
{
    use HasFactory;

    protected $fillable =[
        'article_id',
        'category_id',
    ];

    public function article(){
        return $this->belongsTo(Article::class, 'article_id' ,'id');
    }

    public function articleCategory()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id', 'id');
    }
}
