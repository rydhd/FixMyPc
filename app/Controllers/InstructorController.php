<?php

namespace App\Controllers;

class InstructorController extends BaseController
{
    public function dashboard()
    {
        return view('instructor/dashboard');
    }

}
