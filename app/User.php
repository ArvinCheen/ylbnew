<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

//    protected $table = 'users';
//
//    protected $primaryKey = 'id';

    protected $table = 'cs_worker_info_s';

    protected $primaryKey = 'sn';

    public $timestamps = false;

    protected $fillable = [
        'employee_sn', 'name', 'gender', 'e_name', 'nickname', 'roc_id', 'birthday', 'address', 'edu', 'school',
        'department', 'private_mobile', 'public_mobile', 'location', 'job', 'blood_type', 'emergency_name',
        'emergency_contact_mobile', 'emergency_contact_relation', 'account', 'password', 'work_status',
        'create_time', 'working_type', 'verify_sn', 'remember_token',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}



