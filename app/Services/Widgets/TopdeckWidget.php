<?php

namespace App\Services\Widgets;

use App\Models\Widget;
use Illuminate\Support\Facades\Http;

class TopdeckWidget extends AbstractWidget
{
    protected $urlList = [];

    public function __construct(Widget $widget)
    {
        $widgetConfig = json_decode($widget->data);
        $this->urlList = $widgetConfig->urlList;
    }

    public function getViewContext(): array
    {
        return [
            'table' => print_r(self::getCompareTable($this->urlList), true)
        ];
    }

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

    public static function getCompareTable(array $urlList): array
    {
        $rows = [];
        $cardNameByColIndex = [];
        $cardColIndex = 0;
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

            foreach ($positions as $position) {
                if ($position->cost <= $minPrice + ($minPrice * 0.5) + 100) {
                    $sellerName = is_object($position->seller) ? $position->seller->name : $position->seller; 
                    $rows[$sellerName][$cardColIndex] = $position->cost;
                }
            }
            $cardColIndex++;
            sleep(5);
        }

        uasort($rows, function ($itemA, $itemB) {
            return count($itemB) <=> count($itemA);
        });

        return [
            'rows' => $rows,
            'cardNameByColIndex' => $cardNameByColIndex,
        ];
    }
}
