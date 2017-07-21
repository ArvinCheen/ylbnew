<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class loginInfoMModel extends Model
{
    protected $table = 'cs_login_info_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-21 拿取資料庫內此手機號碼以及User Agent的最後X筆登入記錄
    function get_login_log($userMobile, $userAgent, $md5CheckWord, $limit)
    {
        return $this->where('user_mobile', $userMobile)
            ->where('user_agent', $userAgent)
            ->where('md5_check_word', $md5CheckWord)
            ->limit($limit)
            ->orderBy("create_time",'DESC')
            ->get();
    }

    # 取得目前手機驗證碼
    function get_verify_code_by_phone($userMobile, $userAgent, $md5CheckWord)
    {
        return $this->select('sms_verify_code')
            ->where('user_mobile', $userMobile)
            ->where('user_agent', $userAgent)
            ->where('md5_check_word', $md5CheckWord)
            ->orderBy("create_time",'DESC')
            ->get();
    }

    # m-24 新增cs_login_info_m的登入紀錄資料
    public function insert_login_log($data)
    {
        /**
         * 改寫
         */
        $result = $this->db->insert('cs_login_info_m', $data);

        if($result)
        {
            return TRUE;
        }

        return FALSE;
    }

    # m-31 更新cs_login_info_m
    public function update_login_info_m($where_array,$update_array)
    {
        /**
         * 改寫
         */
        $this->db->where($where_array);
        $result = $this->db->update('cs_login_info_m',$update_array);

        if($result)
        {
            return TRUE;
        }

        return FALSE;
    }

    # m-32 拿取cs_login_info_m資料
    public function select_login_info_m($where_array,$x)
    {
        /**
         * 改寫
         */
        $this->db->select('*');
        $this->db->from('cs_login_info_m');
        $this->db->where($where_array);
        $this->db->limit($x);

        return $this->db->get()->result();
    }
}
