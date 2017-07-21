<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class distributionSModel extends Model
{
    protected $table = 'cs_distribution_s';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # 會員列表 會員Tag 拉出秘書擁有的所有Tag
    # 會員分配 取目前分配的秘書
    # get_distribution_data_by_condition
    function get_distribution_data_by_condition($condition)
    {
        $query = <<<EOQ
            SELECT
                *
            FROM
                cs_distribution_s
            WHERE
                member_sn = :memberSn
EOQ;

        if (isset($condition['worker_sn'])) {
            $query .= ' AND worker_sn = :workerSn';
        }

        return DB::select($query, $condition);

//        $this->db->from('cs_distribution_s');
//        if($condition != null)
//        {
//            $this->db->where($condition);
//        }
//        $this->db->order_by('`sn` asc');
//        $this->db->order_by('`create_time` asc');
//        return $this->db->get()->result();
    }
}
