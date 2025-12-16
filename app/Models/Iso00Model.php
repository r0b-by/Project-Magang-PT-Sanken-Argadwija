<?php namespace App\Models;

use CodeIgniter\Model;

class Iso00Model extends Model
{
    protected $table      = 'iso_00';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false; // karena sudah ada uploaded_at & updated_at manual
    protected $allowedFields = [
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
        'uploader_foto',
        'uploaded_at',
        'updated_by',
        'updated_at',
        'barcode'
    ];

    // --- RELASI ---
    public function revisions()
    {
        return $this->hasMany(Iso001Model::class, 'iso00_id', 'id');
    }

    public function uploader()
    {
        return $this->belongsTo(UserModel::class, 'uploaded_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(UserModel::class, 'updated_by', 'id');
    }

    // --- LOGIKA BISNIS ---
    public function addDocument(array $data)
    {
        // Tambahkan dokumen baru
        return $this->insert($data);
    }

    public function updateDocument(int $id, array $data)
    {
        // Update metadata / file master
        return $this->update($id, $data);
    }

    public function getLatestRevision(int $id)
    {
        return model('Iso001Model')
            ->where('iso00_id', $id)
            ->orderBy('id', 'DESC')
            ->first();
    }
}
