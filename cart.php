<div class="container">
  <div class="row" style="padding-top: 20px">
    <table class="table table-bordered" >
    <thead>
      <tr>
        <th>#</th>
        <th>Имя файла</th>
        <th>Размеры</th>
        <th>Цена</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // define('ROOT', $_SERVER['DOCUMENT_ROOT']);
      if (isset($_COOKIE['cart'])){
        require(ROOT.'/function/class.db.php');
        $con = new db();
        $str = $_COOKIE['cart'];
        $cart_exp = explode("::", $str);
        //print_r($cart_exp);
        $cou = count($cart_exp)-1;
        //echo $cou;
        $id ='';
        for ($i=0; $i < $cou; $i++) {
          if ($i == ($cou-1)){
            $id .='id='.$cart_exp[$i];
          }else{
            $id .='id='.$cart_exp[$i].' OR ';
          }
        }
        $sql = 'SELECT * FROM `image` WHERE '.$id;
        //echo $sql;
        if ($result = $con->dbcon->query($sql)){
          while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['href']."</td>
                    <td>".$row['size']."</td>
                    <td>".$row['price']."</td>
                  </tr>";
          }
        }
      }else{
        echo "<tr>
                <td name='empty' colspan='4'>У Вас в корзине ничего нет</td>
              </tr>";
      }

      ?>
    </tbody>
  </table>
<div id='sending_form'>
  <input type="email" name="email" value="" placeholder="Введите email">
  <input type="text" name="tel" value="" placeholder="Введите телефон">
  <button class="button" id='cart_send' disabled='disabled'>Отправить</button> <span id='sendemail_error'></span>
</div>
  </div>
</div>
