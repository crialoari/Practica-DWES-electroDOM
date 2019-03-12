<?php
include('menuNavegacionHTML.php');
unset($_SESSION['usuario']);
unset($_SESSION["cesta"]);
imprimirMenu("Home");

echo '<div class="container">
        <div class="row">
            <div class="col-12 col-md-6 m-auto p-5">';
			
//imprimir errores
if(isset($_GET["error"])){
	switch($_GET["error"]){
		case 0:
			echo '<p style="color: #ff8001;">Error al iniciar sesión. Debe rellenar todos los campos.</p>';
		break;
		case 1:
			echo '<p style="color: #ff8001;">Error al iniciar sesión. El usuario no existe.</p>';
		break;
		case 2:
		echo '<p style="color: #ff8001;">Error al iniciar sesión. La contraseña no es correcta.</p>';
		break;
	}
}
//imprimir formulario de entrada
echo '<form action="iniciarSesion.php" method="POST">
                        <div class="form-group">
                            <label for="user">
                                Usuario:
                            </label>
                            <input class="form-control" id="user" name="user" type="text">
                            </input>
                        </div>
                        <div class="form-group">
                            <label for="pwd">
                                Contraseña:
                            </label>
                            <input class="form-control" id="pwd" name="pswd" type="password">
                            </input>
                        </div>
                        <button class="btn mr-3" type="submit" name="iniciarSesion" style="background-color: #ff8001;">
                            Iniciar Sesion
                        </button>
                        <a href="catalogo.php" style="color: #ff8001;">Ver catálogo</a>
                    </form>
                </div>
            </div>
            <div class="row">
            	<div class="col-12 col-md-6 m-auto text-center">
            		<a href="crearCuenta.php" style="color: #ff8001;"><small><em>Registrarse</em></small></a>
            	</div>
            </div>
        </div>';
imprimirFin();
?>