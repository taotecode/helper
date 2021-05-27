<?php
/**
 * 字符串助手类
 * @project helper
 * @copyright
 * @author yuanzhumc
 * @version 1.0.0
 * @date: 2021/5/27
 * @createTime: 15:07
 * @filename Strings.php
 * @product_name PhpStorm
 * @link
 * @example
 *
 * @namespace yuanzhumc\helper
 */


namespace yuanzhumc\helper;


class Strings
{
    /**
     * 字符串截取
     * @param string $string 需要截取的字符串
     * @param int $length 截取长度
     * @param string $dot 超出长度代理字符串，默认...
     * @param string $charset 字符编码，默认utf-8
     * @return string
     */
    static function strCut(string $string, int $length, string $dot = '...', string $charset = 'utf-8') :string {

        $string = str_replace('&nbsp;', ' ', strip_tags($string));
        $string = str_replace(array(
            '&',
            '"',
            '<',
            '>',
            '\''
        ), array(
            '＆;',
            '＂',
            '＜',
            '＞',
            '＇'
        ), $string);
        return mb_substr($string, 0, $length, $charset) . (mb_strlen($string, $charset) > $length ? $dot : '');
    }

    /**
     * 获得唯一字符串
     * @return string 返回字符串
     */
    static function uniqueStr() :string {
        mt_srand((double) microtime() * 1000000);
        return md5(uniqid(mt_rand(), true));
    }

    /**
     * 将\n\r移除
     * @param string $str 需要处理的字符串
     * @return array|string|string[]|null
     */
    static function removeNr(string $str) {
        return preg_replace('/[\r\n]/', '', $str);
    }

    /**
     * 截取utf-8格式的中文字符串
     * @param string $string 字符串
     * @param int $cutlength 长度
     * @param string $dot 超出显示字符
     * @return string
     */
    static function cutStrUtf8(string $string, int $cutlength, string $dot = '...') :string {
        $returnstr = '';
        $i = 0;
        $n = 0;
        $sourcestr =$string;
        $str_length = strlen($sourcestr); // 字符串的字节数
        while (($n < $cutlength) and ( $i <= $str_length)) {
            $temp_str = substr($sourcestr, $i, 1);
            $ascnum = Ord($temp_str); // 得到字符串中第$i位字符的ascii码
            if ($ascnum >= 224) { // 如果ASCII位高与224，
                $returnstr = $returnstr . substr($sourcestr, $i, 3); // 根据UTF-8编码规范，将3个连续的字符计为单个字符
                $i = $i + 3; // 实际Byte计为3
                $n ++; // 字串长度计1
            } elseif ($ascnum >= 192) { // 如果ASCII位高与192，
                $returnstr = $returnstr . substr($sourcestr, $i, 2); // 根据UTF-8编码规范，将2个连续的字符计为单个字符
                $i = $i + 2; // 实际Byte计为2
                $n ++; // 字串长度计1
            } elseif ($ascnum >= 65 && $ascnum <= 90) { // 如果是大写字母，
                $returnstr = $returnstr . substr($sourcestr, $i, 1);
                $i = $i + 1; // 实际的Byte数仍计1个
                $n ++; // 但考虑整体美观，大写字母计成一个高位字符
            } else { // 其他情况下，包括小写字母和半角标点符号，
                $returnstr = $returnstr . substr($sourcestr, $i, 1);
                $i = $i + 1; // 实际的Byte数计1个
                $n = $n + 0.5; // 小写字母和半角标点等与半个高位字符宽...
            }
        }
        if ($str_length > strlen($returnstr)) {
            $returnstr = $returnstr . $dot; // 超过长度时在尾处加上省略号
        }
        return $returnstr;
    }
}