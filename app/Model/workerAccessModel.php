<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class workerAccessModel extends Model
{
    protected $table = 'cs_worker_access';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # worker_access JOIN cs_access_list
    # 檢查權限是否存在
    function check_access_exist($url,$worker_sn)
    {
        $query = DB::table('cs_worker_access')
            ->select('access_sn,worker_sn')
            ->leftJoin('cs_access_list', 'cs_access_list.sn = cs_worker_access.access_sn');

        $condition = array(
            'worker_sn' => $worker_sn,
        );
        $query->where($condition);
        $query->like('url', $url);

        return $query->get();
    }
    # 取員工權限
    function get_worker_access_by_worker_sn($worker_sn)
    {
        $condition = array(
            'cs_worker_access.worker_sn' => $worker_sn,
        );
        return $this->leftJoin('cs_access_list', 'cs_access_list.sn = cs_worker_access.access_sn')
            ->where($condition)
            ->order_by("`father_sn` asc , `order` asc")
            ->get();
    }

    # worker_access
    # 新增員工權限
    function insert_worker_access_item($insert_data)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_worker_access', $insert_data);
        return $this->db->insert_id();
    }
    # 刪除員工權限 by access_sn
    function delete_worker_access_item_by_access_sn($access_sn)
    {
        return $this->where('access_sn', $access_sn)->delete();
    }
    # 刪除員工權限
    function delete_worker_access_item_by_worker_sn($worker_sn)
    {
        return $this->where('worker_sn', $worker_sn)->delete();
    }
}
