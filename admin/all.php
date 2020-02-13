
<div class="container-fluid">
  <div class="flex-box">
<?php

  require(ROOT.'/function/class.db.php');
  $con = new db();

    $result = $con->dbcon->query("SELECT * FROM `image`;");
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

  unset($row);
  unset($row2);
  unset($result);
  unset($result2);

echo '</div>';

?>
  </div>
</div>
