<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Model\workerInfoSModel;
use App\Model\workerRememberMModel;
use App\Model\constantMapModel;

use App\cs_access_list;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->workerInfoSModel = new workerInfoSModel();
        $this->workerRememberMModel = new workerRememberMModel();
        $this->constantMapModel = new constantMapModel();

    }

    public function index(Request $request)
    {

        # 頁面下拉選單取值
        # 篩選 審核項目 下拉式選單 項目拉值
        # GYH(所屬會館)
        $location = $this->constantMapModel->getConstantMapByType('GYH');
        # EPN(職務)
        $job = $this->constantMapModel->getConstantMapByType('EPN');
        # ESS(在職狀況)
        $work_status = $this->constantMapModel->getConstantMapByType('ESS');
        # MGE(性別)
        $gender = $this->constantMapModel->getConstantMapByType('MGE');
        # EWT(員工上班型態)
        $working_type = $this->constantMapModel->getConstantMapByType('EWT');
        # MEL(最高學歷)
        $edu = $this->constantMapModel->getConstantMapByType('MEL');

        foreach ($edu as $key => $value) {
            # 去掉 不拘 選項
            if($value->describe_e == "all") {
                unset($edu[$key]);
            }
        }
        # MBT(血型)
        $blood_type = $this->constantMapModel->getConstantMapByType('MBT');
        foreach ($blood_type as $key => $value) {
            # 去掉 不拘 選項
            if($value->describe_e == "all") {
                unset($blood_type[$key]);
            }
        }

        # 取記住我資料庫資料 判斷自動登入
//        if(!empty(get_cookie('SSID')))
//        {
//            $session_id = get_cookie('SSID');
//            $user_ip = $this->user_equipment_info->get_user_ip();
//            $user_agent = $this->user_equipment_info->get_user_agent();
//
//            $result = $this->admins_worker_remember_me_model->get_workerlogin_remember_me_by_session_id($session_id);
//
//            if (!empty($result))
//            {
//                # 全部正確 且 未過期
//                if( ($session_id === ($result['0']->session_id)) and ($user_ip === $result['0']->ip_address) and ($user_agent === $result['0']->user_agent) and (time() < $result['0']->expire_time) )
//                {
//                    $_SESSION['worker_sn'] = $result['0']->worker_sn;
//                    redirect(base_url().'admins','refresh');
//                }
//                else
//                {
//                    # 刪除記住我資料庫資料
//                    $this->admins_worker_remember_me_model->delete_workerlogin_remember_me_by_session_id($session_id);
//                    # 刪除cookie
//                    delete_cookie('SSID');
//                    # 登出
//                    redirect(base_url().'admins/logout','refresh');
//                }
//            }
//        }

        # create_account_submit 送出申請
        if($request->create_account_submit) {
            if($this->input->post('account',TRUE) != "") {
                # 確認帳號是否重複
                $account_exist = $this->admins_worker_model->check_account_exist($this->input->post('account',TRUE));

                # 帳號 重複 則顯示錯誤訊息
                if($account_exist) {
                    $account = $this->input->post('account',TRUE);
                    $password = $this->input->post('password', TRUE);
                    $address = $this->input->post('address');
                    $blood_type = $this->input->post('blood_type');
                    $department = $this->input->post('department');
                    $e_name = $this->input->post('e_name');
                    $edu = $this->input->post('edu');
                    $emergency_contact_mobile = $this->input->post('emergency_contact_mobile');
                    $emergency_contact_relation = $this->input->post('emergency_contact_relation');
                    $emergency_name = $this->input->post('emergency_name');
                    $gender = $this->input->post('gender');
                    $job = $this->input->post('job');
                    $location = $this->input->post('location');
                    $name = $this->input->post('name');
                    $nickname = $this->input->post('nickname');
                    $private_mobile = $this->input->post('private_mobile');
                    $public_mobile = $this->input->post('public_mobile');
                    $birthday = $this->input->post("birthday",TRUE);
                    $roc_id = $this->input->post('roc_id');
                    $school = $this->input->post('school');
                    $work_status = $this->input->post('work_status');
                    $working_type = $this->input->post('working_type');
                    # 顯示錯誤訊息
                    $message_error = "帳號重複，請重新輸入！";
                } else {
                    $insert_data = array();
                    $insert_data['employee_sn'] = $this->ylb_random_create->create_sn("worker_sn");
                    $insert_data['account'] = $this->input->post('account',TRUE);
                    $insert_data['password'] = $this->lib_admins->password_hash($this->input->post('password', TRUE));
                    $insert_data['address'] = $this->input->post('address');
                    $insert_data['blood_type'] = $this->input->post('blood_type');
                    $insert_data['department'] = $this->input->post('department');
                    $insert_data['e_name'] = $this->input->post('e_name');
                    $insert_data['edu'] = $this->input->post('edu');
                    $insert_data['emergency_contact_mobile'] = $this->input->post('emergency_contact_mobile');
                    $insert_data['emergency_contact_relation'] = $this->input->post('emergency_contact_relation');
                    $insert_data['emergency_name'] = $this->input->post('emergency_name');
                    $insert_data['gender'] = $this->input->post('gender');
                    $insert_data['job'] = $this->input->post('job');
                    $insert_data['location'] = $this->input->post('location');
                    $insert_data['name'] = $this->input->post('name');
                    $insert_data['nickname'] = $this->input->post('nickname');
                    $insert_data['private_mobile'] = $this->input->post('private_mobile');
                    $insert_data['public_mobile'] = $this->input->post('public_mobile');
                    $insert_data['roc_id'] = $this->input->post('roc_id');
                    $insert_data['school'] = $this->input->post('school');
                    $insert_data['work_status'] = $this->input->post('work_status');
                    $insert_data['working_type'] = $this->input->post('working_type');
                    # time_format_to_unix_time
                    $insert_data['birthday'] = $this->lib_admins->time_format_to_unix_time($this->input->post("birthday",TRUE));
                    $insert_data['create_time'] = time();
                    # 建立員工
                    $this->admins_worker_model->insert_cs_worker_info_s($insert_data);

                    # 註冊成功訊息
                    $message_success = "註冊成功！ 請登入。";
                }
            }
        }

        # login_submit 登入
        if(($request->login_submit != null) || ($request->login_account != null) and ($request->login_password != null)) {
            # 記住我 checkbox 設定
            if($this->input->post('remember',TRUE) != NULL) {
                # 設置cookie 有效期間 (86400)*(30.44)*(3) = 3 個月
                $this->input->set_cookie('SSID',session_id(),(86400)*(30.44)*(3),'','/','',FALSE,TRUE);
                $remember = $this->input->post('remember',TRUE);
            } elseif (($this->input->post('login_account') != null) and ($this->input->post('login_password') != null) and ($this->input->post('remember',TRUE) == null)) {
                delete_cookie('SSID');
                unset($remember);
            } elseif (($this->input->post('login_account') == null) and ($this->input->post('login_password') == null) and (isset($_COOKIE['SSID']))) {
                $remember = 1;
            }

            # 檢查帳密
            if ( ($this->input->post('login_account') != null) and ($this->input->post('login_password') != null) ) {
                $account = $this->input->post('login_account', TRUE);
                $password = $this->lib_admins->password_hash($this->input->post('login_password', TRUE));
                $result = $this->admins_worker_model->get_worker_sn_by_check_login($account,$password);

                if (empty($result)) {
                    $error_msg = "帳號或密碼錯誤，請重新輸入";
                    # 帳密補回至登入頁
                    $remember_account = $this->input->post('login_account', TRUE);
                    $remember_password = $this->input->post('login_password', TRUE);
                } else {
                    $_SESSION['worker_sn'] = $result['0']->worker_sn;

                    /**/
                    # 寫入記住我資料庫
                    if($this->input->post('remember',TRUE) != NULL) {
                        $insert_data = array();
                        $insert_data['session_id'] = session_id();
                        $insert_data['worker_sn'] = $_SESSION['worker_sn'];
                        $insert_data['ip_address'] = $this->user_equipment_info->get_user_ip();
                        $insert_data['user_agent'] = $this->user_equipment_info->get_user_agent();
                        $insert_data['create_time'] = time();
                        $insert_data['expire_time'] = (int)time()+(86400)*(30.44)*(3);

                        $this->admins_worker_remember_me_model->insert_workerlogin_remember_me($insert_data);
                    }

                    redirect(base_url().'admins','refresh');
                }
            }
        }

        $view_data = array(
            'account' => @$account,
            'password' => @$password,
            'address' => @$address,
            'blood_type' => @$blood_type,
            'department' => @$department,
            'e_name' => @$e_name,
            'edu' => @$edu,
            'emergency_contact_mobile' => @$emergency_contact_mobile,
            'emergency_contact_relation' => @$emergency_contact_relation,
            'emergency_name' => @$emergency_name,
            'gender' => @$gender,
            'job' => @$job,
            'location' => @$location,
            'name' => @$name,
            'nickname' => @$nickname,
            'private_mobile' => @$private_mobile,
            'public_mobile' => @$public_mobile,
            'birthday' => @$birthday,
            'roc_id' => @$roc_id,
            'school' => @$school,
            'work_status' => @$work_status,
            'working_type' => @$working_type,
            'message_error' => @$message_error,
            'message_success' => @$message_success,
            'remember_account' => @$remember_account,
            'remember_password' => @$remember_password,
            'remember' => @$remember,
            'error_msg' => @$error_msg,
        );

        $data = [
            'location' => $location,
            'job' => $job,
            'work_status' => $work_status,
            'gender' => $gender,
            'working_type' => $working_type,
            'edu' => $edu,
            'blood_type' => $blood_type
        ];
        return view('login', $data);
    }
}
