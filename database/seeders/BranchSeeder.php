<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'branch_name' => 'Merkez Şube',
                'branch_address' => 'Atatürk Caddesi No:123, İzmir',
                'branch_phone' => '0232 123 45 67',
                'branch_lat' => 38.4192,
                'branch_lng' => 27.1287,
            ],
            [
                'branch_name' => 'Karşıyaka Şube',
                'branch_address' => 'Karşıyaka Çarşı No:45, İzmir',
                'branch_phone' => '0232 234 56 78',
                'branch_lat' => 38.4559,
                'branch_lng' => 27.1098,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
