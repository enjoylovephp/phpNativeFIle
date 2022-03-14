<?php
/**
 * Ajax类
 * 
 * @Date         2021/8/28
 * @LastEditors  actcpbe
 * @LastEditTime 2021/8/28 
 * @category     Class
 * @package      Class
 * @author       actcpbe <x16owo@163.com>
 * @license      actcpbe x16owo@163.com
 * @link         x16owo@163.com
 **/
// require dirname(dirname(__FILE__)).'/abstract/Cache.php';
/**
 * Ajax处理类
 * 
 * @category Actcpbe
 * @package  Actcpbe
 * @author   actcpbe <x16owo@163.com>
 * @license  email (x16owo@163.com)
 * @link     x16owo@163.com
 * @time     2021/8/28
 **/
final class Ajax
{
    

    public $cache;
    public $cache_data;
    public $fileContent;

    /**
     * 处理ajax请求的构造函数 
     * 
     * @author actcpbe
     * @time   2021/8/28
     * @return void
     **/
    function __construct()
    {
        // echo $url;
        // $temp_key1 = $temp_key2 = '';
        
        // $this->cache = new Cache($disk);
        // // echo $this->cache->file;
        // $this->cache_data = $this->cache->getDiskFileData();
        // // echo json_encode($url);

        // $filename_utf8 = json_encode($url);
        // foreach($this->cache_data as $k1=>$arr){
        //     foreach($arr as $k2=>$a){
        //         if($url == $k2){
        //             $temp_key1 = $k1;
        //             $temp_key2 = $k2;
                    
        //             $this->cache_data[$temp_key1][$temp_key2] = '已删除';
        //             // $this->cache_data = array_diff_key($this->cache_data,[$k2=>$k2]);
        //         }
        //     }
            
        // }
        
        // $this->cache_data = array_diff_key($this->cache_data,[json_encode($url)=>$url]);
        // echo json_encode($this->cache_data);
        // echo $this->cache->file;
        // $this->cache->writeDiskFile($this->cache_data);
        // echo $disk;
    }

    /**
     * 更改路径的名称
     * 
     * @param int    $id   文件id
     * @param string $old  旧的文件名
     * @param string $text 新的文件名
     * 
     * @Author actcpbe 
     * @time   2021/10/26 
     *
     * @return void
     **/
    public function rename($id,$old,$text)
    {
        $pos = mb_strrpos($id, '\\');
        $path = substr($id, 0, $pos);
        // echo $pos;
        rename($id, $path.$text);
    }
    
    /**
     * 文件夹和文件的递归删除
     * 
     * @param string $directory 目录
     * 
     * @Author actcpbe 
     * @time   2021/9/7 
     *
     * @return void
     **/
    public function delete($directory)
    {
        $i=0;
        if (is_dir($directory)) {
            if ($dh = opendir($directory)) {    //打开文件夹
                while (false !== ($file = readdir($dh))) {    //读取文件夹
                    $tmp = $directory.DIRECTORY_SEPARATOR.$file;    //递归得到文件夹中的文件夹路径或文件路径
                    
                    if (is_dir($tmp)) {   //如果是文件夹
                        $i++;   //系统自动有一个当前目录和子目录的引用，所以需要跳过前两个文件夹
                        if ($i>2) {
                            $this->delete($tmp);    //递归删除功能
                        }
                    }
                    
                    //先递归删除文件夹下的所有文件，删除完之后删除文件夹
                    if (is_file($tmp)) {  //如果是文件
                        unlink($tmp);
                    }
                }

                closedir($dh);
            }

            rmdir($directory);
        } else {
            unlink($directory);
        }
    }

    /**
     * 转码
     * 
     * @param string $str 字符串
     * 
     * @Author actcpbe 
     * @time   2021/9/7 
     *
     * @return string
     **/
    function unicode2utf8($str)
    {
        if (!$str) return $str;
        
        $decode = json_decode($str);
        
        if ($decode) return $decode;
        
        $str = '["' . $str . '"]';
        
        $decode = json_decode($str);
        
        if (count($decode) == 1) {
            return $decode[0];
        
        }
        
        return $str;
        
    }

    /**
     * 创建文件夹
     * 
     * @param string $folder 文件夹
     * 
     * @Author actcpbe 
     * @time   2021/10/30 
     *
     * @return void
     **/
    public function newfolder($folder)
    {
        mkdir($folder);
    }

    /**
     * 创建文件
     * 
     * @param string $file 文件
     * 
     * @Author actcpbe 
     * @time   2021/10/30 
     *
     * @return void
     **/
    public function newfile($file)
    {
        fopen($file, 'w');
    }


    /**
     * 根据路径展开文件夹
     * 
     * @param string $path 路径
     * 
     * @Author actcpbe 
     * @time   2022/2/9 
     *
     * @return void
     **/
    public function expand($path)
    {
        if ($dh = opendir($path)) {
            while (false !== ($file=readdir($dh))) {
                if (strpos($file, '.')==0) {
                    $this->fileContent[] = $file.'\\';
                } else {
                    $this->fileContent[] = $file;
                }
            }
            sort($this->fileContent);
        }
        echo json_encode($this->fileContent);
        // closedir($dh);
    }
}
//2021/8/29，无法删除存在文件的文件夹，需编写一个函数专门做删除文件夹功能



$action = $_GET['action'];
decide($action);



/**
 * 处理业务逻辑的方法
 * 
 * @param string $action 动作
 * 
 * @Author actcpbe 
 * @time   2021/10/26 
 *
 * @return void
 **/
function decide($action)
{
    $ajax = new Ajax();
    switch($action)
    {
    case 'delete':
        $path = $_POST['path'];
        $disk = $_POST['disk'];
        $ajax->delete($path);
        break;
    case 'rename':
        $id = $_POST['id'];
        $text = $_POST['text'];
        $old = $_POST['old'];
        $ajax->rename($id, $old, $text);
        break;
    case 'newfolder':
        $folder = $_POST['folder'];
        $ajax->newfolder($folder);
        break;
    case 'newfile':
        $file = $_POST['file'];
        $ajax->newfile($file);
        break;
    case 'expand':
        $path = $_POST['path'];
        $ajax->expand($path);
        break;
    }
}