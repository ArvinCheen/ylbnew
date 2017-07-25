<?php

namespace App\Http\Library;

class adminsLibrary {

    public function __construct()
    {
    }

    # 檢查登入
    function check_login()
    {
        # 取記住我資料庫資料 判斷自動登入
        # 有 cookie
        if(!empty(get_cookie('SSID')))
        {
            $session_id = get_cookie('SSID');
            $user_ip = $this->ci->user_equipment_info->get_user_ip();
            $user_agent = $this->ci->user_equipment_info->get_user_agent();

            $result = $this->ci->admins_worker_remember_me_model->get_workerlogin_remember_me_by_session_id($session_id);

            if (!empty($result))
            {
                # 全部正確 且 未過期
                if( ($session_id === ($result['0']->session_id)) and ($user_ip === $result['0']->ip_address) and ($user_agent === $result['0']->user_agent) and (time() < $result['0']->expire_time) )
                {
                    $_SESSION['worker_sn'] = $result['0']->worker_sn;

                    # 載入員工資料
                    $worker_info = $this->load_worker_info();

                    # 檢查權限
                    if($this->check_access() == FALSE)
                    {
                        redirect('/admins/login','refresh');
                    }

                    return $worker_info;
                }
                else
                {
                    # 刪除記住我資料庫資料
                    $this->ci->admins_worker_remember_me_model->delete_workerlogin_remember_me_by_session_id($session_id);
                    # 刪除cookie
                    delete_cookie('SSID');
                    # 登出
                    redirect('/admins/login','refresh');
                }
            }
            # 有cookie 資料庫 沒資料
            else
            {
                # 登出
                redirect('/admins/login','refresh');
            }
        }
        # 檢查 無 session 無 cookie 轉至登入頁
        else if (!isset($_SESSION['worker_sn']) and empty(get_cookie('SSID')))
        {
            # 轉至登入頁
            redirect('/admins/login','refresh');
        }
        # 檢查權限 若為FALSE 轉回首頁
        else if($this->check_access() == FALSE)
        {
            # 轉至登入頁
            redirect('/admins/','refresh');
        }
        else
        {
            # 載入員工資料
            $worker_info = $this->load_worker_info();

            return $worker_info;
        }
    }
    # 檢查權限
    function check_access()
    {
        $url = explode("/",$_SERVER['REQUEST_URI']);

        if(sizeof($url) > 2)
        {
            $temp = explode("?",$url["2"]);
            $url["2"] = $temp["0"];

            switch ($url["2"])
            {
                # 會員管理
                # 會員列表 功能 開放權限
                # 開放以下功能： 會員資料tab：會員近況、完整資料、完整談話紀錄(待整理)、帳戶狀況、審核資料 功能：會員分類、分類管理、會員Tag、Tag管理
                case 'member_list':
                    return $this->ci->admins_worker_access_model->check_access_exist('member_list',$_SESSION['worker_sn']);
                    break;
                # 會員分配 功能：單一分配、分配記錄
                case 'member_assignment':
                    return $this->ci->admins_worker_access_model->check_access_exist('member_assignment',$_SESSION['worker_sn']);
                    break;
                default:
                    return $this->ci->admins_worker_access_model->check_access_exist($url["2"],$_SESSION['worker_sn']);
                    break;
            }
        }
        else
        {
            return TRUE;
        }
    }

