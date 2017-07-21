<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class suspendModel extends Model
{
    protected $table = 'cs_suspend';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # 新增暫停資料表
    public function insert_suspend($insert_array)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_suspend',$insert_array);
        $insert_sn = $this->db->insert_id();

        return $insert_sn;
    }


    public function get_suspend($where_array)
    {
        return $this->where($where_array)->get();
    }

    public function update_suspend($update_array,$where_array)
    {
        return $this->where($where_array)->update('cs_suspend',$update_array);
    }

}
