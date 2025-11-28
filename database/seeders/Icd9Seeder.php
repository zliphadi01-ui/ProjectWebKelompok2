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
            ['code' => '89.0', 'name' => 'Interview, evaluation, consultation, and examination', 'keywords' => 'Konsultasi Dokter, Periksa Dokter, Anamnesa'],
            ['code' => '89.7', 'name' => 'General physical examination', 'keywords' => 'Pemeriksaan Fisik, Cek Badan'],
            ['code' => '90.5', 'name' => 'Microscopic examination of blood', 'keywords' => 'Cek Darah, Lab Darah'],
            ['code' => '91.3', 'name' => 'Microscopic examination of urine', 'keywords' => 'Cek Urin, Lab Urin'],
            ['code' => '87.44', 'name' => 'Routine chest x-ray, so described', 'keywords' => 'Rontgen Dada, Foto Thorax, X-Ray'],
            ['code' => '88.76', 'name' => 'Diagnostic ultrasound of abdomen and retroperitoneum', 'keywords' => 'USG Perut, USG Abdomen'],
            ['code' => '88.78', 'name' => 'Diagnostic ultrasound of gravid uterus', 'keywords' => 'USG Hamil, USG Kandungan'],
            ['code' => '99.99', 'name' => 'Other miscellaneous procedures', 'keywords' => 'Tindakan Lain, Surat Sehat, Surat Sakit'],

            // --- SUNTIKAN & INFUS ---
            ['code' => '99.18', 'name' => 'Injection or infusion of electrolytes', 'keywords' => 'Infus, Pasang Infus'],
            ['code' => '99.21', 'name' => 'Injection of antibiotic', 'keywords' => 'Suntik Antibiotik'],
            ['code' => '99.23', 'name' => 'Injection of steroid', 'keywords' => 'Suntik Steroid'],
            ['code' => '99.29', 'name' => 'Injection or infusion of other therapeutic or prophylactic substance', 'keywords' => 'Suntik Obat, Injeksi'],
            ['code' => '93.96', 'name' => 'Other oxygen enrichment', 'keywords' => 'Oksigen, Pasang Oksigen, Nebulizer, Uap'],

            // --- BEDAH MINOR & LUKA ---
            ['code' => '86.59', 'name' => 'Closure of skin and subcutaneous tissue of other sites', 'keywords' => 'Jahit Luka, Hecting'],
            ['code' => '86.22', 'name' => 'Excisional debridement of wound, infection, or burn', 'keywords' => 'Bersihkan Luka, Debridement, Ganti Perban, Rawat Luka'],
            ['code' => '86.04', 'name' => 'Other incision with drainage of skin and subcutaneous tissue', 'keywords' => 'Insisi Abses, Pecah Bisul'],
            ['code' => '86.11', 'name' => 'Biopsy of skin and subcutaneous tissue', 'keywords' => 'Biopsi Kulit'],
            ['code' => '23.0', 'name' => 'Extraction of tooth', 'keywords' => 'Cabut Gigi'],
            ['code' => '23.2', 'name' => 'Restoration of tooth by filling', 'keywords' => 'Tambal Gigi'],
            ['code' => '96.51', 'name' => 'Irrigation of eye', 'keywords' => 'Irigasi Mata, Cuci Mata'],
            ['code' => '96.52', 'name' => 'Irrigation of ear', 'keywords' => 'Irigasi Telinga, Bersihkan Telinga, Spooling'],
            ['code' => '97.11', 'name' => 'Replacement of cast on upper limb', 'keywords' => 'Ganti Gips Tangan'],
            ['code' => '97.12', 'name' => 'Replacement of cast on lower limb', 'keywords' => 'Ganti Gips Kaki'],

            // --- IBU & ANAK ---
            ['code' => '72.0', 'name' => 'Low forceps operation', 'keywords' => 'Melahirkan Forceps'],
            ['code' => '73.59', 'name' => 'Manually assisted delivery', 'keywords' => 'Melahirkan Normal, Partus Spontan'],
            ['code' => '75.34', 'name' => 'Other fetal monitoring', 'keywords' => 'Cek Detak Jantung Janin, Doppler'],
            ['code' => '69.7', 'name' => 'Insertion of contraceptive device', 'keywords' => 'Pasang IUD, KB Spiral'],
            ['code' => '69.02', 'name' => 'Dilation and curettage following delivery or abortion', 'keywords' => 'Kuret'],

            // --- LAIN-LAIN ---
            ['code' => '57.94', 'name' => 'Insertion of indwelling urinary catheter', 'keywords' => 'Pasang Kateter, Pasang Selang Kencing'],
            ['code' => '96.04', 'name' => 'Insertion of endotracheal tube', 'keywords' => 'Intubasi, Pasang ETT'],
            ['code' => '93.54', 'name' => 'Application of splint', 'keywords' => 'Pasang Bidai, Spalk'],
            ['code' => '93.57', 'name' => 'Application of other wound dressing', 'keywords' => 'Perban Luka, Balut Luka'],
        ];

        foreach ($data as $item) {
            Icd9Procedure::create($item);
        }
    }
}
