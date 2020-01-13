<?php
session_start();

include 'validacion.php';

$id_user = $_SESSION['id'];
$usuario = $_SESSION['usuario'];
$estado = $_SESSION['estado'];
$nombre = $_SESSION['nombre'];

if(isset($_GET['nombre'])) {
  $nombre = $_GET['nombre'];
  $_SESSION['nombre'] = $nombre;

  if(isset($_GET['estado'])) {
    $estado = $_GET['estado'];
    $_SESSION['estado'] = $estado;

    $busqueda = "SELECT * FROM tareas WHERE tarea like '%$nombre%' 
                                                  AND realizada = '$estado'
                                                  AND id_usuario = '$id_user'";
    $respuesta = mysqli_query($conexion,$busqueda);
  }
} else {
    $busqueda = "SELECT * FROM tareas WHERE tarea like '%$nombre%' 
                                                  AND realizada = '$estado'
                                                  AND id_usuario = '$id_user'";
    $respuesta = mysqli_query($conexion,$busqueda);
  } 

?>

<html>
 <head>
   <meta charset='utf-8'>
   <title>Filtro</title>
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
             <li><a href='ingresar_tarea.php' title='Agregar Tarea'><span class='icon-plus'></span></a></li>
             <li><a href='cerrar_sesion.php' title='Cerrar Sesi&oacute;n'><span class='icon-sign-out'></span></a></li>
           </ul>
         </nav>
       </div>
     </div>
   </header>
   <div class='contenedor-form-select'>
     <form method='get' class='form-select'>
       <input class='form-select-input' type='text' name='nombre' value='<?php echo $nombre ?>' placeholder='Nombre de la tarea a buscar'>
       <select class='form-select-lista' name='estado'>
         <option value='0' <?php if($estado == '0') echo 'selected' ?>>Pendientes</option>
         <option value='1' <?php if($estado == '1') echo 'selected' ?>>Realizadas</option>
       </select>
       <input class='btn-select' type='submit' value='Filtrar'>
     </form>
   </div>
   <br><br><br>
   <div class='contenedor-titulos-tabla'>
     <table class='cabecera-tabla'>
       <tr>
         <th class='col-titulo-tarea'>Tarea</th>
         <th class='col-titulo-realizada'>Realizada</th>
         <th class='col-titulo-fecha'>Fecha realizada</th>
         <th class='col-titulo-editar'></th>
         <th class='col-titulo-borrar'></th>
       </tr>
     </table>
   </div>

<?php   

while($registro = mysqli_fetch_array($respuesta)) {
    $id = $registro["id"];
    $tarea = $registro["tarea"];
    $realizada = $registro["realizada"];
    $fecha_realizada = $registro["fecha_realizada"];
         
    if($realizada){
      $realizada_txt = "<span class='icon-check'>";
      $fecha_realizada_txt = $fecha_realizada;
    }

    if(!$realizada){
      $realizada_txt = "<span class='icon-circle'>";
      $fecha_realizada_txt = '-';
    }

    echo "
     <div class='contenedor-tareas-tabla'>
        <table class='tarea-tabla'>
          <tr>
            <td class='col-tarea'>$tarea</td>
            <td class='col-realizada'>$realizada_txt</td>
            <td class='col-fecha'>$fecha_realizada_txt</td>
            <td class='col-editar'><a href='editar.php?id=$registro[id]'><span class='icon-pencil'></span></a></td>
            <td class='col-borrar'><a href='borrar.php?id=$registro[id]'><span class='icon-trash-o'></span></a></td>
          </tr>
        </table>
     </div>";       
}
    
?>

  <div class='margen-inf'>
  </div>
 </body>
</html>