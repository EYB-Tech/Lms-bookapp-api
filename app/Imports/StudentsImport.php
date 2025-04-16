<?php

namespace App\Imports;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;


class StudentsImport implements ToCollection, WithValidation, WithHeadingRow, WithChunkReading
{
    use Importable;
    public function __construct()
    {
        set_time_limit(300);
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $existingUsers = User::pluck('email', 'username')->toArray();
        $students = [];

        foreach ($rows as $row) {
            if (isset($existingUsers[$row['email']]) || in_array($row['username'], $existingUsers)) {
                continue;
            }

            $students[] = [
                'name' => $row['name'],
                'email' => $row['email'],
                'username' => $row['username'],
                'type' => 'Student',
                'email_verified_at' => now(),
                'password' => Hash::make($row['password']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($students)) {
            User::insert($students);
        }
    }

    public function chunkSize(): int
    {
        return 100; // Process 100 rows at a time to avoid memory issues
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ];
    }
}
