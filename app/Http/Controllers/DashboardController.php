<?php

namespace App\Http\Controllers;

use App\Models\Widget;
// use App\Services\Widgets;
use App\Services\Widgets\WidgetFactory;

class DashboardController extends Controller
{
    public function index()
    {
        $context = ['widgets' => []];
        foreach (Widget::latest()->get() as $widgetModel) {
            $context['widgets'][] = (new WidgetFactory)->build($widgetModel);
        }
        return view('index', $context);
    }

    public function detail(Widget $widgetModel)
    {
        $widget = (new WidgetFactory)->build($widgetModel);
        return view($widget->getViewName(), $widget->getViewContext());
    }
}
