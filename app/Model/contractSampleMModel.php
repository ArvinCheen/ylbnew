<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class contractSampleMModel extends Model
{
    protected $table = 'cs_contract_sample_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # join_contract_sample
    public function joinContractSample($sampleSn)
    {
        $query = '
            SELECT
                cm.sn,
                cm.title_sn,
                cm.content_sn,
                cs.sample_name,
                ct.title_name,
                cc.contract_statute,
                ct.remark
            FROM
                cs_contract_sample_m AS cm
            LEFT JOIN cs_contract_sample AS cs ON cs.sn = cm.sample_sn
            LEFT JOIN cs_contract_title AS ct ON ct.sn = cm.title_sn
            LEFT JOIN cs_contract AS cc ON cc.sn = cm.content_sn
            WHERE
                cm.sample_sn = :sample_sn
            AND cm.switch = "on"
            ORDER BY
                title_sn,
                ORDER
        ';

        $condition = ['sample_sn' => $sampleSn];

        return DB::select($query, $condition);

//        $this->db->select('cs_contract_sample_m.sn,');
//        $this->db->select('cs_contract_sample_m.title_sn,');
//        $this->db->select('cs_contract_sample_m.content_sn,');
//        $this->db->select('cs_contract_sample.sample_name,');
//        $this->db->select('cs_contract_title.title_name,');
//        $this->db->select('cs_contract.contract_statute,');
//        $this->db->select('cs_contract_title.remark,');
//
//        $this->db->from('cs_contract_sample_m');
//        $this->db->join('cs_contract_sample', 'cs_contract_sample.sn = cs_contract_sample_m.sample_sn');
//        $this->db->join('cs_contract_title', 'cs_contract_title.sn = cs_contract_sample_m.title_sn');
//        $this->db->join('cs_contract', 'cs_contract.sn = cs_contract_sample_m.content_sn');
//
//        $this->db->where('cs_contract_sample_m.sample_sn', $sample_sn);
//        $this->db->where('cs_contract_sample_m.switch', 'on');
//        $this->db->order_by('cs_contract_sample_m.title_sn ASC,cs_contract_sample_m.order ASC');
//
//        return $this->db->get()->result();
    }


    # 取 契約樣版名稱X內容 by sample_sn
    # get_contract_sample_m_data_by_sample_sn
    function getContractSample($sn)
    {
        return $this->where('sample_sn', $sn)->get();

//        $this->db->select('cs_contract_sample_m.*,');
//
//        $this->db->from('cs_contract_sample_m');
//
//        $condition = array(
//            'cs_contract_sample_m.sample_sn' => $sample_sn,
//        );
//
//        $this->db->where($condition);
//
//        return $this->db->get()->result();
    }

    # 取 契約樣版名稱X內容 by sample_sn
    function get_contract_sample_m_with_title_content_by_sample_sn($sampleSn)
    {
        $query = '
            SELECT
                cm.sn,
                cm.title_sn,
                cm.content_sn,
                cs.sample_name,
                ct.title_name,
                cc.contract_statute,
                ct.remark
            FROM
                cs_contract_sample_m AS cm
            LEFT JOIN cs_contract_sample AS cs ON cs.sn = cm.sample_sn
            LEFT JOIN cs_contract_title AS ct ON ct.sn = cm.title_sn
            LEFT JOIN cs_contract AS cc ON cc.sn cm.content_sn
            WHERE
                cm.sample_sn = :sample_sn
            AND cm.switch = "on"
        ';

        $condition = ['sample_sn' => $sampleSn];

        return DB::select($query, $condition);

//        $this->db->select('cs_contract_sample_m.sn,');
//        $this->db->select('cs_contract_sample_m.title_sn,');
//        $this->db->select('cs_contract_sample_m.content_sn,');
//        $this->db->select('cs_contract_sample.sample_name,');
//        $this->db->select('cs_contract_title.title_name,');
//        $this->db->select('cs_contract.contract_statute,');
//        $this->db->select('cs_contract_title.remark,');
//
//        $this->db->from('cs_contract_sample_m');
//        $this->db->join('cs_contract_sample','cs_contract_sample.sn = cs_contract_sample_m.sample_sn');
//        $this->db->join('cs_contract_title','cs_contract_title.sn = cs_contract_sample_m.title_sn');
//        $this->db->join('cs_contract','cs_contract.sn = cs_contract_sample_m.content_sn');
//
//
//        $condition = array(
//            'cs_contract_sample_m.sample_sn' => $sample_sn,
//            'cs_contract_sample_m.switch' => 'on',
//        );
//
//        $this->db->where($condition);
//
//        return $this->db->get()->result();
    }

    # 取 契約樣版名稱X內容 by sample_sn
    function get_contract_sample_m_with_title_content_by_condition($condition)
    {
        $query = '
            SELECT
                cm.title_sn,
                cm.content_sn,
                cs.sample_name,
                ct.title_name,
                cc.contract_statute,
                cc_title.remark
            FROM
                cs_contract_sample_m AS cm
            LEFT JOIN cs_contract_sample AS cs ON cs.sn = cm.sample_sn
            LEFT JOIN cs_contract_title AS ct ON ct.sn = cm.title_sn
            LEFT JOIN cs_contract AS cc ON cc.sn = cm.content_sn
            WHERE
                cm.sample_sn =: :sample_sn
            AND cc.contract_statute LIKE :contract_statute
        ';

        $condition = [
            'sample_sn' => $condition['sample_sn'],
            'contract_statute like' => $condition['contract_statute'],
        ];

        return DB::select($query, $condition);

//        $this->db->select('cs_contract_sample_m.title_sn,');
//        $this->db->select('cs_contract_sample_m.content_sn,');
//        $this->db->select('cs_contract_sample.sample_name,');
//        $this->db->select('cs_contract_title.title_name,');
//        $this->db->select('cs_contract.contract_statute,');
//        $this->db->select('cs_contract_title.remark,');
//
//        $this->db->from('cs_contract_sample_m');
//        $this->db->join('cs_contract_sample','cs_contract_sample.sn = cs_contract_sample_m.sample_sn');
//        $this->db->join('cs_contract_title','cs_contract_title.sn = cs_contract_sample_m.title_sn');
//        $this->db->join('cs_contract','cs_contract.sn = cs_contract_sample_m.content_sn');
//
//        $this->db->where($condition);
//
//        return $this->db->get()->result();
    }

}
