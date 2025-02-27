<?php

namespace App\Filament\Resources\AttendanceResource\Widgets;

use App\Models\Attendance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AttendanceOverview extends BaseWidget
{

    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Attendances'), $this->getQuery()->count())
                ->icon('heroicon-o-user-group')
                ->description(__('Total attendances recorded for your lectures'))
                ->color('primary'),
            Stat::make(__('Attendances Today'), $this->getQuery()->whereDate('scanned_at', now())->count())
                ->icon('heroicon-o-calendar')
                ->description(__('Attendances recorded today'))
                ->color('success'),
            Stat::make(__('Attendances This Month'), $this->getQuery()->whereMonth('scanned_at', now())->count())
                ->icon('heroicon-o-calendar')
                ->description(__('Attendances recorded this month'))
                ->color('info'),
        ];
    }

    protected function getQuery()
    {
        return Attendance::whereHas('lecture', function ($q) {
            $q->where('created_by', auth()->id());
        });
    }
}
