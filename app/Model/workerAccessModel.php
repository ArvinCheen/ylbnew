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

    function getLeftMenuMainClass($workerSn)
    {
        $mainClass = $this->leftJoin('cs_access_list', 'cs_access_list.sn', 'cs_worker_access.access_sn')
            ->where('worker_sn', $workerSn)
            ->where('show', 1)
            ->where('father_sn', 0)
            ->orderBy('order')
            ->get();

        $data = [];
        foreach ($mainClass as $val) {

            switch ($val->sn) {
                case "1": $icon = 'icon-home'; break;  //儀表板
                case "34": $icon = 'icon-screen-desktop'; break;  //前台管理
                case "2": $icon = 'icon-users'; break;  //會員管理
                case "4": $icon = 'icon-ghost'; break;  //員工管理
                case "7": $icon = 'icon-lock'; break;  //權限管理
                case "28": $icon = 'icon-eye'; break;  //審核管理
                case "31": $icon = 'icon-shuffle'; break;  //資料轉換
            }
            $data[$val->sn]['icon'] = $icon;
            $data[$val->sn]['name'] = $val->name;
            $data[$val->sn]['url'] = $val->url;
        }

        return $data;
    }

    function getLeftMenuSubclass($workerSn)
    {
        $subClass = $this->leftJoin('cs_access_list', 'cs_access_list.sn', 'cs_worker_access.access_sn')
            ->where('worker_sn', $workerSn)
            ->where('show', 1)
            ->where('father_sn', '<>', 0)
            ->orderBy('father_sn')
            ->orderBy('order')
            ->get();

        $data = [];
        foreach ($subClass as $val) {
            $data[$val->father_sn][$val->sn]['name'] = $val->name;
            $data[$val->father_sn][$val->sn]['url'] = $val->url;
        }

        return $data;
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
        /**
         * 改寫
         */
        return $this->where('worker_sn', $worker_sn)->delete();
    }

}
