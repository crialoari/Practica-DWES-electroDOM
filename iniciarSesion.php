<?php
include("BBDD.php");
session_start();
$usuario=$_REQUEST["user"];
$pass=$_REQUEST["pswd"];
if($usuario=="" || $pass==""){
	//campos vacios: error 0
	header("Location: index.php?error=0");
}else{
	//el usuario no existe: error 1
	$resultado=BBDD::getUsuarioUser($usuario);
	if(!$fila=$resultado->fetch_assoc())
		header("Location: index.php?error=1");
	else{
		//la constraseña es incorrecta: error 2
		if(md5($pass)!=$fila["password"])
			header("Location: index.php?error=2");
		else{
			$_SESSION["usuario"]=$fila;
			header("Location: catalogo.php");
		}
	}
}
?>