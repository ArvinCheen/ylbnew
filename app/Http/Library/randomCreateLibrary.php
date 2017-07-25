<?php

namespace App\Http\Library;

class randomCreateLibrary {


    # l-32 產生各式自定編號
    public function create_sn($create_type ='')
    {
        $sn = '';

        switch($create_type)
        {
            case 'member_sn':	#會員編號
                $sn .= 'MEM';
                $sn .= time();
                $sn .= $this->create_rand_num(3);
                break;

            case 'worker_sn':	#工作人員編號
                $sn .= 'EMP';
                $sn .= time();
                $sn .= $this->create_rand_num(3);
                break;

            case 'partner_sn':	#廠商編號
                $sn .= 'PAR';
                $sn .= time();
                $sn .= $this->create_rand_num(3);
                break;

            case 'allpay_sn':	#歐付寶訂單編號
                $sn .= 'ORD';
                $sn .= time();
                $sn .= $this->create_rand_num(3);
                break;

            case 'room_sn':		#聊天ROOM編號
                $sn .= 'R';
                $sn .= time();
                $sn .= $this->create_rand_num(3);
                break;

            case 'point_order_sn':	#點數訂單編號
                $sn .= 'POI';
                $sn .= time();
                $sn .= $this->create_rand_num(3);
                break;

            default:
                $sn = 'FALSE';
        }

        return $sn;
        #Controller記得檢驗$sn是否為FALSE...
    }

    # l-33 產生X位數字亂數
    public function create_rand_num($length = 3)
    {
        $random_num = '';
        for ($i=0; $i < $length; $i++)
        {
            $random_num .= rand(0, 9);
        }

        return $random_num;
    }

    # l-34 產生中英文夾雜亂數,預設8位數
    public function create_check_word($length = 8)
    {
        $random_num = array();
        for ($i=0; $i < $length; $i++)
        {
            $temp = rand(1,2);
            if($temp == 1)
            {
                $random_num[$i] = rand(48, 57); #0~9
            }
            else
            {
                $random_num[$i] = rand(65, 90); #A~Z
            }
        }

        # ASCII 轉 字串
        for ($i=0; $i < $length; $i++)
        {
            $random_word = sprintf('%s%c', isset($random_word) ? $random_word : NULL, $random_num[$i]);
        }

        return $random_word;
    }




}