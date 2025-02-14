<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models;
use App\Services;

class WidgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Models\Widget::create([
            'title' => 'Topdeck',
            'config' => json_encode([
                'urlList' => [
                    'https://topdeck.ru/apps/toptrade/singles/search?q=All+Will+Be+One',
                    'https://topdeck.ru/apps/toptrade/singles/search?q=Counterspell',
                    'https://topdeck.ru/apps/toptrade/singles/search?q=%D0%91%D0%BE%D0%B3%D0%BE%D1%85%D1%83%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9+%D0%9D%D0%B0%D1%81%D1%82%D0%B0%D0%B2%D0%BD%D0%B8%D0%BA',
                ]
            ]),
            'data' => json_encode([]),
            'class' => Services\Widgets\TopdeckWidget::class
        ]);
    }
}
