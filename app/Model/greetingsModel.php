<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class greetingsModel extends Model
{
    protected $table = 'cs_greetings';

    protected $primaryKey = 'greeting_id';

    public $timestamps = false;

    # get_greetings_verify
    public function getGreetingsVerify($sqlWhere, $pagination = 0, $perPage = 15)
    {
        $addSqlWhere = '';
        $condition = [];

        if ((!empty($memberData))) {
            if ($memberData['type'] == 'mobile') {
                $addSqlWhere = 'and md.mobile = "%:value%"';
            }

            if ($memberData['type'] == 'name') {
                $addSqlWhere = 'and pp.name like "%:value%"';
            }

            $condition += ['value' => $memberData['value']];
        }

        $query = <<<EOQ
				select 
					g.greetings_id, 
					g.title, 
					g.content, 
					g.member_sn, 
					pp.name, 
					md.mobile, 
					dv.verify_result,
					dv.verify_remark, 
					dv.sn as data_verify_sn 
				from cs_greetings as g
				left join cs_data_verify_m as dv on g.data_verify_sn = dv.sn
				left join cs_member_data_s as md on g.member_sn = md.member_sn
				left join cs_personal_point_s as pp on g.member_sn = pp.member_sn
				where dv.verify_result = :verifyStatus
				and dv.verify_item_sn = 743
				$addSqlWhere
				order by g.greetings_id desc
				limit :pagination, :perPage;
EOQ;

        $condition += [
            'memberData'   => $sqlWhere['memberData'],
            'verifyStatus' => $sqlWhere['verifyStatus'],
            'pagination'   => $pagination,
            'perPage'      => $perPage,
        ];

        return DB::select($query, $condition);
    }

    # get_greetings_verify_count
    public function getGreetingsVerifyCount($sqlWhere)
    {
        $addSqlWhere = '';
        $condition = [];

        if ((!empty($memberData))) {
            if ($memberData['type'] == 'mobile') {
                $addSqlWhere = 'and md.mobile = "%:value%"';
            }

            if ($memberData['type'] == 'name') {
                $addSqlWhere = 'and pp.name like "%:value%"';
            }

            $condition += ['value' => $memberData['value']];
        }

        $query = <<<EOQ
                 SELECT
                    g.greetings_id,
                    g.title,
                    g.content,
                    g.member_sn,
                    pp. NAME,
                    md.mobile,
                    dv.verify_result,
                    dv.verify_remark,
                    dv.sn AS data_verify_sn
                FROM
                    cs_greetings AS g
                LEFT JOIN cs_data_verify_m AS dv ON g.data_verify_sn = dv.sn
                LEFT JOIN cs_member_data_s AS md ON g.member_sn = md.member_sn
                LEFT JOIN cs_personal_point_s AS pp ON g.member_sn = pp.member_sn
                WHERE
                    dv.verify_result = :verifyStatus
                AND dv.verify_item_sn = 743
				$addSqlWhere
				ORDER BY g.greetings_id DESC
EOQ;

        $condition += [
            'memberData'   => $sqlWhere['memberData'],
            'verifyStatus' => $sqlWhere['verifyStatus'],
        ];

        return count(DB::select($query, $condition));
    }

    public function getMemberGreetings($memberSn)
    {
        $query = <<<EOQ
            SELECT
                g.greetings_id,
                dv.sn,
                g.title,
                g.content,
                dv.verify_result,
                dv.verify_remark
            FROM
                cs_greetings AS g
            LEFT JOIN cs_data_verify_m AS dv ON g.data_verify_sn = dv.sn
            WHERE g.member_sn = :member_sn
              AND dv.verify_item_sn = 743
EOQ;

        $condition['member_sn'] = $memberSn;

        return DB::select($query, $condition);
    }

    public function getMemberPassGreetings($memberSn, $greetingsId = null)
    {
        $query = '
            SELECT
                g.greetings_id,
                dv.sn,
                g.title,
                g.content,
                dv.verify_result,
                dv.verify_remark
            FROM
                cs_greetings AS g
            LEFT JOIN cs_data_verify_m AS dv ON g.data_verify_sn = dv.sn
            WHERE g.member_sn = :memberSn
              AND dv.verify_item_sn = 743
              AND dv.verify_result = "valid_pass"
        ';

        $condition['memberSn'] = $memberSn;

        if ($greetingsId != null) {
            $query .= 'AND g.greetings_id = :greetingsId ';
            $condition['greetingsId'] = $greetingsId;
        }

        return DB::select($query, $condition);
    }

    public function updateMemberGreetings($greetingsId, $verifySn, $title, $content)
    {
        /**
         * controller改寫
         */
        $data = [
            'title' => $title,
            'content' => $content,
            'update_time' => time(),
        ];

        $this->db->where('greetings_id', $greetingsId);
        $this->db->update('cs_greetings', $data);

        /**
         * controller改寫
         */

        $data = [
            'verify_result' => 'waiting',
            'verify_remark' => NULL,
        ];

        $this->db->where('sn', $verifySn);
        $this->db->update('cs_data_verify_m', $data);
    }

    public function deleteMemberGreetings($greetingsId, $verifySn)
    {
        /**
         * controller改寫
         */

        $this->db->delete('cs_greetings', ['greetings_id' => $greetingsId]);
        $this->db->delete('cs_data_verify_m', ['sn' => $verifySn]);
    }

    public function insertGreetingsAndDataVerify($insertData)
    {
        /**
         * controller改寫
         */
        $data = [
            'verify_status' => 'no_verify',
            'verify_result' => 'waiting',
            'verify_item' => 'greetings_verifly',
            'verify_item_sn' => '743',
            'member_sn' => $insertData['member_sn'],
            'verify_endtime' => time(),
        ];

        $this->db->insert('cs_data_verify_m', $data);

        /**
         * controller改寫
         */
        $data = [
            'member_sn' => $insertData['member_sn'],
            'title' => $insertData['title'],
            'content' => $insertData['content'],
            'create_time' => time(),
            'data_verify_sn' => $this->db->insert_id()
        ];

        $this->db->insert('cs_greetings', $data);
    }
    
}
