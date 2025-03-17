<?php

namespace App\Services\Widgets;

use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation;
use Illuminate\Support\Facades;

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
        $config = json_decode($this->widgetModel->config, true);
        if (!isset($config['url'])) {
            $config['url'] = '';
        }
        return [
            'config' => $config,
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

    public function getConfigValidator(Request $request): Validation\Validator
    {
        return Facades\Validator::make($request->all(), []);
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
            'cold' => $xml->cold[0]->__toString(),
            'hot' => $xml->hot[0]->__toString(),
        ];
        $this->widgetModel->data = json_encode($data);
        $this->widgetModel->save();
    }

}
