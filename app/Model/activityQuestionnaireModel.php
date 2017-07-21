<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class activityQuestionnaireModel extends Model
{
    protected $table = 'cs_activity_questionnaire';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    // 似乎沒用到
}
