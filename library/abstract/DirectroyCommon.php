<?php
/**
 * DirectoryCommon.php
 * 
 * @Author       actcpbe
 * @Date         2022-02-05 17:52:48
 * @LastEditors  actcpbe
 * @LastEditTime 2022-02-06 18:58:36
 * @category     Controller
 * @package      Controller
 * @author       actcpbe <x16owo@163.com>
 * @license      email (x16owo@163.com)
 * @link         x16owo@163.com
 */

require dirname(__FILE__).'/FDCommon.php';

/**
 * 目录操作类
 * 
 * @category Controller
 * @package  Controller
 * @author   actcpbe <x16owo@163.com>
 * @license  email (x16owo@163.com)
 * @link     x16owo@163.com
 **/
class DirectoryCommon extends FDCommon
{

    public $fileContent;
    public $fileAll;
    public $baseFile;

    /**
     * 得到子目录和子目录下的子目录
     * 
     * @Author      actcpbe
     * @Description 得到所有的子目录和子目录下的子目录
     * @Time        2021年4月1日20:33:44
     * @return      void
     **/
    public function getFileContent()
    {
        // $this->cache = new Cache(parent::$disk);  //缓存路径
        // if(!$this->cache->getDiskFile()){   //不存在该文件

        if ($dh = opendir(parent::$disk)) {
            while (false !== ($file=readdir($dh))) {
                if (strpos($file, '.')===false) {  //得到文件夹，有后缀名的是文件
                    $this->fileContent[] = $file;
                } else {
                    $this->fileAll[][parent::$disk.$file] = $file;
                }

            }
            closedir($dh);
        }
        
        foreach ($this->fileContent as $directory) { //$directory是所有顶级文件夹
            $this->getChildTopFile(parent::getDisk().$directory);
            $this->getChildFile(parent::getDisk().$directory);   //递归读取子级文件夹
        }
        // $this->cache->writeDiskFile($this->fileAll);
        echo json_encode($this->fileAll);
        // }
        // else{  //存在该文件
            // $data = $this->cache->getDiskFileData();
            // echo json_encode($data);
        // }
       
    }
    
    /**
     * 得到顶级目录
     * 
     * @param string $directory 目录
     * 
     * @Author actcpbe 
     * @time   2021/8/28 
     *
     * @return void
     **/
    public function getChildTopFile($directory)
    {
        $this->fileAll [][$directory] = $directory; //用二维数组表示文件夹=>对应的文件夹字符串，存储加密码的代表文件夹和文件夹路径，读取根目录
    }

    /**
     * 得到所有子文件
     * 
     * @param string $directory 目录
     * 
     * @Author actcpbe 
     * @time   2021/8/28 
     *
     * @return void
     **/
    public function getChildFile($directory)
    {
        $i=0;
        if (is_dir($directory)) {
            
            if (@$dh = opendir($directory)) {    //打开文件夹
            
                while (false !== ($file = readdir($dh))) {    //读取文件夹
                    
                    $tmp = $directory.'\\'.$file;
                    if (is_file($tmp)) {
                        $this->fileAll[][$tmp] = $file;
                    }
                    if (is_dir($directory.'\\'.$file)) {//如果是文件夹
                        $i++;
                        if ($i>2) {
                            $this->fileAll[][$tmp] = $file;
                            $this->getChildFile($tmp);
                            
                        }
                        //把文件的路径=>映射到文件名中
                    }                        
                }
            
                closedir($dh);
            
            }
        }
            
    }
    /**
     * 处理根级目录 
     * 
     * @author actcpbe
     * @time   2021/8/28
     * @return void
     **/
    public function dealBaseFile()
    {
        $this->baseFile = array_splice($this->baseFile, 3);
    }

    
}