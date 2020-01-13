<?php
session_start();
mysqli_close($conexion);
session_destroy();

header("location: login.php");

?>