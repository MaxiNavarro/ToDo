<?php

$mensaje='';

if(!empty($_POST)){

if(isset($_POST['nombreDeUsuario']) && isset($_POST['contrasenia']) && isset($_POST['mail']) && isset($_POST['nombreCompleto'])){
  if(!empty($_POST['nombreDeUsuario']) && !empty($_POST['contrasenia']) && !empty($_POST['mail']) && !empty($_POST['nombreCompleto'])){
     
      $mail = $_POST['mail'];
      $contrasenia = $_POST['contrasenia'];
      $nombreCompleto = $_POST['nombreCompleto'];
      $nombreDeUsuario = $_POST['nombreDeUsuario'];
      $fecha = date("Y-m-d");
      $password_encriptado = password_hash("$contrasenia", PASSWORD_BCRYPT);
      
      $conexion = mysqli_connect("localhost","root","","todo");
      $busqueda = "SELECT * FROM usuarios WHERE usuario='$nombreDeUsuario'";
      $respuesta = mysqli_query($conexion,$busqueda);

      if(!($registro = mysqli_fetch_array($respuesta))){

        $consulta = "INSERT INTO usuarios(usuario,contrasenia,mail,nombre_completo,fecha) 
                            VALUES ('$nombreDeUsuario','$password_encriptado','$mail','$nombreCompleto','$fecha')";

        $respuesta = mysqli_query($conexion,$consulta);
        
        $mensaje="<p class='form-messageOk'>Registro exitoso!</p>";

      }else{
          $mensaje="<p class='form-message'>El usuario ya existe</p>";
      }

  }else{
     if(empty($_POST['nombreDeUsuario']) || empty($_POST['contrasenia']) || empty($_POST['mail']) || empty($_POST['nombreCompleto'])){
         
         $mensaje="<p class='form-message'>Debe completar todos los campos</p>";
         }
      }  
}else
  die("error");
}
?>

 <html>
 <head>
   <meta charset='utf-8'>
   <title>Registro</title>
   <link rel='stylesheet' href='Styles/Styles.css'>
   <link rel='stylesheet' href='Styles/fonts/style.css'>
 </head>
 <body background='Imagenes/Fondo.jpg'>
  <br><br><br><br><br><br><br>
   <div class='contenedorreg'>
      <form class='formreg' method='post'>
         <div class='formreg-header'>
            <h1 class='formreg-title'>Crear Usuario</h1>
         </div>
         <input type='text' class='formreg-input' name='nombreDeUsuario' placeholder='Usuario'>
         <input type='password' class='formreg-input' name='contrasenia' placeholder='Contrase&ntilde;a'>
         <input type='text' class='formreg-input' name='mail' placeholder='E-mail'>
         <input type='text' class='formreg-input' name='nombreCompleto' placeholder='Nombre completo'>
         <input type='submit' class='btnreg-submit' value='Registrarme'>
         <div class='formreg-loguear'>
            <a href='login.php'>Iniciar Sesi&oacute;n</a>
         </div>
         <div class='formreg-down'>
            <?php echo $mensaje ?>
         </div>
      </form>
   </div>
</body>
</html>