<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Icd10Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $codes = [
            ['code' => 'A00', 'name' => 'Cholera'],
            ['code' => 'A01', 'name' => 'Typhoid and paratyphoid fevers'],
            ['code' => 'A09', 'name' => 'Infectious gastroenteritis and colitis, unspecified'],
            ['code' => 'A15', 'name' => 'Respiratory tuberculosis, bacteriologically and histologically confirmed'],
            ['code' => 'B50', 'name' => 'Plasmodium falciparum malaria'],
            ['code' => 'E11', 'name' => 'Type 2 diabetes mellitus'],
            ['code' => 'I10', 'name' => 'Essential (primary) hypertension'],
            ['code' => 'J00', 'name' => 'Acute nasopharyngitis [common cold]'],
            ['code' => 'J06', 'name' => 'Acute upper respiratory infections of multiple and unspecified sites'],
            ['code' => 'J18', 'name' => 'Pneumonia, organism unspecified'],
            ['code' => 'K21', 'name' => 'Gastro-esophageal reflux disease'],
            ['code' => 'K29', 'name' => 'Gastritis and duodenitis'],
            ['code' => 'R50', 'name' => 'Fever of other and unknown origin'],
            ['code' => 'R51', 'name' => 'Headache'],
        ];

        foreach ($codes as $code) {
            \App\Models\Icd10Code::create($code);
        }
    }
}
