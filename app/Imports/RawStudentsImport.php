<?php

namespace App\Imports;

use App\Models\RawStudent;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class RawStudentsImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            try {

                // Normalize header keys (lowercase + trim)
                $data = collect($row)->mapWithKeys(function ($value, $key) {
                    $cleanKey = strtolower(trim($key));
                    return [$cleanKey => $value];
                });

                $email = strtolower(trim($data['your_email_address'] ?? ''));

                // ✅ Skip if email is empty
                if (!$email) {
                    continue;
                }

                // ✅ Skip if email already exists
                if (RawStudent::where('email', $email)->exists()) {
                    continue;
                }

                RawStudent::create([
                    'name' => $data['what_is_your_complete_name'] ?? null,
                    'address' => $data['your_current_address'] ?? null,
                    'dob' => $this->parseDate($data['your_birthdate'] ?? null),
                    'education' => $data['education_details'] ?? null,
                    'preferred_technology' => $data['preferred_technology'] ?? null,
                    'phone' => $data['your_mobile_number'] ?? null,
                    'email' => $email,
                    'college' => $data['your_college_details'] ?? null,
                    'job_assurance' => $this->mapJobAssurance(
                        $data['do_you_need_100_job_assurance'] ?? null
                    ),
                ]);

            } catch (\Throwable $e) {
                // Skip broken rows safely
                logger('Raw Import Skipped Row: ' . $e->getMessage());
                continue;
            }
        }
    }

    private function parseDate($value)
    {
        try {
            return $value ? Carbon::parse($value)->format('Y-m-d') : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function mapJobAssurance($value)
    {
        if (!$value) return null;

        $val = strtolower(trim($value));
        return in_array($val, ['yes', 'true', '1']) ? 'yes' : 'no';
    }
}
