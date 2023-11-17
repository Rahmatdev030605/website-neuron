<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory;
    protected $table = 'portofolios';
    protected $fillable = [
        'name', 'customer_name', 'desc', 'image', 'link', 'our_solution', 'details', 'created_at', 'successProject', 'service_id'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
