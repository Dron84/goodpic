<!DOCTYPE html>
<html lang="ru">
<?php
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
include(ROOT."/head.php");
?>
<body>
	<?php include(ROOT."/header.php"); ?>
	<section>
<?php
  require(ROOT.'/function/class.db.php');
  $con = new db();
  if (isset($_GET['id'])){
    echo '<div class="conteiner"><div class="flex-box">';
    $id = $_GET['id'];
    $sql= 'SELECT * FROM `image` WHERE tag_id LIKE "%'.$id.'::%"';
    // echo $sql;
    $result= $con->dbcon->query($sql);
    while ($row = $result->fetch_assoc()){
      $tags_id=$row['tag_id'];
      $tags_array=explode("::",$tags_id);
      $cou = count($tags_array)-1;
      unset($tags_array[$cou]);
      // print_r($tags_array);
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
		            </div>
		          </div>
		        </div>
            <div class='modal fade' id='".$row['id']."'>
              <div class='modal-dialog modal-lg'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <h4 class='modal-title'>Изображение ".$row['href']."</h4>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  </div>
                  <div class='modal-body'>
                    <a href='/uploads/1600/".$row['href']."' target='_blank' ><img src='/uploads/1600/".$row['href']."' style='width: 100%;'></a>
                  </div>
                  <div class='modal-footer'>
                    <div class='container-fluid'>
                      <div class='row'>
                        <div class='col-xs-5'><p><b> Размеры:</b> ".$row['size']." </p></div>
                        <div class='col-xs-5'><p><b> Теги:</b> ".$tags_str." </p></div>
                      </div>
                    </div>
										<button type='button' class='btn btn-info' data-dismiss='modal' data-cart='".$row['id']."'><i class='fa fa-cart-plus'></i></button>
                    <button type='button' class='btn btn-danger' data-dismiss='modal'>Закрыть</button>
                  </div>

                </div>
              </div>
            </div>";
    }
    echo "</div></div>";
  }
  if(isset($_GET['words'])){

    $tags = array();
    $words = explode(' ',trim($_GET['words']));
    if (count($words)>1){
      '$words='.print_r ($words);
    }else {
      $sql= 'SELECT * FROM `tags`';
      $result= $con->dbcon->query($sql);
      while ($row = $result->fetch_assoc()){
        $str = base64_decode($row['tagname']);
        $tags[]= mb_strtolower($str)."::::".$row['id'];
      }
      //print_r($tags);
      $search = array();
      foreach ($tags as $key => $value) {
        $word = mb_strtolower($words[0]);
        if(stristr($value, $word) !== FALSE) {
          $search[] = $value;
        }
      }
      if (count($search)==0){
        echo "<br><h3 class='text-center'>В нашей базе по запросу #".$word." изображений НЕТ.</h3>
        <p class='text-center' style='font-size: 1.2em'>Немного разных изображений ниже!</p>";
        require ROOT.'/main.php';
      }else{
        $exp = explode('::::',$search[0]);
        $tag_name = $exp[0];
        $id = $exp[1];
      	// echo '$tag_name='.$tag_name . '<br>$id='.$id.'<br>';
        $sql2= 'SELECT * FROM `image` WHERE tag_id LIKE "%'.$id.'%"';
        $result2 = $con->dbcon->query($sql2);
        echo '<div class="conteiner"><div class="flex-box">';
        while ($row2 = $result2->fetch_assoc()){
          // print_r($row2);
          $tags_id=$row2['tag_id'];
          $tags_array=explode("::",$tags_id);
          $cou = count($tags_array)-1;
          unset($tags_array[$cou]);
          $tags_str = '';
          for ($i=0; $i <$cou ; $i++) {
            $result3 = $con->dbcon->query("SELECT * FROM `tags` WHERE id = '".$tags_array[$i]."'");
            $row3 = $result3->fetch_assoc();
            $cou2=$cou-1;
            $tag_name=base64_decode($row3['tagname']);
            if ($i == $cou2){
              $tags_str.= "<a href='/search.php?query=tagid&id=".$row3['id']."'>".ucfirst($tag_name).'</a>';
            }else{
              $tags_str.= "<a href='/search.php?query=tagid&id=".$row3['id']."'>".ucfirst($tag_name).'</a>, ';
            }
          }
          echo "<div class='flex-item text-center image'>
				          <div class='image_img' data-toggle='modal' data-target='#".$row3['id']."'>
				            <img src='/uploads/250/".$row2['href']."' style='height: 100%; overflow: hidden'>
				            <div class='image_info'>
				              <p><b>Размеры:</b> ".$row2['size']."</p>
				              <p><b>Теги:</b> ".$tags_str."</p>
				            </div>
				          </div>
				        </div>
                <div class='modal fade' id='".$row['id']."'>
                  <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>

                      <!-- Modal Header -->
                      <div class='modal-header'>
                        <h4 class='modal-title'>Изображение ".$row2['href']."</h4>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                      </div>

                      <!-- Modal body -->
                      <div class='modal-body'>
                        <a href='/uploads/1600/".$row2['href']."' target='_blank' ><img src='/uploads/1600/".$row2['href']."' style='width: 100%;'></a>
                      </div>

                      <!-- Modal footer -->
                      <div class='modal-footer'>
                        <div class='container-fluid'>
                          <div class='row'>
                            <div class='col-xs-5'><p><b> Размеры:</b> ".$row2['size']." </p></div>
                            <div class='col-xs-5'><p><b> Теги:</b> ".$tags_str." </p></div>
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
        echo '</div></div>';
      }
      // print_r($search);
    }


    // $sql= 'SELECT * FROM `image` WHERE tag_id LIKE "%'.$id.'::%"';
    // // echo $sql;
    // $result= $con->dbcon->query($sql);
    // while ($row = $result->fetch_assoc()){
    //   $tags_id=$row['tag_id'];
    //   $tags_array=explode("::",$tags_id);
    //   $cou = count($tags_array)-1;
    //   unset($tags_array[$cou]);
    //   // print_r($tags_array);
    //   $tags_str = '';
    //   for ($i=0; $i <$cou ; $i++) {
    //     $result2 = $con->dbcon->query("SELECT * FROM `tags` WHERE id = '".$tags_array[$i]."'");
    //     $row2 = $result2->fetch_assoc();
    //     $cou2=$cou-1;
    //     $tag_name=base64_decode($row2['tagname']);
    //     if ($i == $cou2){
    //       $tags_str.= "<a href='/search.php?query=tagid&id=".$row2['id']."'>".ucfirst($tag_name).'</a>';
    //     }else{
    //       $tags_str.= "<a href='/search.php?query=tagid&id=".$row2['id']."'>".ucfirst($tag_name).'</a>, ';
    //     }
    //   }
    //   echo "<div class='flex-item text-center'>
    //           <div style='height: 70%'  data-toggle='modal' data-target='#".base64_encode($row['href'])."'><img src='/uploads/250/".$row['href']."' style='height: 100%; overflow: hidden'></div>
    //           <p><b>Размеры:</b> ".$row['size']."</p><p><b>Теги:</b> ".$tags_str."</p>
    //         </div>
    //         <div class='modal fade' id='".base64_encode($row['href'])."'>
    //           <div class='modal-dialog modal-lg'>
    //             <div class='modal-content'>
    //               <div class='modal-header'>
    //                 <h4 class='modal-title'>Изображение ".$row['href']."</h4>
    //                 <button type='button' class='close' data-dismiss='modal'>&times;</button>
    //               </div>
    //               <div class='modal-body'>
    //                 <a href='/uploads/1600/".$row['href']."' target='_blank' ><img src='/uploads/1600/".$row['href']."' style='width: 100%;'></a>
    //               </div>
    //               <div class='modal-footer'>
    //                 <div class='container-fluid'>
    //                   <div class='row'>
    //                     <div class='col-xs-5'><p><b> Размеры:</b> ".$row['size']." </p></div>
    //                     <div class='col-xs-5'><p><b> Теги:</b> ".$tags_str." </p></div>
    //                   </div>
    //                 </div>
    //                 <button type='button' class='btn btn-danger' data-dismiss='modal'>Закрыть</button>
    //               </div>
    //
    //             </div>
    //           </div>
    //         </div>";
    // }
    echo "</div></div>";
  }
?>
</section>
</body>
</html>
