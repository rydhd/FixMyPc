<?php

namespace App\Controllers;

class MasterAdminController extends BaseController
{
    public function dashboard()
    {
        return view('master_admin/master_dashboard');
    }
    public function students(){
        return view('master_admin/master_students');
    }

}
