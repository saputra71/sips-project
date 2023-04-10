<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Document::factory()->create([
            'code' => 'SU',
            'name' => 'Surat Undangan',
            'code_number' => '005'
        ]);

        \App\Models\Document::factory()->create([
            'code' => 'SK',
            'name' => 'Surat Kepegawaian',
            'code_number' => '800'
        ]);

        \App\Models\Document::factory()->create([
            'code' => 'SKU',
            'name' => 'Surat Keuangan',
            'code_number' => '900'
        ]);

        \App\Models\Document::factory()->create([
            'code' => 'SP',
            'name' => 'Surat Perintah',
            'code_number' => '001'
        ]);
    }
}
