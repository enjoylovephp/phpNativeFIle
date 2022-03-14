<?php
/**
 * 文件类
 * 
 * @Date         2021/10/26
 * @LastEditors  actcpbe
 * @LastEditTime 2021/10/26 
 * @category     Class
 * @package      Class
 * @author       actcpbe <x16owo@163.com>
 * @license      email x16owo@163.com
 * @link         x16owo@163.com
 **/
require_once dirname(dirname(__FILE__))."/abstract/FDCommon.php";
/**
 * 读取类
 * 
 * @category Class
 * @package  Class
 * @author   actcpbe <x16owo@163.com>
 * @license  email (x16owo@163.com)
 * @link     x16owo@163.com
 * @time     2021/10/26
 **/
class Read extends FDCommon
{

    public $fileContent;
   
    /**
     * 得到文件内容 
     * 
     * @author actcpbe
     * @time   2021/10/26
     * @return void
     **/
    public function getFileContent()
    {
        if ($dh = opendir(parent::$disk)) {
            while (false !== ($file=readdir($dh))) {
                if (strpos($file, '.')===false) {
                    $this->fileContent[] = $file.parent::DIRECTORY;
                } else {
                    $this->fileContent[] = $file;
                }

            }
            sort($this->fileContent);
        }
            
        closedir($dh);
    }

    
}