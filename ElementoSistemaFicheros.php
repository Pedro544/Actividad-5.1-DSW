<?php
abstract class ElementoSistemaFicheros {
	protected string $nombre;
	protected string $permisos;
	protected string $fechaModificacion;
	protected string $horaModificacion;
	public const ROOT = "/";
	

	public function __construct(string $nombre, string $permisos = "xxxx--x--")
	{
		$this->nombre = $nombre;
		$this->permisos = $permisos;
		$this->fechaModificacion = date("dd/mm/yyyy");
		$this->horaModificacion = date("HH:ii");
	}

	abstract function listar($ruta = "");

	public function getNombre() 
	{
		return $this->nombre;
	}

	public function getPermisos()
	{
		return $this->permisos;
	}

	public function setNombre(string $nombre)
	{
		$this->nombre = $nombre;
	}
	
	public function setPermisos(string $permisos)
	{
		$this->permisos = $permisos;
	}

	public function guardar()
	{
		$this->fechaModificacion = date("dd/mm/yyyy");
		$this->horaModificacion = date("HH:ii");
	}
}
?>