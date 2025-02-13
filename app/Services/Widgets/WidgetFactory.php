<?php

namespace App\Services\Widgets;

use App\Models;

class WidgetFactory
{
    public static function build(Models\Widget $widget): AbstractWidget
    {
        return new ($widget->class)($widget);
    }
}
