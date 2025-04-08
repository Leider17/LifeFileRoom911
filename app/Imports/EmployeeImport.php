<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToCollection, WithHeadingRow
{
    protected $requiredHeaders = [
        'internal_id',
        'first_name',
        'last_name',
        'department_id',
        'has_access',
    ];
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {

        if ($rows->isEmpty()) {
            throw ValidationException::withMessages([
                'file' => ['El archivo está vacío o no contiene datos.']
            ]);
        }

        $firstRow = $rows->first();
        $firstRowArray = $firstRow->toArray();
        foreach ($this->requiredHeaders as $header) {
            if (!array_key_exists($header, $firstRowArray)) {
                throw ValidationException::withMessages([
                    'file' => ["Falta el campo requerido: '{$header}' en el archivo."]
                ]);
            }
        }
        foreach ($rows as $index => $row) {
            $data = [
                'internal_id' => $row['internal_id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'department_id' => $row['department_id'],
                'has_access' => $row['has_access'],
            ];

            $validator = Validator::make($data, [
                'internal_id' => 'required|string|max:50|unique:employees,internal_id',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'department_id' => 'required|exists:departments,id',
                'has_access' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                throw ValidationException::withMessages([
                    "row_{$index}" => $validator->errors()->all(),
                ]);
            }

            Employee::create($data);
        }
    }
}
