<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use HasFactory;

    protected $table = 'home';

    protected $fillable = [
        'hero_image',
        'about_desc',
        'about_title',
        'service_title',
        'service_desc',
        'partner_title',
        'partner_desc',
        'article_title',
        'article_desc',
    ];

    public function neuronPrograms()
    {
        return $this->hasMany(NeuronProgram::class, 'neuronPrograms_id');
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'home_id');
    }

    public function heroTitleLists()
    {
        return $this->hasMany(HeroTitleList::class, 'home_id');
    }

    public function partners()
    {
        return $this->hasMany(Partner::class, 'home_id');
    }
}
