<?php

namespace App\Controllers;

class MasterAdminController extends BaseController
{
    public function dashboard()
    {
        return view('masteradmin/dashboard');
    }

}
