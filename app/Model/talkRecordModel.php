<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class talkRecordModel extends Model
{
    protected $table = 'cs_talk_record';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # 取談話記錄
    function get_member_talk_record($join=false,$condition=null,$page=1,$limit=30)
    {
        $query = DB::table('cs_talk_record')
            ->leftJoin('cs_worker_info_s', 'cs_worker_info_s.employee_sn = cs_talk_record.create_worker');

        if($join != false)
        {
            $query->join('cs_talk_status_list', 'cs_talk_status_list.talk_record_sn', '=', 'cs_talk_record.sn');
        }

        if($condition != null)
        {
            $query->where($condition);
        }

        if($page <= 1 and $page != null)
        {
            $query->limit($limit, 0);
        }
        else if($page > 1 and $page != null)
        {
            $query->limit($limit, ($page-1) * $limit);
        }

        $query->orderBy("create_time", "desc");

        return $query->get();
    }
    # 新增談話紀錄
    function insert_talk_record($data)
    {
        /**
         * 改寫
         */
        $insert_data = array(
            'member_sn' => (isset($data['member_sn']) and ['member_sn'] != null) ? $data['member_sn'] : '',
            'content' => (isset($data['content']) and ['content'] != null) ? $data['content'] : '',
            'create_time' => time(),
            'create_worker' => (isset($data['create_worker']) and ['create_worker'] != null) ? $data['create_worker'] : '',
            'next_contact_time' => (isset($data['next_contact_time']) and ['next_contact_time'] != null) ? $data['next_contact_time'] : null,
        );

        $this->db->insert('cs_talk_record', $insert_data);

        return $this->db->insert_id();
    }

}
