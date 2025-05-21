<?php

namespace App\Exports;

use App\Models\AddJobsColumn;
use App\Models\Fields;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;

class JobsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStartRow, WithHeadingRow
{
    protected $projectId;
    public function __construct($projectId)
    {
        $this->projectId = $projectId;
    }
    public function collection()
    {
        $data = AddJobsColumn::select('properties')->where('project_id', $this->projectId)->get();
        // log::info($data);

        $excelData = [];
        foreach ($data as $row) {
            $propertiesArray = $row->properties;
            foreach ($propertiesArray[0] as $key => $object) {
                // Log::info($object);
                $excelData[] = $object;
                // log::info($excelData);

            }
            // log::info($excelData);

        }
        return collect($excelData);
    }

    public function headings(): array
    {
        $staticColumns =  [
            'S.No',
            'Project Name',
            'Client Name',
            'Service Name',
            'Cost Type',
            // 'Submiter',
            // 'Reviewer',
        ];
        log::info($staticColumns);

        $dynamicColumns = Fields::where('projects_id', $this->projectId)
            ->pluck('field_name')
            ->toArray();
             // Filter out null values
    $dynamicColumns = array_filter($dynamicColumns, function ($value) {
        return $value !== null;
    });
            log::info($dynamicColumns);
        $combinedColumns = [...$staticColumns, ...$dynamicColumns];
        log::info($combinedColumns);

        return $combinedColumns;
    }
    public function startRow(): int
    {
        return 2;
    }
}
