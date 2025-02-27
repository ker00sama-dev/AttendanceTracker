<?php

namespace App\Filament\Resources\LectureResource\Widgets;

use App\Models\Lecture;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class LectureChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'lectureChart';

    /**
     * Widget Title
     *
     * @var string|null
     */


  protected function getHeading(): ?string
  {
    return __('Lecture Chart');
  }
    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
      $lectureData = Lecture::selectRaw('DATE(created_at) as date, count(*) as count')
        ->groupBy('date')
        ->get()
        ->pluck('count', 'date')
        ->toArray();

      return [
            'chart' => [
                'type' => 'pie',
                'height' => 300,
            ],
        'series' => array_values(Lecture::selectRaw('DATE(created_at) as date, count(*) as count')
          ->groupBy('date')
          ->get()
          ->pluck('count', 'date')
          ->toArray()),
        'labels' => array_keys(Lecture::selectRaw('DATE(created_at) as date, count(*) as count')
          ->groupBy('date')
          ->get()
          ->pluck('count', 'date')
          ->toArray()),
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
