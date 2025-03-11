<?php

namespace App\Http\Controllers;

use App\Models\Widget;
// use App\Services\Widgets;
use App\Services\Widgets\Widgets;

class DashboardController extends Controller
{
    public function index()
    {
        $context = ['widgets' => []];
        foreach (Widget::latest()->get() as $widgetModel) {
            $context['widgets'][] = Widgets::createFromModel($widgetModel);
        }
        return view('index', $context);
    }

    public function detail(Widget $widgetModel)
    {
        $widget = Widgets::createFromModel($widgetModel);
        return view($widget->getViewName(), $widget->getViewContext());
    }
}
