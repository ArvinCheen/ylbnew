<?php
namespace App\Http\Library;

class userInfoLibrary
{

    function getBrowser()
    {
        $userAgent = $_SERVER["HTTP_USER_AGENT"];

        if( preg_match('/MSIE/', $userAgent)) {
            $browser = "IE";
        } elseif ( preg_match('/Safari/', $userAgent) && !preg_match('/Chrome/', $userAgent)) {
            $browser = "Safari";
        } elseif ( preg_match('/Safari/', $userAgent) && preg_match('/Chrome/', $userAgent) && preg_match('/Edge/', $userAgent)) {
            $browser = "Edge";
        }elseif( preg_match('/OPR/', $userAgent)) {
            $browser = "Opera";
        } elseif ( preg_match('/Firefox/', $userAgent)) {
            $browser = "Firefox";
        } elseif ( preg_match('/Safari/', $userAgent) && preg_match('/Chrome/', $userAgent)) {
            $browser = "Chrome";
        } else {
            $browser = "Unknow";
        }

        return $browser;
    }

    function getOs()
    {
        $userAgent = $_SERVER["HTTP_USER_AGENT"];

        if( preg_match('/Windows NT 10.0/', $userAgent)) {
            $os = "Windows 10";
        } elseif( preg_match('/Windows NT 5.1/', $userAgent)) {
            $os = "Windows XP";
        } elseif ( preg_match('/Windows NT 6.0/', $userAgent)) {
            $os = "Windows Vista";
        } elseif ( preg_match('/Windows NT 6.1/', $userAgent)) {
            $os = "Windows 7/2008 R1";
        } elseif ( preg_match('/Windows NT 5.0/', $userAgent)) {
            $os = "Windows 2000";
        } elseif ( preg_match('/Mac OS X/', $userAgent)) {
            $os = "Apple Macintosh";
        } elseif ( preg_match('/Linux/', $userAgent) && preg_match('/Android/', $userAgent)) {
            $os = "Android";
        } elseif ( preg_match('/Linux/', $userAgent)) {
            $os = "Linux";
        } else {
            $os = "Unknow";
        }

        return $os;
    }
}