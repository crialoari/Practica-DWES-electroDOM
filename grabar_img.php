<?php
include("BBDD.php");
session_start();
if (isset($_POST["cancelar"])){
	header("Location: asignarFoto.php");
}else{
	$foto_name= $_FILES['foto']['name'];
	$foto_size= $_FILES['foto']['size'];
	$foto_type=  $_FILES['foto']['type'];
	$foto_temporal= $_FILES['foto']['tmp_name'];
	$lim_tamano= $_POST['lim_tamano'];
	$codigo= $_POST['codigo'];

	if ($foto_type=="image/x-png" OR $foto_type=="image/png"){
	 $extension="image/png";
	 }
	if ($foto_type=="image/pjpeg" OR $foto_type=="image/jpeg"){
	 $extension="image/jpeg";
	 }
	if ($foto_type=="image/gif" OR $foto_type=="image/gif"){
	 $extension="image/gif";
	 }

	if ($foto_name != "" AND $foto_size != 0 AND $foto_size<=$lim_tamano AND $extension !=''){
		$f1= fopen($foto_temporal,"rb");
		$foto_reconvertida = fread($f1, $foto_size);
		$foto_reconvertida=addslashes($foto_reconvertida);
		BBDD::asignarFoto($codigo,$foto_reconvertida,$extension);
		header("Location: asignarFoto.php");
	}else{
		header("Location: asignarFoto.php?error=1");
	 }
}
?>
