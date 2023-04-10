<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Employee::factory()->create([
            'nip' => '01265480145',
            'name' => 'Budi',
            'address' => 'KEPO',
            'phone' => '058723048625',
        ]);
    }
}
