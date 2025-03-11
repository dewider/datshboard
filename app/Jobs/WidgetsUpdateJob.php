<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Widget;
use App\Services\Widgets\Widgets;

/**
 * Обновляет данные виджетов
 */
class WidgetsUpdateJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach (Widget::latest()->get() as $widget) {
            Widgets::createFromModel($widget)->runTasks();
        }
    }
}
