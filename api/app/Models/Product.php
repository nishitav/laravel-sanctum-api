<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Allow these fields to be mass assignable
    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    // Casts for correct JSON output
    protected $casts = [
        'price' => 'float',
    ];
}
