<?php

namespace App\Filament\Resources\ChildVaccinationResource\Widgets;

use App\Models\ChildVaccination;
use App\Models\Vaccine;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class VaccinationChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Vaksinasi';

    // protected function getData(): array
    // {
    //     // Fetch the last 10 groups of data based on record_date
    //     $vaccinationCounts = ChildVaccination::select(
    //         DB::raw('DATE(vaccine_date) as date'),
    //         DB::raw('COUNT(*) as vaccination_count') // Count the number of vaccinations
    //     )
    //     ->groupBy('date')
    //     ->orderBy('date', 'desc')
    //     ->take(10)
    //     ->get()
    //     ->reverse(); // Reverse to display in chronological order

    //     // Prepare datasets and labels for the chart
    //     $labels = [];
    //     $data = [];

    //     foreach ($vaccinationCounts as $record) {
    //         $labels[] = $record->date; // Collect the date for labels
    //         $data[] = $record->vaccination_count; // Collect the count of vaccinations
    //     }

    //     return [
    //         'datasets' => [
    //             [
    //                 'label' => 'Jumlah Balita yang Melakukan Vaksinasi',
    //                 'data' => $data, // Use the collected vaccination counts
    //                 'borderColor' => 'rgba(75, 192, 192, 1)',
    //                 'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
    //                 'borderWidth' => 2,
    //             ],
    //         ],
    //         'labels' => $labels, // Use the collected labels for the x-axis
    //     ];
    // }


    protected function getData(): array
    {
        // Fetch data grouped by vaccine_id and date
        $vaccinationCounts = ChildVaccination::select(
            DB::raw('DATE(vaccine_date) as date'),
            'vaccine_id', // Group by vaccine_id
            DB::raw('COUNT(*) as vaccination_count')
        )
        ->groupBy('date', 'vaccine_id') // Group by date and vaccine_id
        ->orderBy('date', 'asc')
        ->get();

        // Prepare datasets for each vaccine_id
        $dataByVaccineId = [];
        $labels = [];

        foreach ($vaccinationCounts as $record) {
            $labels[$record->date] = $record->date; // Collect all unique dates

            // Group vaccination counts by vaccine_id
            $dataByVaccineId[$record->vaccine_id][$record->date] = $record->vaccination_count;
        }

        // Ensure labels are sorted in chronological order
        $labels = array_values(array_unique($labels));

        // Get vaccine names based on vaccine_id
        $vaccineIds = array_keys($dataByVaccineId);
        $vaccines = Vaccine::whereIn('id', $vaccineIds)->get()->keyBy('id');

        // Generate random colors for each vaccine_id
        $datasets = [];
        foreach ($dataByVaccineId as $vaccineId => $data) {
            $vaccine = $vaccines->get($vaccineId);

            $datasets[] = [
                'label' => $vaccine->name ?? "Vaksin ID: $vaccineId", // Set the label as the vaccine name or fallback to ID
                'data' => array_map(
                    fn($date) => $data[$date] ?? 0, // Fill gaps with 0 if no data for a date
                    $labels
                ),
                'borderColor' => $vaccine->color ?? 'rgba(0, 0, 0, 1)', // Use the generated random color
                'backgroundColor' => 'rgba(0, 0, 0, 0)', // Transparent background for lines
                'borderWidth' => 2,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
