<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Iso00Model;
use App\Models\IsoAccessUserModel;
use App\Models\IsoAccessHolderModel;

class IsoSearchController extends BaseController
{
    protected $iso00;
    protected $accessUser;
    protected $holder;

    public function __construct()
    {
        $this->iso00      = new Iso00Model();
        $this->accessUser = new IsoAccessUserModel();
        $this->holder     = new IsoAccessHolderModel();
    }

    public function index()
    {
        $q      = trim($this->request->getGet('q'));
        $role   = session()->get('role');
        $userId = session()->get('user_id');

        /* =====================================================
         * BASE QUERY (SAMA DENGAN INDEX)
         * =================================================== */
        $query = $this->iso00
            ->select('
                iso_00.*,
                uploader.fullname AS uploader_name,
                updater.fullname AS updater_name
            ')
            ->join('users AS uploader', 'uploader.id = iso_00.uploaded_by', 'left')
            ->join('users AS updater', 'updater.id = iso_00.updated_by', 'left');

        /* =====================================================
         * FILTER AKSES NON-ADMIN
         * =================================================== */
        if ($role !== 'admin') {

            $allowed = $this->accessUser
                ->select('iso_access_documents.iso00_id')
                ->join(
                    'iso_access_documents',
                    'iso_access_documents.holder_id = iso_access_users.holder_id'
                )
                ->where('iso_access_users.user_id', $userId)
                ->findAll();

            $docIds = array_column($allowed, 'iso00_id');

            if (empty($docIds)) {
                return view('iso00/partials/table_body', [
                    'documents' => []
                ]);
            }

            $query->whereIn('iso_00.id', $docIds);
        }

        /* =====================================================
         * SEARCH FILTER
         * =================================================== */
        if ($q !== '') {
            $query
                ->groupStart()
                    ->like('iso_00.kode_dokumen', $q)
                    ->orLike('uploader.fullname', $q)
                    ->orLike('updater.fullname', $q)
                ->groupEnd();
        }

        $documents = $query
            ->orderBy('iso_00.id', 'DESC')
            ->findAll();

        /* =====================================================
         * TAMBAHKAN HOLDER (SAMA SEPERTI INDEX)
         * =================================================== */
        foreach ($documents as &$doc) {

            $holders = $this->holder->getHolderWithUsersByDokumen($doc['id']);

            $doc['holder_code']  = $holders[0]['holder_code'] ?? null;
            $doc['holder_users'] = [];

            foreach ($holders as $h) {
                if (!empty($h['fullname'])) {
                    $doc['holder_users'][] = $h['fullname'];
                }
            }
        }

        return view('iso00/partials/table_body', [
            'documents' => $documents
        ]);
    }
}
