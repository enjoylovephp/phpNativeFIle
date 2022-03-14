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
    <!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-olOxEXxDwd20BlATUibkEnjPN3sVq2YWmYOnsMYutq7X8YcUdD6y/1I+f+ZOq/47" crossorigin="anonymous">
    <script src="../static/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    
<!-- jQuery and JavaScript Bundle with Popper -->
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-NU/T4JKmgovMiPaK2GP9Y+TVBQxiaiYFJB6igFtfExinKlzVruIK6XtKqxCGXwCG" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
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
<div id="html1">
  <ul>
    <li>根节点 1
      <ul>
        <li>子节点 1</li>
        <li><a href="#">子节点 2</a></li>
      </ul>
    </li>
    <li>根节点2</li>
  </ul>
</div>
<!-- <div id="html1"></div> -->
<!-- <ul> -->
    <?php
    
    $test = new TestDirectory();
    $test->getFileContent();
    // $arr_str = implode('---',$test->fileContent);
    var_dump($test->fileAll);
    $count = 0;
    $data;
    $cursor = 0;
    $record = 0;
    $record_key;
    $record_key2 = '';
    $record_key3 = '';$record_key4 = '';
    // $tmp;
    $record_key_arr;

    $count_1 = 0;
    $data_all;
    $tmp = $tmp2=$tmp3=[];
    $json;
    $start_key;
    $record2=$record3=$record4=$record5=0;
    $top_key_arr =[];

    $three_index = $two_index = 0;
    $use_three;
    foreach($test->fileAll as $key1=>$arr):
     
      foreach($arr as $key2=>$file):
    ?>
      <?php  
      // $data[] = $file;
      $start = 2;
      $count = substr_count($key2,'\\');
      if($count >= 2){
        if($count==2){
          $record = $key1;
          $record_key = $key2;
          $top_key_arr[] = $key2;
          $tmp=[];
          // $count_1++;
        }else if($count == 3){
          $record_key2 = $key2;
          
          $tmp[] = ['text'=>$file];//这个说明了二级目录
          
          $data[$record_key] = 
            ['text'=>$record_key,'children'=>$tmp]
          ;
          $three_index++;
        }
        // else if($count == 4){
          
        //   $record_key3 = $key2;
        //   $tmp[] = ['text'=>$file];
        //   $data[$record_key][$record_key2] = 
        //     ['text'=>$record_key2,'children'=>$tmp];
        //   $three_index++;
        // }
        // else if($count == 5){
        //   $record_key4 = $key2;
        //   $tmp[] = ['text'=>$file];
        //   $data[$record_key][$record_key2][$record_key3] = 
        //     ['text'=>$record_key3,'children'=>$tmp];
        // }
        
      }

      // echo "<li class='nodes'>".$file."</li>";
      
      // if()
        // echo "<li>".$file;
        // echo "</li>"; 
      
      $cursor++;
      ?>
            
    <?php
      endforeach;
    endforeach; 
    $json=json_encode($data);
    $top_key_arr = json_encode($top_key_arr);
    var_dump($data);
    ?>
<!-- </ul>
</div> -->

<script type="text/javascript">
// $('#html1').jstree();
let json=<?=$json?>;
let data= [];
let c = JSON.stringify(json);
let d = eval('('+c+')');
let w = eval('('+c+')')
let key_arr = <?=$top_key_arr?>;

  for(let value of key_arr){
    console.log(value)
  }
var findata = [];
for(let ww in w){
  findata.push(w[ww])
  
  console.log(w[ww])
}
$('#html1').jstree({
  'core':{
    'data':findata
  }
})
console.log(w)
</script>
</body>
</html>