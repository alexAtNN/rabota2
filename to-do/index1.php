<?php
require 'dbUsers.php';
require 'login.php';
require 'signup.php';
require 'logout.php';

?>
<?php if ( isset ($_SESSION['logged_user']) ) : ?>
Авторизован! <br/>
Привет, <?php echo $_SESSION['logged_user']->login; ?>!<br/>

<a href="logout.php">Выйти</a>
<?php else : ?>
    <a href="/login.php">Авторизация</a>
    <a href="/signup.php">Регистрация</a>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main1.css" type="text/css" media="all"/>
<?php endif; ?>
<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">

            <div class="tab" role="tabpanel">
                <!--  <!-- Nav tabs
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab">Авторизация</a></li>
                    <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab">Регистрация</a></li>
                </ul>
                -- Tab panes -->
                <div class="tab-content tabs">
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
                    <?php
                    //require 'dbUsers.php';

                    $data = $_POST;

                    function captcha_show(){
                        $questions = array(
                            1 => 'Столица России',
                            2 => 'Столица США',
                            3 => '2 + 3',
                            4 => '15 + 14',
                            5 => '45 - 10',
                            6 => '33 - 3'
                        );
                        $num = mt_rand( 1, count($questions) );
                        $_SESSION['captcha'] = $num;
                        echo $questions[$num];
                    }

                    //если кликнули на button
                    if ( isset($data['do_signup']) )
                    {
                        // проверка формы на пустоту полей
                        $errors = array();
                        if ( trim($data['login']) == '' )
                        {
                            $errors[] = 'Введите логин';
                        }

                        /*if ( trim($data['email']) == '' )
                        {
                            $errors[] = 'Введите Email';
                        }
                */
                        if ( $data['password'] == '' )
                        {
                            $errors[] = 'Введите пароль';
                        }

                        if ( $data['password_2'] != $data['password'] )
                        {
                            $errors[] = 'Повторный пароль введен не верно!';
                        }

                        //проверка на существование одинакового логина
                        if ( R::count('users', "login = ?", array($data['login'])) > 0)
                        {
                            $errors[] = 'Пользователь с таким логином уже существует!';
                        }

                        /*проверка на существование одинакового email
                            if ( R::count('users', "email = ?", array($data['email'])) > 0)
                            {
                                $errors[] = 'Пользователь с таким Email уже существует!';
                            }*/

                        //проверка капчи
                        $answers = array(
                            1 => 'москва',
                            2 => 'вашингтон',
                            3 => '5',
                            4 => '29',
                            5 => '35',
                            6 => '30'
                        );
                        if ( $_SESSION['captcha'] != array_search( mb_strtolower($_POST['captcha']), $answers ) )
                        {
                            $errors[] = 'Ответ на вопрос указан не верно!';

                        }


                        if ( empty($errors) )
                        {
                            //ошибок нет, теперь регистрируем
                            $user = R::dispense('users');
                            $user->login = $data['login'];
                            //$user->email = $data['email'];
                            $user->password = password_hash($data['password'], PASSWORD_DEFAULT); //пароль нельзя хранить в открытом виде, мы его шифруем при помощи функции password_hash для php > 5.6
                            R::store($user);
                            echo '<div style="color:dreen;">Вы успешно зарегистрированы!</div><hr>';
                        }else
                        {
                            echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
                        }

                    }

                    ?>

                    <div role="tabpanel" class="tab-pane fade" id="Section2">
                        <form action="signup.php" method="POST"class="form-horizontal">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Логин</label>
                                <input type="text" class="form-control" name="login"id="exampleInputEmail1" value="<?php echo @$data['login']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Пароль</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" name="password" value="<?php echo @$data['password']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Повторите пароль</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" name="password_2" value="<?php echo @$data['password_2']; ?>">
                            </div>
                            <div class="form-group">
                                <strong><?php captcha_show(); ?></strong>
                                <input type="text" name="captcha" ><br/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">Зарегестрироваться</button>
                            </div>
                        </form>
                    </div>
                    <!--      <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                        <form action="login.php" class="form-horizontal">
                            <div class="form-group">
                                <label for="validationCustom01">Логин</label>
                                <input type="text" class="form-control" id="validationCustom01" value="<?php echo @$data['login']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Пароль</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" value="<?php echo @$data['password']; ?>">
                            </div>

                            <div class="form-group">
                                <button type="submit" name="do_login" class="btn btn-default">Войти</button>
                            </div>

                        </form>
                    </div>--
                    <div role="tabpanel" class="tab-pane fade" id="Section2">
                        <form action="signup.php" method="POST"class="form-horizontal">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Логин</label>
                                <input type="text" class="form-control" name="login"id="exampleInputEmail1" value="<?php echo @$data['login']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Пароль</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" name="password" value="<?php echo @$data['password']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Повторите пароль</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" name="password_2" value="<?php echo @$data['password_2']; ?>">
                            </div>
                            <div class="form-group">

                            <input type="text" name="captcha" ><br/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">Зарегестрироваться</button>
                            </div>
                        </form>
                    </div>-->
                </div>
            </div>

        </div><!-- /.col-md-offset-3 col-md-6 -->
    </div><!-- /.row -->
</div><!-- /.container -->
<?//php endif; ?>