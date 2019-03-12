<?php
include("BBDD.php");
include("Cesta.php");
include('menuNavegacionHTML.php');
imprimirMenu("Carrito");

//vaciar cesta
if (isset($_POST["vaciar"])){
	unset($_SESSION["cesta"]);
}

echo '<div class="container-fluid">
    <div class="row">
		<div class="col-12 p-2">';
if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]["rol"]==1){
	//crear cesta
	if (!isset($_SESSION["cesta"]))
		$cesta=new Cesta();
	else
		$cesta=$_SESSION["cesta"];
	//quitar producto
	if(isset($_POST["quitarProducto"])){
		$cesta->quitar_producto($_POST["codigo"]);
		$cesta->guarda_cesta();
	}
	//añadir unidad
	if(isset($_POST["añadirUnidad"])){
		$cesta->añadir_unidad($_POST["codigo"]);
		$cesta->guarda_cesta();
	}
	//quitar unidad
	if(isset($_POST["quitarUnidad"])){
		$cesta->quitar_unidad($_POST["codigo"]);
		$cesta->guarda_cesta();
	}
	//confirmar compra
	if(isset($_POST["confirmar"])){
		header("Location: confirmarCompra.php");
	}
	echo '<table class="table">
		 <thead class="thead-light">
		<tr>
			<th class="text-center">Foto</th>
			<th>Producto</th>
			<th>Descripción</th>
			<th>Precio</th>
			<th>Cantidad</th>
			<th class="text-center">Acciones</th>';
		echo '</thead></tr>';
	$productos=$cesta->get_productos();
	foreach ($productos as $producto){
		echo "<tr><form action='carrito.php' method='post'>";
		//codigo
		echo "<input type='hidden' name='codigo' value=".$producto->getcodigo().">";
		//foto
		if($producto->getfoto()!=null)
			echo "<td class='text-center'><img src='verFoto.php?n=".$producto->getcodigo()."' style='width:100px;'></td>";
		else
			echo "<td><img src='images/nofoto.jpg' style='width:150px;'></td>";
		//producto
		echo "<td>".$producto->getnombrecorto()." - ".$producto->getnombre()."</td>";
		//descripcion
		echo "<td>".$producto->getdescripcion()."</td>";
		//precio
		echo "<td>".$producto->getpvp()."</td>";
		echo "<td>".$producto->getcantidad()."</td>";
		echo '<td><button class="btn btn-sm bg-success" type="submit" name="añadirUnidad" style="background-color: #ff8001;">+</button>
		<button class="btn btn-sm bg-danger" type="submit" name="quitarUnidad" style="background-color: #ff8001;">-</button>
		<button class="btn btn-sm" type="submit" name="quitarProducto" style="background-color: #ff8001;">X</button></td>';
		echo "</form></tr>";
	} 
	echo '<tfoot><tr><td>Total</td><td>'.$cesta->getTotal().'</td></tr></tfoot>';
	echo '</table></div></div>';
	//botones finales
	echo '<div class="row"><div class="col-12">';
	echo '<form action="catalogo.php" method="POST">
	<button class="btn btn-sm" type="submit" name="seguir" style="background-color: #ff8001;">Seguir comprando</button></form></div></div>';

	if(!$cesta->estavacia())
		echo '<form action="carrito.php" method="POST" class="mt-2">
					<button class="btn btn-sm bg-danger" type="submit" name="vaciar">Anular compra</button>
					<button class="btn btn-sm bg-success" type="submit" name="confirmar" style="background-color: #ff8001;">
						<img src="images/add.png" style="width:20px;">Confirmar compra
					</button></form></div></div>';
	echo '</div>';
	
}else{
	//si no hay usuario
		echo '<p style="color: #ff8001;">Debe <a href="index.php" style="color: #ff8001; text-decoration:underline;">iniciar sesión como usuario.</a></p>';
		echo '</div></div></div>';
}
imprimirFin();
?>