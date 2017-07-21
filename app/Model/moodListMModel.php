<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class moodListMModel extends Model
{
    protected $table = 'cs_mood_list_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-121 取得使用者心情動態X筆(1~全部)
    # 傳入：memeber_sn、筆數、偏移、是否為計算
    function get_mind_status($member_sn, $limit, $offset, $count)
    {
        $query = DB::table('cs_mood_list_m')->select(
            'cs_mood_list_m.sn',
            'cs_mood_list_m.member_sn',
            'cs_mood_list_m.create_time',
            'cs_mood_list_m.contents',
            'cs_mood_list_m.delet',
            'count(cs_praise_info_m.sn) as count_like'
        )->leftJoin('cs_praise_info_m', 'cs_praise_info_m.table_sn', '=', 'cs_mood_list_m.sn','left')
        ->where('cs_mood_list_m.member_sn',$member_sn)
        ->where('cs_mood_list_m.delet','show');

        if($count != NULL) {
            return $query->count();
        }

        $query->groupBy('cs_mood_list_m.sn')->order_by('cs_mood_list_m.create_time','DESC');

        if($limit != 'all'){
            $query->limit($limit, $offset);
        }

        return $query->get();
    }


    # m-123 新增一筆心情動態。
    function insert_mind_status($insert_array)
    {
        /**
         * 改寫
         */
        $insert_action = $this->db->insert('cs_mood_list_m', $insert_array);

        if($insert_action)
        {
            return TRUE;
        }

        return FALSE;
    }


    # m-81 依照心情動態編號 找出相關資訊
    public function get_mood_approve($mood_sn,$member_sn,$limit,$offset,$limit,$black_list)
    {
        $query = DB::table('cs_mood_list_m')->
            select(
                'cs_mood_list_m.sn',
                'cs_mood_list_m.member_sn as mood_creater',
                'cs_mood_list_m.create_time as mood_create_time',
                'cs_mood_list_m.contents',
                'cs_praise_info_m.member_sn as praise_creater',
                'cs_praise_info_m.create_time as praise_create_time'
            )
            ->leftJoin('cs_praise_info_m', 'cs_praise_info_m.table_sn', '=', 'cs_mood_list_m.sn','left')
            ->leftJoin('cs_member_data_s', 'cs_praise_info_m.member_sn', '=', 'cs_member_data_s.member_sn')
            ->where('cs_mood_list_m.sn',$mood_sn)
            ->where('cs_praise_info_m.member_sn', '<>',$member_sn)
            ->where('cs_mood_list_m.delet','show')
            ->where('cs_member_data_s.member_type','formal_member')
            ->get();

        if($black_list != NULL) {
            $query->whereNotIn('cs_praise_info_m.member_sn', $black_list);
        }

        if($limit == NULL) {
            $query->limit($limit);
        }

        if($limit == 'all') {
            return $query->get();
        }

        $query->orderBy('cs_praise_info_m.create_time','DESC');

        if($limit != 'all') {
            $query->limit($limit, $offset);
        }

        return $query->get();
    }
    # 更新心情動態
    public function update_mind($system_sn,$status)
    {
        $where_array = array(
            'sn' => $system_sn,
        );

        $update_array = array(
            'delet' => $status,
        );

        return $this->where($where_array)->update('cs_mood_list_m', $update_array);

    }
}
