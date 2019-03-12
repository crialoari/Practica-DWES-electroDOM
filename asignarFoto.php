<?php
include("BBDD.php");
include('menuNavegacionHTML.php');
imprimirMenu("Asignar foto");
echo '<div class="container">
    <div class="row">
		<div class="col-12 p-2">';
if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]["rol"]==0){
	if(isset($_GET["error"])){
		echo '<p style="color: #ff8001;">Error al subir la imagen. Pruebe de nuevo con otro archivo.</p>';
	}
	if (isset($_POST["asignarFoto"])){
		//formulario asignar foto
		$codigo=$_POST["codigo"];
		echo'<h2 style="color: #ff8001;">Asignar foto a producto</h2>';
		echo '<h4>Identificador: '.$codigo.'</h4>';
		echo'<FORM ENCTYPE="multipart/form-data" ACTION="grabar_img.php" METHOD="post">
		<div class="form-group">
		<INPUT type="hidden" name="lim_tamano" value="1000000">
		<INPUT type="hidden" name="codigo" value="'.$codigo.'">
		<p><strong>Selecciona la imagen a transferir</strong></p>
		
		<p><INPUT type="file" name="foto"></p>
		<button class="btn" type="submit" name="enviar" style="background-color: #ff8001;">Asignar</button>
		<button class="btn bg-danger" type="submit" name="cancelar">Cancelar</button>
		</div>
		</FORM>';

	}else{
		//mostrar productos para añadir foto
		echo '<div class="container-fluid">
		<div class="row">
			<div class="col-12">';
		$productos=BBDD::getTodosProductos();
		if (count($productos)==0){
			//si no hay productos
			echo '<p style="color: #ff8001;">No hay productos en estos momentos.</a></p>';
			echo '</div></div></div>';
		}else{
			echo '<table class="table">
			 <thead class="thead-light">
			<tr class="text-center">
				<th>Foto</th>
				<th>Producto</th>
				<th>Descripción</th>
				<th>Asignar</th>
				</tr></thead>';
			foreach ($productos as $producto){
				echo "<tr><form action='asignarFoto.php' method='post'>";
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
				//asignat
				echo '<td class="text-center"><button class="btn p-2" type="submit" name="asignarFoto" style="background-color: #ff8001;">
						<img src="images/img.png" style="width:20px;">
					</button></td>';
				echo "</form></tr>";
			}
			echo '</table></div></div></div>';	
		}
	}
}else{
	//si no hay usuario admin
		echo '<p style="color: #ff8001;">Debe <a href="index.php" style="color: #ff8001; text-decoration:underline;">iniciar sesión como usuario.</a></p>';
		echo '</div></div></div>';
}
imprimirFin();
?>