<?php

namespace App\Services\Widgets;

use App\Models\Widget;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Validation;
use Illuminate\Support\Facades;

/**
 * Класс для получения сводной таблицы цен у продавцов на topdeck.ru
 */
class TopdeckWidget extends AbstractWidget
{
    protected array $urlList = [];

    const ONLY_MIN_PRICE_POSITIONS = false;

    public function __construct(Widget $widgetModel)
    {
        $widgetConfig = json_decode($widgetModel->config);
        $this->urlList = $widgetConfig->urlList;
        $this->widgetModel = $widgetModel;
    }

    public function getViewContext(): array
    {
        $data = json_decode($this->widgetModel->data, true);
        if (empty($data)) {
            $data['rows'] = [];
            $data['cardNameByColIndex'] = [];
        }
        self::sortRows($data['rows']);
        return [
            'config' => json_decode($this->widgetModel->config, true),
            'data' => $data,
            'widget' => Widgets::createFromModel($this->widgetModel),
        ];
    }

    public function updateConfigFromRequest(Request $request): array
    {
        $result = [
            'urlList' => []
        ];
        foreach ($request->url as $url) {
            if ($url != '') {
                $result['urlList'][] = $url;
            }
        }
        return $result;
    }

    public function runTasks(): bool
    {
        $this->loadTable();
        return true;
    }

    public static function getTypeName(): string
    {
        return 'topdeck';
    }

    public function getViewName(): string
    {
        return 'widget.topdeck';
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
    public function loadTable(): void
    {
        $this->widgetModel->data = json_encode(self::getCompareTable($this->urlList));
        $this->widgetModel->save();
    }

    /**
     * Парсит цены у продавцов на странице
     * 
     * @param string $url
     * @return array
     */
    public static function parsePage(string $url): array
    {
        $response = Http::get($url);
        preg_match('/JSON.parse\(.+\)\,/', $response->body(), $matches);
        $json = mb_substr($matches[0], 12, strlen($matches[0]) - 15);

        $json = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, $json);
        $json = str_replace('\\', '', $json);

        $positions = json_decode($json);

        return $positions;
    }

    /**
     * Сортировка строк таблицы
     * 
     * @param array &$rows
     */
    protected static function sortRows(array &$rows)
    {
        uasort($rows, function ($itemA, $itemB) {
            return count($itemB) <=> count($itemA);
        });
    }

    /**
     * Получение сводной таблицы по всем позициям с минимальными ценами
     * 
     * @param array $urlList
     * @return array
     */
    public static function getCompareTable(array $urlList): array
    {
        $rows = [];
        $cardNameByColIndex = [];
        $cardColIndex = 0;
        $minPrices = [];
        foreach ($urlList as $url) {
            $positions = self::parsePage($url);
            if (empty($positions)) {
                continue;
            }

            $cardNameByColIndex[$cardColIndex] = $positions[0]->name;

            $minPrice = -1;
            /** @var Object $position */
            foreach ($positions as $position) {
                $minPrice = ($minPrice < 0 || $position->cost < $minPrice) ? $position->cost : $minPrice;
            }
            $minPrices[$cardColIndex] = $minPrice;

            foreach ($positions as $position) {
                if (!self::ONLY_MIN_PRICE_POSITIONS || $position->cost <= $minPrice + ($minPrice * 0.5) + 100) {
                    $sellerName = is_object($position->seller) ? $position->seller->name : $position->seller;
                    if (!isset($rows[$sellerName][$cardColIndex]) || $rows[$sellerName][$cardColIndex] > $position->cost) {
                        $rows[$sellerName][$cardColIndex] = [
                            'cost' => $position->cost,
                            'url' => $position->url
                        ];
                    }
                }
            }
            $cardColIndex++;
            sleep(5);
        }

        // self::sortRows($rows);

        return [
            'rows' => $rows,
            'cardNameByColIndex' => $cardNameByColIndex,
            'minPrices' => $minPrices,
        ];
    }
}
