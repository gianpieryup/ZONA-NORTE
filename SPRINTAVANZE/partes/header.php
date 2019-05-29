<?php
if (isset($_COOKIE["username"])) {
//loguearUsuario($_COOKIE["username"]);
$usuario = buscarClientePorUsuario($_COOKIE["username"]);
loguearUsuario($usuario["username"]);
}

 ?>


  <header>
    <a href="home.php"><h2 class="logo">DarkCode</h2></a>
    <input type="checkbox" id="chk">
    <label for="chk" class="show-menu-btn">
      <i class="fas fa-ellipsis-h"></i>
    </label>

    <ul class="menu-header">
      <a href="home.php">Home</a>
      <a href="productos.php">Productos</a>
      <?php if (usuarioLogueado()): ?>
        <img class="avatar" src="<?= $usuario["foto"] ?>" alt="">
        <a href="editarPerfil.php?id=<?= $usuario['id'] ?>"><span class="nombre-header btn btn-color"><?= $usuario["username"] ?></span></a>
        <a class="btn btn-danger" href="logout.php">Logout</a>
        <a href="editarPerfil.php"><i class="fas fa-cog"></i></a>
      <?php else: ?>
        <a href="contacto.php">Contacto</a>
        <a href="registro.php">Registro</a>
        <a class="btn btn-success" href="login.php">Login</a>
      <?php endif; ?>
      <a href="carrito.php"><i class="fas fa-shopping-cart"></i></a>
      <label for="chk" class="hide-menu-btn">
        <i class="fas fa-times"></i>
      </label>
    </ul>
  </header>
