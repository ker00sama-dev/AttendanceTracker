<?php

namespace App\Filament\Resources\AttendanceResource\Widgets;

use App\Models\Attendance;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class AttendanceChartWidget extends ChartWidget
{

  protected static ?string $loadingIndicator = 'Loading...';

  protected static ?string $chartId = 'attendance-chart';

  public function getHeading(): string|Htmlable|null
  {
    return __('Attendance Chart');
  }

  protected function getOptions(): array
  {
    return [
      'chart' => [
        'type' => 'line',
        'height' => 400,
        'toolbar' => [
          'show' => true,
        ],
        'zoom' => [
          'enabled' => true,
        ],
      ],
      'dataLabels' => [
        'enabled' => false,
      ],
      'stroke' => [
        'curve' => 'smooth',
        'width' => 3,
      ],
      'markers' => [
        'size' => 5,
        'colors' => ['#f59e0b'],
        'strokeColors' => '#fff',
        'strokeWidth' => 2,
      ],
      'series' => [
        [
          'name' => __('Attendance Count'),
          'data' => array_values($this->getData()['series']),
        ],
      ],
      'xaxis' => [
        'categories' => array_keys($this->getData()['labels']),
        'labels' => [
          'style' => [
            'fontFamily' => 'inherit',
            'fontWeight' => 600,
          ],
        ],
        'title' => [
          'text' => __('Date'),
          'style' => [
            'fontWeight' => 700,
          ],
        ],
      ],
      'yaxis' => [
        'labels' => [
          'style' => [
            'fontFamily' => 'inherit',
          ],
        ],
        'title' => [
          'text' => __('Attendance Count'),
          'style' => [
            'fontWeight' => 700,
          ],
        ],
      ],
      'tooltip' => [
        'y' => [
          'formatter' => fn($val) => $val . ' attendees',
        ],
      ],
      'colors' => ['#f59e0b'],
      'grid' => [
        'borderColor' => '#e7e7e7',
        'strokeDashArray' => 5,
      ],
    ];
  }

  protected function getData(): array
  {
    $attendanceData = Attendance::selectRaw('DATE(created_at) as date, count(*) as count')
      ->groupBy('date')
      ->get()
      ->pluck('count', 'date')
      ->toArray();

    return [
      'labels' => array_keys($attendanceData),
      'series' => array_values($attendanceData),
    ];
  }
  protected function getType(): string
  {
    return 'line';
  }
}
