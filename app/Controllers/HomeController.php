<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function home()
    {
        // Render halaman home dan sertakan form scan
        return view('Home/index');
    }
}
