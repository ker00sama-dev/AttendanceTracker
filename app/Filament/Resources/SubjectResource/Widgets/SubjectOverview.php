<?php

namespace App\Filament\Resources\SubjectResource\Widgets;

use App\Models\Subject;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SubjectOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Subjects'), auth()->user()->role == 'admin' ? Subject::count() : Subject::where('professor_id', auth()->id())->orWhere('instructor_id', auth()->id())->count())
                ->icon('heroicon-o-clipboard-document')
                ->description(__('Total subjects created'))
                ->color('primary'),
        ];
    }
}
