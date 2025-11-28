<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Icd10Code;
use Illuminate\Support\Facades\DB;

class Icd10Seeder extends Seeder
{
    public function run()
    {
        // Kosongkan tabel dulu agar tidak duplikat saat seeding ulang
        DB::table('icd10_codes')->truncate();

        $data = [
            // --- BAB 1: Penyakit Infeksi & Parasit (A00-B99) ---
            ['code' => 'A00', 'name' => 'Cholera', 'keywords' => 'Kolera, Diare, Muntaber'],
            ['code' => 'A01', 'name' => 'Typhoid and paratyphoid fevers', 'keywords' => 'Tifus, Tipes, Demam Tifoid'],
            ['code' => 'A09', 'name' => 'Infectious gastroenteritis and colitis, unspecified', 'keywords' => 'Diare, Mencret, Gastroenteritis, GEA'],
            ['code' => 'A15', 'name' => 'Respiratory tuberculosis, bacteriologically and histologically confirmed', 'keywords' => 'TBC, Tuberkulosis Paru, Batuk Darah, KP'],
            ['code' => 'A37', 'name' => 'Whooping cough', 'keywords' => 'Batuk Rejan, Pertusis'],
            ['code' => 'A90', 'name' => 'Dengue fever [classical dengue]', 'keywords' => 'DBD, Demam Berdarah, Dengue'],
            ['code' => 'A91', 'name' => 'Dengue haemorrhagic fever', 'keywords' => 'DBD, Demam Berdarah Dengue'],
            ['code' => 'B01', 'name' => 'Varicella [chickenpox]', 'keywords' => 'Cacar Air'],
            ['code' => 'B02', 'name' => 'Zoster [herpes zoster]', 'keywords' => 'Dompo, Cacar Ular, Herpes'],
            ['code' => 'B05', 'name' => 'Measles', 'keywords' => 'Campak, Gabag'],
            ['code' => 'B15', 'name' => 'Acute hepatitis A', 'keywords' => 'Hepatitis A, Sakit Kuning'],
            ['code' => 'B16', 'name' => 'Acute hepatitis B', 'keywords' => 'Hepatitis B, Sakit Kuning'],
            ['code' => 'B26', 'name' => 'Mumps', 'keywords' => 'Gondongan, Parotitis'],
            ['code' => 'B50', 'name' => 'Plasmodium falciparum malaria', 'keywords' => 'Malaria Tropika'],
            ['code' => 'B51', 'name' => 'Plasmodium vivax malaria', 'keywords' => 'Malaria Tertiana'],

            // --- BAB 2: Neoplasma / Kanker (C00-D48) ---
            ['code' => 'C50', 'name' => 'Malignant neoplasm of breast', 'keywords' => 'Kanker Payudara, Ca Mammae'],
            ['code' => 'C53', 'name' => 'Malignant neoplasm of cervix uteri', 'keywords' => 'Kanker Serviks, Kanker Leher Rahim'],
            ['code' => 'D17', 'name' => 'Benign lipomatous neoplasm', 'keywords' => 'Lipoma, Benjolan Lemak'],

            // --- BAB 4: Endokrin, Nutrisi, Metabolik (E00-E90) ---
            ['code' => 'E10', 'name' => 'Type 1 diabetes mellitus', 'keywords' => 'Diabetes Tipe 1, Gula Darah, Kencing Manis'],
            ['code' => 'E11', 'name' => 'Type 2 diabetes mellitus', 'keywords' => 'Diabetes Tipe 2, DM, Kencing Manis, Gula'],
            ['code' => 'E14', 'name' => 'Unspecified diabetes mellitus', 'keywords' => 'Diabetes, DM, Gula'],
            ['code' => 'E46', 'name' => 'Unspecified protein-energy malnutrition', 'keywords' => 'Gizi Buruk, Kurang Gizi'],
            ['code' => 'E66', 'name' => 'Obesity', 'keywords' => 'Obesitas, Kegemukan'],
            ['code' => 'E86', 'name' => 'Volume depletion', 'keywords' => 'Dehidrasi, Kurang Cairan'],

            // --- BAB 6: Penyakit Susunan Saraf (G00-G99) ---
            ['code' => 'G40', 'name' => 'Epilepsy', 'keywords' => 'Epilepsi, Ayan, Kejang'],
            ['code' => 'G43', 'name' => 'Migraine', 'keywords' => 'Migrain, Sakit Kepala Sebelah'],
            ['code' => 'G44', 'name' => 'Other headache syndromes', 'keywords' => 'Sakit Kepala, Pusing, Cekot-cekot'],
            ['code' => 'G44.2', 'name' => 'Tension-type headache', 'keywords' => 'Sakit Kepala Tegang, TTH'],
            ['code' => 'G81', 'name' => 'Hemiplegia', 'keywords' => 'Stroke, Lumpuh Sebelah'],

            // --- BAB 7: Penyakit Mata (H00-H59) ---
            ['code' => 'H10', 'name' => 'Conjunctivitis', 'keywords' => 'Konjungtivitis, Mata Merah, Belekan'],
            ['code' => 'H25', 'name' => 'Senile cataract', 'keywords' => 'Katarak'],
            ['code' => 'H52', 'name' => 'Disorders of refraction and accommodation', 'keywords' => 'Mata Minus, Rabun Jauh, Miopi, Hipermetropi'],

            // --- BAB 8: Penyakit Telinga (H60-H95) ---
            ['code' => 'H60', 'name' => 'Otitis externa', 'keywords' => 'Infeksi Telinga Luar, Sakit Telinga'],
            ['code' => 'H66', 'name' => 'Suppurative and unspecified otitis media', 'keywords' => 'Infeksi Telinga Tengah, Congek, OMP'],

            // --- BAB 9: Penyakit Sirkulasi / Jantung (I00-I99) ---
            ['code' => 'I10', 'name' => 'Essential (primary) hypertension', 'keywords' => 'Hipertensi, Darah Tinggi, HT'],
            ['code' => 'I20', 'name' => 'Angina pectoris', 'keywords' => 'Angina, Nyeri Dada, Jantung Koroner'],
            ['code' => 'I21', 'name' => 'Acute myocardial infarction', 'keywords' => 'Serangan Jantung, AMI'],
            ['code' => 'I50', 'name' => 'Heart failure', 'keywords' => 'Gagal Jantung, Jantung Lemah, CHF'],
            ['code' => 'I64', 'name' => 'Stroke, not specified as haemorrhage or infarction', 'keywords' => 'Stroke, CVA'],
            ['code' => 'I95', 'name' => 'Hypotension', 'keywords' => 'Hipotensi, Darah Rendah'],

            // --- BAB 10: Penyakit Pernapasan (J00-J99) ---
            ['code' => 'J00', 'name' => 'Acute nasopharyngitis [common cold]', 'keywords' => 'Pilek, Flu, Salesma, Common Cold'],
            ['code' => 'J01', 'name' => 'Acute sinusitis', 'keywords' => 'Sinusitis, Radang Sinus'],
            ['code' => 'J02', 'name' => 'Acute pharyngitis', 'keywords' => 'Radang Tenggorokan, Sakit Menelan'],
            ['code' => 'J03', 'name' => 'Acute tonsillitis', 'keywords' => 'Amandel, Radang Amandel, Tonsilitis'],
            ['code' => 'J06', 'name' => 'Acute upper respiratory infections of multiple and unspecified sites', 'keywords' => 'ISPA, Batuk Pilek, Masuk Angin'],
            ['code' => 'J18', 'name' => 'Pneumonia, organism unspecified', 'keywords' => 'Pneumonia, Radang Paru, Paru-paru Basah'],
            ['code' => 'J20', 'name' => 'Acute bronchitis', 'keywords' => 'Bronkitis, Radang Bronkus'],
            ['code' => 'J45', 'name' => 'Asthma', 'keywords' => 'Asma, Sesak Napas, Mengi'],
            ['code' => 'J44', 'name' => 'Other chronic obstructive pulmonary disease', 'keywords' => 'PPOK, Paru Obstruktif Kronis'],

            // --- BAB 11: Penyakit Pencernaan (K00-K93) ---
            ['code' => 'K02', 'name' => 'Dental caries', 'keywords' => 'Sakit Gigi, Gigi Berlubang'],
            ['code' => 'K04', 'name' => 'Diseases of pulp and periapical tissues', 'keywords' => 'Sakit Gigi, Pulpa'],
            ['code' => 'K21', 'name' => 'Gastro-oesophageal reflux disease', 'keywords' => 'GERD, Asam Lambung Naik'],
            ['code' => 'K29', 'name' => 'Gastritis and duodenitis', 'keywords' => 'Maag, Gastritis, Nyeri Ulu Hati, Sakit Perut'],
            ['code' => 'K30', 'name' => 'Dyspepsia', 'keywords' => 'Dispepsia, Kembung, Begah, Maag'],
            ['code' => 'K35', 'name' => 'Acute appendicitis', 'keywords' => 'Usus Buntu, Apendisitis'],
            ['code' => 'K59.0', 'name' => 'Constipation', 'keywords' => 'Sembelit, Susah BAB, Konstipasi'],
            ['code' => 'K80', 'name' => 'Cholelithiasis', 'keywords' => 'Batu Empedu'],

            // --- BAB 12: Penyakit Kulit (L00-L99) ---
            ['code' => 'L02', 'name' => 'Cutaneous abscess, furuncle and carbuncle', 'keywords' => 'Bisul, Abses, Udun'],
            ['code' => 'L03', 'name' => 'Cellulitis', 'keywords' => 'Selulitis, Infeksi Kulit'],
            ['code' => 'L20', 'name' => 'Atopic dermatitis', 'keywords' => 'Eksim, Gatal-gatal, Alergi Kulit'],
            ['code' => 'L50', 'name' => 'Urticaria', 'keywords' => 'Biduran, Kaligata, Gatal Bentol'],
            ['code' => 'L70', 'name' => 'Acne', 'keywords' => 'Jerawat'],

            // --- BAB 13: Penyakit Otot & Tulang (M00-M99) ---
            ['code' => 'M06', 'name' => 'Other rheumatoid arthritis', 'keywords' => 'Rematik, Radang Sendi'],
            ['code' => 'M10', 'name' => 'Gout', 'keywords' => 'Asam Urat, Pirai'],
            ['code' => 'M54.5', 'name' => 'Low back pain', 'keywords' => 'Sakit Pinggang, Nyeri Punggung Bawah, LBP, Boyok'],
            ['code' => 'M79.1', 'name' => 'Myalgia', 'keywords' => 'Nyeri Otot, Pegal Linu, Myalgia'],

            // --- BAB 14: Penyakit Kemih & Kelamin (N00-N99) ---
            ['code' => 'N17', 'name' => 'Acute kidney failure', 'keywords' => 'Gagal Ginjal Akut'],
            ['code' => 'N18', 'name' => 'Chronic kidney disease', 'keywords' => 'Gagal Ginjal Kronis, CKD, Cuci Darah'],
            ['code' => 'N20', 'name' => 'Calculus of kidney and ureter', 'keywords' => 'Batu Ginjal, Kencing Batu'],
            ['code' => 'N39.0', 'name' => 'Urinary tract infection, site not specified', 'keywords' => 'ISK, Infeksi Saluran Kemih, Anyang-anyangan, Sakit Kencing'],

            // --- BAB 18: Gejala & Tanda Umum (R00-R99) ---
            ['code' => 'R05', 'name' => 'Cough', 'keywords' => 'Batuk'],
            ['code' => 'R07', 'name' => 'Pain in throat and chest', 'keywords' => 'Nyeri Dada'],
            ['code' => 'R10', 'name' => 'Abdominal and pelvic pain', 'keywords' => 'Sakit Perut, Nyeri Perut, Colic'],
            ['code' => 'R11', 'name' => 'Nausea and vomiting', 'keywords' => 'Mual, Muntah'],
            ['code' => 'R50', 'name' => 'Fever of other and unknown origin', 'keywords' => 'Demam, Panas, Febris'],
            ['code' => 'R51', 'name' => 'Headache', 'keywords' => 'Sakit Kepala, Pusing, Cekot-cekot, Cephalgia'],
            ['code' => 'R53', 'name' => 'Malaise and fatigue', 'keywords' => 'Lemas, Letih, Lesu, Badan Gak Enak'],

            // --- BAB 19: Cedera & Keracunan (S00-T98) ---
            ['code' => 'S00', 'name' => 'Superficial injury of head', 'keywords' => 'Luka Lecet Kepala, Benjol'],
            ['code' => 'S01', 'name' => 'Open wound of head', 'keywords' => 'Luka Robek Kepala'],
            ['code' => 'S60', 'name' => 'Superficial injury of wrist and hand', 'keywords' => 'Luka Tangan'],
            ['code' => 'T14', 'name' => 'Injury of unspecified body region', 'keywords' => 'Luka, Cedera, Kecelakaan'],
            ['code' => 'T31', 'name' => 'Burns classified according to extent of body surface involved', 'keywords' => 'Luka Bakar'],

            // --- BAB 21: Faktor Pelayanan Kesehatan (Z00-Z99) ---
            ['code' => 'Z00', 'name' => 'General examination and investigation of persons without complaint', 'keywords' => 'Check Up, Periksa Kesehatan, MCU'],
            ['code' => 'Z30', 'name' => 'Contraceptive management', 'keywords' => 'KB, Keluarga Berencana, Suntik KB, Pil KB'],
            ['code' => 'Z48', 'name' => 'Follow-up surgical care', 'keywords' => 'Ganti Perban, Kontrol Jahitan, Post Op'],
        ];

        foreach ($data as $item) {
            Icd10Code::create($item);
        }
    }
}
