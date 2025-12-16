<?php namespace App\Models;

use CodeIgniter\Model;

class Iso001Model extends Model
{
    protected $table      = 'iso_001';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'iso00_id',
        'versi',
        'kode_dokumen',
        'nama_dokumen_internal',
        'nama_file',
        'file_path',
        'file_size',
        'mime_type',
        'tanggal_efektif',
        'halaman_dokumen',
        'ruang_lingkup',
        'tujuan',
        'status',
        'uploaded_by',
        'uploader_name',
        'uploader_role',
        'uploaded_at',
        'barcode'
    ];

    // --- RELASI ---
    public function master()
    {
        return $this->belongsTo(Iso00Model::class, 'iso00_id', 'id');
    }

    public function uploader()
    {
        return $this->belongsTo(UserModel::class, 'uploaded_by', 'id');
    }

    // --- LOGIKA BISNIS ---
    public function addRevision(array $data)
    {
        // Hitung versi terakhir
        $lastRevision = $this->where('iso00_id', $data['iso00_id'])
                             ->orderBy('id', 'DESC')
                             ->first();

        $newVersion = 'Rev-1';
        if ($lastRevision) {
            $num = (int) str_replace('Rev-', '', $lastRevision['versi']);
            $newVersion = 'Rev-' . ($num + 1);
        }

        $data['versi'] = $newVersion;

        return $this->insert($data);
    }

    public function getAllRevisions(int $iso00_id)
    {
        return $this->where('iso00_id', $iso00_id)
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }
}
