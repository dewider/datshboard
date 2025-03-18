<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $fillable = [
        'id',
        'title',
        'config',
        'data',
        'class',
    ];
}
