<?php
session_start();

include 'validacion.php';

$usuario = $_SESSION['usuario'];

$id = $_GET['id'];

    $busqueda = "SELECT * FROM tareas WHERE id = '$id'";
    $respuesta = mysqli_query($conexion,$busqueda);

    if($registro = mysqli_fetch_array($respuesta)) {
         $id = $registro["id"];
         $tarea = $registro["tarea"];
         $realizada = $registro["realizada"];
         $fecha_realizada = $registro["fecha_realizada"];
         
    }

if (!empty($_POST)) {

   if(isset($_POST['tarea_mod']) && isset($_POST['estado_mod']) && isset($_POST['fecha_mod'])){
    
      $tarea_mod = $_POST['tarea_mod'];
      $estado_mod = $_POST['estado_mod'];
      $fecha_mod = $_POST['fecha_mod'];

      $busqueda = "UPDATE tareas SET tarea = '$tarea_mod',realizada = '$estado_mod',fecha_realizada = '$fecha_mod' 
                                 WHERE id = '$id'";
      $respuesta = mysqli_query($conexion,$busqueda);

      if($respuesta){

      header("Location: filtro.php");
    }

   }else
   die("error");
}

?>

<html>
 <head>
   <meta charset='utf-8'>
   <title>Editar</title>
   <link rel='stylesheet' href='Styles/Styles.css'>
   <link rel='stylesheet' href='Styles/fonts/style.css'>
 </head>
 <body bgcolor='#787475'>
   <header class='header'>
     <div class='usuario-nav-container'>
       <div class='user'>
         <p><span class='icon-user-circle-o'></span><?php echo $usuario ?>
            <a href='cambiar_contrasenia.php' title='Cambiar contrase&ntilde;a'><span class='icon-cog'></span></a></p>
       </div>
       <div class='links'>
         <nav class='navigation'>
           <ul>
             <li><a href='filtro.php' title='Filtrar Tareas'><span class='icon-filter'></span></a></li>
             <li><a href='ingresar_tarea.php' title='Agregar Tarea'><span class='icon-plus'></span></a></li>
             <li><a href='cerrar_sesion.php' title='Cerrar Sesi&oacute;n'><span class='icon-sign-out'></span></a></li>
           </ul>
         </nav>
       </div>
     </div>
   </header>
   <div class='contenedor-form-select'>
     <form method='post' class='form-edit'>
       <input class='formedit-input' type='text' name='tarea_mod' value='<?php echo $tarea ?>'>
       <select class='formedit-lista' name='estado_mod'>
         <option value='1' <?php if($realizada == "1") echo "selected" ?>>Realizada</option>
         <option value='0' <?php if($realizada == "0") echo "selected" ?>>Pendiente</option>
       </select>

       <?php
         if($realizada == "0"){
          echo "<input class='formedit-input' type='text' name='fecha_mod' placeholder='Fecha realizada (aaaa-mm-dd)'>";
        }
         if($realizada == "1"){
          echo "<input class='formedit-input' type='text' name='fecha_mod'  value=$fecha_realizada placeholder='Fecha realizada (aaaa-mm-dd)'>";
        }   
       ?>
      
       <input class='btn-edit' type='submit' value='Editar'>
     </form>
   </div>
 </body>
</html>