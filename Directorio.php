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
	public function add(ElementoSistemaFicheros $e, $ruta = ""): bool
	{
		if ($ruta != ""){
			$zona = $this->rutaExiste($ruta);
			if ($zona === false || !($zona instanceof Directorio)){
				return false;
			} 
		} else {
			$zona = $this;
		}
		if (!array_key_exists($e->nombre,$zona->elementos)){
			$zona->elementos[$e->nombre] = $e;
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
			} else if ($recurso instanceof Directorio) {
				$recurso->listar();
				echo "\n";
				foreach ($recurso->elementos as $key => $value) {
					echo "\t" . $value->listar() . "\n";
				}
			} else {
				echo $recurso->listar();
			}
		}
	}
	// public function delete(&$objeto){
	// 	return array_search($objeto,$this->elementos);
	// }
	//Devuelve información del directorio en sí.
	public function toString(): string
	{
		return Directorio::ROOT . "$this->nombre\t$this->permisos\t$this->fechaModificacion\t$this->horaModificacion";
	}
	//Si la ruta relativa hacia un recurso lleva hasta el mismo, devuelve el objeto correspondiente a la ruta. Si no lleva a nada, devuelve false.
	public function rutaExiste($ruta): mixed
	{
		$componentesRuta = explode("/",$ruta);
		$nextPart = $this->elementos;
		$cont = 0;
		for ($cont = 0; $cont < sizeof($componentesRuta); $cont++){
			$nextKey = $componentesRuta[$cont];
			if (is_array($nextPart) && array_key_exists($nextKey,$nextPart)){
				if ($nextPart[$nextKey] instanceof Directorio){					
					$aux = $nextPart[$nextKey];
					$nextPart = $nextPart[$nextKey]->elementos;
				} else {
					$nextPart = $nextPart[$nextKey];
				}
			} else {
				return false;
			}
		}
		if ($nextPart instanceof Fichero){
			return $nextPart;
		} else {
			return $aux;
		}
	}
}
$directorio3 = new Directorio("directorio3");
$directorio3->add(new Fichero("fichero.cfg"));

$directorio2 = new Directorio("directorio2");
$directorio2->add($directorio3);
$directorio2->add(new Fichero("fichero.txt"));
$directorio2->add(new Directorio("directorio3"));
$directorio2->add(new Fichero("ejercicio.java"));
$directorio1 = new Directorio("directorio1");
$directorio1->add($directorio2);
?>