<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Iso00Seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode_dokumen'   => 'DOC-001',
                'departement'    => 'HRD',
                'nama_file'      => 'doc_001_v1.pdf',
                'keterangan'     => 'Prosedur Absensi Karyawan',
                'status'         => 'save',
                'user_update'    => 'user_hrd',
            ],
            [
                'kode_dokumen'   => 'DOC-002',
                'departement'    => 'IT',
                'nama_file'      => 'doc_002_v1.pdf',
                'keterangan'     => 'Prosedur Backup Data',
                'status'         => 'save',
                'user_update'    => 'user_it',
            ],
            [
                'kode_dokumen'   => 'DOC-003',
                'departement'    => 'Management',
                'nama_file'      => 'doc_003_v1.pdf',
                'keterangan'     => 'Kebijakan Mutu Perusahaan',
                'status'         => 'save',
                'user_update'    => 'admin',
            ],
        ];

        $this->db->table('iso_00')->insertBatch($data);
    }
}
