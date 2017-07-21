<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class memberDataSModel extends Model
{
    protected $table = 'cs_member_data_s';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-100更新cs_member_data_s個人資料，根據傳入的資料來做更新
    public function update_personal_single_data($member_sn, $updateArray)
    {
        return $this->where('member_sn', $member_sn)->update($updateArray);
    }

    # m-57 取得某會員的各項分數
    function get_member_all_point($member_sn)
    {
        return $this->select('personal_grade, hope_grade, interactive_grade, mentality_grade, marry_point_grade')
            ->where('member_sn', $member_sn)->get();
    }

    # m-58 取得某會員的各項資料完成度
    function get_member_data_complete($member_sn)
    {
        return $this->where('member_sn', $member_sn)->get();
    }


    # m-152 拿取某位會員的會員等級
    public function get_member_type($member_sn)
    {
        return $this->select('cs_member_data_s')->where('member_sn', $member_sn)->get();
    }

    public function get_new_to_old_data($member_sn=null){
        # 取 新系統欄位值 包含 手機號碼、姓名、暱稱、性別、生日、學歷、身高、居住區域、婚姻狀態 皆不為空白 的 會員資料

        $query = <<<EOQ
            SELECT
                ms.member_sn,
                ms.mobile,
                ps.name,
                ps.nickname,
                ps.gender,
                ps.birth_day,
                ps.highest_edu_level,
                ps.height,
                ps.living_city,
                ps.marriage_status
            FROM
                cs_member_data_s AS ms
            LEFT JOIN cs_personal_point_s AS ps ON ps.member_sn = ms.member_sn
EOQ;
        $condition = [];

        if(empty($member_sn)) {
            $query .= <<<EOQ
                AND ps.name != ""
                AND ps.nickname != ""
                AND ps.gender != ""
                AND ps.birth_day != ""
                AND ps.highest_edu_level != ""
                AND ps.height != ""
                AND ps.living_city != ""
                AND ps.marriage_status != ""
EOQ;
        } else {
            $query = 'ms.member_sn = : memberSn';
            $condition['memberSn'] = $member_sn;
        }

        return DB::select($query, $condition);

    }

    public function change_member_level($member_sn, $member_type)
    {
        $updateData = [
            'member_type' => $member_type,
        ];

        return $this->where('memberSn', $member_sn)->update($updateData);
    }

    # m-33 用手機號碼取得個人單選資料，根據傳入的資料來做提取
    public function get_personal_single_data_mobile($mobile)
    {
        return $this->where('mobile', $mobile)->get();
    }
}
