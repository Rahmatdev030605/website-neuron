<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeuronProgram extends Model
{
    use HasFactory;

    protected $table = 'neuron_programs';

    protected $fillable = [
        'title',
        'desc',
        'video',
        'tagline',
        'home_id'
    ];

    public function home()
    {
        return $this->belongsTo(Home::class, 'home_id');
    }
}
