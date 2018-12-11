<!doctype html>
<?php require_once 'db.php';

$page = (isset($_GET['page']) ? $_GET['page'] : 1 );

$perPage = (isset($_GET['per-page']) && ($_GET['per-page']) <= 50 ? $_GET['per-page'] : 5 );

$start = ($page>1) ? ($page* $perPage) - $perPage : 0;
$sql = "select * from tasks limit  ".$start." , ".$perPage." ";
$total= $db->query("select * from tasks")->num_rows;
$pages = ceil($total/ $perPage);
$rows = $db->query($sql);
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

        <center><h1 class="center"> TODO list </h1></center>

        <div class="col-lg offset-md-1">
            <table class="table table-hover">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
                    создать
                </button>
                <button type="button" class="btn btn-default float-right" onclick="print()">Печатать</button>
                <hr>
                <br>
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Добавить лист</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="add.php" method="post">
                                    <div class="form-group">
                                        <label for="">Название листа</label>
                                        <input type="text" required name="task" class="form-control">
                                    </div>
                                    <input type="submit" name="send" value="Добавить лист" class="btn btn-success">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <thead>
                <tr>
                    <th scope="col">Номер</th>
                    <th scope="col">Вопрос</th>

                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php while ($row = $rows->fetch_assoc()):
                    //var_dump($row);
                    ?>
                    <th scope="row"><? echo $row['id'] ?></th>
                    <td class="col-lg"><? echo $row['name'] ?></td>
                    <td><a href="update.php?id=<? echo $row['id']; ?>" class="btn btn-success">Редактировать</a></td>
                    <td><a href="delete.php?id=<? echo $row['id']; ?>" class="btn btn-danger">Удалить</a></td>

                </tr>
                <? endwhile; ?>
                </tbody>
            </table>
            <nav aria-label="...">
            <ul class="pagination justify-content-center"><li class="page-item">
                    <? for($i = 1; $i <= $pages; $i++)  :            ?>
                    <a class="page-link"href="?page=<? echo $i; ?>&per-page=<? echo $perPage;?>"><? echo $i; ?></a>
                </li>
                <?      endfor;                         ?>
            </ul>
            </nav>
        </div>


    </div>

</div>

</body>
</html>