<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Cek login dulu
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Cek role
        if ($arguments && !in_array($session->get('role'), $arguments)) {
            return redirect()->to('/login')->with('error', 'Akses ditolak!');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
