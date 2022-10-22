<?php
namespace App\Helpers;
class Helper
{

    public static function GetRouteStatus($value)
    {
        static $routeStatus = array(
            '0' => 'จัดเตรียมออเดอร์',
            '1' => 'เตรียมจัดส่ง',
            '2' => 'จัดส่งสำเร็จแล้ว'
        );

        return $routeStatus[$value];
    }

    public static function GetRouteListStatus($value)
    {
        static $routeStatus = array(
            '0' => 'รอส่ง',
            '1' => 'จัดส่งสำเร็จแล้ว'
        );

        return $routeStatus[$value];
    }

    public static function GetProductStatus($value)
    {
        static $status = array(
            '0' => 'ถูกยกเลิก',
            '1' => 'ปกติ'
        );

        return $status[$value];
    }

    public static function DateTimeStringToEndOfDay($dateTime)
    {
        return (explode(' ', $dateTime)[0] . ' 23:59:59');
    }

    public static function IDGenerator($model, $trow, $length =  3, $prefix){
        $data = $model::orderBy('id' , 'desc')->first();
        if(!data){
                $og_length = $length;
                $last_number = ' ';
        }else{
                $code = substr($data->$trow, srtlen($prefix)+1);
                $actial_last_number = ($code/1)*1;
                $increment_last_number = $actial_last_number+1;
                $last_number_length = strlen($increment_last_number);
                $og_length = $length - $last_number_length;
                $last_number = $increment_last_number;
        }
        $zeros = "";
        for($i=0; $i<$og_length; $i++){
                $zeros.="0";
        }
        return $prefix. '-' .$zeros.$last_number;
    }

    public static function v4() 
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
   }
}

?>