<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>email</th>
              <th>Телефон</th>
              <th>ID изображений</th>
              <th>Статус</th>
              <th>Удалить?</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // define('ROOT', $_SERVER['DOCUMENT_ROOT']);
            require(ROOT.'/function/class.db.php');
            $con = new db();
            $sql = 'SELECT * FROM `orders`;';
            // echo $sql;
            if ($result = $con->dbcon->query($sql)){
              while ($row = $result->fetch_assoc()) {
                echo"<tr>
                      <td>".$row['id']."</td>
                      <td>".base64_decode($row['email'])."</td>
                      <td>".base64_decode($row['tel'])."</td>
                      <td>".$row['order_str']."</td>
                      <td>".base64_decode($row['status_order'])."</td>
                      <td class='text-center'><a href='/admin/func_get.php?del=orders&order_id=".$row['id']."'><i class='fa fa-trash' data-target='tooltip' title='Удалить заявку'></i></a></td>
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
