<?php
/**
 * Cache
 * 
 * @Date         2021/10/9
 * @LastEditors  actcpbe
 * @LastEditTime 2021/10/9 
 * @category     Cache
 * @package      Cache
 * @author       actcpbe <x16owo@163.com>
 * @license      email (x16owo@163.com)
 * @link         x16owo@163.com
 **/
/**
 * 缓存类
 * 
 * @category File
 * @package  File
 * @author   actcpbe <x16owo@163.com>
 * @license  email (x16owo@163.com)
 * @link     x16owo@163.com
 * @time     2021/10/9
 **/
class Cache
{
    public $disk;
    const FILE_NAME = 'disk';

    public $file;  //缓存文件的名称
  
    /**
     * 构造函数
     * 
     * @param string $disk 磁盘
     * 
     * @Author actcpbe 
     * @time   2022/2/5 
     *
     * @return void
     **/
    public function __construct($disk)
    {
        $this->disk = $disk;
        $this->file = $this->disk.self::FILE_NAME;
    }

    /**
     * 判断文件是否存在 
     * 
     * @author actcpbe
     * @time   2021/10/9
     * @return bool
     **/
    public function getDiskFile()
    {
        $temp = file_exists($this->file);
        
        return $temp;  //存在返回真
    }

    /**
     * 写入序列化数组信息到文件中
     * 
     * @param string $data 
     * 
     * @Author actcpbe 
     * @time   2021/10/9
     *
     * @return void
     **/
    public function writeDiskFile($data)
    {
        //缓存 
        if (false!==($res = fopen($this->file, 'w+'))) { 
            file_put_contents($this->file, serialize($data));//写入缓存 
            fclose($res);
        } 

    }

    /**
     * 得到缓存文件的数据信息 
     * 
     * @author actcpbe
     * @time   2021/10/9
     * @return array
     **/
    public function getDiskFileData()
    {
        if (file_exists($this->file)) {
            //读出缓存 
            $handle=fopen($this->file, 'r'); 
            $cacheArray=unserialize(fread($handle, filesize($this->file)));
            fclose($handle);
        }
        return $cacheArray ?? null;
    }
}
