<?php

namespace App\Services\Widgets;

use App\Models\Widget;

abstract class AbstractWidget
{
    protected $view = 'detail';

    abstract public function getViewContext(): array;

    public function getViewName(): string
    {
        return $this->view;
    }
}
