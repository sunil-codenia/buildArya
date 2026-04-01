<?php

namespace App\Exports;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Generator;

use Maatwebsite\Excel\Concerns\FromCollection;

class TableSheetExport implements FromCollection, WithHeadings,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */   
     protected $dbName,$headings,$query,$sheet_name;

    public function __construct($dbName,$headings,$query,$sheet_name)
    {
        $this->dbName = $dbName;
        $this->headings = $headings;
        $this->query = $query;
        $this->sheet_name = $sheet_name;
    }

    public function collection()
    {
        $results = DB::connection($this->dbName)->cursor($this->query);
        return collect($this->convertToArray($results));

    }
    private function convertToArray(Generator $results): array
    {
        $data = [];
        foreach ($results as $row) {
            $data[] = (array) $row; // Convert objects to associative arrays
        }
        return $data;
    }

    public function headings(): array
    {
        return $this->headings;
    }
    public function title(): string
    {
        return ucfirst(str_replace('_', ' ', $this->sheet_name)); // Convert table name to readable format
    }
}
