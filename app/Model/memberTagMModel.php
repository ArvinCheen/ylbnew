<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class memberTagMModel extends Model
{
    protected $table = 'cs_member_tag_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # cs_member_tag_m
    # 取會員列表 私人TAG 值 by condition
    function get_tag_text_num_by_condition($condition)
    {
        return $this->leftJoin('cs_tag_list', 'cs_tag_list.sn', '=', 'cs_member_tag_m.tag_text_sn')
            ->where('cs_tag_list.worker_sn', $condition['cs_tag_list.worker_sn'])
            ->where('cs_tag_list.tag_text', $condition['cs_tag_list.tag_text'])
            ->get();
    }

    # 會員列表 會員Tag 拉出 分配sn 會員 擁有的所有Tag sn
    function get_tag_sn_by_condition($condition=null)
    {
        return $this->select('tag_text_sn as tag_sn')
            ->where('distribution_sn', $condition['distribution_sn'])
            ->where('member_sn', $condition['member_sn'])
            ->get();
    }

    # 會員列表 新增會員Tag
    function insert_worker_assign_tag_to_member($insert_data)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_member_tag_m', $insert_data);
        return $this->db->insert_id();
    }
    # 會員列表 刪除會員Tag
    function delete_member_assign_tag_by_distribution_sn($distribution_sn)
    {
        return $this->where('distribution_sn', $distribution_sn)->delete();
    }
    # 刪除 會員 X Tag 項目 by tag_sn
    function delete_member_tag_m_by_tag_sn()
    {
        return $this->where('tag_text_sn', $tag_sn)->delete();
    }

    # cs_member_tag_m JOIN cs_tag_list
    # 取會員列表 私人TAG 值 by condition
    function get_tag_text_by_condition($condition=null)
    {
        $query = DB::table('cs_member_tag_m')->leftJoin('cs_tag_list', 'cs_tag_list.sn', '=', 'cs_member_tag_m.tag_text_sn');

        if($condition != null) {
            $query->where($condition);
        }

        return $query->get();
    }

}
