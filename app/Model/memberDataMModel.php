<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class memberDataMModel extends Model
{
    protected $table = 'cs_member_data_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-98 新增個人複選資料，根據傳入的資料來做新增
    public function insert_personal_multi_data($insert_array)
    {
        /**
         * 改寫
         */
        $insert_action = $this->db->insert('cs_member_data_m', $insert_array);

        if($insert_action)
        {
            return TRUE;
        }

        return FALSE;
    }


    # m-99 刪除某會員的某項個人複選資料全部
    public function delete_personal_multi_data($memberSn,$rowName)
    {
        return $this->where('member_sn', $memberSn)
            ->where('row_name', $rowName)
            ->delete();
    }

    # m-102 個人複選資料的取得動作，根據傳入的資料來做提取
    public function get_personal_multi_data($memberSn, $filedArray)
    {
        return $this->where('member_sn', $memberSn)
            ->whereIn('row_name', $filedArray)
            ->get();
    }

    # m-103 取得個人複選資料的row_name與row_content
    public function get_muti_row_name_content($memberSn, $rowName)
    {
        return $this->select('row_name, row_content')
            ->where('member_sn', $memberSn)
            ->where('row_name', $rowName)
            ->get();
    }

    # m-55取得某會員重點資料欄位多值項目包含以下：公司備註(個人複選)
    function get_point_m($member_sn)
    {
        // 沒用到
        $this->db->from('cs_member_data_m');
        $array = array(
            'member_sn' => $member_sn,
            'row_name' 	=> '公司備註', #待修正
        );
        $this->db->where($array);

        return $this->db->get()->result();
    }

    # m-109 更新個人複選資料 ●待確認
    function update_member_muti_data($member_sn,$field_name,$field_content)
    {
        // 沒用到
        $data = array(
            'row_content' => $field_content,
        );

        $this->db->where('member_sn',$member_sn);
        $this->db->where('row_name',$field_name);

        $result = $this->db->update('cs_member_data_m', $data);


        if($result)
        {
            return TRUE;
        }

        return FALSE;
    }


    # m-151 刪除一筆多選
    function delete_personal_one_multi_data($memberSn,$rowName,$content)
    {
        return $this->where('member_sn', $memberSn)
            ->where('row_name', $rowName)
            ->where('row_content', $content)
            ->delete();
    }

}
