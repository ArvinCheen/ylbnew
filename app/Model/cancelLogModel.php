<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class cancelLogModel extends Model
{
    protected $table = 'cs_cancel_log';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # 插入取消紀錄
    # insert_cancel_log
    public function insertCancelLogAndReturnId($insertData)
    {
        return $this->insertGetId($insertData);
//
//        $this->db->insert('cs_cancel_log', $insert_array);
//        $cancel_log_sn = $this->db->insert_id();
//
//        return $cancel_log_sn;
    }
}
