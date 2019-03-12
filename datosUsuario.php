<?php
include('menuNavegacionHTML.php');
include("BBDD.php");

if(!isset($_POST["modificarCuenta"])){
	imprimirMenu("Mis datos");
	echo '<div class="container">
        <div class="row">
            <div class="col-12 col-md-6 m-auto p-2">';
	//controlar errores
	if(isset($_GET["error"])){
		switch($_GET["error"]){
			case 0:
				echo '<p style="color: #ff8001;">Error al modificar cuenta. Debe rellenar todos los campos</p>';
			break;
			case 1:
				echo '<p style="color: #ff8001;">Error al modificar cuenta. Ya existe un usuario con ese DNI.</p>';
			break;
			case 2:
			echo '<p style="color: #ff8001;">Error al modificar cuenta. El nombre de usuario ya existe.</p>';
			break;
			case 3:
			echo '<p style="color: #ff8001;">Error al modificar cuenta. Contraseña incorrecta.</p>';
			break;
			case 4:
			echo '<p style="color: #ff8001;">Datos modificados.</p>';
			break;
		}
	}
	//controlar que hay usuario del que mostrar datos
	if(isset($_SESSION["usuario"])){
		//si hay usuario
		echo '<form  method="POST">
						<div class="form-group">
							<label for="DNI">
								DNI*:
							</label>
							<input class="form-control" id="DNI" name="DNI" type="text" value="'.$_SESSION["usuario"]["DNI"].'">
							</input>
						</div>
						<div class="form-group">
							<label for="nombre">
								Nombre:
							</label>
							<input class="form-control" id="nombre" name="nombre" type="text" value="'.$_SESSION["usuario"]["nombre"].'">
							</input>
						</div>
						<div class="form-group">
							<label for="direccion">
								Dirección:
							</label>
							<input class="form-control" id="direccion" name="direccion" type="text" value="'.$_SESSION["usuario"]["direccion"].'">
							</input>
						</div>
						<div class="form-group">
							<label for="user">
								Usuario*:
							</label>
							<input class="form-control" id="user" name="user" type="text" value="'.$_SESSION["usuario"]["usuario"].'">
							</input>
						</div>
						<div class="form-group">
							<label for="pwd">
								Contraseña*:
							</label>
							<input class="form-control" id="pwd" name="pswd" type="password">
							</input>
						</div>
						<div class="form-group">
							<label for="pwd">
								Nueva contraseña:
							</label>
							<input class="form-control" id="newpwd" name="newpswd" type="password">
							</input>
						</div>
						<button class="btn mr-3" type="submit" name="modificarCuenta" style="background-color: #ff8001;">
							Modificar Datos
						</button>
					</form>
				</div>
			</div>
		</div>';
	}else{
		//si no hay usuario
		echo '<p style="color: #ff8001;">Debe <a href="index.php" style="color: #ff8001; text-decoration:underline;">iniciar sesión.</a></p>';
	}
	imprimirFin();

}else{
	extract($_POST);
	if($DNI=="" || $user=="" || $pswd=="")
		//comprobar campos
		header("Location: datosUsuario.php?error=0");
	
	//comprobar contraseña
	if($_SESSION["usuario"]["password"]!=md5($pswd)){
		header("Location: datosUsuario.php?error=3");
	}else{
		if($_SESSION["usuario"]["DNI"]!=$DNI){
			$resultado=BBDD::getUsuarioDNI($DNI);
			if($fila=$resultado->fetch_assoc())
				//error si existe usuario con el mismo dni
				header("Location: datosUsuario.php?error=1");
		}
		if($_SESSION["usuario"]["usuario"]!=$user){
			$resultado=BBDD::getUsuarioUser($user);
			if($fila=$resultado->fetch_assoc())
				//error si existe usuario con el mismo nombre de usuario
				header("Location: datosUsuario.php?error=2");
		}
		//modificar datos
		if($newpswd=="")
			$update="UPDATE clientes SET DNI='".$DNI."',nombre='".$nombre."',direccion='".$direccion."',usuario='".$user."'";
		else	
			$update="UPDATE clientes SET DNI='".$DNI."',nombre='".$nombre."',direccion='".$direccion."',usuario='".$user."', password='".md5($newpswd)."'";
		$update.=" WHERE DNI='".$_SESSION["usuario"]["DNI"]."'";
		$conexion=BBDD::conexion("localhost","root","","tienda");
		mysqli_query($conexion,$update);
		
		$resultado=BBDD::getUsuarioDNI($DNI);
		$fila=$resultado->fetch_assoc();
		$_SESSION["usuario"]=$fila;
		
		header("Location: datosUsuario.php?error=4");
	}

}
?>