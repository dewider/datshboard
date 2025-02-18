<?php

namespace App\Http\Controllers;

use App\Models\Widget;
// use App\Services\Widgets;
use App\Services\Widgets\WidgetFactory;

class AdminController extends Controller
{
    public function index()
    {
        $context = ['widgets' => Widget::latest()->get()];
        return view('adminpanel', $context);
    }

    public function widgetDetail(Widget $widgetModel)
    {
        $widget = (new WidgetFactory)->build($widgetModel);
        return view($widget->getViewName() . '-admin', $widget->getViewContext());
    }
}
