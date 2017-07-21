<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class blackListMModel extends Model
{
    protected $table = 'cs_black_list_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-07 新增黑名單。
    # insert_black_list
    function insertBlackList($insertData)
    {
        return $this->insert($insertData);

//        $result = $this->db->insert('cs_black_list_m',$insert_array);
//
//        if($result)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }


    # m-08 找出某會員編號的全部黑名單
    public function get_black_list($memberSn)
    {
        return $this->where('set_member_sn', $memberSn)->get();

//        $this->db->select('black_member_sn');
//        $this->db->from('cs_black_list_m');
//        $this->db->where('set_member_sn',$set_member_sn);
//
//        return $this->db->get()->result();
    }


    # m-09 找出某人的黑名單(有分頁功能)
    # get_black_list_page
    public function get_black_list_page($memberSn, $limit, $offset)
    {
        return $this->select('black_member_sn')
            ->where('set_member_sn', $memberSn)
            ->limit($limit)
            ->offset($offset)
            ->get();

//        $this->db->select('black_member_sn');
//        $this->db->from('cs_black_list_m');
//        $this->db->where('set_member_sn',$set_member_sn);
//        $this->db->limit($num, $offset);
//
//        return $this->db->get()->result();
    }

    # m-10 刪除黑名單編號紀錄。
    # delete_black_list
    public function deleteBlackList($deleteArray)
    {
        return $this->where('set_member_sn', $deleteArray['set_member_sn'])
            ->where('black_member_sn', $deleteArray['black_member_sn'])
            ->delete();

//        $result = $this->db->delete('cs_black_list_m', $delete_array);
//        if($result)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }


    # m-11 查詢使用者會員編號是否有加某另一位使用者黑名單
    # check_black_list_relation
    public function checkBlackListRelation($setMemberSn, $blackMemberSn)
    {
        return $this->where('set_member_sn', $setMemberSn)
            ->where('black_member_sn', $blackMemberSn)
            ->get();

//        $this->db->from('cs_black_list_m');
//        $this->db->where('set_member_sn',$set_member_sn);
//        $this->db->where('black_member_sn',$black_member_sn);
//
//        return $this->db->get()->result();
    }
}
