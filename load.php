<?php
// define('ROOT', $_SERVER['DOCUMENT_ROOT']);
require(ROOT.'/function/class.db.php');
$con = new db();
echo '<div class="conteiner">';
$page = $_GET['page'];
$result = $con->dbcon->query('SELECT `catname` FROM `category` WHERE id = "'.$page.'" ;');
$result = $result->fetch_all();

$catname = base64_decode($result[0][0]);
echo '<h1 class="text-center" style="text-transform: uppercase; color: #7bc7bc; padding-top: 30px">'.$catname.'</h1>';
$result = $con->dbcon->query('SELECT * FROM `image` WHERE folder = "'.$page.'" ;');
$num_rows = $result->num_rows;
$pagination = $num_rows /15;
echo '<div class="flex-box">';
if (isset($_GET['limits'])){
  $l = $_GET['limits'];
  $lm=$l-1;
  $fl = 15*$lm; // number of step by output row
  $sl = 15; // number of output row if you change value, and change value to 74 string on sql query
  // echo '$l='.$l;
  // echo '$fl='.$fl;
  // echo '$sl='.$sl;
  $result = $con->dbcon->query("SELECT * FROM `image` WHERE folder = '".$page."' LIMIT ".$fl.", ".$sl.";");
  while ($row = $result->fetch_assoc()) {
  //print_r($row);
  $tags_id=$row['tag_id'];
  $tags_array=explode("::",$tags_id);
  $cou = count($tags_array)-1;
  unset($tags_array[$cou]);
  $tags_str = '';
  for ($i=0; $i <$cou ; $i++) {
    $result2 = $con->dbcon->query("SELECT * FROM `tags` WHERE id = '".$tags_array[$i]."'");
    $row2 = $result2->fetch_assoc();
    $cou2=$cou-1;
    $tag_name=base64_decode($row2['tagname']);
    if ($i == $cou2){
      $tags_str.= "<a href='/search.php?query=tagid&id=".$row2['id']."'>".ucfirst($tag_name).'</a>';
    }else{
      $tags_str.= "<a href='/search.php?query=tagid&id=".$row2['id']."'>".ucfirst($tag_name).'</a>, ';
    }
  }
  echo "<div class='flex-item text-center image'>
          <div class='image_img' data-toggle='modal' data-target='#".$row['id']."'>
            <img src='/uploads/250/".$row['href']."' style='height: 100%; overflow: hidden'>
            <div class='image_info'>
              <p><b>Размеры:</b> ".$row['size']."</p>
              <p><b>Теги:</b> ".$tags_str."</p>
              <p><b>Цена:</b> ".$row['price']."</p>
            </div>
          </div>
        </div>
        <div class='modal fade' id='".$row['id']."'>
          <div class='modal-dialog modal-lg'>
            <div class='modal-content'>

              <!-- Modal Header -->
              <div class='modal-header'>
                <h4 class='modal-title'>Изображение ".$row['href']."</h4>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
              </div>

              <!-- Modal body -->
              <div class='modal-body'>
                <a href='/uploads/1600/".$row['href']."' target='_blank' ><img src='/uploads/1600/".$row['href']."' style='width: 100%;'></a>
              </div>

              <!-- Modal footer -->
              <div class='modal-footer'>
                <div class='container-fluid'>
                  <div class='row'>
                    <div class='col-xs-5'><p><b> Размеры:</b> ".$row['size']." </p></div>
                    <div class='col-xs-5'><p><b> Теги:</b> ".$tags_str." </p></div>
                    <div class='col-xs-5'><p><b> Цена:</b> ".$row['price']." </p></div>
                  </div>
                </div>
                <button type='button' class='btn btn-info' data-dismiss='modal' data-cart='".$row['id']."'><i class='fa fa-cart-plus'></i></button>
                <button type='button' class='btn btn-danger' data-dismiss='modal'>Закрыть</button>
              </div>

            </div>
          </div>
        </div>

        ";
}
}else{
  $result = $con->dbcon->query("SELECT * FROM `image` WHERE folder = '".$page."' LIMIT 0, 12 ;");
  while ($row = $result->fetch_assoc()) {
  // print_r($row);
  $tags_id=$row['tag_id'];
  $tags_array=explode("::",$tags_id);
  $cou = count($tags_array)-1;
  unset($tags_array[$cou]);
  $tags_str = '';
  for ($i=0; $i <$cou ; $i++) {
    $result2 = $con->dbcon->query("SELECT * FROM `tags` WHERE id = '".$tags_array[$i]."'");
    $row2 = $result2->fetch_assoc();
    $cou2=$cou-1;
    $tag_name=base64_decode($row2['tagname']);
    if ($i == $cou2){
      $tags_str.= "<a href='/search.php?query=tagid&id=".$row2['id']."'>".ucfirst($tag_name).'</a>';
    }else{
      $tags_str.= "<a href='/search.php?query=tagid&id=".$row2['id']."'>".ucfirst($tag_name).'</a>, ';
    }
  }
  echo "<div class='flex-item text-center'>
          <div style='height: 70%' data-toggle='modal' data-target='#".$row['id']."_2'><img src='/uploads/250/".$row['href']."' style='height: 100%; overflow: hidden'></div>
          <p><b>Размеры:</b> ".$row['size']."</p><p><b>Теги:</b> ".$tags_str."</p>
        </div>
        <div class='modal fade' id='".$row['id']."_2'>
          <div class='modal-dialog modal-lg'>
            <div class='modal-content'>

              <!-- Modal Header -->
              <div class='modal-header'>
                <h4 class='modal-title'>Изображение ".$row['href']."</h4>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
              </div>

              <!-- Modal body -->
              <div class='modal-body'>
                <a href='/uploads/1600/".$row['href']."' target='_blank' ><img src='/uploads/1600/".$row['href']."' style='width: 100%;'></a>
              </div>

              <!-- Modal footer -->
              <div class='modal-footer'>
                <div class='container-fluid'>
                  <div class='row'>
                    <div class='col-xs-5'><p><b> Размеры:</b> ".$row['size']." </p></div>
                    <div class='col-xs-5'><p><b> Теги:</b> ".$tags_str." </p></div>
                  </div>
                </div>
                <button type='button' class='btn btn-info' data-cart='".$row['id']."'><i class='fa fa-cart-plus'></i></button>
                <button type='button' class='btn btn-danger' data-dismiss='modal'>Закрыть</button>
              </div>

            </div>
          </div>
        </div>

        ";
}
}
echo '</div>
    <div class="row">
      <ul class="pagination">';
        // echo $pagination;
        if ($pagination>7){
          $pag=$l-1+4;
          if ($l >4){
            $ap = $l-4;
            $pag=$l+3;
            $ceil = ceil($pagination)-4;
            if ($pag>=$ceil){
              $pag = ceil($pagination);
            }
          }else{
            $ap = 0;
            $pag= 7;
          }
          if ($l>=5){
            echo "<li class='page-item'><a class='page-link' href='?page=".$page."&limits=1'>1</a></li><li class='page-item'><a class='page-link' style='border-top:none;border-bottom:none;'>…</a></li>";
          }
          for ($i=$ap; $i < $pag; $i++) {
            $p = $i+1;
            if ($l == $p){
              echo "<li class='page-item active'><a class='page-link' href='?page=".$page."&limits=".$p."'>".$p."</a></li>";
            }else{
            echo "<li class='page-item'><a class='page-link' href='?page=".$page."&limits=".$p."'>".$p."</a></li>";
            }
          }
          if ($l <=(ceil($pagination)-3) ){
            echo "<li class='page-item'><a class='page-link' style='border-top:none;border-bottom:none;'>…</a></li><li class='page-item'><a class='page-link' href='?page=".$page."&limits=".ceil($pagination)."'>".ceil($pagination)."</a></li>";
          }

        }
echo "</ul>
    </div>
  </div>";
unset($row);
unset($row2);
unset($result);
unset($result2);
?>
