<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class interactiveRelationListMModel extends Model
{
    protected $table = 'cs_interactive_relation_list_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-135 新增互動關係訂單
    public function insert_relation_list($insert_array)
    {
        /**
         * 改寫
         */
        $insert_action = $this->db->insert('cs_interactive_relation_list_m',$insert_array);

        if($insert_action)
        {
            return TRUE;
        }

        return FALSE;
    }

    # m-136 修改互動關係訂單
    public function update_relation_list($where_array,$update_array)
    {
        // 沒用到
        $this->db->where($where_array);
        $update_action = $this->db->update('cs_interactive_relation_list_m', $update_array);

        if($update_action)
        {
            return TRUE;
        }

        return FALSE;
    }

    # m-137 刪除互動關係訂單
    public function delete_relation_list($sn)
    {
        /**
         * 改寫
         */
        $this->db->where('sn', $sn);
        $delete_action = $this->db->delete('cs_interactive_relation_list_m');

        if($delete_action)
        {
            return TRUE;
        }

        return FALSE;
    }

    # m-138 拿取互動關係訂單
    public function get_relation_list($where_array)
    {
        // 沒用到
        $this->db->from('cs_interactive_relation_list_m');
        $this->db->where($where_array);

        return $this->db->get()->result();
    }
}
