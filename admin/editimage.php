<div class="container">
  <div class="navbar navbar-expand-sm bg-light navbar-light sticky-top" style="background: transparent !important;">
    <ul class="navbar-nav">
        <?php
        require ROOT.'/admin/func.php';
        $con = new db();
    		if ($result = $con->dbcon->query("select * from `category` WHERE tagid=0 or tagid=-1;")) {
    			$result = $result->fetch_all();
          // print_r($result);
    			for ($i=0; $i < count($result) ; $i++) {
    				 $row = $result[$i];
    				 if ($row[2]=='-1'){

    					 // $conresult[$i]= array('value' => $row[0], 'catname'=> base64_decode($row[1]));
    					 echo "<li class='nav-item dropdown'>
                     <a class='nav-link dropdown-toggle' href='?page=cat&limits=1&catname=".$row[0]."' data-toggle='dropdown' aria-expanded='true'>
                       ".base64_decode($row[1])."
                     </a><div class='dropdown-menu'>";
    					 $str = "select * from `category` WHERE tagid=".$row[0].";";
    					 if ($result2 = $con->dbcon->query($str)){
    						 while ($row2 = $result2->fetch_assoc()) {
    							 	// $conresult[$i]['podcat'][]= array('value' => $row2['id'], 'catname'=> base64_decode($row2['catname']));
    								echo "<a class='nav-link' href='?page=cat&limits=1&catname=".$row2['id']."'>&nbsp&nbsp&nbsp".base64_decode($row2['catname'])."</a>";
    							 }
    					 }
               echo '</div></li>';
    				 }else if($row[2]=='0'){
    					 $conresult[$i]= array('value' => $row[0], 'catname'=> base64_decode($row[1]));
    					 echo "<li class='nav-item'><a class='nav-link' href='?page=cat&limits=1&catname=".$row[0]."'>".base64_decode($row[1])."</a></li>";
    				 }
    			}
    		}

        ?>
    </ul>
  </div>
</div>
<div class="container-fluid">
  <div class="flex-box">
