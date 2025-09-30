<?php
// database/seeders/TreatmentSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Treatment;

class TreatmentSeeder extends Seeder
{
    public function run()
    {
        $treatments = [
            ['code' => 'T001', 'name' => 'Pemeriksaan Umum', 'description' => 'Pemeriksaan rutin gigi dan mulut', 'price' => 50000],
            ['code' => 'T002', 'name' => 'Scaling', 'description' => 'Pembersihan karang gigi', 'price' => 150000],
            ['code' => 'T003', 'name' => 'Tambal Gigi', 'description' => 'Penambalan gigi berlubang', 'price' => 100000],
            ['code' => 'T004', 'name' => 'Cabut Gigi', 'description' => 'Ekstraksi gigi', 'price' => 200000],
            ['code' => 'T005', 'name' => 'Root Canal Treatment', 'description' => 'Perawatan saluran akar', 'price' => 500000],
            ['code' => 'T006', 'name' => 'Crown/Mahkota Tiruan', 'description' => 'Pemasangan mahkota tiruan', 'price' => 800000],
            ['code' => 'T007', 'name' => 'Bridge', 'description' => 'Gigi tiruan jembatan', 'price' => 1200000],
            ['code' => 'T008', 'name' => 'Denture/Gigi Tiruan Lepasan', 'description' => 'Gigi tiruan lepasan', 'price' => 1500000],
            ['code' => 'T009', 'name' => 'Bleaching/Whitening', 'description' => 'Pemutihan gigi', 'price' => 300000],
            ['code' => 'T010', 'name' => 'Orthodontic/Kawat Gigi', 'description' => 'Pemasangan kawat gigi', 'price' => 2000000],
        ];

        foreach ($treatments as $treatment) {
            Treatment::create($treatment);
        }
    }
}