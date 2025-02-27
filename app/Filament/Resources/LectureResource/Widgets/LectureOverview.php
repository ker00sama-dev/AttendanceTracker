<?php

namespace App\Filament\Resources\LectureResource\Widgets;

use App\Models\Lecture;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LectureOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Lectures'), auth()->user()->role == 'admin' ? Lecture::count() : Lecture::where('created_by', auth()->id())->count())
                ->icon('heroicon-o-clipboard-document')
                ->description(__('Total subjects created'))
                ->color('primary'),
        ];
    }
}
