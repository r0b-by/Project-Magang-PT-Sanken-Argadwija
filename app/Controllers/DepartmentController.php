<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DepartmentModel;

class DepartmentController extends BaseController
{
    protected $department;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->department = new DepartmentModel();
    }

    /* ============================================================
     * LIST DEPARTMENT
     * ============================================================ */
    public function index()
    {
        $data['departments'] = $this->department->findAll(); // findAll() lebih standar
        return view('departments/index', $data);
    }

    /* ============================================================
     * FORM TAMBAH DEPARTMENT
     * ============================================================ */
    public function create()
    {
        return view('departments/create');
    }

    /* ============================================================
     * SIMPAN DEPARTMENT BARU
     * ============================================================ */
    public function store()
    {
        $rules = [
            'kode_dept' => 'required|is_unique[departments.kode_dept]',
            'nama_dept' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->department->insert([
            'kode_dept' => strtoupper($this->request->getPost('kode_dept')),
            'nama_dept' => $this->request->getPost('nama_dept'),
        ]);

        return redirect()->to('/departments')
            ->with('success', 'Department berhasil ditambahkan!');
    }

    /* ============================================================
     * FORM EDIT DEPARTMENT
     * ============================================================ */
    public function edit($id)
    {
        $department = $this->department->find((int)$id);

        if (!$department) {
            return redirect()->to('/departments')
                ->with('error', 'Department tidak ditemukan!');
        }

        return view('departments/edit', [
            'department' => $department
        ]);
    }

    /* ============================================================
     * UPDATE DEPARTMENT
     * ============================================================ */
    public function update($id)
    {
        $department = $this->department->find((int)$id);

        if (!$department) {
            return redirect()->to('/departments')
                ->with('error', 'Department tidak ditemukan!');
        }

        $kodeDeptPost = strtoupper($this->request->getPost('kode_dept'));
        $rules = [
            'nama_dept' => 'required'
        ];

        // Validasi unik hanya jika kode_dept berubah
        if ($department['kode_dept'] !== $kodeDeptPost) {
            $rules['kode_dept'] = 'required|is_unique[departments.kode_dept]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->department->update($id, [
            'kode_dept' => $kodeDeptPost,
            'nama_dept' => $this->request->getPost('nama_dept'),
        ]);

        return redirect()->to('/departments')
            ->with('success', 'Department berhasil diperbarui!');
    }

    /* ============================================================
     * DELETE DEPARTMENT
     * ============================================================ */
    public function delete($id)
    {
        $department = $this->department->find((int)$id);

        if (!$department) {
            return redirect()->to('/departments')
                ->with('error', 'Department tidak ditemukan!');
        }

        // 🔒 Opsional: cek jika masih dipakai user
        // Misal: if ($this->userModel->where('department_id', $id)->countAllResults() > 0) { ... }

        $this->department->delete($id);

        return redirect()->to('/departments')
            ->with('success', 'Department berhasil dihapus!');
    }
}
