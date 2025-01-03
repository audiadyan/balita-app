<?php

namespace App\Filament\Resources\ChildVaccinationResource\Widgets;

use App\Models\ChildVaccination;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class VaccinationChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Vaksinasi';

    protected function getData(): array
    {
        // Fetch the last 10 groups of data based on record_date
        $vaccinationCounts = ChildVaccination::select(
            DB::raw('DATE(vaccine_date) as date'),
            DB::raw('COUNT(*) as vaccination_count') // Count the number of vaccinations
        )
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->take(10)
        ->get()
        ->reverse(); // Reverse to display in chronological order

        // Prepare datasets and labels for the chart
        $labels = [];
        $data = [];

        foreach ($vaccinationCounts as $record) {
            $labels[] = $record->date; // Collect the date for labels
            $data[] = $record->vaccination_count; // Collect the count of vaccinations
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Balita yang Melakukan Vaksinasi',
                    'data' => $data, // Use the collected vaccination counts
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels, // Use the collected labels for the x-axis
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
