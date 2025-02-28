<?php

namespace App\Services\Widgets;

use ReflectionClass;

class Helper
{
    public static function getWidgetsList(): array
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
}
