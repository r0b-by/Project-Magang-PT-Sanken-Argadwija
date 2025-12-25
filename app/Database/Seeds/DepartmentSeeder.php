<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // 1
            [
                'kode_dept' => 'QS',
                'nama_dept' => 'Direksi / Factory Manager',
            ],
            // 2 (MR tidak punya kode di dokumen, tapi tetap butuh identitas)
            [
                'kode_dept' => 'MR',
                'nama_dept' => 'Management Representative',
            ],
            // 3
            [
                'kode_dept' => 'PP',
                'nama_dept' => 'Production Planning & Inventory Control (PPIC)',
            ],
            // 4
            [
                'kode_dept' => 'WG',
                'nama_dept' => 'Produksi White Goods, Brown Goods, Small Appliance',
            ],
            // 5
            [
                'kode_dept' => 'WH',
                'nama_dept' => 'Warehouse',
            ],
            // 6
            [
                'kode_dept' => 'PC',
                'nama_dept' => 'Purchasing',
            ],
            // 7
            [
                'kode_dept' => 'MT',
                'nama_dept' => 'Maintenance',
            ],
            // 8
            [
                'kode_dept' => 'RF',
                'nama_dept' => 'Refurbishment',
            ],
            // 9 (ENGINEERING UTAMA)
            [
                'kode_dept' => 'EN',
                'nama_dept' => 'Engineering',
            ],
            // 10
            [
                'kode_dept' => 'HG',
                'nama_dept' => 'Human Resource Department (HRD)',
            ],
            // 11
            [
                'kode_dept' => 'QC',
                'nama_dept' => 'Quality Control',
            ],
            // 12
            [
                'kode_dept' => 'IS',
                'nama_dept' => 'Information System',
            ],
            // 13
            [
                'kode_dept' => 'RG',
                'nama_dept' => 'Produksi Refrigerator',
            ],
        ];

        $this->db->table('departments')->insertBatch($data);
    }
}
