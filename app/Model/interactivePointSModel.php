<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class interactivePointSModel extends Model
{
    protected $table = 'cs_interactive_point_s';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-107 拿出所有個人互動指標資料
    # get_interactive_point_data
    function get_interactive_point_data($member_sn)
    {
        return $this->where('member_sn', $member_sn)->get();

//        $this->db->from('cs_interactive_point_s');
//        $this->db->where('member_sn',$member_sn);
//
//        return $this->db->get()->result();
    }



    # m-108 更新個人互動指標資料
    function update_interactivie_point_data($member_sn,$update_array)
    {
        /**
         * 改寫
         */
        $this->db->where('member_sn',$member_sn);
        $update_action = $this->db->update('cs_interactive_point_s', $update_array);

        if($update_action)
        {
            return TRUE;
        }

        return FALSE;
    }

    # m-29 新增會員至互動指標資料表
    public function insert_interactive_point_s($insert_array)
    {
        /**
         * 改寫
         */
        $result = $this->db->insert('cs_interactive_point_s',$insert_array);

        if($result)
        {
            return TRUE;
        }

        return FALSE;
    }
}
