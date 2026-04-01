<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YourImportClass implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        foreach ($collection as $row) {
            if ($row->isEmpty()) {
                continue; // Skip empty rows
            }
              // Ensure the correct number of columns
              if (count($row) < 5) {
                // Handle cases where there are fewer columns than expected
                continue; // or handle as needed
            }

         $user_db_conn_name = session()->get('comp_db_conn_name');
         DB::connection($user_db_conn_name)->table('contact')->insert([
        'name' => $row[0] ?? null,
         'phone' => $row[1] ?? null,
         'email' => $row[2] ?? null,
         'address' => $row[3] ?? null,
         'categories' => $row[4] ?? null,
 ]);

    }
}
}
