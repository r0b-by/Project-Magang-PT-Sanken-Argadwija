<?php namespace App\Models;

use CodeIgniter\Model;

class Iso00Model extends Model
{
    protected $table      = 'iso_00';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    // manual timestamp
    protected $useTimestamps = false;

    protected $allowedFields = [
        'kode_dokumen',
        'nama_dokumen_internal',
        'department_id',   // FK ke table departments
        'kode_dept',

        // file
        'nama_file',
        'file_path',
        'file_size',
        'mime_type',

        // metadata
        'tanggal_efektif',
        'halaman_dokumen',
        'ruang_lingkup',
        'tujuan',

        // status & revisi
        'status',        // unsave | save | revisi
        'revision_no',   // 0,1,2,3...
        'is_locked',     // 1 = terkunci (unsave)

        // uploader
        'uploaded_by',
        'uploader_name',
        'uploader_role',
        'uploader_foto',
        'uploaded_at',

        // updater
        'updated_by',
        'updated_at',

        // tambahan
        'barcode',
    ];

    /* =======================
     |        RELASI
     ======================= */

    public function revisions()
    {
        return $this->hasMany(\App\Models\Iso001Model::class, 'iso00_id', 'id');
    }

    public function uploader()
    {
        return $this->belongsTo(\App\Models\UserModel::class, 'uploaded_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\UserModel::class, 'updated_by', 'id');
    }

    public function department()
    {
        return $this->belongsTo(\App\Models\DepartmentModel::class, 'department_id', 'id');
    }

    /* =======================
     |     QUERY SIAP PAKAI
     ======================= */

    public function getWithHolder()
    {
        return $this->select([
                'iso_00.*',
                'iso_access_holders.id AS holder_id',
                'iso_access_holders.holder_code AS holder_code',
            ])
            ->join('iso_access_documents', 'iso_access_documents.iso00_id = iso_00.id', 'left')
            ->join('iso_access_holders', 'iso_access_holders.id = iso_access_documents.holder_id', 'left')
            ->groupBy('iso_00.id')
            ->orderBy('iso_00.kode_dokumen', 'ASC')
            ->findAll();
    }

    public function getByIdWithHolder(int $id)
    {
        return $this->select([
                'iso_00.*',
                'iso_access_holders.id AS holder_id',
                'iso_access_holders.holder_code AS holder_code',
            ])
            ->join('iso_access_documents', 'iso_access_documents.iso00_id = iso_00.id', 'left')
            ->join('iso_access_holders', 'iso_access_holders.id = iso_access_documents.holder_id', 'left')
            ->where('iso_00.id', $id)
            ->first();
    }

    public function getAccessibleByUser(int $userId)
    {
        return $this->select([
                'iso_00.*',
                'iso_access_holders.holder_code AS holder_code'
            ])
            ->join('iso_access_documents', 'iso_access_documents.iso00_id = iso_00.id')
            ->join('iso_access_holders', 'iso_access_holders.id = iso_access_documents.holder_id')
            ->join('iso_access_users', 'iso_access_users.holder_id = iso_access_documents.holder_id')
            ->where('iso_access_users.user_id', $userId)
            ->groupBy('iso_00.id')
            ->orderBy('iso_00.kode_dokumen', 'ASC')
            ->findAll();
    }

    /* =======================
     |     LOGIKA BISNIS ISO
     ======================= */

    public function isLocked(array $doc): bool
    {
        return ($doc['status'] ?? 'unsave') === 'unsave';
    }

    public function isFinalized(array $doc): bool
    {
        return ($doc['status'] ?? '') === 'save';
    }

    public function bumpRevision(int $id)
    {
        $doc = $this->find($id);
        if (!$doc) return false;

        return $this->update($id, [
            'status'      => 'revisi',
            'revision_no' => ($doc['revision_no'] ?? 0) + 1,
            'is_locked'   => 0,
        ]);
    }

    public function saveFinal(int $id)
    {
        return $this->update($id, [
            'status'    => 'save',
            'is_locked' => 0,
        ]);
    }

    public function getLatestRevision(int $iso00Id)
    {
        return model('Iso001Model')
            ->where('iso00_id', $iso00Id)
            ->orderBy('id', 'DESC')
            ->first();
    }

    public function searchLimited(string $keyword)
    {
        return $this->select([
                'iso_00.*',
                'iso_access_holders.holder_code'
            ])
            ->join('iso_access_documents', 'iso_access_documents.iso00_id = iso_00.id', 'left')
            ->join('iso_access_holders', 'iso_access_holders.id = iso_access_documents.holder_id', 'left')
            ->groupStart()
                ->like('iso_00.kode_dokumen', $keyword)
                ->orLike('iso_access_holders.holder_code', $keyword)
                ->orLike('iso_00.uploader_name', $keyword)
                ->orLike('iso_00.updated_by', $keyword)
            ->groupEnd()
            ->groupBy('iso_00.id')
            ->orderBy('iso_00.kode_dokumen', 'ASC')
            ->findAll();
    }
}
