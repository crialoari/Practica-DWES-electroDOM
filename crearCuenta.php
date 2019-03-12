<?php
include("BBDD.php");
include('menuNavegacionHTML.php');
unset($_SESSION['usuario']);
unset($_SESSION["cesta"]);
if(!isset($_POST["crearCuenta"])){
	imprimirMenu("Crear cuenta");
	echo '<div class="container">
        <div class="row">
            <div class="col-12 col-md-6 m-auto p-5">';
//imprimir errores
if(isset($_GET["error"])){
	switch($_GET["error"]){
		case 0:
			echo '<p style="color: #ff8001;">Error al crear cuenta. Debe rellenar todos los campos</p>';
		break;
		case 1:
			echo '<p style="color: #ff8001;">Error al crear cuenta. Ya existe un usuario con ese DNI.</p>';
		break;
		case 2:
		echo '<p style="color: #ff8001;">Error al crear cuenta. El nombre de usuario ya existe.</p>';
		break;
	}
}
//imprimir formulario de entrada
	echo '<form  method="POST">
						<div class="form-group">
							<label for="DNI">
								DNI*:
							</label>
							<input class="form-control" id="DNI" name="DNI" type="text">
							</input>
						</div>
						<div class="form-group">
							<label for="nombre">
								Nombre:
							</label>
							<input class="form-control" id="nombre" name="nombre" type="text">
							</input>
						</div>
						<div class="form-group">
							<label for="direccion">
								Dirección:
							</label>
							<input class="form-control" id="direccion" name="direccion" type="text">
							</input>
						</div>
						<div class="form-group">
							<label for="user">
								Usuario*:
							</label>
							<input class="form-control" id="user" name="user" type="text">
							</input>
						</div>
						<div class="form-group">
							<label for="pwd">
								Contraseña*:
							</label>
							<input class="form-control" id="pwd" name="pswd" type="password">
							</input>
						</div>
						<button class="btn mr-3" type="submit" name="crearCuenta" style="background-color: #ff8001;">
							Crear cuenta
						</button>
					</form>
			</div>
		</div>
	</div>';
	imprimirFin();
}else{
	//comprobar campos
	extract($_POST);
	if($DNI=="" || $user=="" || $pswd==""){
		header("Location: crearCuenta.php?error=0");
	}else{
		$resultado=BBDD::getUsuarioDNI($DNI);
		if($fila=$resultado->fetch_assoc())
			//error si existe usuario con el mismo dni
			header("Location: crearCuenta.php?error=1");
		else{
			$resultado=BBDD::getUsuarioUser($user);
			if($fila=$resultado->fetch_assoc())
				//error si existe usuario con el mismo nombre de usuario
				header("Location: crearCuenta.php?error=2");
			else{//insertar
				$encriptada=md5($pswd);
				BBDD::insertarUsuario($DNI,$nombre,$direccion,$user,$encriptada);
				//se inicia sesion con el usuario insertado
				header("Location: iniciarSesion.php?user=".$user."&pswd=".$pswd);
			}
		}
	}
}
?>