<?php
session_start();

$message='';

if(!empty($_POST)){

  if(isset($_POST['nombreDeUsuario']) && isset($_POST['contrasenia'])){
     if(!empty($_POST['nombreDeUsuario']) && !empty($_POST['contrasenia'])){

        $nombreDeUsuario = $_POST['nombreDeUsuario'];
        $contrasenia = $_POST['contrasenia'];
      
        $conexion = mysqli_connect("localhost","root","","todo");
        $busqueda = "SELECT * FROM usuarios WHERE usuario='$nombreDeUsuario'";
        $respuesta = mysqli_query($conexion,$busqueda);

        if($registro = mysqli_fetch_array($respuesta)){
        
          $pass = $registro['contrasenia'];
          $coinciden = password_verify ("$contrasenia", "$pass");

          if($coinciden){
             
             $_SESSION['id'] = $registro['id'];
             $_SESSION['usuario'] = $registro['usuario'];
             $_SESSION['estado'] = '';
             $_SESSION['nombre'] = '';
           
             header("location: filtro.php");

          }else{
             $message = "<p class='form-message'>Error al iniciar sesi&oacute;n</p>";         
          }

        }else{
           $message = "<p class='form-message'>Usuario o Contrase&ntilde;a incorrectos</p>"; 
        }
     }
  }else
     die("error");
}

?>

 <html>
 <head>
   <meta charset='utf-8'>
   <title>Iniciar Sesi&oacute;n</title>
   <link rel='stylesheet' href='Styles/Styles.css'>
   <link rel='stylesheet' href='Styles/fonts/style.css'>
 </head>
 <body background='Imagenes/Fondo.jpg'>
  <br><br><br><br><br><br><br>
   <div class='contenedorlog'>
      <form class='formlog' method='post'>
         <div class='formlog-header'>
            <h1 class='formlog-title'>Iniciar Sesi&oacute;n</h1>
         </div>
         <input type='text' class='formlog-input' name='nombreDeUsuario' placeholder='Usuario'>
         <input type='password' class='formlog-input' name='contrasenia' placeholder='Contrase&ntilde;a'>
         <input type='submit' class='btnlog-submit' value='Iniciar Sesi&oacute;n'>
         <div class='formlog-reg'>
            <a href='registro.php'>Registrarme</a>
         </div>
         <div class='formlog-down'>
            <?php echo $message ?>
         </div>
      </form>
   </div>
</body>
</html>