<?php

namespace App\Helper;

use Carbon\Carbon;

class Helper
{

    public static function todayDate()
    {
        return Carbon::now()->format('Y-m-d');
    }
    public static function todayDateTime()
    {
        return Carbon::now()->format('M d, Y h:i A');
    }
    public static function dateFormat($date)
    {
        if (isset($date)) {
            return Carbon::parse($date)->format('M d, Y');
        }
        return;
    }

    public static function timestampFormat($time)
    {
        if (isset($time)) {
            return Carbon::createFromTimestamp(strtotime($time))->format('h:i A');
        }
        return;
    }

    public static function datetimeFormat($date)
    {
        if (isset($date)) {
            return Carbon::parse($date)->format('M d, Y h:i A');
        }
        return;
    }

    public static function gettime($id)
    {
        return Carbon::createFromTime($id)->format('H:i:s');
    }

    public static function timeFormat($id)
    {
        $time =  Carbon::createFromTime($id)->format('H:i:s');
        return Carbon::parse($time)->format('H:i A');
    }
}
