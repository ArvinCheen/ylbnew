<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class memberStarMModel extends Model
{
    protected $table = 'cs_member_star_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # 新增
    function insert_member_star($insert_data)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_member_star_m', $insert_data);

        return $this->db->insert_id();
    }

    # 更新 member_star_m by sn
    function update_member_star_by_sn($data)
    {
        /**
         * 改寫
         */
        $condition = array(
            'sn' => $data['sn'],
        );
        $this->db->where($condition);
        $this->db->update('cs_member_star_m', $data);
    }

    # 取資料
    function get_member_star_by_member_sn($member_sn)
    {
        return $this->select('cs_member_star_m.create_time,')
            ->select('cs_member_star_m.star_start_time,')
            ->select('cs_member_star_m.star_end_time,')
            ->select('cs_member_star_m.point_order_sn,')
            ->select('cs_service_order.point')
            ->leftJoin('cs_service_order', 'cs_service_order.sn', '=', 'point_order_sn')
            ->where('member_sn',$member_sn)
            ->get();
    }

    # 刪除
    function delete_member_star_by_member_sn($member_sn)
    {
        /**
         * 改寫s
         */
        $this->db->where('member_sn', $member_sn);
        $this->db->delete('cs_member_star_m');
    }

    # m-82 取得某會員非黑名單且不同性別的本月之星名單X筆(1~全部)內容
    # 傳入值 (8)：黑名單(all)、性別(all)、會員等級(all)、時間(UNIXTIME)、排序(new/hot)、筆數、偏移、是否只計算筆數
    function get_month_star_by_member($where_not_in_array,$gender,$member_type_array,$time,$order,$limit,$offset,$count)
    {
        $query = <<<EOQ
select
mm.member_sn,
mm.star_end_time,
mm.point_order_sn,
mm.create_time,
ps.nickname,
ps.birth_day,
ps.gender,
ps.blood_type,
ps.zodiac_sign,
ps.animal_zodiac,
ps.living_city,
ps.highest_edu_level,
ps.job_name,
count(ml.sn) as visit_num
from cs_member_star_m as mm
left join cs_personal_point_s as ps on ps.member_sn = mm.member_sn
left join cs_member_data_s as ms on ms.member_sn = mm.member_sn
left join cs_member_visit_log as ml on ml.bewatch_member = mm.member_sn
where ps.gender != :gender
and ms.member_type = 'formal_member'
and mm.star_end_time > :time
group by mm.member_sn
EOQ;

        $condition['gender'] = $gender;
        $condition['time'] = $time;

        #如果有、排除黑名單
        /**
         * 這塊暫時不知道怎麼改寫
         */
//        if($where_not_in_array != NULL) {
//            $this->db->where_not_in('mm.member_sn', $where_not_in_array);
//        }


        #是否排序、預設隨機排序
        if($order == 'new') {
            $query .= 'mm.sn desc';
        } elseif($order == 'hot') {
            $query .= 'visit_num desc';
        } else {
            $query .= 'mm.member_sn desc';
        }

        if($limit != 'all') {
            $query .= 'limit :$limit , $offset';

            $condition['limit'] = $limit;
            $condition['offset'] = $offset;
        }

        return DB::select($query, $condition);
    }

    # m-83 取得某會員非黑名單且不同性別的本月之星名單X筆(1~全部)內容
    # 傳入值 (8)：黑名單(all)、性別(all)、會員等級(all)、時間(UNIXTIME)、排序(new/hot)、筆數、偏移、是否只計算筆數
    function count_month_star($where_not_in_array,$gender,$member_type_array,$time,$order,$x,$offset,$count)
    {

        $this->db->from('cs_member_star_m');
        $this->db->join('cs_personal_point_s', 'cs_personal_point_s.member_sn = cs_member_star_m.member_sn','left');
        $this->db->join('cs_member_data_s', 'cs_member_data_s.member_sn = cs_member_star_m.member_sn','left');


        #如果有填性別、排除同性別
        $this->db->where('cs_personal_point_s.gender !=',$gender);

        #排除非正式會員
        $this->db->where_in('cs_member_data_s.member_type',$member_type_array);

        #排除已到期的本月之星
        $this->db->where('cs_member_star_m.star_end_time >',$time);

        #如果有、排除黑名單
        if($where_not_in_array != NULL)
        {
            /**
             * 這塊暫時不知道怎麼改寫
             */
            $this->db->where_not_in('cs_member_star_m.member_sn', $where_not_in_array);
        }

        $result = $this->db->count_all_results();

        return $result;

    }

    # 檢查某一會員現在是否為 本月之星
    public function check_m_star_status($member_sn)
    {
        return $this->where('star_start_time <', time())
            ->where('star_end_time >', time())
            ->where('member_sn',$member_sn)
            ->get();
    }
}
