<?php
/**
 * 类
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
require_once dirname(dirname(__FILE__)).'/class/Read.php';
/**
 * 类
 * 
 * @category Class
 * @package  Class
 * @author   actcpbe <x16owo@163.com>
 * @license  email (x16owo@163.com)
 * @link     x16owo@163.com
 * @time     2021/10/26
 **/
class AjaxExpand extends Read
{
    public $childFile;
    /**
     * 得到子级文件
     * 
     * @param string $data 文件
     * 
     * @Author actcpbe 
     * @time   2021/10/26 
     *
     * @return json
     **/
    public function getChildFileContent($data)
    {
        // return 'feefrfre';
        // return parent::$disk.$str;
        // echo parent::getDisk().$data;
        if ($dh = opendir('e://'.$data)) {
            while (false !== ($file=readdir($dh))) {
                if (strpos($file, '.')===false) {
                    $this->childFile[] = $data.$file.parent::DIRECTORY;
                } else {
                    $this->childFile[] = $data.$file;
                }

                // if(strpos($file,'.')===false){  //得到文件夹，有后缀名的是文件
                //     $this->fileContent[] = $file;
                // }
            }
            // sort($this->childFile);
        }
            
        closedir($dh);
        $this->childFile = array_splice($this->childFile, 2);
        //排序一维数组的目录
        echo json_encode($this->childFile);
    }
}
$data = $_POST['d'];
$ajax = new AjaxExpand();
$ajax->getChildFileContent($data);