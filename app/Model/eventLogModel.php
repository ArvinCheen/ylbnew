<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class eventLogModel extends Model
{
    protected $table = 'cs_event_log';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # 新增 banner click log 回傳新增編號
    # insert_event_log
    function insert_event_log($insert_data)
    {
        /**
         * 改寫controller
         */
//        $this->db->insert('cs_event_log', $insert_data);
//
//        return $this->db->insert_id();
    }
}
