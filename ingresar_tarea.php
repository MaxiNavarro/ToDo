<?php
session_start();

include 'validacion.php';

$id_user = $_SESSION['id'];
$usuario = $_SESSION['usuario'];
$fecha = date('Y-m-d');
$mge='';
$nombre='';

echo "
<html>
 <head>
   <meta charset='utf-8'>
   <title>Ingresar Tarea</title>
   <link rel='stylesheet' href='Styles/Styles.css'>
   <link rel='stylesheet' href='Styles/fonts/style.css'>
 </head>
 <body bgcolor='#787475'>
   <header class='header'>
     <div class='usuario-nav-container'>
       <div class='user'>
         <p><span class='icon-user-circle-o'></span>$usuario
            <a href='cambiar_contrasenia.php' title='Cambiar contrase&ntilde;a'><span class='icon-cog'></span></a></p>
       </div>
       <div class='links'>
         <nav class='navigation'>
           <ul>
             <li><a href='filtro.php' title='Filtrar Tareas'><span class='icon-filter'></span></a></li>
             <li><a href='cerrar_sesion.php' title='Cerrar Sesi&oacute;n'><span class='icon-sign-out'></span></a></li>
           </ul>
         </nav>
       </div>
     </div>
   </header>
   <div class='contenedor-form-select'>
     <form method='post' class='form-select'>
       <input class='form-select-input' type='text' name='nombreTarea' placeholder='Nombre de la tarea a ingresar'>
       <select class='form-select-lista' name='estadoTarea'>
         <option value='realizada'>Realizada</option>
         <option value='pendiente'>Pendiente</option>
       </select>
       <input class='btn-select' type='submit' value='Agregar'>
       <div class='formlog-down'>
         <p class='form-message'>$mge</p>
       </div>
     </form>
   </div>";

  if(isset($_POST['nombreTarea']) && isset($_POST['estadoTarea'])){

    if(!empty($_POST['nombreTarea'])){

      $nombreTarea = $_POST['nombreTarea'];
      $estadoTarea = $_POST['estadoTarea'];

      if($estadoTarea=='pendiente'){
        
        $busqueda = "INSERT INTO tareas(tarea,fecha_creada,realizada,id_usuario) 
                            VALUES ('$nombreTarea','$fecha','0','$id_user')";

        if($respuesta = mysqli_query($conexion,$busqueda)){
 
            $busqueda = "SELECT * FROM tareas WHERE tarea = '$nombreTarea'";
            $respuesta = mysqli_query($conexion,$busqueda);

            if($registro = mysqli_fetch_array($respuesta)){

            $id = $registro["id"];
            $tarea = $registro["tarea"];
            
            echo "
            <div class='contenedor-tareas-tabla'>
            <table class='tarea-tabla'>
              <tr>
                <td class='col-tarea'>$tarea</td>
                <td class='col-realizada'><span class='icon-circle'></span></td>
                <td class='col-fecha'>-</td>
                <td class='col-editar'><a href='editar.php?id=$registro[id]'><span class='icon-pencil'></span></a></td>
                <td class='col-borrar'><a href='borrar.php?id=$registro[id]'><span class='icon-trash-o'></span></a></td>
              </tr>
            </table>
            </div>";
          }else
             $mge ='No se pudo ingresar la tarea';
        }
      }

      if($estadoTarea=='realizada') {
         
         $busqueda = "INSERT INTO tareas(tarea,fecha_creada,realizada,fecha_realizada,id_usuario) 
                             VALUES ('$nombreTarea','$fecha','1','$fecha','$id_user')";

         if($respuesta = mysqli_query($conexion,$busqueda)){
 
            $busqueda = "SELECT * FROM tareas WHERE tarea = '$nombreTarea'";
            $respuesta = mysqli_query($conexion,$busqueda);

            if($registro = mysqli_fetch_array($respuesta)){

               $id = $registro["id"];
               $tarea = $registro["tarea"];
               $fecha_realizada = $registro["fecha_realizada"];
        
               echo "
               <div class='contenedor-tareas-tabla'>
               <table class='tarea-tabla'>
                 <tr>
                   <td class='col-tarea'>$tarea</td>
                   <td class='col-realizada'><span class='icon-check'></span></td>
                   <td class='col-fecha'>$fecha_realizada</td>
                   <td class='col-editar'><a href='editar.php?id=$registro[id]'><span class='icon-pencil'></span></a></td>
                   <td class='col-borrar'><a href='borrar.php?id=$registro[id]'><span class='icon-trash-o'></span></a></td>
                 </tr>
               </table>
               </div>";
               }
          }else
             $mge ='No se pudo ingresar la tarea';
      }
    }else
       $mge ='Debe escribir el nombre de la tarea';
  }

echo "
 </body>
</html>";
?>