<?php

namespace App\Http\Controllers;

use App\Models\Widget;
use App\Services\Widgets\AbstractWidget;
// use App\Services\Widgets;
use App\Services\Widgets\WidgetFactory;
use Illuminate\Http\Request;
use ReflectionClass;

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
        return view($widget->getAdminViewName(), $widget->getViewContext());
    }

    public function addWidget()
    {
        $context = [
            'widgetTypeList' => [],
        ];

        $widgetsDir = __DIR__ . '/../../Services/Widgets';
        $widgetsFiles = array_diff(scandir($widgetsDir), array('..', '.'));
        foreach ($widgetsFiles as $widgetFileName) {
            $widgetClass = '\\App\\Services\\Widgets\\' . str_replace('.php', '', $widgetFileName);
            if ((new ReflectionClass($widgetClass))->isSubclassOf(AbstractWidget::class)) {
                /** @var AbstractWidget $widgetClass */
                $context['widgetTypeList'][] = $widgetClass::getTypeName();
            }
        }

        return view('admin.add-widget', $context);
    }
}
