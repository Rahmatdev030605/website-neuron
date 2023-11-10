<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobQualification extends Model
{
    use HasFactory;
    protected $table = 'jobs_qualification';

    protected $fillable = [
        'gender',
        'education',
        'domicile',
        'major',
        'other',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'id'); // Sesuaikan dengan nama kolom yang benar
    }

}
