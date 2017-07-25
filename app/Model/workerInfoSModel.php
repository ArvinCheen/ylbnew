<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class workerInfoSModel extends Model
{
    protected $table = 'cs_worker_info_s';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # cs_worker_info_s
    # 檢查帳號是否存在
    function check_account_exist($account)
    {
        return $this->select('account')
            ->from('cs_worker_info_s')
            ->where('account' , $account)
            ->count();
    }

    # 登入檢查 條件:帳、密、在職
    function get_worker_sn_by_check_login($account, $password)
    {
        $data = $this->select('employee_sn')
            ->from('cs_worker_info_s')
            ->where('account', $account)
            ->where('password', $password)
            ->where('work_status','serving')
            ->get();

        if(count($data)) {
            return $data[0]->employee_sn;
        } else {
            return false;
        }
    }
    # 會員分配 取所有員工
    function get_worker_list()
    {
        return $this->select('employee_sn', 'name')
            ->get();
    }
    # 員工管理 取全部員工
    function get_worker_info_by_condition($condition=null)
    {
        $query = DB::table('cs_worker_info_s');
        if($condition != null)
        {
            $query->where($condition);
        }

        $query->orderBy('sn', 'desc')->get();
    }
    # 員工管理 取全部在職員工
    function get_all_online_worker()
    {
        return $this->where('work_status', 'serving')
            ->orderBy('sn', 'desc')
            ->get();
    }
    # 員工管理 取全部離職員工
    function get_all_offline_worker()
    {
        return $this->where('work_status', 'leave_work')
            ->orderBy('sn', 'desc')
            ->get();
    }
    # 取員工資料 by worker_sn
    function get_worker_info_by_worker_sn($worker_sn)
    {
        return $this->where('employee_sn', $worker_sn)
            ->orderBy('sn', 'desc')
            ->get();
    }
    # 權限管理 取worker_sn 除外的員工
    function get_worker_list_without_worker_sn($worker_sn)
    {
        return $this->select('employee_sn', 'name')
            ->where('employee_sn', '!=', $worker_sn)
            ->orderBy('sn', 'desc')
            ->get();
    }

    # 寫入員工建檔
    function insert_cs_worker_info_s($insert_data)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_worker_info_s', $insert_data);
        return $this->db->insert_id();
    }

    # 更新員工資料
    function update_cs_worker_info_s_by_worker_sn($update_data,$worker_sn)
    {
        /**
         * 改寫
         */
        $this->db->where('employee_sn',$worker_sn);
        $this->db->update('cs_worker_info_s', $update_data);
    }
}
