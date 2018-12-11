<?php require_once 'db.php';
$id = $_GET['id'];
$sql = "select * from tasks where id ='$id'";
$rows = $db->query($sql);
$row = $rows->fetch_assoc();
if(isset($_POST['send'])){
    $task = $_POST['task'];
    $sql2="update  tasks set name='$task' where id= '$id'";
    $db->query($sql2);
    header('location: index.php');}
?>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/main.css" type="text/css" media="all"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div id="AlertDiv" class="row">

        <center><h1 class="center">Обновление TODO листа </h1></center>

        <div class="col-lg offset-md-1">

                <hr>
                <br>

                <form  method="post">
                    <div class="form-group">
                        <label for="validationCustom02">Название листа</label>
                        <input type="text" required name="task" class="form-control" value="<? echo $row['name']?>">
                    </div>
                    <input type="submit" name="send" value="Обновить лист" class="btn btn-success">&nbsp;
                    <a href="index.php" class="btn btn-warning">Назад</a>
                </form>

    </div>


</div>

</div>

</body>
</html>