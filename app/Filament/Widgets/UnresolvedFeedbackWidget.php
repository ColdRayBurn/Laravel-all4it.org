<?php

namespace App\Filament\Widgets;

use App\Models\Feedback;
use App\Filament\Resources\FeedbackResource;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UnresolvedFeedbackWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $unresolvedCount = Feedback::where('isResolved', false)->count();

        return [
            Stat::make(
                'Неразрешённые обращения',
                $unresolvedCount
            )
//                ->description('Неразрешённые обращения')
//                ->color('warning')
                ->url(FeedbackResource::getUrl('index'))
                ->icon('heroicon-o-arrow-top-right-on-square'),
        ];
    }
}
