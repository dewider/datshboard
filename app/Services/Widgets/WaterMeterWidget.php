<?php

namespace App\Services\Widgets;

use App\Models\Widget;
use Illuminate\Http\Request;

/**
 * Класс для получения сводной таблицы цен у продавцов на topdeck.ru
 */
class WaterMeterWidget extends AbstractWidget
{
    public function __construct(Widget $widgetModel)
    {
        $widgetConfig = json_decode($widgetModel->config);
        $this->widgetModel = $widgetModel;
    }

    public function getViewContext(): array
    {
        $data = json_decode($this->widgetModel->data, true);
        $data['hot'] = 111;
        $data['cold'] = 222;
        return [
            'config' => json_decode($this->widgetModel->config, true),
            'data' => $data,
            'widget' => Widgets::createFromModel($this->widgetModel),
        ];
    }

    public function updateConfigFromRequest(Request $request): void
    {
        $config = json_decode($this->widgetModel->config, true);

        $this->widgetModel->config = json_encode($config);
        $this->widgetModel->save();
    }

    public function runTasks(): bool
    {
        $this->getMetersValue();
        return true;
    }

    public static function getTypeName(): string
    {
        return 'water-meter';
    }

    public function getViewName(): string
    {
        return 'widget.water-meter';
    }

    /**
     * Сохранение таблицы виджета в БД
     * 
     * @return void
     */
    public function getMetersValue(): void
    {
        // $this->widgetModel->data = json_encode(self::getCompareTable($this->urlList));
        $this->widgetModel->save();
    }

}
