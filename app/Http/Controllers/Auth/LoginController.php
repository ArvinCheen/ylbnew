<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Model\workerInfoSModel;
use App\Model\workerRememberMModel;
use App\Model\constantMapModel;

use App\Http\Library\randomCreateLibrary;
use App\Http\Library\adminsLibrary;
use App\Http\Library\userInfoLibrary;

use Cookie;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->workerInfoSModel = new workerInfoSModel();
        $this->workerRememberMModel = new workerRememberMModel();
        $this->constantMapModel = new constantMapModel();

        $this->adminsLibrary = new adminsLibrary();
        $this->randomCreateLibrary = new randomCreateLibrary();
        $this->userInfoLibrary = new userInfoLibrary();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function index(Request $request)
    {
        $location = $this->constantMapModel->getConstantMapByType('GYH');
        $job = $this->constantMapModel->getConstantMapByType('EPN');
        $work_status = $this->constantMapModel->getConstantMapByType('ESS');
        $gender = $this->constantMapModel->getConstantMapByType('MGE');
        $working_type = $this->constantMapModel->getConstantMapByType('EWT');
        $edu = $this->constantMapModel->getConstantMapByType('MEL');

        foreach ($edu as $key => $value) {
            if($value->describe_e == "all") {
                unset($edu[$key]);
            }
        }

        $blood_type = $this->constantMapModel->getConstantMapByType('MBT');
        foreach ($blood_type as $key => $value) {
            if($value->describe_e == "all") {
                unset($blood_type[$key]);
            }
        }

        $data = [
            'location' => $location,
            'job' => $job,
            'work_status' => $work_status,
            'gender' => $gender,
            'working_type' => $working_type,
            'edu' => $edu,
            'blood_type' => $blood_type,
        ];

        return view('login', $data);
    }

    public function register(Request $request)
    {
        $account = $request->account;

        if (empty($account)) {
            $request->session()->flash('registerFlashError', '請輸入帳號');
            return redirect('login')->withInput();
        }

        $accountExist = $this->workerInfoSModel->check_account_exist($account);
        if($accountExist) {
            $request->session()->flash('registerFlashError', '帳號重覆');
            return redirect('login')->withInput();
        } else {
            $insert_data = [];
            $insert_data['employee_sn'] = $this->randomCreateLibrary->create_sn("worker_sn");
            $insert_data['account'] = $account;
            $insert_data['password'] = bcrypt($request->password);
            $insert_data['address'] = $request->address;
            $insert_data['blood_type'] = $request->blood_type;
            $insert_data['department'] = $request->department;
            $insert_data['e_name'] = $request->e_name;
            $insert_data['edu'] = $request->edu;
            $insert_data['emergency_contact_mobile'] = $request->emergency_contact_mobile;
            $insert_data['emergency_contact_relation'] = $request->emergency_contact_relation;
            $insert_data['emergency_name'] = $request->emergency_name;
            $insert_data['gender'] = $request->gender;
            $insert_data['job'] = $request->job;
            $insert_data['location'] = $request->location;
            $insert_data['name'] = $request->name;
            $insert_data['nickname'] = $request->nickname;
            $insert_data['private_mobile'] = $request->private_mobile;
            $insert_data['public_mobile'] = $request->public_mobile;
            $insert_data['roc_id'] = $request->roc_id;
            $insert_data['school'] = $request->school;
            $insert_data['work_status'] = $request->work_status;
            $insert_data['working_type'] = $request->working_type;
            $insert_data['birthday'] = strtotime($request->birthday);
            $insert_data['create_time'] = time();
            $this->workerInfoSModel->insert($insert_data);

            $request->session()->flash('registerFlashSuccess', '註冊成功，請重新登入');
            return redirect('login');
        }
    }


    public function login(Request $request)
    {
        $account = $request->login_account;
        $password = $request->login_password;
        if (Auth::attempt(['account' => $account, 'password' => $password], true)) {
            return redirect('index');
        } else {
            $request->session()->flash('loginFlashError', '帳號密碼錯誤');
            return redirect('login')->withInput();
        }
    }
}
