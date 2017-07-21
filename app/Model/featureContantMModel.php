<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class featureContantMModel extends Model
{
    protected $table = 'cs_feature_contant_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # 拿取 某 sn 的 tag 資訊
    # get_tag_by_sn
    public function get_tag_by_sn($sn)
    {
        /**
         * 改寫
         */
        $this->db->from('cs_feature_contant_m');
        $this->db->where('sn',$sn);

        return $this->db->get()->result();
    }

    # m-106 掃描是否已有符合引用的特色
    # search_feature_exist
    public function searchFeatureContent($content)
    {
        return $this->where('content', $content)->get();

//        $this->db->from('cs_feature_contant_m');
//        $this->db->where('content',$contant);
//        $result = $this->db->get()->result();
//
//        return $result;
    }

    # m-109 新增特色引用內容
    public function insert_feature($data)
    {
        /**
         * 改寫
         */
//        $this->db->insert('cs_feature_contant_m', $data);
//        $feature_contant_sn = $this->db->insert_id();
//
//        return $feature_contant_sn;
    }
}
