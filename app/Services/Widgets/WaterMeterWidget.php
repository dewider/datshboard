<?php

namespace App\Services\Widgets;

use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Cache;

/**
 * Класс для получения сводной таблицы цен у продавцов на topdeck.ru
 */
class WaterMeterWidget extends AbstractWidget
{
    public function __construct(Widget $widgetModel)
    {
        $this->widgetModel = $widgetModel;
    }

    public function getViewContext(): array
    {
        $data = json_decode($this->widgetModel->data, true);
        $config = json_decode($this->widgetModel->config, true);
        if (!isset($config['url'])) {
            $config['url'] = '';
        }
        $data = array_merge($data, $this->getMetersValue());
        return [
            'config' => $config,
            'data' => $data,
            'widget' => Widgets::createFromModel($this->widgetModel),
        ];
    }

    public function updateConfigFromRequest(Request $request): array
    {
        $result = [
            'url' => $request->get('url')
        ];
        return $result;
    }

    public function runTasks(): bool
    {
        $data = $this->getMetersValue();
        $this->widgetModel->data = json_encode($data);
        $this->widgetModel->save();
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
     * @return array
     */
    public function getMetersValue(): array
    {
        $cacheKey = $this->getTypeName() . '_' . $this->getId();
        $result = Cache::get($cacheKey);
        if (!$result) {
            $config = json_decode($this->widgetModel->config, true);
            if (isset($config['url'])) {
                $response = Http::accept('text/xml')->get($config['url']);
                $xml = new \SimpleXMLElement($response->body());
                $result = [
                    'cold' => $xml->cold[0]->__toString(),
                    'hot' => $xml->hot[0]->__toString(),
                ];
                Cache::put($cacheKey, $result, 3600);
            } else {
                $result = [];
            }
        }
        return $result;
    }

}
