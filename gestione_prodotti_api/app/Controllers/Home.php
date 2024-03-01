<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function home(): string
    {
        return view('home/index');
    }
}
