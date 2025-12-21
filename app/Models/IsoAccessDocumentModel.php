<?php

namespace App\Models;

use CodeIgniter\Model;

class IsoAccessDocumentModel extends Model
{
    protected $table      = 'iso_access_documents';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'holder_id',
        'iso00_id',
        'created_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = null;

    /* ===============================
     * AMBIL DOKUMEN BERDASARKAN HOLDER
     * =============================== */
    public function getDokumenByHolder(int $holderId): array
    {
        return $this->db->table('iso_access_documents AS iad')
            ->select([
                'i.id AS iso00_id',
                'i.kode_dokumen',
                'i.nama_dokumen_internal'
            ])
            ->join('iso_00 AS i', 'i.id = iad.iso00_id')
            ->where('iad.holder_id', $holderId)
            ->orderBy('i.kode_dokumen', 'ASC')
            ->get()
            ->getResultArray();
    }

    /* ===============================
     * AMBIL HOLDER DARI DOKUMEN
     * =============================== */
    public function getHolderByDokumen(int $iso00Id)
    {
        return $this->where('iso00_id', $iso00Id)->first();
    }

    /* ===============================
     * ASSIGN DOKUMEN KE HOLDER
     * =============================== */
    public function assignDocumentsToHolder(int $holderId, array $dokumenIds): bool
    {
        $this->db->transStart();

        // hapus lama
        $this->where('holder_id', $holderId)->delete();

        if (!empty($dokumenIds)) {
            $data = [];
            foreach ($dokumenIds as $dokId) {
                $data[] = [
                    'holder_id' => $holderId,
                    'iso00_id'  => $dokId,
                ];
            }
            $this->insertBatch($data);
        }

        $this->db->transComplete();

        return $this->db->transStatus();
    }
}
