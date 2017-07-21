<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\accessListModel;

class indexController extends Controller
{
    public function index(Request $request)
    {
        $orm = new accessListModel();
        $x = $orm->getTest();

        dd($x);
    }
}
