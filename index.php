<?php
require('library/class/TestDirectory.php');

?>
<!DOCTYPE html>
<html lang="zh-Cn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS -->
<link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="/static/jquery-3.5.1.min.js"></script>
<link rel="stylesheet" href="/static/jstree/dist/themes/default/style.min.css" />
<!-- jQuery and JavaScript Bundle with Popper -->
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
<script src="/static/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/static/jstree/dist/jstree.min.js"></script>
    <style>
        .directory{
            display: inline-block;
        }
    </style>
</head>
<body>
    <div> 
      <button id="delete" class="btn btn-light">删除</button>
      <button id="rename" class="btn btn-light">重命名</button>
      <button id="newfile" class="btn btn-light">新建文件</button>
      <button id="newfolder" class="btn btn-light">新建文件夹</button>
    </div>
    <?php

    $test = new TestDirectory();

    // var_dump($test->cache->getDiskFile());
    // var_dump($test::$disk_all);
    foreach($test::$disk_all as $key=>$d):
    ?>
      <button class='disk' value="<?=$d?>"><?=$key?></button>

    <?php

    endforeach;
    ?>
    
<div id="html1"></div>
<script type="text/javascript">

let num = 2 //初始目录路径

//13层目录遍历
let p1_id,p2_id,p3_id,p4_id,p5_id,p6_id,p7_id,p8_id,p9_id,p10_id,p11_id,p12_id,p13_id= ''
let directroy_depth = [];

let current_disk = ''

$('.disk').each(function(index,elm){
  $(elm).click(function(){
    //comment
    current_disk = $(this).val();

    var val = $(this).val();
   
    $.post('/library/ajax/AjaxDisk.php',{data:val},function(data){
      var result = []
      result.push({'id':current_disk,'parent':'#','text':current_disk,icon:'jstree-folder'});
      console.log(data)
      let json_str = JSON.parse(data)
      // console.log(data)

      let icon = "jstree-folder";
      for(let index in json_str){
        let rootfile
        if(json_str[index] instanceof Array){
          rootfile = json_str[index][0]
          // if(rootfile.indexOf('RECYCLE'>=0))continue;
          result.push({'id':rootfile,'parent':current_disk,'text':rootfile,'icon':'jstree-file'})
        }
        
        let filename
        let arr =[];
        
        let json_key = Object.keys(json_str[index]) //得到json对象的属性名
        let count = numCount(json_key[0]) //得到属性中的路径分隔符数量

        for(var i in json_str[index]){
          filename = json_str[index][i] //得到文件名
        }


        //可以用ajax判断，是否为文件和目录
        if(json_key[0].indexOf('\.')>=1){
          icon = 'jstree-file'
        }else{
          icon = 'jstree-folder'
        }
        //num+几代表几层目录
        switch(count){
          case num:
            p1_id = json_key[0]
            let index = filename.lastIndexOf('\\') + 1;
            filename = filename.substr(index,filename.length)
            result.push({'id':p1_id,'parent':current_disk,'text':filename,'icon':icon})
            break;
          case num+1:
            p2_id = json_key[0]
            result.push({'id':p2_id,'parent':p1_id,'text':filename,'icon':icon})
            break;
          case num+2:
            p3_id = json_key[0]
            result.push({'id':p3_id,'parent':p2_id,'text':filename,'icon':icon})
            break;
          case num+3:
            p4_id = json_key[0]
            result.push({'id':p4_id,'parent':p3_id,'text':filename,'icon':icon})
            break;
          case num+4:
            p5_id = json_key[0]
            result.push({'id':p5_id,'parent':p4_id,'text':filename,'icon':icon})
            break;
          case num+5:
            p6_id = json_key[0]
            result.push({'id':p6_id,'parent':p5_id,'text':filename,'icon':icon})
            break;
          case num+6:
            p7_id = json_key[0]
            result.push({'id':p7_id,'parent':p6_id,'text':filename,'icon':icon})
            break;
          case num+7:
            p8_id = json_key[0]
            result.push({'id':p8_id,'parent':p7_id,'text':filename,'icon':icon})
            break;
          case num+8:
            p9_id = json_key[0]
            result.push({'id':p9_id,'parent':p8_id,'text':filename,'icon':icon})
            break;
          case num+9:
            p10_id = json_key[0]
            result.push({'id':p10_id,'parent':p9_id,'text':filename,'icon':icon})
            break;
          case num+10:
            p11_id = json_key[0]
            result.push({'id':p11_id,'parent':p10_id,'text':filename,'icon':icon})
            break;
          case num+11:
            p12_id = json_key[0]
            result.push({'id':p12_id,'parent':p11_id,'text':filename,'icon':icon})
            break;
          case num+10:
            p13_id = json_key[0]
            result.push({'id':p13_id,'parent':p12_id,'text':filename,'icon':icon})
            break;
        }
      }
      
      $.jstree.destroy()
      $('#html1').jstree({  //渲染
        'core':{
          "check_callback" : true,
          
          "plugins": ["dnd",'contextmenu'],
          'contextmenu': {    // 右键菜单
              'items': {
                  'edit': {
                      'label': '编辑',
                      'action': function (data) {}
                  },
                  'delete': {
                      'label': '删除',
                      'action': function (data) {}
                  }
              }
          },
          'data':result
        }
      })
    })
    
  })
})

