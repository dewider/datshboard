<?php

namespace App\Services\Widgets;

use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        // $this->getMetersValue();
        $data = json_decode($this->widgetModel->data, true);
        return [
            'config' => json_decode($this->widgetModel->config, true),
            'data' => $data,
            'widget' => Widgets::createFromModel($this->widgetModel),
        ];
    }

    public function updateConfigFromRequest(Request $request): void
    {
        $config = json_decode($this->widgetModel->config, true);

        $config['url'] = $request->get('url');

        $this->widgetModel->config = json_encode($config);
        $this->widgetModel->save();
    }

    public function runTasks(): bool
    {
        // $this->getMetersValue();
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
        $config = json_decode($this->widgetModel->config, true);
        $response = Http::accept('text/xml')->get($config['url']);
        $xml = new \SimpleXMLElement($response->body());
        $data = [
            'cold' => $xml->waterMeter->cold,
            'hot' => $xml->waterMeter->hot,
        ];
        $this->widgetModel->data = json_encode($data);
        $this->widgetModel->save();
    }

}
