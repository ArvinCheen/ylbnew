<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class personalPointSModel extends Model
{
    protected $table = 'cs_personal_point_s';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-96 查詢個人指標資料的審核狀態
    public function get_personal_data_verify_info($member_sn)
    {
        return $this->join('cs_data_verify_m', 'cs_personal_point_s.verify_sn = cs_data_verify_m.sn')
            ->where('cs_personal_point_s.member_sn',$member_sn)
            ->get();
    }


    # m-47 提取觀看紀錄，有哪些人觀看了使用者~並順便拿取基本資料
    function get_who_visit_me($member_sn)
    {
        return $this->select(
            'cs_member_visit_log.watch_member',
            'cs_member_visit_log.create_time',
            'cs_personal_point_s.member_sn',
            'cs_personal_point_s.nickname',
            'cs_personal_point_s.gender',
            'cs_personal_point_s.birth_day',
            'cs_personal_point_s.zodiac_sign',
            'cs_personal_point_s.living_city'
            )
            ->leftJoin('cs_personal_point_s','cs_member_visit_log.watch_member', '=', 'cs_personal_point_s.member_sn')
            ->where('cs_member_visit_log.bewatch_member',$member_sn)
            ->get();
    }
    # m-54 取得某會員重點資料欄位的單一值項目
    function get_point_s($member_sn)
    {
        $this->where('member_sn',$member_sn)->get();
    }

    # m-56 取得某會員的暱稱、星座、血型、居住地區
    function get_basic_show_data($member_sn)
    {
        $this->select(
            'nickname','zodiac_sign',
            'blood_type',
            'living_city',
            'gender'
        )->where('member_sn',$member_sn)
        ->get();
    }


    # m-106 拿出所有個人指標資料
    function get_point_data_all($member_sn)
    {
        $this->where('member_sn',$member_sn)->get();
    }

    # m-146 更新個人指標資料
    function update_personal_point($member_sn,$update_array)
    {
        return $this->where('member_sn',$member_sn)->update('cs_personal_point_s',$update_array);
    }


    function get_personal_basic_profile_by_condition($member_sn,$verify_status)
    {
        $query = DB::table('cs_personal_point_s')->select(
            'cs_personal_point_s.sn as member_basic_profile_sn',
            'cs_data_verify_m.sn as verify_sn',
            'cs_personal_point_s.*',
            'cs_data_verify_m.verify_status',
            'cs_data_verify_m.verify_worker',
            'cs_data_verify_m.verify_time',
            'cs_data_verify_m.verify_result',
            'cs_data_verify_m.verify_remark',
            'cs_data_verify_m.verify_endtime'
        )->leftJoin('cs_data_verify_m','cs_data_verify_m.sn', '=', 'cs_personal_point_s.verify_sn')
        ->where('cs_data_verify_m.verify_status',$verify_status)
        ->where('cs_personal_point_s.member_sn',$member_sn)
        ->get();
    }


    # m-27 新增會員至個人指標表
    public function insert_personal_point_s($data)
    {
        /**
         * 改寫
         */
        $result = $this->db->insert('cs_personal_point_s',$data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }


    # m-22 找緣份-基本搜尋
    public function basic_search($where_list_array,$where_in_array,$blist,$count,$per_page,$from)
    {
        $query = DB::table('cs_personal_point_s')
        ->select('cs_personal_point_s.member_sn')
        ->leftJoin('cs_member_data_s', 'cs_personal_point_s.member_sn', '=', 'cs_member_data_s.member_sn');
        if($where_list_array != NULL) {
            $query->where($where_list_array);
        }

        if($where_in_array != NULL) {
            $query->where_in('cs_personal_point_s.highest_edu_level',$where_in_array);
        }

        if($blist != NULL) {
            $query->where_not_in('cs_personal_point_s.member_sn',$blist);
        }

        if($count == TRUE) {
            $per_page 	= FALSE;
            $from 		= FALSE;
        } else {
            $query->limit($per_page, $from);
        }

        return $query->get()->result();
    }

    # 找緣份-進階搜尋 (雖然目前與基本搜尋一模一樣~但是還是另外開一個MODEL FUNCTION 為了保持未來要搜尋更多的時後 可以不用動到基本搜尋~保持獨立)
    public function advanced_search($where_list_array,$where_in_array,$blist,$count,$per_page,$from)
    {

        $query = DB::table('cs_personal_point_s')->select('cs_personal_point_s.member_sn')
            ->leftJoin('cs_member_data_s', 'cs_personal_point_s.member_sn', '=', 'cs_member_data_s.member_sn');
        if($where_list_array != NULL) {
            $query->where($where_list_array);
        }

        if($where_in_array != NULL) {
            $query->where_in('cs_personal_point_s.highest_edu_level',$where_in_array);
        }

        if($blist != NULL) {
            $query->where_not_in('cs_personal_point_s.member_sn',$blist);
        }

        if($count)  {
            $per_page 	= FALSE;
            $from 		= FALSE;
        } else {
            $query->limit($per_page, $from);
        }

        return $query->get();
    }
}
