<?php


class RandString
{
//    private static $lowerLetters = 'abcdefghijklmnopqrstuvwxyz'; //小写字母
//    private static $upperLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; //大写字母
//    private static $numeric = '0123456789'; //数字
    private static $string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; //数字+大小写字母
    private static $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; //大小写字母
    private static $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~!@#$%^&*()'; //数字+大小写字母+特殊字符

    private static function generate($minLength=10, $maxLength=30, $seedString)
    {
        if ($minLength <= 0) {
            return '';
        }
        if ($minLength > $maxLength) {
            $len = $minLength;
        } else {
            $len = mt_rand($minLength, $maxLength);
        }
        $strCnt = strlen($seedString);
        $strMaxIdx = $strCnt - 1;
        $result = '';
        for ($i = 0; $i < $len; $i++) {
            $idx = mt_rand(0, $strMaxIdx);
            $result .= $seedString[$idx];
        }
        return $result;
    }

    public static function string($minLength=10, $maxLength=30)
    {
        return self::generate($minLength, $maxLength, self::$string);
    }

    public static function letters($minLength=10, $maxLength=30)
    {
        return self::generate($minLength, $maxLength, self::$letters);
    }

    public static function chars($minLength=10, $maxLength=30)
    {
        return self::generate($minLength, $maxLength, self::$chars);
    }
}



?>