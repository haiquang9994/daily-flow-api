<?php

namespace App\Http\Controller;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->text('Phở ngon quá !!!');
    }
}