    # 取 src 底下 指定資料夾 檔案清單 input: 路徑 , 型態(array/json)
    function get_file_list($full_path,$return_type)
    {
        $file_list = array();

        if(!file_exists($full_path))
        {
            return FALSE;
        }
        else
        {
            foreach (glob($full_path."*.*") as $file)
            {
                $filename = explode($full_path, $file);
                array_push($file_list,$filename[1]);
            }

            if($return_type == "json")
            {
                echo json_encode($file_list);
            }
            else if($return_type == "array")
            {
                return $file_list;
            }
        }
    }
    # 談話紀錄 資料轉換
    function get_member_talk_record_transfer(&$transferdata)
    {
        foreach ($transferdata as $key => $value)
        {
            # 建立時間
            $transferdata[$key]->create_time = $this->unix_time_to_time_format($value->create_time,'Y-m-d H:i');

            # 下次連絡時間
            if($value->next_contact_time != null && $value->next_contact_time != 0)
            {
                $transferdata[$key]->next_contact_time = $this->unix_time_to_time_format($value->next_contact_time,'Y-m-d H:i');
            }
            else
            {
                $transferdata[$key]->next_contact_time = "";
            }


            # 員工姓名
            $transferdata[$key]->create_worker = $transferdata[$key]->name.' '.$transferdata[$key]->e_name;
        }
    }

    # 載入員工資料
    function load_worker_info()
    {
        $worker_info = $this->ci->admins_worker_model->get_worker_info_by_worker_sn($_SESSION['worker_sn']);

        if (!empty($worker_info))
        {
            foreach ($worker_info as $key => $value)
            {
                $value->worker_c_e_name = $value->name." ".$value->e_name;
            }
        }

        # 載入權限資料
        $worker_info['access_item'] = $this->ci->admins_worker_access_model->get_worker_access_by_worker_sn($_SESSION['worker_sn']);

        return $worker_info;
    }

    # 會員列表 私人TAG 子function 多欄合併成一欄
    function push_object_tag(&$temp,$objname,$objvalue,&$count)
    {
        if($count == 0)
        {
            $temp->$objname = "# ".$objvalue;
        }
        else
        {
            $temp->$objname .= "<br># ".$objvalue;
        }
        $count++;
    }
    # 會員列表 完整資料 子function 多欄合併成一欄
    function push_object(&$temp,$objname,$objvalue,&$count)
    {
        if($count == 0)
        {
            $temp->$objname = $objvalue;
        }
        else
        {
            $temp->$objname .= ",".$objvalue;
        }
        $count++;
    }

    # 密碼加密
    function password_hash($password)
    {
        $password = sha1(hash('sha512',md5($password)));
        return $password;

    }

