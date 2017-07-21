<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class memberVisitLogModel extends Model
{
    protected $table = 'cs_member_visit_log';

    protected $primaryKey = 'sn';

    public $timestamps = false;


    # m-189 拿取觀看資料~觀看者與被觀看者使用參數傳入
    public function get_visit_data($watch_member,$bewatch_member)
    {
        return $this->where('watch_member', $watch_member)
        ->where('bewatch_member', $bewatch_member)
        ->orderBy('create_time', 'desc')
        ->limit(1)
        ->get();
    }


    # m-46 新增觀看紀錄
    function insert_visit_log($insert_array)
    {
        /**
         * 改寫
         */
        $insert_action = $this->db->insert('cs_member_visit_log', $insert_array);

        if($insert_action)
        {
            return TRUE;
        }

        return FALSE;
    }

    # m-47 提取觀看紀錄，有哪些人觀看了使用者~並順便拿取基本資料
    function get_who_visit_me($member_sn)
    {
        return $this->select('cs_member_visit_log.watch_member')
            ->select('cs_member_visit_log.create_time')
            ->select('cs_personal_point_s.member_sn')
            ->select('cs_personal_point_s.nickname')
            ->select('cs_personal_point_s.gender')
            ->select('cs_personal_point_s.birth_day')
            ->select('cs_personal_point_s.zodiac_sign')
            ->select('cs_personal_point_s.living_city')
            ->from('cs_member_visit_log')
            ->leftJoin('cs_personal_point_s', 'cs_member_visit_log.watch_member', '=', 'cs_personal_point_s.member_sn')
            ->where('cs_member_visit_log.bewatch_member', $member_sn)
            ->get();
    }

    # m-218 計算 30 天內被觀看次數，做為本月之星熱門排序依據
    function count_who_visit_me($member_sn)
    {
        return $this->where('cs_member_visit_log.bewatch_member',$member_sn)
            ->where('cs_member_visit_log.create_time' ,'>=','UNIX_TIMESTAMP((NOW() - INTERVAL 30 DAY))')
            ->get();
    }

    # m-194 誰看過我總數
    public function who_visit_member($member_sn,$blist_number_array,$limit)
    {
        $query = DB::table('cs_member_visit_log')
            ->where('bewatch_member',$member_sn)
            ->whereNotIn('watch_member', $blist_number_array);

        if($limit != null) {
            $query->limit($limit);
        }

        $query->orderBy('create_time', 'DESC');

        return $query;
    }

    # 未讀的誰看過我 (尚未入文件)
    public function new_watch_me_num($member_sn)
    {
        return $this->where('bewatch_member', $member_sn)
            ->where('read_status','non_read')
            ->orderBy('create_time','DESC')
            ->get();
    }

    # 誰看過我分頁 (尚未入文件)
    public function who_visit_member_page($member_sn,$blist_number_array,$num,$offset)
    {
        return $this->where('bewatch_member',$member_sn)
            ->whereNotIn('watch_member', $blist_number_array)
            ->limit($num,$offset)
            ->order_by('create_time','DESC')
            ->get();

        return $this->db->get()->result();
    }

    # 修改誰看過我資料表
    public function update_who_visit_me($where_array,$update_array)
    {
        return $this->where($where_array)->update('cs_member_visit_log', $update_array);

    }
    # 拿取某有 tag 的人
    public function get_tag_member($limit,$tag_sn,$gender,$member_type)
    {
        $query = DB::table('cs_member_feature_m')
            ->select('cs_member_feature_m.member_sn',
                'cs_member_feature_m.content_sn',
                'cs_member_feature_m.create_time',
                'cs_feature_contant_m.feature_type',
                'cs_feature_contant_m.content',
                'cs_personal_point_s.gender',
                'count(cs_member_visit_log.sn) as visit_num');

        $query->leftJoin('cs_personal_point_s','cs_personal_point_s.member_sn', '=', 'cs_member_feature_m.member_sn');
        $query->leftJoin('cs_feature_contant_m','cs_feature_contant_m.sn', '=', 'cs_member_feature_m.content_sn');
        $query->leftJoin('cs_member_data_s','cs_member_data_s.member_sn', '=', 'cs_member_feature_m.member_sn');
        $query->leftJoin('cs_member_visit_log', 'cs_member_visit_log.bewatch_member', '=', 'cs_member_feature_m.member_sn','left');
        $query->whereIn('cs_member_feature_m.content_sn', $tag_sn);
        $query->where('cs_member_data_s.member_type', $member_type);
        if ($gender != 'all') {
            $query->where('cs_personal_point_s.gender', '!=', $gender);
        }
        $query->groupBy('cs_member_feature_m.member_sn');
        $query->orderBy('visit_num', 'DESC');
        $query->limit($limit);

        return $query->get();
    }
}
