<?php
require('../library/class/TestDirectory.php');


?>
<!DOCTYPE html>
<html lang="zh-Cn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../static/jquery-3.5.1.min.js"></script>
    
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<link href="../static/bootstrap-treeview.css" rel="stylesheet"/>


    <style>
        .directory{
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="container"> 
      <h1>Bootstrap Tree View - DOM Tree</h1>
      <br/>
      <div class="row">
        <div class="col-sm-12">
          <label for="treeview"></label>
          <div id="treeview"/>
        </div>
      </div>
</div>

    <?php
    
    $test = new TestDirectory();
    $test->getFileContent();
    $arr_str = implode('---',$test->fileContent);
    
  
    
    foreach($test->fileContent as $arr):
            // var_dump($arr);
    ?>
      <?php 
        
        
      ?>
            
    <?php
         
    endforeach;
    ?>


<script src="../static/bootstrap-treeview.js"></script>
<script type="text/javascript">
var arr_str = "<?=$arr_str?>"
var arr = arr_str.split('---')

function buildDomTree() {
   
  var data = [];

  function walk(nodes, data) {
    if (!nodes) { return; }
    $.each(nodes, function (id, node) {
      var obj = {
        id: id,
        text: node.nodeName + " - " + (node.innerText ? node.innerText : ''),
        tags: [node.childElementCount > 0 ? node.childElementCount + ' child elements' : '']
      };
      if (node.childElementCount > 0) {
        obj.nodes = [];
        walk(node.children, obj.nodes);
      }
      data.push(obj);
    });
  }

  walk($('html')[0].children, data);
  return data;
}
var tree = [
  // {
  //   text: "Parent 1",
  //   nodes: [
  //     {
  //       text: "Child 1",
  //       // nodes: [
  //       //   {
  //       //     text: "Grandchild 1"
  //       //   },
  //       //   {
  //       //     text: "Grandchild 2"
  //       //   }
  //       // ]
  //     },
  //     {
  //       text: "Child 2"
  //     }
  //   ]
  // },
  // {
  //   text: "Parent 2"
  // },
  // {
  //   text: "Parent 3"
  // },
  // {
  //   text: "Parent 4"
  // },
  // {
  //   text: "Parent 5"
  // }
];


let node_c;
let index = 0;
for(var value of arr){
  tree.push({text:value});
  if(value.lastIndexOf('/')>=0){
    tree[index].nodes=[];
  }
  index++;
}
var path ='';
let first = true;
let first_click_id;
let nodes;
let child_num
let dindex = 0
let iindex = 0
$(function() {
  //第一次上面的id点击和下面的id点击，处理第一次点击下面Id的点击
  var options = {
    bootstrap2: false, 
    showTags: true,
    expanded:false,
    levels: 5,
    data: tree,
    onNodeExpanded: function (event, data) {
      if(first){
        first_click_id = data.nodeId; //记录第一次点击的值
        nodes = tree[data.nodeId]
      }
      if(data.nodeId > first_click_id && !(data.nodeId < (first_click_id + dindex))){
        console.log('dssdsd')
        nodes = tree[data.nodeId - dindex]
      }else if(data.nodeId < (first_click_id + dindex)){
        // nodes = nodes.nodes
        console.log(nodes)
      }
      
      first = false;
      console.log(data)

     console.log(nodes);
     $.post('../library/ajax/AjaxExpand.php',{d:data.text},function(dw){
      //  console.log(dw);
        iindex = 0
        for(let value of JSON.parse(dw)){
          console.log(value)
          
          nodes.nodes.push({text:value})
          
          if(value.lastIndexOf('/')>=0){
            console.log(nodes)
            nodes.nodes[iindex].nodes=[];
          }
          iindex++
          dindex++;
          
        }
        // n.push({text:'fwwfe'})
        // console.log(n);
        $('#treeview').treeview(options);
     })
     
  }
  };

  $('#treeview').treeview(options);
  
});
    
</script>
</body>
</html>