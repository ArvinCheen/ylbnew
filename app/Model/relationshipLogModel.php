<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class relationshipLogModel extends Model
{
    protected $table = 'cs_relationship_log';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-38 從表取得會員編號的交往互動記錄，要尋找的會員編號有可能在發送方或是接收方，將會員的交往互動紀錄取出。
    function get_relationship_log($where_array)
    {
        return $this->where($where_array)->get();
    }



    # m-39 從表新增交往互動記錄，此時為第一次新增。
    function insert_relationship_log($insert_array)
    {
        /**
         * 改寫
         */
        $insert_action = $this->db->insert('cs_relationship_log', $insert_array);
        $action_sn = $this->db->insert_id();


        if($action_sn)
        {
            return $action_sn;
        }

        return FALSE;
    }



    # m-40 從表更新交往互動記錄，判斷方式：cs_relationship_log.sn為輸入的交往互動編號
    function update_relationship_log($where_array,$update_array)
    {
        return $this->where($where_array)->update('cs_relationship_log', $update_array);
    }

}
