<?php

namespace App\Services\Widgets;

use Illuminate\Http\Request;

abstract class AbstractWidget
{
    protected string $view = 'detail';

    /**
     * Возвращает контекст для шаблона
     * 
     * @return array
     */
    abstract public function getViewContext(): array;

    /**
     * Сохранения настроек из запроса
     */
    abstract public function saveConfigFromRequest(Request $request): void;

    /**
     * Выполняет фоновые задачи виджета
     * 
     * @return bool
     */
    public function runTasks(): bool
    {
        return true;
    }

    /**
     * Возвращает имя шаблона для виджета
     */
    public function getViewName(): string
    {
        return $this->view;
    }
}
