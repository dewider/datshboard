<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveWidgetRequest;
use App\Models\Widget;
use App\Services\Widgets\Helper;
// use App\Services\Widgets;
use App\Services\Widgets\WidgetFactory;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $context = ['widgets' => Widget::latest()->get()];
        return view('admin.panel', $context);
    }

    public function widgetDetail(Widget $widgetModel)
    {
        $widget = (new WidgetFactory)->build($widgetModel);
        return view($widget->getAdminViewName(), $widget->getViewContext());
    }

    public function widgetUpdateConfig(Request $request, Widget $widgetModel)
    {
        $widget = (new WidgetFactory)->build($widgetModel);
        $validator = $widget->getConfigValidator($request);
        $validator->validate();
        $widget->updateConfigFromRequest($request);
        return redirect(route('adminWidgetDetail', ['widgetModel' => $widget->getId()]));
    }

    public function addWidget()
    {
        return view('admin.add-widget', ['widgetTypeList' => array_keys(Helper::getWidgetsList())]);
    }

    public function saveWidget(SaveWidgetRequest $request)
    {
        Widget::create([
            'title' => $request->get('title'),
            'config' => json_encode([
                'urlList' => []
            ]),
            'data' => json_encode([]),
            'class' => Helper::getWidgetsList()[$request->get('type')]
        ]);
        return redirect(route('admin'));
    }

    public function deleteWidget(Widget $widget)
    {
        $widget->delete();
        return redirect(route('admin'));
    }
    
}
