<?php
session_start();
function validarRegistro($datos){
    $errores=[];
    $datosFinales = [];

    foreach ($datos as $posicion => $valores) {//todo el foreach es para trimiar los datos (osea que no queden espacios a los costados)
    if(!is_array($datos[$posicion])){
        $datosFinales[$posicion] = trim($valores);
    }
      // if($posicion !== "hobbies"){
      //   $datosFinales[$posicion] = trim($valores);
      // }
    } // ver en que caso rompe.... Rta: cuando el dato es un array.

    //var_dump($errores, $datosFinales);

    if(strlen($datosFinales["nombre"]) == 0){
      $errores["nombre"] = "Por favor complete el campo nombre.";
    } else if(ctype_alpha($datosFinales["nombre"]) == false){
      $errores["nombre"] = "El nombre debe contener solo letras";
    }

    if(strlen($datosFinales["email"]) == 0){
      $errores["email"] = "Por favor complete el campo email.";
    } elseif (!filter_var($datosFinales["email"], FILTER_VALIDATE_EMAIL)) {
      $errores["email"] = "Por favor ingrese un email con formato válido.";
    }
    /*PENDIENTEEEEEEEEEEEEEE
    if ( validar si no hay otro usuario con el mismo name ) {
      $errores["username"]="Este nombre de Usuario ya esta siendo usado "
    }*/

    if(strlen($datosFinales["password"]) == 0){
      $errores["password"] = "El campo contraseña no puede estar vacío.";
    }
    /*EN CASO QUIERAS QUE REPITA SU CONTRASEÑA 2 VECES (SERA PARA MAYOR SEGURIDAD)
    if(strlen($datosFinales["pass2"]) == 0){
      $errores["pass"] = "Por favor repita su contraseña.";
    } elseif($datosFinales["pass"] !== $datosFinales["pass2"]){
      $errores["pass"] = "Las contraseñas no coinciden.";
    }*/
//VALIDACION DE LA IMAGEN
    //NO QUIERO QUE SEA UN NECESARIO CARGAR LA IMAGEN
    /*
    if ($_FILES["foto"]["error"]!= 0) {
      $errores["foto"] = "Hubo un error al acargar la imagen <br>";
    }  else {
        $ext = pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);
        if ($ext!= "jpg" && $ext!= "jpeg" && $ext!= "png") {
            $errores["foto"] = "el cv debe ser jpg ,jpeg o png <br>";
        }
    }
    */
    if (buscarClientePorUsuario($_POST["username"]) != NULL) {
      $errores["username"] = "Nombre de Usuario usado";
    }


    return $errores;
}

function nextId(){
  // TODO: que pasa si no hay usuario anterior.
  if (!file_exists("usuarios.json")) {
    $json = '';
  }else {
    $json = file_get_contents("usuarios.json");
  }
  if ($json == '') {
    return 1;
  }

  $array = json_decode($json, true);
  $ultimoUsuario = array_pop($array["usuarios"]);
  $lastId = $ultimoUsuario["id"];

  return $lastId + 1;

}

function armarUsuario(){//Se pasa por $_POST
  return  [
    "id" => nextId(),
    "nombre" => trim($_POST["nombre"]),
    "email" =>  trim($_POST["email"]),
    "username" => trim($_POST["username"]),
    "password" => password_hash($_POST["password"],PASSWORD_DEFAULT),
    "foto" => "img/".$_POST["username"]
  ];
}

function guardarUsuario($usuario){
  // TODO: que pasa si no hay archivo.
  if (!file_exists("usuarios.json")) {
    $json = '';
  }else {
    $json = file_get_contents("usuarios.json");
  }
//  $json = file_get_contents("usuarios.json");
  $array = json_decode($json, true);

  $array["usuarios"][] = $usuario;
  $array = json_encode($array, JSON_PRETTY_PRINT);

  file_put_contents("usuarios.json", $array);
}

//Falta validar que no haya usuarios repetidos ese es nuestro criterio
function buscarClientePorUsuario($username){
  $json = file_get_contents("usuarios.json");
  $array = json_decode($json, true);
  foreach ($array["usuarios"] as $value) {
    if ($value["username"]==$username) {
      return $value;
    }
  }
  return null;
}

function existeUsuario($username){
  return buscarClientePorUsuario($username) !== null;
}

function validarLogin($datos){
  $errores = [];
  if(strlen($datos["username"]) == 0){
    $errores["username"] = "Por favor complete el campo email.";
  } elseif(!existeUsuario($datos["username"])){
    $errores["username"] = "Este Username no se encuentra registrado.";
  }

  if(strlen($datos["password"]) == 0){
    $errores["password"] = "El campo contraseña no puede estar vacío.";
  } else {
    $usuario = buscarClientePorUsuario($datos["username"]);
    if(!password_verify($datos["password"], $usuario["password"])){
      $errores["password"] = "La contraseña es incorrecta.";
    }
  }

  return $errores;
}

function loguearUsuario($username){
  $_SESSION["username"] = $username;
}

function usuarioLogueado(){
  return isset($_SESSION["username"]);
}

function traerUsuarioLogueado(){
  // Si está logueado trae los datos del usuario
  if(isset($_SESSION["username"])) {
    $usuario = buscarClientePorUsuario($_SESSION["username"]);
    return $usuario;
  } else {
    // Sino: FALSE
    return false;
  }
}

function listaUsuarios(){
  $json = file_get_contents("db.json");
  $array = json_decode($json, true);

  return $array["usuarios"];
}

 ?>
