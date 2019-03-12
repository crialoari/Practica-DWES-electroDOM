<?php
session_start();
function imprimirMenu($titulo){
	echo '<!DOCTYPE html>
<html lang="es">
    <head>
        <title>
            electroDOM - '.$titulo.'
        </title>
        <meta charset="utf-8">
            <meta content="width=device-width, initial-scale=1" name="viewport">
                <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
                    </script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js">
                    </script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js">
                    </script>
                </link>
            </meta>
        </meta>
    </head>
    <body>
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a class="navbar-brand mr-auto" href="index.php">
                <img alt="logo" src="images/logo.png" style="height: 40px;">
                </img>
            </a>
            <button class="navbar-toggler" data-target="#collapsibleNavbar" data-toggle="collapse" type="button">
                <span class="navbar-toggler-icon">
                </span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="catalogo.php">
                            Catálogo
                        </a>
                    </li>';
		if(isset($_SESSION["usuario"])){
			if($_SESSION["usuario"]["rol"]!=0){
				echo '<li class="nav-item">
                        <a class="nav-link" href="carrito.php">
                            Mi carrito
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="datosUsuario.php">
                            Mis datos
                        </a>
                    </li>';
			}else{
                echo '<li class="nav-item">
                        <a class="nav-link" href="asignarFoto.php">
                            Asignar foto
                        </a>
                    </li>';
			}
            echo '<li class="nav-item mr-5">
                        <a class="nav-link" href="verPedidos.php">
                            Ver pedidos
                        </a>
					</li>
			<li class="nav-item">
                        <a class="nav-link" href="index.php">
                            salir
                        </a>
                    </li>';
		}
		echo '</ul>
            </div>
        </nav>';	
}

function imprimirFin(){
	echo "</body></html>";
}
?>
