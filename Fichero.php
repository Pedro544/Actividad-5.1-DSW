<?php
class Fichero extends ElementoSistemaFicheros {

	private int $tamanio;

	public function __construct(string $nombre, string $permisos = "xxxx--x--")
	{
		parent::__construct($nombre,$permisos); //Se llama al constructor del padre.
		$this->tamanio = rand(1,100);
	}
	
	public function listar(){
		echo "$this->nombre\t$this->permisos\t$this->fechaModificacion\t$this->horaModificacion\t$this->tamanio KB";
	}
}
?>