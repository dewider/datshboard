<?php

namespace App\Services\Widgets;

use Illuminate\Http\Request;
use App\Models\Widget;
use Illuminate\Support\Facades;
use Illuminate\Validation;

abstract class AbstractWidget
{
    protected Widget $widgetModel;

    /**
     * Возвращает контекст для шаблона
     * 
     * @return array
     */
    abstract public function getViewContext(): array;

    /**
     * Сохранения настроек из запроса
     */
    abstract public function updateConfigFromRequest(Request $request): void;

    /**
     * Возвращает названия типа виджета
     * 
     * @return string
     */
    abstract public static function getTypeName(): string;

    /**
     * Возвращает имя шаблона для виджета
     * 
     * @return string
     */
    abstract public function getViewName(): string;

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
     * Валидация сохранения конфигураций
     * 
     * @return Validation\Validator
     */
    public function getConfigValidator(Request $request): Validation\Validator
    {
        return Facades\Validator::make($request->all(), []);
    }

    /**
     * Возвращает имя шаблона превью для виджета
     * 
     * @return string
     */
    public function getPreViewName(): string
    {
        return $this->getViewName() . '-preview';
    }

    /**
     * Возвращает имя шаблона страницы редактирования настроек виджета
     * 
     * @return string
     */
    public function getAdminViewName(): string
    {
        return $this->getViewName() . '-admin';
    }

    /**
     * Возвращает название виджета
     * 
     * @return string
     */
    public function getTitle(): string
    {
        return $this->widgetModel->title;
    }

    /**
     * Возвращает ID виджета
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->widgetModel->id;
    }

    /**
     * Возвращает дату обновления
     * 
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->widgetModel->updated_at;
    }
}
