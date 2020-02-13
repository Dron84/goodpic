<div class="container">
  <div class="row">
    <form action="/admin/save_img.php" enctype="multipart/form-data" method="POST" id='file-save' name='r'>
      <!-- <div class="form-check">
        <div class="clear-40"></div>
        <label class="form-check-label">
          <input class="form-cheke-input" type="checkbox" name='zip' id='zip'> Сжать в ZIP
        </label>
        <label class="form-check-label">
          <input class="form-cheke-input" type="checkbox" name='ssh' id='ssh'> Передать на сервер оригинал
        </label>
      </div> -->
      <div class="form-group" style="padding-left: 20px; padding-right: 20px;">
        <label for="newname">Новое имя на сервере: <i id="newname_error"></i></label>
        <input type="text" class="form-control" id="newname" name="newname" placeholder="новое имя" data-toggle="tooltip" title="Новое имя на сервере на английском!">
      </div>
      <div class="form-group" style="padding-left: 20px; padding-right: 20px;">
        <label for="category">Категория  &nbsp
          <button type="button" class="btn-primary" data-toggle="modal" data-target="#add_category">
            <i class="fa fa-plus"></i>
          </button>
        </label>
        <select class="form-control impotants" id="category" name='category'>
          <option value="">Выберите категорию</option>
          <?php
            require(ROOT."/admin/func.php");
            categoryLoadFromDB('option','value');
          ?>
        </select>

        <div class="modal fade" id="add_category">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Добавить категорию</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <input type="text" id='add_category_text' class='form-cheke-input' placeholder="Название категории" data-toggle="tooltip" title='мин 3 буквы'>
                <button type="button" class="btn-success" id='add_catname' disabled="true"><i class="fa fa-plus"></i></button> <i class="fa fa-check check"></i>

              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="form-group" style="padding-left: 20px; padding-right: 20px;">
        <label for="tags">Теги для поиска:&nbsp<button type="button" class="btn-danger" data-toggle="tooltip" title="Отчистить теги" id='tags_clear'><i class="fa fa-minus"></i></button></label>
        <div class="tags_load">
          <?php
          cloudOfTags();
          ?>
        </div>
        <input type="text" class="form-control" id="tags" name="tags" placeholder="Теги строго 'пробел , пробел' так" data-toggle="tooltip" title="Теги строго 'пробел , пробел' так">
      </div>
      <div class="input-group" style="padding-left: 20px; padding-right: 20px;">
        <input type="text" class="form-control" name="comment" id='comment' placeholder="Комментарий доп инфо" >
        <input type="text" class="form-control" name="price" id='price' placeholder="Цена" style="margin-left: 20px; margin-right: 10px;">
        <span class="">&nbsp&nbsp</span>
        <input type="text" class="form-control" name="width" id='width' placeholder="Ширина 0000" data-toggle='tooltip' title='Если отличны от закачиваемого файла' >
        <span class="" style="margin-top: 4px">&nbspX&nbsp</span>
        <input type="text" class="form-control" name="height" id='height' placeholder="Высота 0000" data-toggle='tooltip' title='Если отличны от закачиваемого файла' >
      </div>
      <input id="image" name="image" type="file" style="padding-left: 20px; padding-right: 20px;"/>
      <button type='submit' class="btn btn-primary" style="margin: 20px;" id='img-submit' disabled='true' name="submit">Загрузить</button>
      <i id='img-result'></i>
    </form>
  </div>
</div>
