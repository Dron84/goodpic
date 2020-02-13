<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Имя</th>
              <th>Фамилия</th>
              <th>Ник</th>
              <th>e-mail</th>
              <th>Пос. изм</th>
              <th>HEX Пароля</th>
              <th>Admin?</th>
            </tr>
          </thead>
          <tbody>
              <?php
              // define('ROOT', $_SERVER['DOCUMENT_ROOT']);
              require ROOT .'/function/class.db.php';
              $con= new db();

              $sql = 'SELECT * FROM `user`;';
              if ($result = $con->dbcon->query($sql)){
                while ($row = $result->fetch_assoc()) {
                  echo"<tr>
                        <td>".$row['id']."</td>
                        <td>".$row['firstname']."</td>
                        <td>".$row['lastname']."</td>
                        <td>".$row['nickname']."</td>
                        <td>".$row['email']."</td>
                        <td>".$row['reg_date']."</td>
                        <td>".$row['pass']."</td>";
                        if ($row['admin']!=1){
                          echo "<td>НЕТ</td>";
                        }else{
                          echo "<td>ДА</td>";
                        }
                  echo "<td class='text-center'><a href='/admin/func_get.php?del=user&userid=".$row['id']."'><i class='fa fa-trash' data-target='tooltip' title='Удалить пользователя'></i></a></td>
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
