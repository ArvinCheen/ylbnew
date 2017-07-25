<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class indexController extends Controller
{
    public function index(Request $request)
    {
//        $x = Auth::user();
//        dd($x->name);
//        $accessListModel  = new accessListModel();
//        $leftList = $accessListModel->get();

        return view('layout/index');
    }
}
