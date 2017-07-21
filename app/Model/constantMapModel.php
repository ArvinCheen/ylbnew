<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class constantMapModel extends Model
{
    protected $table = 'cs_constant_map';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # cs_constant_map
    # get_c_code_map_by_sn
    public function getConstantMap($sn)
    {
        return $this->where('sn', $sn)->get();

//        $this->db->select('*');
//        $this->db->from('cs_constant_map');
//        $this->db->where('sn',$sn);
//        return $this->db->get()->result();
    }


    # m-12 前綴取得常數表英文內容
    # get_constant_e_by_pre
    public function getConstantMapEnglish($constantType)
    {
        return $this->select('describe_e')
            ->where('constant_type', $constantType)
            ->get();
//
//        $this->db->select('describe_e');
//        $this->db->from('cs_constant_map');
//        $this->db->where('constant_type',$constant_type);
//        @$query = $this->db->get();
//
//        return $query->result();
    }



    # m-13 前綴取常數表的所有值
    # get_code_map_by_type
    public function getConstantMapByType($constantType)
    {
        return $this->where('constant_type', $constantType)
            ->orderBy('constant_id')
            ->get();
//
//        $this->db->select('*');
//        $this->db->from('cs_constant_map');
//        $this->db->where('constant_type',$constant_type);
//        $this->db->order_by('constant_id', 'ASC');
//        @$query = $this->db->get();

//        return $query->result();
    }



    # m-14 以常數表的前綴、英文，來拿取中文
    # get_c_by_e_and_prefix
    public function getConstantMapChinese($constantType, $describe_e)
    {
        $data = $this->select('describe_c')
            ->where('constant_type', $constantType)
            ->where('describe_e', $describe_e)
            ->get();

        if(!empty($data)) {
            return $data[0]->describe_c;
        }

        return false;

//        $this->db->select('describe_c');
//        $this->db->from('cs_constant_map');
//        $this->db->where('constant_type',$constant_type);
//        $this->db->where('describe_e',$e);
//        @$query = $this->db->get();
//
//        if($query->result() != NULL)
//        {
//            return $query->result()[0]->describe_c;
//        }
//
//        return FALSE;
    }


    # get_c_by_e
    public function get_c_by_e($describe_e)
    {
        $data = $this->select('describe_c')
            ->where('describe_e', $describe_e)
            ->get();

        if(!empty($data)) {
            return $data[0]->describe_c;
        }

        return false;
//
//        $this->db->select('describe_c');
//        $this->db->from('cs_constant_map');
//        $this->db->where('describe_e',$e);
//        @$query = $this->db->get();
//
//        if($query->result() != NULL)
//        {
//            return $query->result()[0]->describe_c;
//        }
//
//        return FALSE;
    }

}
