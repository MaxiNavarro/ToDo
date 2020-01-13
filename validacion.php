<?php

if(!isset($_SESSION['id'])){
  
  header("location:login.php");
}

$conexion = mysqli_connect("localhost","root","","todo");

?>