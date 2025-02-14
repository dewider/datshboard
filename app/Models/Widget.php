<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Widgets\WidgetFactory;

class Widget extends Model
{
    protected $fillable = [
        'id',
        'title',
        'config',
        'data',
        'class',
    ];

    public function getPreViewName(): string
    {
        return WidgetFactory::build($this)->getViewName() . '-preview';
    }
}