<?php
if ( (isset($_GET['page'])) & ($_GET['page']=='cat') & (isset($_GET['catname'])) ){
  // require(ROOT.'/function/class.db.php');
  $con = new db();
  $page = $_GET['page'];
  $catname =$_GET['catname'];
  $result = $con->dbcon->query("SELECT * FROM `image` WHERE folder=".$catname);
  // print_r($result->fetch_all());
  $num_rows = $result->num_rows;
  $pagination = $num_rows /15;
  $l='';
  if (isset($_GET['limits'])){
    $l = $_GET['limits'];
    $lm=$l-1;
    $fl = 15*$lm; // number of step by output row
    $sl = 15; // number of output row
    // echo '$l='.$l;
    // echo '$fl='.$fl;
    // echo '$sl='.$sl;
    $result = $con->dbcon->query("SELECT * FROM `image` WHERE folder='".$catname."' LIMIT ".$fl.", ".$sl.";");
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
          $tags_str.= ucfirst($tag_name).' ';
        }else{
          $tags_str.= ucfirst($tag_name).' , ';
        }
      }
      $s = explode('x', $row['size']);
      $f = $row['folder'];
      echo "<div class='flex-item text-center'>
              <p style='display: inline-block;'><b>Имя файла:</b> ".$row['href']."
              <a href='?action=edit&id=".$row['id']."&href=".base64_encode($row['href'])."' class='btn btn-warning' data-toggle='modal' data-target='#".$row['id']."'><i class='fa fa-edit' data-target='tooltip' title='Редактировать' style='color: white'></i></a>
              <a href='/admin/func_get.php?action=del&id=".$row['id']."&href=".base64_encode($row['href'])."' class='btn btn-danger'><i class='fa fa-trash' data-target='tooltip' title='Удалить' style='color: white'></i></a>
              </p>

              <div style='height: 50%' data-toggle='modal' data-target='#".$row['id']."'>
                <img src='/uploads/250/".$row['href']."' style='height: 100%; overflow: hidden'>
              </div>
              <p><b>Размеры:</b> ".$row['size']."</p><p><b>Теги:</b> ".$tags_str."</p>

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

                    <div class='input-group' style='height: 50%; padding: 20px;'>
                      <a href='/uploads/1600/".$row['href']."' target='_blank'><img src='/uploads/250/".$row['href']."' style='height: 100%; overflow: hidden'></a>
                    </div>
                    <div class='input-group' style='padding: 20px;'>
                      <input type='text' class='form-control' data-name='".$row['id']."' placeholder='имя' disabled value='".$row['href']."'>
                      <input type='hidden' data-oldname='".$row['id']."' value='".$row['href']."'>
                    </div>
                    <div class='form-group' style='padding-left: 20px; padding-right: 20px;'>
                      <label for='category'>Категория  &nbsp<button type='button' class='btn-primary' data-toggle='modal' data-target='#add_category' data-dismiss='modal'><i class='fa fa-plus'></i></button>
                      </label>
                      <select class='form-control' id='category' data-category='".$row['id']."'>
                        <option value=''>Выберите категорию</option>";
                        if ($result4 = $con->dbcon->query('select * from `category` WHERE tagid=0 or tagid=-1;')) {
                          /* извлечение ассоциативного массива */
                          while ($row4 = $result4->fetch_assoc()) {
                            if ($row4['tagid']==-1){
                              if ($f == $row4['id']){
                                echo "<option value='".$row4['id']."' selected='selected'>".base64_decode($row4['catname'])."</option>";
                              }else{
                                echo "<option value='".$row4['id']."'>".base64_decode($row4['catname'])."</option>";
                              }
                              $str = "select * from `category` WHERE tagid=".$row4['id'].";";
                     					 if ($result5 = $con->dbcon->query($str)){
                     						 while ($row5 = $result5->fetch_assoc()) {
                                     if ($f == $row5['id']){
                                       echo "<option value='".$row5['id']."' selected='selected'>&nbsp&nbsp&nbsp".base64_decode($row5['catname'])."</option>";
                                     }else{
                                       echo "<option value='".$row5['id']."'>&nbsp&nbsp&nbsp".base64_decode($row5['catname'])."</option>";
                                     }
                     							 }
                     					 }
                            }else{
                              if ($f == $row4['id']){
                                echo "<option value='".$row4['id']."' selected='selected'>".base64_decode($row4['catname'])."</option>";
                              }else{
                                echo "<option value='".$row4['id']."'>".base64_decode($row4['catname'])."</option>";
                              }
                            }

                          }
                          /* удаление выборки */
                          // $result4->free();
                          // return $new_result;
                        }
                echo "</select>

                    </div>
                    <div class='form-group' style='padding-left: 20px; padding-right: 20px;'>
                      <label for='tags'>Теги для поиска:&nbsp<button type='button' class='btn-danger' data-toggle='tooltip' title='Отчистить теги' id='tags_clear'><i class='fa fa-minus'></i></button></label>
                      <div class='tags_load'>";
                         if ($result5 = $con->dbcon->query('select * from `tags`;')) {
                           // print_r($result);
                           /* извлечение ассоциативного массива */
                           while ($row5 = $result5->fetch_assoc()) {
                             echo "#<tag class=tags data-tagsid='".$row['id']."'>".base64_decode($row5['tagname'])." </tag>";
                           }
                           /* удаление выборки */
                           $result5->free();
                           // return $new_result;
                          }
                  echo "</div>
                      <input type='text' class='form-control' data-tags='".$row['id']."' placeholder='Теги строго 'пробел , пробел' так' data-toggle='tooltip' title='Теги строго 'пробел , пробел' так' value='".$tags_str."'>
                    </div>
                    <div class='input-group' style='padding-left: 20px; padding-right: 20px;'>

                      <input type='text' class='form-control' data-comment='".$row['id']."' placeholder='Комментарий доп инфо' value='".$row['comment']."'>
                      <input type='text' class='form-control' data-price='".$row['id']."' placeholder='Цена' value='".$row['price']."'>
                      <span class=''>&nbsp&nbsp</span>
                      <input type='hidden' data-id='".base64_encode($row['href']).$row['id']."' value='".$row['id']."'>
                      <input type='text' class='form-control' data-width='".$row['id']."' id='width' placeholder='Ширина 0000' data-toggle='tooltip' title='Если отличны от закачиваемого файла' value='".$s[0]."'>
                      <span class='' style='margin-top: 4px'>&nbspX&nbsp</span>
                      <input type='text' class='form-control' data-height='".$row['id']."' id='height' placeholder='Высота 0000' data-toggle='tooltip' title='Если отличны от закачиваемого файла' value='".$s[1]."'>
                    </div>
                    <button type='submit' class='btn btn-success' style='margin: 20px;' data-hrefid='".$row['id']."'>Изменить</button><span data-error='".$row['id']."'></span>

                </div>

                  <!-- Modal footer -->
                  <div class='modal-footer'>
                    <a href='/admin/func_get.php?action=del&id=".$row['id']."&href=".base64_encode($row['href'])."' class='btn btn-danger'><i class='fa fa-trash'></i> Удалить</a>
                    <button type='button' class='btn btn-danger' data-dismiss='modal'><i class='fa fa-times'></i> Закрыть</button>
                  </div>

                </div>
              </div>
            </div>
            ";
    }
  }
  unset($row);
  unset($row2);
  unset($result);
  unset($result2);

echo '</div>';
echo '<div class="row">
  <ul class="pagination">';

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
      echo "<li class='page-item'><a class='page-link' href='?page=".$page."&limits=1&catname=".$catname."'>1</a></li><li class='page-item'><a class='page-link' style='border-top:none;border-bottom:none;'>…</a></li>";
    }
    for ($i=$ap; $i < $pag; $i++) {
      $p = $i+1;
      if ($l == $p){
        echo "<li class='page-item active'><a class='page-link' href='?page=".$page."&limits=".$p."&catname=".$catname."'>".$p."</a></li>";
      }else{
      echo "<li class='page-item'><a class='page-link' href='?page=".$page."&limits=".$p."&catname=".$catname."'>".$p."</a></li>";
      }
    }
    if ($l <=(ceil($pagination)-3) ){
      echo "<li class='page-item'><a class='page-link' style='border-top:none;border-bottom:none;'>…</a></li><li class='page-item'><a class='page-link' href='?page=".$page."&limits=".ceil($pagination)."&catname=".$catname."'>".ceil($pagination)."</a></li>";
    }

  }

echo   "</ul>";

}
?>
  </div>
</div>
