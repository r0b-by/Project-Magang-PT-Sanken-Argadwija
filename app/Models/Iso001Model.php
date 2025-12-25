<?php namespace App\Models;

use CodeIgniter\Model;

class Iso001Model extends Model
{
    protected $table      = 'iso_001';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    // History → INSERT ONLY
    protected $useTimestamps = true;
    protected $createdField  = 'uploaded_at';
    protected $updatedField  = ''; // history tidak pernah diupdate

    protected $allowedFields = [
        'iso00_id',
        'department_id',
        'kode_dept',
        'nama_dept',
        'versi',
        'revision_note',

        // snapshot iso_00
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

        // snapshot user
        'uploaded_by',
        'uploader_name',
        'uploader_role',
    ];

    /* =====================================================
     | RELASI
     =====================================================*/

    public function master()
    {
        return $this->belongsTo(\App\Models\Iso00Model::class, 'iso00_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(\App\Models\DepartmentModel::class, 'department_id', 'id');
    }

    /* =====================================================
     | BUSINESS LOGIC
     =====================================================*/

    /**
     * Tambah revisi (snapshot dari iso_00)
     */
    public function addRevision(array $master, array $extra = [])
    {
        $last = $this->where('iso00_id', $master['id'])
                     ->orderBy('id', 'DESC')
                     ->first();

        $nextVersion = 'Rev-1';
        if ($last && !empty($last['versi'])) {
            $num = (int) str_replace('Rev-', '', $last['versi']);
            $nextVersion = 'Rev-' . ($num + 1);
        }

        $data = [
            'iso00_id'     => $master['id'],
            'department_id'=> $master['department_id'] ?? null,
            'kode_dept'    => $master['kode_dept'] ?? null,
            'nama_dept'    => $master['nama_dept'] ?? null,
            'versi'        => $nextVersion,

            // snapshot dokumen
            'kode_dokumen'          => $master['kode_dokumen'],
            'nama_dokumen_internal' => $master['nama_dokumen_internal'],
            'nama_file'             => $master['nama_file'],
            'file_path'             => $master['file_path'],
            'file_size'             => $master['file_size'],
            'mime_type'             => $master['mime_type'],
            'tanggal_efektif'       => $master['tanggal_efektif'],
            'halaman_dokumen'       => $master['halaman_dokumen'],
            'ruang_lingkup'         => $master['ruang_lingkup'],
            'tujuan'                => $master['tujuan'],
            'status'                => 'revisi',

            // snapshot user
            'uploaded_by'   => session()->get('user_id') ?? 0,
            'uploader_name' => session()->get('fullname') ?? 'system',
            'uploader_role' => session()->get('role') ?? 'system',
        ];

        $data = array_merge($data, $extra);

        return $this->insert($data);
    }

    /**
     * Ambil semua history satu dokumen
     */
    public function getRevisionsByMaster(int $iso00_id)
    {
        return $this->where('iso00_id', $iso00_id)
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil revisi terakhir untuk dokumen master
     */
    public function getLatestRevision(int $iso00_id)
    {
        return $this->where('iso00_id', $iso00_id)
                    ->orderBy('id', 'DESC')
                    ->first();
    }

    /**
     * Ambil 1 revisi spesifik
     */
    public function getRevision(int $id)
    {
        return $this->find($id);
    }
}
