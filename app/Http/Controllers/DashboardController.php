<?php

namespace App\Http\Controllers;

use App\Models\Widget;
use App\Services\Widgets;

class DashboardController extends Controller
{
    public function index()
    {
        $context = ['widgets' => Widget::latest()->get()];
        return view('index', $context);
    }

    public function detail(Widget $widgetModel)
    {
        $widget = (new \App\Services\Widgets\WidgetFactory)->build($widgetModel);
        return view($widget->getViewName(), $widget->getViewContext());
    }
}
