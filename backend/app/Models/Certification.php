<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;
    protected $table = 'certificate';
    protected $fillable = [
        'image',
        'title',
        'company',
        'about_id',
    ];

    public function certification()
    {
        return $this->belongsTo(Certification::class, 'about_id');
    }
}