    # 轉換 常數表/無資料 欄位值
    function transfer_member_data_format($temp)
    {
        # 處理一般textbox欄位
        # 資料庫直接取值
        # 基本資料
        #姓名
        $temp->member_name 					= ($temp->member_name != NULL)? $temp->member_name : '無資料';
        #暱稱
        $temp->member_nickname 				= ($temp->member_nickname != NULL)? $temp->member_nickname : '無資料';
        #出生年月日
        $temp->member_birthday 				= ($temp->member_birthday != 0)? $this->unix_time_to_time_format($temp->member_birthday,'Y-m-d') : '無資料';

        #身分證字號
        $temp->member_idcard_number 		= (($temp->member_idcard_number != NULL))? $temp->member_idcard_number : '無資料';
        #身高
        $temp->member_height 				= ($temp->member_height != 0)? $temp->member_height : '無資料';
        #體重
        $temp->member_weight 				= ($temp->member_weight != 0)? $temp->member_weight : '無資料';
        # 通訊方式
        #E-mail
        $temp->member_email 				= ($temp->member_email != NULL)? $temp->member_email : '無資料';
        #Line-ID
        $temp->member_line_id 				= ($temp->member_line_id != NULL)? $temp->member_line_id : '無資料';
        #Wechat-ID
        $temp->member_wechat_id 			= ($temp->member_wechat_id != NULL)? $temp->member_wechat_id : '無資料';
        # 學經歷背景
        #最高學歷校名
        $temp->member_highest_school_name 	= ($temp->member_highest_school_name != NULL)? $temp->member_highest_school_name : '無資料';
        #任職公司名稱
        $temp->member_company_name 			= ($temp->member_company_name != NULL)? $temp->member_company_name : '無資料';
        # 收入能力
        #年收入(單位：萬元)*
        $temp->member_income_year 			= $temp->member_income_year." 萬元";
        #不動產#＿不動產價值(單位：佰萬元)*
        $temp->member_immovables_value 		= $temp->member_immovables_value." 佰萬元";
        # 收入能力 # 其他資產
        #＿其他資產價值(單位：佰萬元)*
        $temp->member_other_assets_value 	= $temp->member_other_assets_value." 佰萬元";
        #＿負債金額(單位：佰萬元)*
        $temp->member_debt_value 			= $temp->member_debt_value." 佰萬元";

        # 處理單選欄位
        # 以常數表內容置換值
        # 基本資料
        #性別(MGE)
        $temp->member_gender 				= ($temp->member_gender != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MGE',$temp->member_gender) : '無資料';
        #血型(MBT)
        $temp->member_blood_type 			= ($temp->member_blood_type != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MBT',$temp->member_blood_type) : '無資料';
        #星座(MZS)
        $temp->member_zodiac_sign 			= ($temp->member_zodiac_sign != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MZS',$temp->member_zodiac_sign) : '無資料';
        #生肖(GAZ)
        $temp->member_animal_zodiac 		= ($temp->member_animal_zodiac != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('GAZ',$temp->member_animal_zodiac) : '無資料';
        #婚姻狀況(MMS)
        $temp->member_marriage_status 		= ($temp->member_marriage_status != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MMS',$temp->member_marriage_status) : '無資料';
        #婚姻狀況#_子女人數(MCM)
        $temp->member_child_num 			= ($temp->member_child_num != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MCM',$temp->member_child_num) : '無資料';
        #婚姻狀況#_是否同住(GYN)
        $temp->member_child_live_together 	= ($temp->member_child_live_together != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('GYN',$temp->member_child_live_together) : '無資料';
        #居住地區(GTC)
        $temp->member_living_city 			= ($temp->member_living_city != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('GTC',$temp->member_living_city) : '無資料';
        #計畫結婚時間(MMT)
        $temp->member_hope_marry_time 		= ($temp->member_hope_marry_time != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MMT',$temp->member_hope_marry_time) : '無資料';
        # 學經歷背景
        #教育程度(MEL)
        $temp->member_highest_edu_level		= ($temp->member_highest_edu_level != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MEL',$temp->member_highest_edu_level) : '無資料';
        #科系類別(MSM)
        $temp->member_school_major			= ($temp->member_school_major != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MSM',$temp->member_school_major) : '無資料';
        # 科系(依英文取中文)
        $temp->member_school_dept			= (!empty($temp->member_school_dept)) ? $this->ci->constant_map_model->get_c_by_e($temp->member_school_dept) : '無資料';

        #學歷備註(MER)
        $temp->member_highest_edu_type		= ($temp->member_highest_edu_type != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MER',$temp->member_highest_edu_type) : '無資料';
        #產業類別(MSS)
        $temp->member_company_class			= ($temp->member_company_class != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MSS',$temp->member_company_class) : '無資料';
        # 產業(依英文取中文)
        $temp->member_company_class_sub		= (!empty($temp->member_company_class_sub)) ? $this->ci->constant_map_model->get_c_by_e($temp->member_company_class_sub) : '無資料';

        #職稱(MJT)
        $temp->member_job_name				= ($temp->member_job_name != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MJT',$temp->member_job_name) : '無資料';
        #現任公司年資(MCY)
        $temp->member_company_year 			= (!empty($temp->member_company_year)) ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MCY',$temp->member_company_year) : '無資料';

        # 家庭背景
        #家族成員(MFR)
        $temp->member_family_member 		= ($temp->member_family_member != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MFR',$temp->member_family_member) : '無資料';
        #家族成員(MFC)
        $temp->member_family_order 			= ($temp->member_family_order != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MFC',$temp->member_family_order) : '無資料';
        # 生活狀況
        #宗教信仰(MRB)
        $temp->member_faith 				= ($temp->member_faith != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MRB',$temp->member_faith) : '無資料';
        #政黨傾向(MMP)
        $temp->member_political_party 		= ($temp->member_political_party != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MMP',$temp->member_political_party) : '無資料';
        #飲食習慣(MDH)
        $temp->member_diet_habit 			= ($temp->member_diet_habit != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MDH',$temp->member_diet_habit) : '無資料';
        #抽菸(MHF)
        $temp->member_smoke 				= ($temp->member_smoke != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MHF',$temp->member_smoke) : '無資料';
        #喝酒(MHF)
        $temp->member_drink 				= ($temp->member_drink != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MHF',$temp->member_drink) : '無資料';
        #檳榔(MHF)
        $temp->member_betel_nut 			= ($temp->member_betel_nut != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MHF',$temp->member_betel_nut) : '無資料';
        #家族遺傳疾病史(GYN)
        $temp->member_family_heredity 		= ($temp->member_family_heredity != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('GYN',$temp->member_family_heredity) : '無資料';
        #個人身體狀況(MBS)
        $temp->member_body_status 			= ($temp->member_body_status != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MBS',$temp->member_body_status) : '無資料';
        #前科紀錄(MCR)
        $temp->member_crime_record 			= ($temp->member_crime_record != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MCR',$temp->member_crime_record) : '無資料';
        # 收入能力
        #不動產 ( 房子、土地 )*(GHN)
        $temp->member_immovables 			= ($temp->member_immovables != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('GHN',$temp->member_immovables) : '無資料';

        # 期許資料
        # 對象生活狀況
        #飲食習慣(MDH)
        $temp->member_hope_diet_habit 		= ($temp->member_hope_diet_habit != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MDH',$temp->member_hope_diet_habit) : '無資料';
        #抽菸(MHF)
        $temp->member_hope_smoke 			= ($temp->member_hope_smoke != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MHF',$temp->member_hope_smoke) : '無資料';
        #喝酒(MHF)
        $temp->member_hope_drink 			= ($temp->member_hope_drink != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MHF',$temp->member_hope_drink) : '無資料';
        #檳榔(MHF)
        $temp->member_hope_betel_nut 		= ($temp->member_hope_betel_nut != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MHF',$temp->member_hope_betel_nut) : '無資料';
        # 對象的收入能力
        #不動產 ( 房子、土地 )*(MYC)
        $temp->member_hope_immovables 		= ($temp->member_hope_immovables != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MYC',$temp->member_hope_immovables) : '無資料';

        # 互動與心態
        # 互動資料 # 感情經歷
        #戀愛經歷次數(MEN)
        $temp->member_interactive_ex_love_num 	= ($temp->member_interactive_ex_love_num != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MEN',$temp->member_interactive_ex_love_num) : '無資料';
        #_空窗期(MWD)
        $temp->member_interactive_window_period	= ($temp->member_interactive_window_period != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MWD',$temp->member_interactive_window_period) : '無資料';
        #_最近分手原因(MBR)
        $temp->member_interactive_why_break_last_love = ($temp->member_interactive_why_break_last_love != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MBR',$temp->member_interactive_why_break_last_love) : '無資料';
        #_最久分手原因(MBR)
        $temp->member_interactive_why_break_long_love = ($temp->member_interactive_why_break_long_love != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MBR',$temp->member_interactive_why_break_long_love) : '無資料';
        # 互動資料 # 互動測驗
        #約會中應該誰買單(MWP)
        $temp->member_interactive_date_who_pay = ($temp->member_interactive_date_who_pay != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MWP',$temp->member_interactive_date_who_pay) : '無資料';

        # 心態
        #你願意付出多少時間找尋對象(MPT)
        $temp->member_interactive_pay_time = ($temp->member_interactive_pay_time != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MPT',$temp->member_interactive_pay_time) : '無資料';
        #希望婚後的生活圈是(MME)
        $temp->member_interactive_life_circle = ($temp->member_interactive_life_circle != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MME',$temp->member_interactive_life_circle) : '無資料';
        #婚後你會承擔多少家務(MHW)
        $temp->member_interactive_housework = ($temp->member_interactive_housework != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MHW',$temp->member_interactive_housework) : '無資料';
        #對方的家庭狀況重要嗎(MFS)
        $temp->member_interactive_family_status = ($temp->member_interactive_family_status != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MFS',$temp->member_interactive_family_status) : '無資料';
        #兩個人相處最重要的是？(MLI)
        $temp->member_interactive_relate_important = ($temp->member_interactive_relate_important != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MLI',$temp->member_interactive_relate_important) : '無資料';
        #兩個人相處最重要的是？(MIP)
        $temp->member_interactive_live_with_parent = ($temp->member_interactive_live_with_parent != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MIP',$temp->member_interactive_live_with_parent) : '無資料';
        #婚後經濟分配(MMA)
        $temp->member_interactive_money_after_married = ($temp->member_interactive_money_after_married != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MMA',$temp->member_interactive_money_after_married) : '無資料';
        #婚後是否生育小孩(MKM)
        $temp->member_interactive_kid_after_married = ($temp->member_interactive_kid_after_married != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MKM',$temp->member_interactive_kid_after_married) : '無資料';
        #婚後是否養寵物(MPM)
        $temp->member_interactive_pet_after_married = ($temp->member_interactive_pet_after_married != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MPM',$temp->member_interactive_pet_after_married) : '無資料';
        #對自己的外形是否願意改變(MCO)
        $temp->member_interactive_change_overall = ($temp->member_interactive_change_overall != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MCO',$temp->member_interactive_change_overall) : '無資料';
        #是否願意透過兩性溝通課程改變自己(MPC)
        $temp->member_interactive_promotion_class = ($temp->member_interactive_promotion_class != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MPC',$temp->member_interactive_promotion_class) : '無資料';
        # 備註資料
        #談吐等級(MAL)
        $temp->speech_level = ($temp->speech_level != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MAL',$temp->speech_level) : '無資料';
        #態度等級(MAL)
        $temp->attitude_level = ($temp->attitude_level != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MAL',$temp->attitude_level) : '無資料';
        #外表等級(MAL)
        $temp->appearance_level = ($temp->appearance_level != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MAL',$temp->appearance_level) : '無資料';
        #綜合等級(MAL)
        $temp->total_level = ($temp->total_level != '') ? $this->ci->constant_map_model->get_c_by_e_and_prefix('MAL',$temp->total_level) : '無資料';

        return $temp;
    }

    # 轉換時間 從 日期格式 Y-m-d H:i 轉成 unix time
    function time_format_to_unix_time($time_format='Y-m-d H:i:s')
    {
        // 廢除，改用「strtotime(日期)改代;
//        $date = new date($time_format);
//        return $date->format("U");
        dd('廢除，改用「strtotime(日期)改代');
    }
    # 轉換時間 從 unix time 轉成 日期格式 Y-m-d H:i
    function unix_time_to_time_format($unix_time='1478763620',$time_format='Y-m-d H:i:s')
    {
        $date = new DateTime();
        $date->setTimestamp($unix_time);
        return $date->format($time_format);
    }

    # 轉譯 審核狀態 成 中文
    function verify_status_trans_chinese($data=null)
    {
        if(!empty($data) and $data != "無資料" )
        {
            switch ($data)
            {
                case "no_verify":
                    $data = "待審";
                    break;
                case "verify_fail":
                    $data = "不通過";
                    break;
                case "verify_pass":
                    $data = "通過";
                    break;
            }
        }
        else
        {
            $data = "無資料";
        }
        return $data;
    }

    # 載入 header data
    function return_header_data($title=NULL)
    {
        if(isset($_SESSION['worker_sn']))
        {
            # 員工參數
            $worker_info = $this->load_worker_info();
            $worker_c_e_name = $worker_info[0]->worker_c_e_name;
            $access_item = $worker_info['access_item'];
            $worker_sn = !empty($worker_sn) ? $worker_sn : @$_SESSION['worker_sn'] ;
        }

        # 未登入 後台付款 手動建立選單
        if(!isset($_SESSION['worker_sn']) && ($title== '產品列表' || $title== '建立訂單' || $title== '確認訂單' || $title== '付款完成'))
        {
            $access_item[0] = (object) array(
                'order' => '170',
                'father_sn' => '0',
                'sn' => '51',
                'name' => '後台付款 payment',
                'url' => '/admins/payment/product_list',
                'show' => '1',
            );
            $access_item[1] = (object) array(
                'order' => '170',
                'father_sn' => '0',
                'sn' => '51',
                'name' => '後台訂單查詢',
                'url' => '/admins/payment/order_list',
                'show' => '1',
            );
        }

        $return_data = array(
            'worker_info' => @$worker_info,
            'worker_c_e_name' => @$worker_c_e_name,
            'worker_sn' => @$worker_sn,
            'title' => @$title,
            'access_item' => @$access_item,
        );

        return $return_data;
    }

    # 回傳 自我介紹、大頭照、個人照、各認證項目 的 最新審核狀態
    function get_newest_verify_status($verify_item,$member_sn)
    {
        # 審核項目 最新審核狀態
        switch ($verify_item)
        {
            case "introduction":
            case "mug_shot":
            case "personal_photo":
            case "onsite_verity":
            case "basic_profile":
            case "e_contract":
                $verify_data = $this->ci->admins_verify_model->get_newest_verify_data_info_s($member_sn,$verify_item,1);
                break;
            default:
                # 審核項目 最新審核狀態
                $verify_data = $this->ci->personal_info_model->get_verify_data_info_s($member_sn,$verify_item);
                break;
        }

        # 審核項目 最新審核狀態
        $newest_verify_status = (!empty($verify_data[0]->verify_status)) ? $this->verify_status_trans_chinese($verify_data[0]->verify_status) : '無資料' ;

        return $newest_verify_status;
    }

    # 取得 會員資料 (最新一筆 或 全部)
    function get_member_data($input_data=null,$limit_num=1)
    {
        # 在會員資料上 加入驗證項目
        $member_data = array();
        foreach ($input_data as $key => $value)
        {
            # 取會員資料
            # 最新審核通過會員資料
            # (大頭照、姓名、身分、性別、手機、編號)
            $member_data[$key] = new stdClass();
            $member_data[$key] = $value;
            $member_data[$key]->member_type = $this->ci->constant_map_model->get_c_by_e_and_prefix('MML',$value->member_type);

            # 認證檔案
            # 大頭照 X 最新已審核
            $member_data[$key]->mug_shot_pass = $this->ci->admins_verify_model->get_verify_data_info_s($member_data[$key]->member_sn,'mug_shot','verify_pass',$limit_num);
            # 會員照 取最新審核過的 若無審核過的紀錄 則為 null
            $member_data[$key]->member_pic_url = (!empty($member_data[$key]->mug_shot_pass[0]->pic_url)) ? $member_data[$key]->mug_shot_pass[0]->pic_url : null;
            $member_data[$key]->member_pic_url = (!empty($member_data[$key]->member_pic_url)) ? $this->ci->pic_control->create_real_file_name($member_data[$key]->member_pic_url) : null;

            # 取個人資料完成度%
            # 個資 (基本、期許、互動、心態 個別加總後平均)
            $member_data[$key]->personal_complete = (int)($member_data[$key]->personal_data_complete+$member_data[$key]->hope_data_complete+$member_data[$key]->interactive_data_complete+$member_data[$key]->mentality_data_complete)/4;
            # 總覽 (個資與驗證加總後平均)
            $member_data[$key]->total_complete = (int)($member_data[$key]->personal_complete+$member_data[$key]->verifty_data_complete)/2;
        }

        return $member_data;
    }
}