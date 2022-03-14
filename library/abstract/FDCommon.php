<?php
/**
 * 目录和文件的基类
 * 
 * @Date         2021/3/29
 * @LastEditors  actcpbe
 * @LastEditTime 2021/3/29 
 * @category     Abstract
 * @package      Abstract
 * @author       actcpbe <x16owo@163.com>
 * @license      email (x16owo@163.com)
 * @link         x16owo@163.com
 **/
require 'Cache.php';

define('DISK_PATH', dirname(dirname(dirname(__FILE__))));
define('FILE_NAME', DIRECTORY_SEPARATOR.'static'.DIRECTORY_SEPARATOR.'disk.json');
/**
 * 文件和文件夹的抽象类
 * 
 * @category Class
 * @package  Class
 * @author   actcpbe <x16owo@163.com>
 * @license  email (x16owo@163.com)
 * @link     x16owo@163.com
 * @time     2021/3/29
 **/
class FDCommon
{
    const DIRECTORY = DIRECTORY_SEPARATOR;
    static public $disk_all;    //磁盘路径

    static public $disk;
    public $path_count; 

    public $cache;
    
    /**
     * 构造函数 
     * 
     * @author actcpbe
     * @time   2021/3/29
     * @return void
     **/
    public function __construct()
    {

        for ($i=65;$i<=90;$i++) {
            $temp = chr($i);
            $directory = $temp.':\\\\';
            if ($dh = @opendir($directory)) {    //打开文件夹
                if (false !== ($file = @readdir($dh))) {    //读取文件夹
                    self::$disk_all[$temp] = $directory;//递归得到文件夹中的文件夹路径或文件路径
                }
                closedir($dh);
            }
        }

        unset(self::$disk_all['C']);    //不遍历C盘
    }
    
    /**
     * 得到磁盘盘号 
     * 
     * @author actcpbe
     * @time   2021/8/28
     * @return string
     **/
    public static function getDisk()
    {
        return self::$disk;
    }

}
