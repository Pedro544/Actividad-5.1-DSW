<?php
abstract class ElementoSistemaFicheros {
	protected string $nombre; //Nombre del elemento.
	protected string $permisos; //Permisos del elemento. Por defecto son "xxxx--x--".
	protected string $fechaModificacion; //Fecha de modificación del elemento.
	protected string $horaModificacion; //Hora de modificación del elemento.
	public const ROOT = "/"; //Constante que representa el punto de partida de la creación de elementos.
	
	public function __construct(string $nombre, string $permisos = "xxxx--x--")
	{
		$this->nombre = $nombre;
		$this->permisos = $permisos;
		$this->fechaModificacion = date("d/m/Y"); //La fecha de modificación en un principio es la actual.
		$this->horaModificacion = date("H:i"); //La hora de modificación en un principio es la actual.
	}
	//Función que servirá para mostrar por pantalla la información del elemento.
	abstract function listar();
	//Getter del nombre.
	public function getNombre(): string 
	{
		return $this->nombre;
	}
	//Getter de los permisos.
	public function getPermisos(): string
	{
		return $this->permisos;
	}
	//Modificador del nombre.
	public function setNombre(string $nombre)
	{
		$this->nombre = $nombre;
		$this->guardar();
	}
	//Modificador de los permisos.
	public function setPermisos(string $permisos)
	{
		$this->permisos = $permisos;
		$this->guardar();
	}
	//Actualiza fecha y hora.
	public function guardar()
	{
		$this->fechaModificacion = date("dd/mm/yyyy");
		$this->horaModificacion = date("HH:ii");
	}
}
?>