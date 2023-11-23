<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $table = 'about';

    protected $fillable = [
        'hero_title',
        'hero_desc',
        'about_title',
        'about_desc',
        'hero_image',
        'vision_desc',
        'vision_image',
        'mission_title',
        'value_title',
        'value_subtitle',
        'partnership_title',
        'part_cert_title',
        'part_cert_desc',
        'certification_title'
    ];

    public function ctaContact()
    {
        return $this->belongsTo(CtaContact::class);
    }

    public function missionLists()
    {
        return $this->hasMany(MissionList::class, 'about_id');
    }

    public function valueLists()
    {
        return $this->hasMany(ValueList::class, 'about_id');
    }

    public function directorLists()
    {
        return $this->hasMany(DirectorList::class, 'about_id');
    }

    public function managementStrategies()
    {
        return $this->hasMany(ManagementStrategy::class, 'about_id');
    }
    public function certificate_list()
    {
        return $this->hasMany(Certificate::class, 'about_id');
    }
}
