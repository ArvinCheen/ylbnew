<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class memberRemarkDataModel extends Model
{
    protected $table = 'cs_member_remark_data';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-30 新增會員至會員備註資料表
    public function insert_member_remark_data($insert_array)
    {
        /**
         * 改寫
         */
        $result = $this->db->insert('cs_member_remark_data',$insert_array);

        if($result)
        {
            return TRUE;
        }

        return FALSE;
    }
}
