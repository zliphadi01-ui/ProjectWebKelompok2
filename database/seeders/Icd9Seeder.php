<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Icd9Procedure;
use Illuminate\Support\Facades\DB;

class Icd9Seeder extends Seeder
{
    public function run()
    {
        DB::table('icd9_procedures')->truncate();

        $data = [
            // --- UMUM & DIAGNOSTIK ---
            ['code' => '89.0', 'name' => 'Interview, evaluation, consultation, and examination'],
            ['code' => '89.7', 'name' => 'General physical examination'],
            ['code' => '90.5', 'name' => 'Microscopic examination of blood'],
            ['code' => '91.3', 'name' => 'Microscopic examination of urine'],
            ['code' => '87.44', 'name' => 'Routine chest x-ray, so described'],
            ['code' => '88.76', 'name' => 'Diagnostic ultrasound of abdomen and retroperitoneum'],
            ['code' => '88.78', 'name' => 'Diagnostic ultrasound of gravid uterus'],
            ['code' => '99.99', 'name' => 'Other miscellaneous procedures'],

            // --- SUNTIKAN & INFUS ---
            ['code' => '99.18', 'name' => 'Injection or infusion of electrolytes'],
            ['code' => '99.21', 'name' => 'Injection of antibiotic'],
            ['code' => '99.23', 'name' => 'Injection of steroid'],
            ['code' => '99.29', 'name' => 'Injection or infusion of other therapeutic or prophylactic substance'],
            ['code' => '93.96', 'name' => 'Other oxygen enrichment'],

            // --- BEDAH MINOR & LUKA ---
            ['code' => '86.59', 'name' => 'Closure of skin and subcutaneous tissue of other sites'],
            ['code' => '86.22', 'name' => 'Excisional debridement of wound, infection, or burn'],
            ['code' => '86.04', 'name' => 'Other incision with drainage of skin and subcutaneous tissue'],
            ['code' => '86.11', 'name' => 'Biopsy of skin and subcutaneous tissue'],
            ['code' => '23.0', 'name' => 'Extraction of tooth'],
            ['code' => '23.2', 'name' => 'Restoration of tooth by filling'],
            ['code' => '96.51', 'name' => 'Irrigation of eye'],
            ['code' => '96.52', 'name' => 'Irrigation of ear'],
            ['code' => '97.11', 'name' => 'Replacement of cast on upper limb'],
            ['code' => '97.12', 'name' => 'Replacement of cast on lower limb'],

            // --- IBU & ANAK ---
            ['code' => '72.0', 'name' => 'Low forceps operation'],
            ['code' => '73.59', 'name' => 'Manually assisted delivery'],
            ['code' => '75.34', 'name' => 'Other fetal monitoring'],
            ['code' => '69.7', 'name' => 'Insertion of contraceptive device'],
            ['code' => '69.02', 'name' => 'Dilation and curettage following delivery or abortion'],

            // --- LAIN-LAIN ---
            ['code' => '57.94', 'name' => 'Insertion of indwelling urinary catheter'],
            ['code' => '96.04', 'name' => 'Insertion of endotracheal tube'],
            ['code' => '93.54', 'name' => 'Application of splint'],
            ['code' => '93.57', 'name' => 'Application of other wound dressing'],
        ];

        foreach ($data as $item) {
            Icd9Procedure::create($item);
        }
    }
}
