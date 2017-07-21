<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class memberPicMModel extends Model
{
    protected $table = 'cs_member_pic_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-113 拿出使用者的單張個人照片資料以及各自的審核狀態資料
    function get_one_pic_and_verify($memberSn, $sn)
    {
        return $this->select('cs_member_pic_m.sn')
            ->select('cs_member_pic_m.pic_url')
            ->select('cs_data_verify_m.verify_result')
            ->select('cs_data_verify_m.verify_remark')
            ->leftJoin('cs_data_verify_m', 'cs_data_verify_m.sn', '=', 'cs_member_pic_m.verify_sn')
            ->where('cs_member_pic_m.member_sn', $memberSn)
            ->where('cs_member_pic_m.sn', $sn)
            ->get();
    }

    # m-?? 拿出使用者的單張個人照片給裁切即刪除照片檔案用
    function get_one_pic_for_crop($member_sn,$sn)
    {
        return $this->where('cs_member_pic_m.member_sn',$member_sn)
            ->where('cs_member_pic_m.sn',$sn)
            ->get();
    }


    # m-114 新增會員個人照。
    function insert_personal_pic($insert_array)
    {
        /**
         * 改寫
         */
        $insert_action = $this->db->insert('cs_member_pic_m', $insert_array);

        if($insert_action)
        {
            return TRUE;
        }

        return FALSE;
    }

    # m-116 刪除個人照以及此張照片的審核狀態
    function delete_pic_and_verify($sn)
    {
        $pic_info = $this->from('cs_member_pic_m')
            ->where('cs_member_pic_m.sn', $sn)
            ->get();
        if(!$pic_info) {
            return  '001';
        }

        $result = $this->where('sn', $pic_info[0]->sn)->delete();
        if(!$result) {
            return  '002';
        }

        $result = $this->where('verify_item_sn',$sn )
            ->where('verify_item','member_pic')
            ->delete();
        if(!$result) {
            return  '003';
        }

        return true;
    }

    # m-129 從資料庫取出最後X(1~全部)張已經審核通過的個人照片
    function get_pass_personal_pic($memberSn, $sort)
    {
        return $this->leftJoin('cs_data_verify_m', 'cs_member_pic_m.verify_sn', '=', 'cs_data_verify_m.sn')
            ->where('cs_member_pic_m.member_sn', $memberSn)
            ->where('cs_member_pic_m.sort', $sort)
            ->where('cs_data_verify_m.verify_result', 'valid_pass')
            ->orderBy('cs_member_pic_m.create_time','DESC')
            ->limit(1);
    }

    # m-48判斷是否有大頭照。跟資料庫提取某會員編號的大頭照片，且審核狀態為通過審核，才算
    function get_mug_shot($memberSn)
    {
        return $this->select('cs_member_pic_m.member_sn')
            ->select('cs_member_pic_m.pic_url')
            ->leftJoin('cs_data_verify_m', 'cs_member_pic_m.verify_sn', '=', 'cs_data_verify_m.sn')
            ->where('cs_member_pic_m.member_sn', $memberSn)
            ->where('cs_member_pic_m.top_pic', 'yes')
            ->where('cs_data_verify_m.verify_result', 'valid_pass')
            ->orderBy('cs_member_pic_m.create_time', 'desc')
            ->limit(1);
    }

    # m-154 拿出個人照片以及其驗證狀態
    public function get_personal_pics_and_verify_status($memberSn, $sort)
    {
        return $this->select('cs_member_pic_m.*')
            ->select('cs_data_verify_m.verify_status')
            ->select('cs_data_verify_m.verify_result')
            ->select('cs_data_verify_m.verify_remark')
            ->leftJoin('cs_data_verify_m', 'cs_data_verify_m.sn', '=', 'cs_member_pic_m.verify_sn')
            ->where('cs_member_pic_m.member_sn', $memberSn)
            ->where('cs_member_pic_m.top_pic', 'no')
            ->where('cs_member_pic_m.sort', $sort)
            ->orderBy('create_time', 'desc')
            ->limit(1)
            ->get();
    }

    # m-155 找出會員驗證完成的大頭照
    public function get_member_top_pic_pass_verify($memberSn)
    {
        return $this->leftJoin('cs_data_verify_m', 'cs_data_verify_m.sn', '=', 'cs_member_pic_m.verify_sn')
            ->where('cs_member_pic_m.member_sn', $memberSn)
            ->where('cs_member_pic_m.top_pic','yes')
            ->where('cs_data_verify_m.verify_result','valid_pass')
            ->orderBy('create_time', 'desc')
            ->limit(1)
            ->get();
    }

    # m-184 新增照片並且返回編號
    function insert_personal_pic_id($insert_array)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_member_pic_m', $insert_array);
        $insert_sn = $this->db->insert_id();

        return  $insert_sn;
    }

    # m-185 更新個人照片資料
    function update_personal_pic_id($membersn, $pic, $updateData)
    {
        return $this->where('member_sn', $membersn)->where('pic_url', $pic)->update($updateData);
    }


    # m-182 找出最新大頭貼 (不管通過或不通過)
    function get_mug_shot_verify($member_sn)
    {
        return $this->leftJoin('cs_member_pic_m', 'cs_data_verify_m.sn', '=', 'cs_member_pic_m.verify_sn')
            ->where('cs_member_pic_m.member_sn', $member_sn)
            ->where('cs_member_pic_m.top_pic', 'yes')
            ->orderBy('create_time', 'desc')
            ->limit(1)
            ->get();
    }

}
