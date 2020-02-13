<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Название тега</th>
              <th>Удалить</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // define('ROOT', $_SERVER['DOCUMENT_ROOT']);
            require(ROOT.'/function/class.db.php');
            $con = new db();
            $sql = 'SELECT * FROM `tags`;';
            // echo $sql;
            if ($result = $con->dbcon->query($sql)){
              while ($row = $result->fetch_assoc()) {
                echo"<tr>
                      <td>".$row['id']."</td>
                      <td>".base64_decode($row['tagname'])."</td>
                      <td class='text-center'><a href='/admin/func_get.php?del=tag&tagid=".$row['id']."'><i class='fa fa-trash' data-target='tooltip' title='Удалить #ТЕГ'></i></a></td>
                    </tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
