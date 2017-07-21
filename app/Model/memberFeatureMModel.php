<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class memberFeatureMModel extends Model
{
    protected $table = 'cs_member_feature_m';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    # m-104 取得會員編號的主人的個人特色
    public function get_personal_feature($member_sn)
    {
        $query = <<<EOQ
            SELECT
                mm.sn AS feature_m_sn,
                mm.member_sn,
                mm.content_sn,
                mm.create_time,
                fm.sn AS contant_m_sn,
                fm.feature_type,
                fm.content,
                fm.create_time
            FROM
                cs_member_feature_m AS mm
            LEFT JOIN cs_feature_contant_m AS fm ON mm.content_sn = fm.sn
            WHERE
                mm.member_sn = :memberSn
            ORDER BY
                mm.create_time DESC
EOQ;

        $condition['memberSn'] = $member_sn;

        return DB::select($query, $condition);
    }

    # m-105 取得會員編號的主人的個人特色，可限制數量
    public function get_personal_feature_limit($memberSn, $limit)
    {
        $query = <<<EOQ
            SELECT
                mm.sn AS feature_m_sn,
                mm.member_sn,
                mm.content_sn,
                mm.create_time,
                fm.sn AS contant_m_sn,
                fm.feature_type,
                fm.content,
                fm.create_time
            FROM
                cs_member_feature_m AS mm
            LEFT JOIN cs_feature_contant_m AS fm ON mm.content_sn = fm.sn
            WHERE
                mm.member_sn = :memberSn
            ORDER BY
                mm.create_time rand()
EOQ;

        $condition['memberSn'] = $memberSn;

        if ($limit != 'all') {
            $query .= 'limit :limit';
            $condition['limit'] = $limit;
        }

        return DB::select($query, $condition);
    }


    # m-107 查詢個人特色
    public function check_member_tag($whereArray)
    {
        $query = 'select * from cs_member_feature_m';
        $condition = [];

        if($whereArray) {
            $query .= 'where member_sn = :memberSn and content_sn = :tagSn';
            $condition['memberSn'] = $where_array['member_sn'];
            $condition['contentSn'] = $where_array['content_sn'];
        }

        return DB::select($query, $condition);
    }


    # m-108 刪除會員編號主人的個人特色
    public function delete_personal_feature($memberSn,$contentSn)
    {
        return $this->where('member_sn', $memberSn)
            ->where('sn', $contentSn)
            ->delete();
    }

    # m-110 新增會員編號的主人的個人特色
    function insert_personal_feature($insert_array)
    {
        /**
         * 改寫
         */
        $this->db->insert('cs_member_feature_m', $insert_array);
        $feature_sn = $this->db->insert_id();

        return $feature_sn;
    }

    # 拿取熱門 tag 的 sn
    public function get_popular_tag_count($limit, $gender, $memberType)
    {
        $query = <<<EOQ
            SELECT
                count(mm.content_sn) AS tag_count,
                mm.content_sn,
                fm.content
            FROM
                cs_member_feature_m AS mm
            LEFT JOIN cs_feature_contant_m AS fm ON fm.sn = mm.content_sn
            LEFT JOIN cs_personal_point_s AS ps ON ps.member_sn = mm.member_sn
            LEFT JOIN cs_member_data_s AS ms ON ms.member_sn = mm.member_sn
            WHERE
                ms.member_type = :memberType
EOQ;

        $condition['memberType'] = $memberType;

        if ( $gender != 'all') {
            $query .= 'ps.gender != : gender';
            $condition['gender'] = $gender;
        }

        $query .= '
            GROUP BY mm.content_sn
            ORDER BY tag_count desc
            LIMIT :limit
        ';

        $condition['limit'] = $limit;

        return DB::select($query, $condition);
    }


    # 拿取某有 tag 的人
    public function get_tag_member($limit, $tagSn, $gender, $memberType)
    {
        $query = <<<EOQ
            SELECT
                mm.member_sn,
                mm.content_sn,
                mm.create_time,
                fm.feature_type,
                fm.content,
                ps.gender,
                count(ml.sn) AS visit_num
            FROM
                cs_member_feature_m AS mm
            LEFT JOIN cs_personal_point_s AS ps ON ps.member_sn = mm.member_sn
            LEFT JOIN cs_feature_contant_m AS fm ON fm.sn = mm.content_sn
            LEFT JOIN cs_member_data_s AS ms ON ms.member_sn = mm.member_sn
            LEFT JOIN cs_member_visit_log AS ml ON ml.bewatch_member = mm.member_sn
            WHERE
                mm.content_sn = :tagSn
            AND ms.member_type = :memberType
EOQ;

        $condition['tagSn'] = $tagSn;
        $condition['memberType'] = $memberType;

        if ($gender != 'all') {
            $query .= 'ps.gender != : gender';
            $condition['gender'] = $gender;
        }

        $query .= '
            GROUP BY mm.member_sn
            ORDER BY visit_num desc
            LIMIT :limit
        ';

        $condition['limit'] = $limit;

        return DB::select($query, $condition);
    }



    # 拿取有某個tag內容的人
    public function get_one_tags_member($where_array, $limit, $offset)
    {
        $query = <<<EOQ
            SELECT
                mm.member_sn,
                ps.gender,
                ms.member_type
            FROM
                cs_member_feature_m AS mm
            LEFT JOIN cs_personal_point_s AS ps ON ps.member_sn = mm.member_sn
            LEFT JOIN cs_feature_contant_m AS fm ON fm.sn = mm.content_sn
            LEFT JOIN cs_member_data_s AS ms ON mm.member_sn = ms.member_sn
            WHERE
                mm.content_sn = :contentSn
            AND ps.gender != :gender
            AND ms.member_type = 'formal_member'
EOQ;

        $condition['contentSn'] = $where_array['contentSn'];
        $condition['gender'] = $where_array['gender'];

        if($limit != 'all') {
            $query .= 'limit :limit, :offset';
            $condition['limit'] = $where_array['limit'];
            $condition['offset'] = $where_array['offset'];
        }

        return DB::select($query, $condition);

    }
}
