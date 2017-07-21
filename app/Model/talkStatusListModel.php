<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class talkStatusListModel extends Model
{
    protected $table = 'cs_talk_status_list';

    protected $primaryKey = 'sn';

    public $timestamps = false;

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
