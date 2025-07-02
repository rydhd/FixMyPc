<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLoginController;
use Config\Auth;
use CodeIgniter\Shield\Authentication\Authenticators\Session;

class Home extends ShieldLoginController
{
    public function index(){
        return view('landing_page');
    }
}