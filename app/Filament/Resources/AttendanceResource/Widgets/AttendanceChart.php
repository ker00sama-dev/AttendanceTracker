<?php

namespace App\Filament\Resources\AttendanceResource\Widgets;

use App\Models\Attendance;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class AttendanceChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'attendanceChart';

    /**
     * Widget Title
     *
     * @var string|null
     */

    protected function getHeading(): ?string
    {
      return __('Attendance Chart');
    }

  /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
      $attendanceData = Attendance::selectRaw('DATE(created_at) as date, count(*) as count')
        ->groupBy('date')
        ->get()
        ->pluck('count', 'date')
        ->toArray();
        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'AttendanceChart',
                    'data' => array_values($attendanceData) ?: [2, 4, 6, 10, 14, 7, 2, 9, 10, 15, 13, 18],
                ],
            ],
            'xaxis' => [
              'categories' => array_keys($attendanceData) ?: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
