<?php

namespace App\Services\Widgets;

use ReflectionClass;
use App\Models;

class Widgets
{
    public static function getList(): array
    {
        $widgetsFiles = array_diff(scandir(__DIR__), array('..', '.'));
        $result = [];
        foreach ($widgetsFiles as $widgetFileName) {
            $widgetClass = '\\App\\Services\\Widgets\\' . str_replace('.php', '', $widgetFileName);
            if ((new ReflectionClass($widgetClass))->isSubclassOf(AbstractWidget::class)) {
                /** @var AbstractWidget $widgetClass */
                $result[$widgetClass::getTypeName()] = $widgetClass;
            }
        }
        return $result;
    }

    public static function createFromModel(Models\Widget $widget): AbstractWidget
    {
        return new ($widget->class)($widget);
    }
}
