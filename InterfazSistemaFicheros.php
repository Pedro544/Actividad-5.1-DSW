<?php
/* 
La aplicación permitirá añadir ficheros/directorios a un
directorio, listar información, y modificarla.

MODIFICAR NOMBRE:
-Dónde está el recurso.
-Ingresa su nuevo nombre.

MODIFICAR PERMISOS:
-Dónde está el recurso.
-Ingresa sus nuevos permisos.

LISTAR INFORMACIÓN:
-Ubicación del recurso a listar.
-Listar.

La aplicación también podría serializar la información
recogida para que al volver se quede almacenada.
*/
include "Directorio.php";
class InterfazSistemaFicheros {
	private const ANIADIR = "1";
	private const MOD_NOMBRE = "2";
	private const MOD_PERMISOS = "3";
	private const LISTAR = "4";
	private const SALIR = "5";
	private Directorio $raiz;

	public function __construct()
	{
		$this->raiz = new Directorio(Directorio::ROOT);
	}

	public function main(){
			etiqueta: 
			$opcion = readline("Escoge una opción: 1.Añadir elemento 2.Modificar nombre 3.Modificar permisos 4.Listar 5.Salir\n");
			switch ($opcion) {
				case $this::ANIADIR:
					$this->aniadir();
					break;
				case $this::MOD_NOMBRE:
					// $this->modificarNombre();
					break;
				case $this::MOD_PERMISOS:
					$this->modificarPermisos();
					break;
				case $this::LISTAR:
					$this->listar();
					break;
				case $this::SALIR:
					die("¡Adiós!");
					break;
				default:
					echo "Opción inválida\n\n";
					break;
			}
			goto etiqueta;
	}
	/* 
	AÑADIR:
	-Qué quieres añadir, fichero o directorio.
	-Cómo se llama.´
	-Cuáles son sus permisos.
	-Dónde quieres almacenarlo (nada para que sea en ROOT). 
	*/
	public function aniadir(){
		$elemento = readline("¿Qué quieres añadir, un fichero o un directorio?\n");
		if ($elemento != "Fichero" && $elemento != "Directorio"){
			echo "No has introducido un elemento válido. Cancelando operación.\n\n";
		} else {
			$nombre = readline("¿Cómo se llama?\n");
			if ($nombre == ""){
				echo "Nombre vacío. Cancelando operación.\n";
			} else{
				$permisos = readline("¿Cuáles son sus permisos? (No introduzca nada para que sean xxxx--x--)\n");
				$ruta = readline("¿Dónde quieres almacenarlo?\n");
				switch ($elemento) {
					case "Directorio":
					if ($permisos == ""){
					$recurso = new Directorio($nombre);
					} else {
					$recurso = new Directorio($nombre,$permisos);
					}
						break;
					case "Fichero":
					if ($permisos == ""){
					$recurso = new Fichero($nombre);
					} else{
					$recurso = new Fichero($nombre,$permisos);
					}
						break;
				}
				echo $this->raiz->add($recurso,$ruta) ? "Elemento añadido correctamente\n\n" : "Ya hay un fichero con ese nombre o la ruta no existe. Cancelando operación\n\n";
			}
		}
	}
	/* 
	LISTAR INFORMACIÓN:
	-Ubicación del recurso a listar.
	-Listar.
	*/
	function listar(){
		$rutaRecurso = readline("¿Dónde se ubica el recurso a listar?");
		$this->raiz->listar($rutaRecurso);
		echo "\n\n";
	}
	/* 
	MODIFICAR NOMBRE:
	-Dónde está el recurso.
	-Ingresa su nuevo nombre.
	*/
	// function modificarNombre(){
	// 	$rutaRecurso = readline("¿Dónde se ubica el recurso a listar?");
	// 	$recurso = $this->raiz->rutaExiste($rutaRecurso);
	// 	if ($recurso === false){
	// 		echo "El recurso no existe. Cancelando operación\n\n";
	// 	} else {
	// 		$recurso->setNombre(readline("¿Cuál es el nuevo nombre del recurso?"));
	// 		echo "Nombre actualizado correctamente.\n\n";
	// 	}
	// }
	/* 
	MODIFICAR PERMISOS:
	-Dónde está el recurso.
	-Ingresa sus nuevos permisos.
	*/
	function modificarPermisos(){
		$rutaRecurso = readline("¿Dónde se ubica el recurso cuyos permisos serán modificados?");
		$recurso = $this->raiz->rutaExiste($rutaRecurso);
		if ($recurso === false){
			echo "El recurso no existe. Cancelando operación\n\n";
		} else {
			$recurso->setPermisos(readline("¿Cuáles son los nuevos permisos del recurso?"));
			echo "Permisos actualizados correctamente.\n\n";
		}
	}
}
$interfaz = new InterfazSistemaFicheros();
$interfaz->main();
//! Intentar reproducir la tabulación.
//! Intentar controlar los permisos.
?>