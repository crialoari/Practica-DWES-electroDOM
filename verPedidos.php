<?php
include("fecha.php");
include("BBDD.php");
include("Cesta.php");
include('menuNavegacionHTML.php');
imprimirMenu("Pedidos");
echo '<div class="container">
    <div class="row">
		<div class="col-12 p-2">';
if(isset($_SESSION["usuario"])){
	if($_SESSION["usuario"]["rol"]==1){
		 //si es usuario
		 $pedidos=BBDD::getPedidosUsuario($_SESSION["usuario"]["DNI"]);
	 }else{
		 //si es admin
		 $pedidos=BBDD::getPedidosAdmin();
	 }
	 if (count($pedidos)==0){
		 //si no hay pedidos
		echo '<p style="color: #ff8001;">No se han realizado pedidos.</a></p>';
		echo '</div></div></div>';
	}else{
		echo '<table class="table">
		 <thead class="thead-light">
			<tr>
			<th>Número pedido</th>
			<th>Cliente</th>
			<th>Fecha</th>
			<th>Líneas</th>
			<th>Total (€)</th>';
		echo '</thead></tr>';
		foreach ($pedidos as $pedido){
			$lineas=BBDD::getLineasPedido($pedido["n_pedido"]);
			echo "<tr>";
			//numero
			echo "<td>".$pedido["n_pedido"]."</td>";
			//cliente
			echo "<td>".$pedido["cliente"]."</td>";
			//fecha
			echo "<td>".date2string ($pedido["fecha"])."</td>";
			//lineas
			echo "<td>".count($lineas)."</td>";
			//total
			$total=0;
			foreach ($lineas as $linea){
				$total+=$linea["pvp"];
			}
			echo "<td>".number_format((float)$total, 2, '.', '')."</td>";
			echo "</tr>";
		}
		echo '</table></div></div>';
	}
}else{
	//si no hay usuario
		echo '<p style="color: #ff8001;">Debe <a href="index.php" style="color: #ff8001; text-decoration:underline;">iniciar sesión como usuario.</a></p>';
		echo '</div></div></div>';
}
imprimirFin();
?>