<?php

namespace App\View\Components;

use App\Services\Widgets\AbstractWidget;
use Illuminate\View\Component;

class AdminWidgetEditLayout extends Component
{
    public function __construct(
        public AbstractWidget $widget
    ) {}

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.admin-widget-edit');
    }
}