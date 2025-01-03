<?php

namespace App\Filament\Resources\ChildHealthRecordResource\Widgets;

use App\Models\ChildHealthRecord;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class AverageBMIChart extends ChartWidget
{
    protected static ?string $heading = 'Rata-Rata IMT';

    protected function getData(): array
    {
        // Fetch the last 10 groups of data based on date
        $averageBMIs = ChildHealthRecord::select(
            DB::raw('DATE(record_date) as date'),
            DB::raw('AVG(bmi) as average_bmi')
        )
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->take(10)
        ->get()
        ->reverse();

        // Prepare datasets and labels for the chart
        $labels = [];
        $data = [];

        foreach ($averageBMIs as $record) {
            $labels[] = $record->date; // Collect the date for labels
            $data[] = round($record->average_bmi, 2); // Collect average BMI values, rounded to 2 decimal places
        }

        return [
            'datasets' => [
                [
                    'label' => 'Rata-rata IMT Balita',
                    'data' => $data, // Use the collected average BMI data
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
