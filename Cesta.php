<?php
require_once('BBDD.php');
Class Cesta{
	protected $productos = array();
	
	public function get_productos(){return $this->productos;}
	
	public function añadir_articulo($codigo) {
		$articulo=BBDD::getProductoCodigo($codigo);
		if($this->buscar_articulo($codigo)==null)
			$this->productos[]=$articulo;
		$this->añadir_unidad($codigo);
	}
	
	public function buscar_articulo($codigo){
		foreach($this->productos as $producto){
			if($producto->getcodigo()==$codigo)
				return $producto;
		}
		return null;
	}
	
	public function quitar_producto($codigo){
		$articulo=$this->buscar_articulo($codigo);
		$articulo->setcantidad(0);
		$this->actualizar_cesta();
	}
	
	public function quitar_unidad($codigo){
		$articulo=$this->buscar_articulo($codigo);
		if($articulo->getcantidad()>0)
			$articulo->setcantidad($articulo->getcantidad()-1);
		$this->actualizar_cesta();
	}
	
	public function añadir_unidad($codigo){
		$articulo=$this->buscar_articulo($codigo);
		if($articulo->getcantidad()<$articulo->getstock())
			$articulo->setcantidad($articulo->getcantidad()+1);
		$this->actualizar_cesta();
	}
	
	public function guarda_cesta() { 
		$_SESSION["cesta"]=$this;
	}
	
	public function estavacia() {
		if (count($this->productos)==0)
			return true;
		else
			return false;
    }
	
	public function actualizar_cesta(){
		$productos=array_filter($this->productos, function($v, $k) {
			return $v->getcantidad()>0;}, ARRAY_FILTER_USE_BOTH);
		$this->productos=$productos;
	}
	
	public function getTotal() {
		$total=0;
		foreach ($this->productos as $producto){
			$total+=$producto->getpvp()*$producto->getcantidad();
		}
     return number_format((float)$total, 2, '.', '');
    }
}
?>