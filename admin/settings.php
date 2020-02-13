<div class="container">
  <div class="row">
    <div class="col-12">
      <?php
      if (file_exists(ROOT."/admin/config.json")){
        $file = file_get_contents(ROOT."/admin/config.json");
    		$json_config = json_decode($file, true);
      }
      ?>
      <div class="form-group">
        <legend>База Данных</legend>
        <input type="text" style="margin-top: 10px" class="form-control" id='db_server' placeholder="Имя сервера" value="<?php if (isset($json_config['db_server'])){echo $json_config['db_server'];}?>">
        <input type="text" style="margin-top: 10px" class="form-control" id='db_user' placeholder="Имя пользователя" value="<?php if(isset($json_config['db_user'])){echo $json_config['db_user'];}?>">
        <input type="text" style="margin-top: 10px" class="form-control" id='db_password' placeholder="Пароль" value="<?php if(isset($json_config['db_password'])){echo $json_config['db_password'];}?>">
        <input type="text" style="margin-top: 10px" class="form-control" id='db_base_name' placeholder="Имя БД" value="<?php if(isset($json_config['db_base_name'])){echo $json_config['db_base_name'];}?>">
      </div>
      <div class="form-group">
        <legend>Отправка почты</legend>
        <span>На </span><input type="text" style="margin-top: 10px" class="form-control" id='sendmail_to' placeholder="Почта сюда" value="<?php if (isset($json_config['sendmail_to'])){echo $json_config['sendmail_to'];}?>">
        <span>От имени </span><input type="text" style="margin-top: 10px" class="form-control" id='sendmail_from' placeholder="Почта от 'Имени <mail@mail.ru>'" value="<?php if (isset($json_config['sendmail_from'])){echo $json_config['sendmail_from'];}?>">

      </div>
      <div class="form-group">
        <legend>SSH Server</legend>
        <input type="text" id="ssh_server" style="margin-top: 10px" class="form-control" placeholder="Адрес Сервера" value="<?php if (isset($json_config['ssh_server'])){echo $json_config['ssh_server'];}?>">
        <input type="text" id="ssh_server_port" style="margin-top: 10px" class="form-control" placeholder="Порт Сервера" value="<?php if (isset($json_config['ssh_server_port'])){echo $json_config['ssh_server_port'];}?>">
        <input type="text" id="ssh_user" style="margin-top: 10px" class="form-control" placeholder="Пользователь Сервера" value="<?php if (isset($json_config['ssh_user'])){echo $json_config['ssh_user'];}?>">
        <input type="text" id="ssh_pass" style="margin-top: 10px" class="form-control" placeholder="Пароль Сервера" value="<?php if (isset($json_config['ssh_pass'])){echo $json_config['ssh_pass'];}?>">
      </div>

      <botton style="margin-top: 10px" class="btn btn-success" id='config_save'>Сохранить</botton> <span id='sql_config_msg'></span> <span id='config_msg'></span>
    </div>
  </div>
</div>
