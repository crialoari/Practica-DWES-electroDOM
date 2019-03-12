<?php
include("BBDD.php");
include("Cesta.php");
include('menuNavegacionHTML.php');
imprimirMenu("Catálogo");

//crear cesta
if (!isset($_SESSION["cesta"]))
	$cesta=new Cesta();
else
	$cesta=$_SESSION["cesta"];

//añadir producto a la cesta
if (isset($_POST["añadirProducto"])){
	$cesta->añadir_articulo($_POST["codigo"]);
	$cesta->guarda_cesta();
}

echo '<div class="container-fluid">
    <div class="row">
		<div class="col-12 p-2">';

$productos=BBDD::getProductos();
if (count($productos)==0){
	//si no hay productos
	echo '<p style="color: #ff8001;">No hay stock en estos momentos.</a></p>';
	echo '</div></div></div>';
}else{
	//si hay productos
	echo '<table class="table">
		<thead class="thead-light">
		<tr>
			<th class="text-center">Foto</th>
			<th>Producto</th>
			<th>Descripción</th>
			<th>Stock</th>
			<th>€</th>';
	if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]["rol"]==1)
			echo '<th class="text-center">Añadir</th>';
	echo '</tr></thead>';

	foreach ($productos as $producto){
		echo "<tr><form action='catalogo.php' method='post'>";
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
		//Stock
		echo "<td>".$producto->getstock()."</td>";
		//precio
		echo "<td>".$producto->getpvp()."</td>";
		//carrito
		if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]["rol"]==1)
			echo '<td class="text-center">
			<button class="btn p-2" type="submit" name="añadirProducto" style="background-color: #ff8001;">
				<img src="images/add.png" style="width:20px;">
			</button></td>';
		echo "</form></tr>";
	}
	echo '</table></div></div></div>';
}
imprimirFin();
?>