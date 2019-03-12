<?php
require_once('Producto.php');
Class BBDD{
	public static function getPedidosAdmin(){
		$pedidos=array();
		$conexion=self::conexion("localhost","root","","tienda");
		$consulta="SELECT * FROM pedidos";
		$resultado=$conexion->query($consulta);
		while ($fila=$resultado->fetch_assoc()){
			$pedidos[]=$fila;
		}
		return $pedidos;
	}
	
	public static function getPedidosUsuario($DNI){
		$pedidos=array();
		$conexion=self::conexion("localhost","root","","tienda");
		$consulta="SELECT * FROM pedidos WHERE cliente='".$DNI."'";
		$resultado=$conexion->query($consulta);
		while ($fila=$resultado->fetch_assoc()){
			$pedidos[]=$fila;
		}
		return $pedidos;
	}
	
	public static function getLineasPedido($n_pedido){
		$conexion=self::conexion("localhost","root","","tienda");
		$consulta="SELECT * FROM `lineas` WHERE n_pedido=".$n_pedido;
		$resultado=$conexion->query($consulta);
		while ($fila=$resultado->fetch_assoc()){
			$lineas[]=$fila;
		}
		return $lineas;
	}
	
	public static function getProductos() {
		$productos=array();
		$conexion=self::conexion("localhost","root","","tienda");
		$consulta="SELECT * FROM productos WHERE stock>0 ORDER BY familia";
		$resultado=$conexion->query($consulta);
		while ($fila=$resultado->fetch_assoc()){
			$productos[]=new Producto($fila);
		}
		return $productos;
    }
	
	public static function getTodosProductos() {
		$productos=array();
		$conexion=self::conexion("localhost","root","","tienda");
		$consulta="SELECT * FROM productos ORDER BY familia";
		$resultado=$conexion->query($consulta);
		while ($fila=$resultado->fetch_assoc()){
			$productos[]=new Producto($fila);
		}
		return $productos;
    }
	
	public static function getProductoCodigo($codigo) {
		$conexion=self::conexion("localhost","root","","tienda");
		$consulta="SELECT * FROM productos WHERE codigo='".$codigo."'";
		$resultado=$conexion->query($consulta);
		$fila=$resultado->fetch_assoc();
		$producto=new Producto($fila);
		return $producto;
    }
	
	public static function getFoto($codigo){
		$producto=self::getProductoCodigo($codigo);
		return $producto->getfoto();
	}
	
	public static function getExt($codigo){
		$producto=self::getProductoCodigo($codigo);
		return $producto->getformat();
	}
	
	public static function getUsuarioUser($usuario){
		$conexion=self::conexion("localhost","root","","tienda");
		$consulta="SELECT * FROM clientes WHERE (usuario='".$usuario."')";
		$resultado=$conexion->query($consulta);
		return $resultado;
	}
	
	public static function getUsuarioDNI($DNI){
		$conexion=self::conexion("localhost","root","","tienda");
		$consulta="SELECT * FROM clientes WHERE (DNI='".$DNI."')";
		$resultado=$conexion->query($consulta);
		return $resultado;
	}
	
	public static function insertarUsuario($DNI,$nombre,$direccion,$user,$encriptada){
		$conexion=self::conexion("localhost","root","","tienda");
		$cadinsert="INSERT INTO `clientes`(`DNI`, `nombre`, `direccion`, `usuario`, `password`, `rol`)";
		$cadinsert.=" VALUES ('".$DNI."','".$nombre."','".$direccion."','".$user."','".$encriptada."',1)";
		$conexion->query($cadinsert);
	}
	
	public static function asignarFoto($codigo,$foto,$ext){
		$update="UPDATE `productos` SET `foto`='".$foto."',`format`='".$ext."' WHERE codigo='".$codigo."'";
		$conexion=self::conexion("localhost","root","","tienda");
		$conexion->query($update);
	}
	
	public static function conexion($host,$user,$pass,$DB){
		$conn=new mysqli($host,$user,$pass,$DB);
		$conn->set_charset("utf8");
		return $conn;
	}
}
?>