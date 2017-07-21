<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class reportListMModel extends Model
{
    protected $table = 'cs_report_list_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-76 新增檢舉內容。此時新增一筆檢舉資料。
    public function insert_report_list($data)
    {
        /**
         * 改寫
         */
        $result = $this->db->insert('cs_report_list_m', $data);

        if($result)
        {
            return TRUE;
        }

        return FALSE;
    }

    # m-77查詢某使用者的檢舉紀錄
    public function get_member_report_list($set_member_sn,$limit)
    {
        $array = array(
            'set_member_sn' => $set_member_sn,
        );
        $this->where($array)->limit($limit)->get();
    }



    # m-78更新檢舉記錄內容。判斷方式：cs_report_list_m.sn = 輸入的檢舉列表編號。
    function update_member_report_list($set_member_sn, $data)
    {
        $array = array(
            'set_member_sn' => $set_member_sn,
        );
        $this->where($array)->update('cs_report_list_m', $data);
    }
}
