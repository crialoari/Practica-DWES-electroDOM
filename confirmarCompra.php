<?php
include("fecha.php");
include("BBDD.php");
include("Cesta.php");
include('menuNavegacionHTML.php');
imprimirMenu("Carrito");
echo '<div class="container-fluid">
    <div class="row">
		<div class="col-6 m-auto p-2">';
if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]["rol"]==1){
	if (!isset($_SESSION["cesta"])){
		echo '<p style="color: #ff8001;">Debe <a href="catalogo.php" style="color: #ff8001; text-decoration:underline;">tener cesta.</a></p>';
		echo '</div></div></div>';
	}else{
		$cesta=$_SESSION["cesta"];
		if($cesta->estavacia()){
			echo '<p style="color: #ff8001;">Debe <a href="catalogo.php" style="color: #ff8001; text-decoration:underline;">llenar la cesta.</a></p>';
			echo '</div></div></div>';
		}else{
			//hay cesta llena
			$cliente=$_SESSION["usuario"]["DNI"];
			$fecha=today ();
			//meter en tabla pedido
			$conexion=BBDD::conexion("localhost","root","","tienda");
			$cadinsert="INSERT INTO `pedidos`(`cliente`, `fecha`)";
			$cadinsert.=" VALUES ('".$cliente."','".$fecha."')";
			$conexion->query($cadinsert);
			$n_pedido=$conexion->insert_id;
			//por cada producto en sesion cesta, insertar una linea
			$productos=$cesta->get_productos();
			$i=1;
			foreach ($productos as $producto){
				//insertar linea
				$codigo_producto=$producto->getcodigo();
				$cantidad=$producto->getcantidad();
				$pvp_linea=$producto->getcantidad()*$producto->getpvp();
				$cadinsert="INSERT INTO `lineas`(`n_pedido`, `n_linea`, `producto`, `cantidad`, `pvp`)";
				$cadinsert.=" VALUES (".$n_pedido.",".$i.",'".$codigo_producto."',".$cantidad.",".number_format((float)$pvp_linea, 2, '.', '').")";
				$conexion->query($cadinsert);
				$i++;
				//actualizar stock
				$actualizar_producto=BBDD::getProductoCodigo($codigo_producto);
				$nuevo_stock=$actualizar_producto->getstock()-$cantidad;
				$update="UPDATE `productos` SET `stock`=".$nuevo_stock." WHERE codigo='".$codigo_producto."'";
				$conexion->query($update);
			}
			//mostrar mensaje e ir a pedidos
			unset($_SESSION["cesta"]);
			echo '<h2 style="color: #ff8001;">Pedido realizado</h2>';
			echo '<h4>Identificador: '.$n_pedido.'</h4>';
			echo '<h4>Cliente: '.$cliente.'</h4>';
			echo '<h4>Fecha: '.$fecha.'</h4>';
			echo '<p style="color: #ff8001;"><a href="catalogo.php" style="color: #ff8001;">Seguir comprando</a></p>';
			echo '</div></div></div>';
		}
	}
}else{
	//si no hay usuario
		echo '<p style="color: #ff8001;">Debe <a href="index.php" style="color: #ff8001; text-decoration:underline;">iniciar sesión como usuario.</a></p>';
		echo '</div></div></div>';
}
imprimirFin();
?>