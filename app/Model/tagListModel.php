<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class tagListModel extends Model
{
    protected $table = 'cs_tag_list';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # cs_tag_list
    # 會員列表 會員Tag 拉出秘書擁有的所有Tag
    function get_member_assign_tag($condition=null)
    {
        $query = DB::table('cs_tag_list');

        if($condition != null)
        {
            $query->where($condition);
        }

        $query->orderBy('sn asc');
        $query->orderBy('create_time asc');

        return $query->get();
    }
    # 取秘書 所有 私人TAG 值 by condition
    function get_tag_by_condition($condition=null)
    {
        $query = DB::table('cs_tag_list');
        if($condition != null)
        {
            $query->where($condition);
        }

        return $query->get();
    }
    # 新增tag 回傳新增編號
    function insert_tag($insert_data)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_tag_list', $insert_data);
        return $this->db->insert_id();
    }
    # 更新tag項目 by sn
    function update_tag_by_sn($update_data,$sn)
    {
        /**
         * 改寫
         */
        $this->db->where('sn',$sn);
        $this->db->update('cs_tag_list', $update_data);
    }
    # 刪除tag項目 by sn
    function delete_tag_by_sn($sn)
    {
        /**
         * 改寫
         */
        # 刪除 Tag
        $this->db->where('sn', $sn);
        $this->db->delete('cs_tag_list');
    }
}
