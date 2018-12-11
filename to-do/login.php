<?php 
	//require 'dbUsers.php';

	$data = $_POST;
	if ( isset($data['do_login']) )
	{
		$user = R::findOne('users', 'login = ?', array($data['login']));
		if ( $user )
		{
			//логин существует
			if ( password_verify($data['password'], $user->password) )
			{
				//если пароль совпадает, то нужно авторизовать пользователя
				$_SESSION['logged_user'] = $user;
				echo '<div style="color:dreen;">Вы авторизованы!<br/> Можете перейти на <a href="index.php">главную</a> страницу.</div><hr>';
			}else
			{
				$errors[] = 'Неверно введен пароль!';
			}

		}else
		{
			$errors[] = 'Пользователь с таким логином не найден!';
		}
		
		if ( ! empty($errors) )
		{
			//выводим ошибки авторизации
			echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
		}

	}

?>


<!-- Tab panes
<div class="tab-content tabs">-->
    <div role="tabpanel" class="tab-pane fade in active" id="Section1">
        <form action="login.php" method="POST" class="form-horizontal">
            <div class="form-group">
                <label for="validationCustom01">Логин</label>
                <input type="text"  name="login" value="<?php echo @$data['login']; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input type="password" class="form-control" id="exampleInputPassword1"  name="password" value="<?php echo @$data['password']; ?>">
            </div>

            <div class="form-group">
                <button type="submit" name="do_login" class="btn btn-default">Войти</button>
            </div>

        </form>
    </div>