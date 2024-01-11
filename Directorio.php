<?php
include "ElementoSistemaFicheros.php";
include "Fichero.php";
class Directorio extends ElementoSistemaFicheros {
	private array $elementos;

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
	//Se imprime la información.
	public function listar($ruta = ""){
		if ($ruta == ""){
			echo $this->toString();
		} else {
			$recurso = $this->rutaExiste($ruta);
			if ($recurso === false){
				echo "La ruta al recurso no existe";
			} else if (is_array($recurso)) {
				foreach ($recurso as $key => $value) {
					echo $value->listar() . "\n";
				}
			} else {
				echo $recurso->listar();
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
		$nextPart = $this->elementos;
		for ($i = 0; $i < sizeof($componentesRuta); $i++){
			$nextKey = $componentesRuta[$i];
			if (is_array($nextPart) && array_key_exists($nextKey,$nextPart)){
				if ($nextPart[$nextKey] instanceof Directorio){
					$nextPart = $nextPart[$nextKey]->elementos;
				} else {
					$nextPart = $nextPart[$nextKey];
				}
			} else {
				return false;
			}
		}
		return $nextPart;
	}
}
?>