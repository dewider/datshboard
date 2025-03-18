<?php

namespace App\Services\Widgets;

use Illuminate\Http\Request;
use App\Models\Widget;
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
     * 
     * @return Request
     */
    public function updateFromRequest(Request $request): void
    {
        if ($title = $request->title) {
            $this->widgetModel->title = $title;
        }
        $config = json_decode($this->widgetModel->config, true);
        $config = array_merge($config, $this->updateConfigFromRequest($request));
        $this->widgetModel->config = json_encode($config);
        $this->widgetModel->save();
    }

    /**
     * Сохранения настроек из запроса
     * Реализация для виджета
     * 
     * @return Request
     */
    abstract public function updateConfigFromRequest(Request $request): array;

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
    abstract public function getConfigValidator(Request $request): Validation\Validator;

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
