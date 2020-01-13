<?php
session_start();

include 'validacion.php';

$id = $_GET['id'];

  $conexion = mysqli_connect("localhost","root","","todo");
  $busqueda = "DELETE FROM tareas WHERE id = '$id'";
  $respuesta = mysqli_query($conexion,$busqueda);

  if($respuesta) {

       header("Location: filtro.php");
  }

?>