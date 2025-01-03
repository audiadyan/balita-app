<?php

namespace App\Filament\Resources\ChildrenResource\Widgets;

use App\Models\Child;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsChildren extends BaseWidget
{
    protected function getStats(): array
    {
        // Fetch statistics
        $totalChildren = Child::count(); // Total number of children
        $maleChildrenCount = Child::where('gender', 1)->count(); // Count male children

        // Calculate percentages
        $malePercentage = $totalChildren > 0 ? ($maleChildrenCount / $totalChildren) * 100 : 0;
        $femalePercentage = 100 - $malePercentage;

        return [
            Stat::make('Jumlah Balita', number_format($totalChildren)),
            Stat::make('Balita Laki-Laki', $maleChildrenCount)
                ->description(number_format($malePercentage, 2) . '%'),
            Stat::make('Balita Perempuan', $totalChildren - $maleChildrenCount)
                ->description(number_format($femalePercentage, 2) . '%'),
        ];
    }
}
