<?php

class Producto {
    protected $codigo;
    protected $nombre;
    protected $nombre_corto;
    protected $descripcion;
	protected $pvp;
	protected $familia;
	protected $stock;
	protected $foto;
	protected $format;
	protected $cantidad;
	
    public function getcodigo() {return $this->codigo; }
    public function getnombre() {return $this->nombre; }
    public function getnombrecorto() {return $this->nombre_corto; }
	public function getdescripcion() {return $this->descripcion; }
    public function getpvp() {return $this->pvp; }
    public function getfamilia() {return $this->familia; }
	public function getstock() {return $this->stock; }
	public function getfoto() {return $this->foto; }
	public function getformat() {return $this->format; }
	public function getcantidad() {return $this->cantidad; }
	public function setcantidad($cantidad) {$this->cantidad=$cantidad; }
    
    public function __construct($row) {
        $this->codigo = $row['codigo'];
        $this->nombre = $row['nombre'];
        $this->nombre_corto = $row['nombre_corto'];
		$this->descripcion = $row['descripcion'];
        $this->pvp = $row['pvp'];
		$this->familia = $row['familia'];
		$this->stock = $row['stock'];
		$this->foto = $row['foto'];
		$this->format = $row['format'];
		$this->cantidad = 0;
    }
}
?>