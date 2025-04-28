<?php

namespace App\Services\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ExportExcelService implements FromArray, WithHeadings, ShouldAutoSize, WithStrictNullComparison
{
    use Exportable;

    protected $model; // Keep model separate
    protected $data;  // Separate data property
    protected $columns;
    protected $titles;

    public function __construct($model = null, array $columns, array $titles, $data = null)
    {
        $this->model = $model;
        $this->data = $data;
        $this->columns = $columns;
        $this->titles = $titles;
    }

    public function array(): array
    {
        $items = [];

        // Check if model is provided and not empty
        if ($this->model && !empty($this->model)) {
            $records = $this->model::filter()->get();
            foreach ($records as $record) {
                $row = [];
                foreach ($this->columns as $column) {
                    $value = $this->getColumnValue($record, $column);
                    $row[] = $value;
                }
                $items[] = $row;
            }
        }
        // If model is empty/null, use the provided data
        elseif ($this->data && !empty($this->data)) {
            foreach ($this->data as $record) {
                $row = [];
                foreach ($this->columns as $column) {
                    $value = $this->getColumnValue($record, $column, true);
                    $row[] = $value;
                }
                $items[] = $row;
            }
        }

        return $items;
    }

    public function headings(): array
    {
        return $this->titles;
    }

    private function getColumnValue($record, $column, $isArray = false)
    {
        if ($isArray) {
            // Handle array data
            return $record[$column] ?? '';
        }

        // Handle model data
        if (str_contains($column, '.')) {
            $relations = explode('.', $column);
            $value = $record;
            foreach ($relations as $relation) {
                $value = $value->$relation ?? null;
            }
            return $value;
        }

        switch ($column) {
            case 'price':
            case 'offer_price':
            case 'total':
            case 'delivery_fees':
                return number_format($record->getRawOriginal($column) ?? 0, 3);
            case 'status':
                return __('cp.' . $record->$column);
            case 'created_at':
                return $record->$column?->format('Y-m-d');
            case 'created_at_order':
                return $record->created_at
                    ? $record->created_at->format('d/m/y') . ' | ' . $record->created_at->format('h:i A')
                    : '';
            case 'user_name':
                return $record->user->name ?? $record->name ?? '';
            case 'sold_quantity':
                return $record->quantity - $record->remaining_quantity ?? 0;
            case 'user_email':
                return $record->user->email ?? $record->email ?? '';
            case 'user_mobile':
                return $record->user->mobile ?? $record->mobile ?? '';
            default:
                return $record->$column ?? '';
        }
    }
}
