<?php

namespace App\Services\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportExcelService extends DefaultValueBinder implements
    FromArray,
    WithHeadings,
    ShouldAutoSize,
    WithStrictNullComparison,
    WithCustomValueBinder
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

    /**
     * Download as CSV with UTF-8 BOM to handle Arabic characters properly
     */
    public function downloadAsCSV($filename): BinaryFileResponse
    {
        // Create a temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'csv');

        // Generate the Excel file
        \Maatwebsite\Excel\Facades\Excel::store($this, $tempFile, null, Excel::CSV);

        // Read the file content
        $content = file_get_contents($tempFile);

        // Add UTF-8 BOM if not already present
        if (substr($content, 0, 3) !== "\xEF\xBB\xBF") {
            $content = "\xEF\xBB\xBF" . $content;
        }

        // Write back to the file
        file_put_contents($tempFile, $content);

        // Create response
        $response = new BinaryFileResponse($tempFile);
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response->deleteFileAfterSend(true);

        return $response;
    }

    /**
     * Custom value binder to ensure dates are formatted correctly
     */
    public function bindValue(Cell $cell, $value)
    {
        // If value starts with a single quote, ensure it's treated as text
        if (is_string($value) && substr($value, 0, 1) === "'") {
            $cell->setValueExplicit(substr($value, 1), DataType::TYPE_STRING);
            return true;
        }

        // Format dates as strings to prevent Excel from treating them as numbers
        if (is_string($value) && (
                preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) ||
                preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)
            )) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
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
                // Format dates as plain strings to prevent Excel issues
                return $record->$column ? "'" . $record->$column->format('d/m/Y') : '';
            case 'created_at_order':
                return $record->created_at
                    ? $record->created_at->format('d/m/Y') . ' | ' . $record->created_at->format('h:i A')
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
