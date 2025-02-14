<?php

namespace App\Services\Widgets;

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
