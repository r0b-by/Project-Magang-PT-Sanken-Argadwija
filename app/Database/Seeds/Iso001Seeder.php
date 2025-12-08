<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Iso001Seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'iso_00_id'      => 1,
                'kode_dokumen'   => 'DOC-001',
                'versi'          => 2,
                'nama_file'      => 'doc_001_v2.pdf',
                'keterangan'     => 'Revisi format laporan absensi',
                'status'         => 'revisi',
                'user_update'    => 'user_hrd',
            ],
            [
                'iso_00_id'      => 2,
                'kode_dokumen'   => 'DOC-002',
                'versi'          => 2,
                'nama_file'      => 'doc_002_v2.pdf',
                'keterangan'     => 'Update jadwal backup',
                'status'         => 'revisi',
                'user_update'    => 'user_it',
            ],
        ];

        $this->db->table('iso_001')->insertBatch($data);
    }
}
