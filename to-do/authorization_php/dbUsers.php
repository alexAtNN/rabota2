<?php require 'libs/rb.php';
//echo "<meta charset=\"UTF-8\">";
//header("Content-Type: text/html; charset=utf-8");
R::setup( 'mysql:host=localhost;dbname=lol','lol', '' );
if ( !R::testconnection() )
{
		exit ('Нет соединения с базой данных');
}
session_start();
?>