$('#delete').click(function(){
  var treeNode = $('#html1').jstree(true).get_selected(true); 
  var id = treeNode[0].id

  $.post('/library/ajax/Ajax.php?action=delete',{path:id,disk:current_disk},function(e){
    console.log(e)
  })
  $('#html1').jstree('delete_node', id , true);
  
})
$('#rename').click(function(){
  var treeNode = $('#html1').jstree(true).get_selected(true); 
  var id = treeNode[0].id
  var newtxt = $('#html1').jstree(true).edit(id); 
  $('#html1').on('rename_node.jstree',function (node, e) {
    $.post('/library/ajax/AjaxRename.php?action=rename',{id:e.node.id,text:e.text,old:e.old},function(data){
    })
  })
  
})
let create_index = 0;
$('#newfile').click(function(){
  var treeNode = $('#html1').jstree(true).get_selected(true); 
  var id = treeNode[0].id
  var icon = treeNode[0].icon
  console.log(icon)
  if(icon == 'jstree-file'){
    return;
  }
   
  create_index++;
  let create_id = id+'_'+create_index
  $('#html1').jstree('create_node',treeNode[0],{'text':create_index,'id':create_id,'icon':'jstree-file'},'last');
  var newtxt = $('#html1').jstree(true).edit(create_id);
  $('#html1').on('rename_node.jstree',function (node, e) {
    $.post('/library/ajax/Ajax.php?action=newfile',{file:id+'\\'+e.text},function(data){
    })
  })
  
})
$('#newfolder').click(function(){
  var treeNode = $('#html1').jstree(true).get_selected(true); 
  var id = treeNode[0].id
  var icon = treeNode[0].icon
  if(icon == 'jstree-file'){
    return;
  }
   
  create_index++;
  let create_id = id+'_'+create_index
  $('#html1').jstree('create_node',treeNode[0],{'text':create_index,'id':create_id,'icon':'jstree-folder'},'last');
  var newtxt = $('#html1').jstree(true).edit(create_id);

  $('#html1').on('rename_node.jstree',function (node, e) {
    $.post('/library/ajax/Ajax.php?action=newfolder',{folder:id+'\\'+e.text},function(data){
    })
  })
  
})

function numCount(str) {
    var s = '统计字符出现的次数\n请输入字符串：';
    var str = str.toLowerCase();//将字符串转换小写
    var info1 = '\\';
    var info = info1.toLowerCase();//将字符转换小写
    var sum = 0;
    //统计字符出现的次数,不区分大小写
    //先将所有字符转换成小写的toLowerCase
    var arr = str.split('');//将字符串转换成数组
    // 不使用循环，用forEach代替
    arr.forEach(function (value, index, arr) {
        if (value === info) {
            sum += 1;
        }
    })
    return sum
}
</script>
</body>
</html>