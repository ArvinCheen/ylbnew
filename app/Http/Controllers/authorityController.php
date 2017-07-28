<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\accessListModel;
use App\Model\workerAccessModel;


class authorityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $authorityList = accessListModel::all();
        return view('authority/authority', ['authorityList' => $authorityList]);
    }


    public function insertAuthority(Request $request)
    {
        $insertData = [
            'name' => $request->name,
            'url' => $request->url,
            'fatherSn' => $request->father_sn,
            'order' => $request->order,
            'show' => $request->show,
            'createTime' => time(),
        ];

        return accessListModel::insertGetId($insertData);
    }

    public function updateAuthority(Request $request)
    {
        $sn = $request->sn;

        $updateData = [
            'name' => $request->name,
            'url' => $request->url,
            'fatherSn' => $request->father_sn,
            'order' => $request->order,
            'show' => $request->show,
            'createTime' => time(),
        ];

        $authorityData = accessListModel::find($sn);
        return (int) $authorityData->update($updateData);
    }

    public function deleteAuthority(Request $request)
    {
        $sn = $request->sn;

        return accessListModel::destroy($sn);
    }
}
