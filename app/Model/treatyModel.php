<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class treatyModel extends Model
{
    protected $table = 'cs_treaty';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-01 輸入文案sn，拿出靜態文章的文案標題、內文、更新日期拿出來
    function get_treaty_model($sn)
    {
        /**
         * 改寫
         */
        $this->db->select('chinese_title');
        $this->db->select('english_title');
        $this->db->select('content');
        $this->db->select('update_date');
        $this->db->from('cs_treaty');
        $this->db->where('sn',$sn);

        return $this->db->get()->result();
    }
}
