<?php
/**
 * Ajax磁盘
 * 
 * @Date         2021/8/28
 * @LastEditors  actcpbe
 * @LastEditTime 2021/10/26
 * @category     Ajax
 * @package      Ajax
 * @author       actcpbe <x16owo@163.com>
 * @license      email (x16owo@163.com)
 * @link         x16owo@163.com
 **/
require dirname(dirname(__FILE__)).'/abstract/DirectroyCommon.php';
$disk = $_POST['data'];
// echo $disk;
$test = new DirectoryCommon();
$test::$disk = $disk;
$test->getFileContent();


