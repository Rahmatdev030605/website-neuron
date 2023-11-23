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
        'about_id',
    ];

    public function about()
    {
        return $this->belongsTo(Certificate::class, 'about_id');
    }
}
