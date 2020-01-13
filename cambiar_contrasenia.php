<?php
session_start();

include 'validacion.php';

$usuario = $_SESSION['usuario'];
$id = $_SESSION['id'];
$mje = '';

if(!empty($_POST)) {

  if(isset($_POST['pass']) && isset($_POST['new_pass']) && isset($_POST['rep_pass'])){    
    if(!empty($_POST['pass']) && !empty($_POST['new_pass']) && !empty($_POST['rep_pass'])){

      $pass = $_POST['pass'];
      $new_pass = $_POST['new_pass'];
      $rep_pass = $_POST['rep_pass'];

      $busqueda = "SELECT contrasenia FROM usuarios WHERE id = '$id'";
      $respuesta = mysqli_query($conexion,$busqueda);

      if($registro = mysqli_fetch_array($respuesta)){
        
        $password = $registro['contrasenia'];

        if($coinciden = password_verify ("$pass", "$password")){
          if($new_pass == $rep_pass){ 
          
            $password_encriptado = password_hash("$new_pass", PASSWORD_BCRYPT);

            $update = "UPDATE usuarios SET contrasenia = '$password_encriptado' 
                                       WHERE id = '$id'";
            $respuesta = mysqli_query($conexion,$update);

              if($respuesta){
                $mje = "<p class='form-messageOk'>Cambio exitoso!</p>";
              }
          }else
            $mje = "<p class='form-message'>Error en la nueva contrase&ntilde;a</p>";
        }else
          $mje = "<p class='form-message'>Contrase&ntilde;a incorrecta</p>";
      }
    }else
      $mje = "<p class='form-message'>Debe completar todos los campos</p>";
  }else
     die("error");
}

?>

<html>
 <head>
   <meta charset='utf-8'>
   <title>Cambiar contrase&ntilde;a</title>
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
       <input class='formedit-input' type='password' name='pass' placeholder='Contrase&ntilde;a actual'>
       <input class='formedit-input' type='password' name='new_pass' placeholder='Nueva contrase&ntilde;a'>
       <input class='formedit-input' type='password' name='rep_pass' placeholder='Repetir contrase&ntilde;a'>
       <input class='btn-edit' type='submit' value='Cambiar'>
       <div class='formlog-down'>
         <?php echo $mje ?>
       </div>
     </form>
   </div>
 </body>
</html>