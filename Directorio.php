<?php
include "ElementoSistemaFicheros.php";

class Directorio extends ElementoSistemaFicheros {
	private $elementos;

	public function __construct(string $nombre, string $permisos = "xxxx--x--")
	{
		parent::__construct($nombre,$permisos); //Se llama al constructor del padre.
		$this->elementos = [];
	}
	//Se intenta añadir un elemento al directorio. Si existe uno con el mismo nombre, se añade y devuelve true. Si no, hace lo contrario.
	public function add(ElementoSistemaFicheros $e): bool{
		if (!array_key_exists($e->nombre,$this->elementos)){
			$this->elementos[$e->nombre] = $e;
			return true;
		} 
		return false;
	}
	
	public function listar($ruta = ""){
		if ($ruta == ""){
			echo $this->toString();
		} else {
			$recurso = $this->rutaExiste($ruta);
			if (!$recurso){
				echo "La ruta no existe";
			} else {
				
			}
		}
	}
	//Devuelve información del directorio en sí.
	public function toString(): string
	{
		return Directorio::ROOT . "$this->nombre\t$this->permisos\t$this->fechaModificacion\t$this->horaModificacion";
	}
	//Si la ruta relativa hacia un recurso lleva hasta el mismo, devuelve los elementos correspondientes a la ruta. Si no lleva a nada, devuelve false.
	public function rutaExiste($ruta)
	{
		$componentesRuta = explode("/",$ruta);
		$nextArray = $this->elementos;
		for ($i = 0; $i < sizeof($componentesRuta); $i++){
			$nextKey = $componentesRuta[$i];
			if (array_key_exists($nextKey,$nextArray)){
				$nextArray = $nextArray[$nextKey]->elementos;
			} else {
				return false;
			}
		}
		return $nextArray;
	}
}
?>