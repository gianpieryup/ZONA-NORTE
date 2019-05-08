<?php
require_once "funciones.php";

if(usuarioLogueado()){
  header("Location:home.php");
  exit;
}
  $errores = [];
  //Si viene por POST
if($_POST){
    //Validar Login
    $errores = validarLogin($_POST);
     //exit;

    //Si no hay errores
    if(empty($errores)){
      //logueamos al user => necesitamos session_start al incio de todos nuestros archivos. Ojo con los include/ require.
      loguearUsuario($_POST["username"]);
      //var_dump($_SESSION);NO SE PORQUE SI DEJO ESTO SALE UN WARNIGN??
      header("Location:home.php");//redirigimos a home
      exit;
    }else {
      var_dump($errores);
    }

}

?>



<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/styleLogin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php include("partes/header.php"); ?>
    <div class="login-page">
      <div class="form">
        <form class="login-form" action="login.php" method="post" enctype="multipart/form-data">
             <label for="Usuario"></label>
             <input class="campo-login" id="usuario" name="username" type="text" placeholder="Usuario"/>
             <label for="pass"></label>
             <input class="campo-login" id="pass" type="password" name="password" placeholder="Contraseña"/>
              <div class="recordar">
                <input class="checkbox-login" type="checkbox" name="" value="">
                <label class="texto-recordar" for="">Recordarme</label>
              </div>
             <button>ingresar</button>
          <p class="message">Aun no estas registrado?<a class="reg-button" href="registro.php"> Registrarse</a></p>
        </form>
      </div>
    </div>
    <?php include("partes/footer.php"); ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
