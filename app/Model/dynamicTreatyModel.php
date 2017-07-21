<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class dynamicTreatyModel extends Model
{
    protected $table = 'cs_dynamic_treaty';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-115 新增動態文案
    # insert_dynamic_treaty
    public function insertDynamicTreaty($insertData)
    {
        /**
         * 使用 $dynamicTreatyModel->insertGetId($insertData); 取代
         */
        return $this->insertGetId($insertData);

//        $insert_action = $this->db->insert('cs_dynamic_treaty',$insert_array);
//
//        if($insert_action)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }

    # m-116 更新動態文案
    public function update_dynamic_treaty($where_array,$update_array)
    {
        // 沒用到
//        $this->db->where($where_array);
//        $update_action = $this->db->update('cs_dynamic_treaty', $update_array);
//
//        if($update_action)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }

    # m-117 刪除動態文案
    public function delete_dynamic_treaty($sn)
    {
        // 沒用到
//        $this->db->where('sn', $sn);
//        $delete_action = $this->db->delete('cs_dynamic_treaty');
//
//        if($delete_action)
//        {
//            return TRUE;
//        }
//
//        return FALSE;
    }

    # m-118 取得動態文案by條件
    # get_dynamic_treaty
    public function getDynamicTreaty($viewName, $memberLevel, $gender)
    {
        $query = <<<EOQ
            SELECT
                *
            FROM
                cs_dynamic_treaty
            WHERE
                view_name = : viewName
            AND member_level = : memberLevel
            AND type = "consultant"
            AND (
                gender = "all"
                OR gender = : gender
            )        
EOQ;

        $condition = [
            'viewName'    => $viewName,
            'memberLevel' => $memberLevel,
            'gender'      => $gender
        ];

        return DB::select($query, $condition);
//
//        $this->db->from('cs_dynamic_treaty');
//        $where = 'view_name = "'.$view_name.'" and member_level = "'.$member_type.'" and type = "consultant" and ( gender = "all" OR gender = "'.$gender.'" )';
//        $this->db->where($where);
//
//        return $this->db->get()->result();
    }

}
