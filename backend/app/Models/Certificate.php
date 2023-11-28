<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $table = 'certificate';
    protected $fillable = [
        'image',
        'title',
        'company',
    ];

    public function about()
    {
        return $this->belongsTo(About::class, 'about_id');
    }
}
