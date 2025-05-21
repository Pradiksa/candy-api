<?php

namespace App\Exports;

use App\Models\Categories;
use App\Models\Templates;
use App\Models\TemplateCheckList;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\NamedRange;
use Illuminate\Support\Facades\Log;




class TemplateExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStartRow, WithHeadingRow, WithEvents
{
    protected $templateId;
    public function __construct($templateId)
    {
        $this->templateId = $templateId;
    }

    public function collection()
    {
        $data = TemplateCheckList::select(
            'template_check_list_id',
            DB::raw('(SELECT categories_name FROM categories WHERE categories.categories_id = template_check_list.category) AS category_name'),
            'description',
            'short_description',
        )->where('template_id', $this->templateId)->get();
        // Log::info($data);
        return collect($data);
    }
    public function headings(): array
    {
        return [
            'S.No',
            'Categories',
            'Description',
            'Short Description',
        ];
    }
    public function startRow(): int
    {
        return 2;
    }
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $spreadsheet = $event->sheet->getDelegate();
                // $categories = Templates::select('categories_name')->where('templates_id', $this->templateId)->get()->toArray();
                $categoriesData = Templates::select('categories_name')->where('templates_id', $this->templateId)->get()->toArray();
                // Log::info($categoriesData);
                $categories = [];
                foreach ($categoriesData as $data) {
                    $categoryNames = explode(',', $data['categories_name']);
                    $categories = array_merge($categories, $categoryNames);
                }
                // Log::info($categories);

                // Set the data validation for the "Categories" column
                $columnLetter = 'B'; // Change this to the appropriate column letter for "Categories"
                $startRow = 2; // Change this to the starting row where the data validation should be applied
                $endRow = $startRow + 1000 - 1;
                $dataValidation = new DataValidation();
                $dataValidation->setType(DataValidation::TYPE_LIST);
                $dataValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $dataValidation->setAllowBlank(false);
                $dataValidation->setShowInputMessage(true);
                $dataValidation->setShowErrorMessage(true);
                $dataValidation->setErrorTitle('Input error');
                $dataValidation->setError('Select a value from the list');
                $dataValidation->setPromptTitle('Pick from list');
                $dataValidation->setPrompt('Please pick a value from the drop-down list');
                $dataValidation->setFormula1('"' . implode(',', $categories) . '"');
                $spreadsheet->setDataValidation($columnLetter . $startRow . ':' . $columnLetter . $endRow, $dataValidation);
            },
        ];
    }
}
