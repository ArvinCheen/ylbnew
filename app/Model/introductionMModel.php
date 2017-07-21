<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class introductionMModel extends Model
{
    protected $table = 'cs_introduction_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-94 拿取審核通過的自我介紹資料
    public function get_verify_pass_introduction($memberSn)
    {
        return $this->leftJoin('cs_data_verify_m', 'cs_introduction_m.verify_sn', '=', 'cs_data_verify_m.sn')
            ->where('cs_introduction_m.member_sn', $memberSn)
            ->where('cs_data_verify_m.verify_result', 'valid_pass')
            ->limit(1)
            ->orderBy('cs_introduction_m.create_time', 'desc')
            ->get();
    }

    # m-111 拿取某會員自我介紹資料(不管驗審核通過或不通過)
    function get_personal_introduction($memberSn)
    {
        return $this->select('sn, introduction')
            ->where('member_sn', $memberSn)
            ->limit(1)
            ->orderBy('create_time', 'desc')
            ->get();
    }

    # m-148 新增自我介紹
    public function insert_personal_introduction($insert_array)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_introduction_m', $insert_array);
        $insert_sn = $this->db->insert_id();

        return $insert_sn;
    }

    # m-156 刪除某會員的自我介紹
    public function delete_introduction_by_member_sn($memberSn)
    {
        return $this->where('member_sn', $memberSn)->delete();
    }

    function get_personal_introduction_by_condition($memberSn,$verifyStatus)
    {
        $query = <<<EOQ
            SELECT
                im.sn AS introduction_sn,
                dm.sn AS verify_sn,
                im.introduction,
                im.create_time,
                dm.verify_status,
                dm.verify_worker,
                dm.verify_time,
                dm.verify_result,
                dm.verify_remark,
                dm.verify_endtime,
            
            FROM
                cs_introduction_m AS im
            LEFT JOIN cs_data_verify_m AS dm ON dm.sn = im.verify_sn
            WHERE
                dm.verify_status = :verifyStatus
            WHERE
                im.member_sn = :memberSn
            ORDER BY
                im.create_time DESC        
EOQ;

        $condition['verifyStatus'] = $verifyStatus;
        $condition['memberSn'] = $memberSn;

        return DB::select($query, $condition);
    }

    # 目前會員上傳自介的總筆數 by member_sn
    function get_intro_count_by_member_sn($memberSn)
    {
        return $this->where('member_sn', $memberSn)->get();
    }
}
