<?php

namespace App\Controllers;

class InstructorController extends BaseController
{
    public function dashboard()
    {
        return view('instructor/dashboard');
    }
    public function students(){
        return view('instructor/students');
    }
}
