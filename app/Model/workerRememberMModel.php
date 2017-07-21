<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class workerRememberMModel extends Model
{
    protected $table = 'cs_worker_remember_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # 取員工記住我 資料 by session_id
    function get_workerlogin_remember_me_by_session_id($session_id)
    {
        return $this->where('session_id',$session_id)->get();
    }

    # 寫入員工記住我
    function insert_workerlogin_remember_me($insert_data)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_worker_remember_me', $insert_data);
    }

    # 刪除員工記住我
    function delete_workerlogin_remember_me_by_session_id($session_id)
    {
        return $this->where('session_id',$session_id)->delete();
    }
}
