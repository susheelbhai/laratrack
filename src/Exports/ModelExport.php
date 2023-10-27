<?php

namespace Susheelbhai\Laratrack\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ModelExport implements FromCollection, WithHeadings
{
    public $model;
    public function __construct($model = null)
    {
        $this->model = $model;
    }
    public function collection()
    {
        return $this->model::all();
    }
    public function headings(): array
    {
        $heading = [];
        $item = $this->model::find(1);
        if (isset($item)) {
            $heading = array_keys($item->getAttributes());
        }
        return $heading;
    }
}
