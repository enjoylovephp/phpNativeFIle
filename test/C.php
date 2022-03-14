<?php
// abstract class C{
//     protected  static  $ST = 600;
//     const T = 100;
//     //公有
//     function test(){
//         return "test";
//     }
// }
// class C1 extends C{
    

//     public function getST(){
//         return self::$ST;
//     }
//     public function t(){
//         test();
//     }
//     // function test(){
//     //     return "c1 test";
//     // }
// } 

// interface IO{
//     function test();
// }
// $c = new C1();
// echo $c->getST();

abstract class A implements IO1,IO2{
    function a1(){
        echo "a1";
    }
}
class B extends A{
    function __construct()
    {
        echo "b construct";      
    }
    function a2(){
        echo "a2";
    }
}
abstract class C extends B{
    function testc(){
        echo "hello world";
    }   
}
class D extends C{

}
interface IO1{
    function a1();
}
interface IO2{
    function a2();
}
$c = new D();
$c->a2();



abstract class F1 implements IOA{
    function __construct()
    {
        echo "\nf1";
    }
    abstract function io1();
    function io2(){

    }
    abstract function io3();
    function io4(){

    }
}
class FA extends F1{
    function io1(){

    }
    function io3(){

    }
}

$fa = new FA();
interface IOA{
    function io1();
    function io2();
    function io3();
    function io4();
}


abstract class ab1{
    public $path;
    public function __construct($path)
    {
        echo "<br>ab1 test";
        $this->path = 'path';
    }
}

abstract class testab extends ab1{

}
class testabc extends testab{

}
$atest = new testabc('wfefe');
echo $atest->path;