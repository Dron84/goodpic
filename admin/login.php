
<div class="container">
		<div class="col-md-12">
			<form class="" action="/admin/func.php" method="post">
				<div class="form-group">
				  <label for="usr">Имя:</label>
				  <input type="text" class="form-control" id="user" name='user'>
				</div>
				<div class="form-group">
				  <label for="pwd">Пароль:</label>
				  <input type="password" class="form-control" id="pass" name='pass'>
				</div>
				<div class="form-group">

				  <button type="submit" class="btn btn-success" name='submit'>Войти</button>
				</div>
				<?php
						if (isset($_GET['error'])){
							if ($_GET['error']=='baduser')
							echo "<i id='img-result'>Нет такого пользователя или пароль не корректный </i>";
						}
				?>
			</form>

		</div>
</div>
