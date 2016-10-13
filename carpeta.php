<?php

$carpeta = "http://team.openspa.info/HNxp3t6$v&/Canales/"; //carpeta para mostrar su contenido

function scan($carpeta){ //busca recursivamente los archivos y carpetas de $dir y los devuelve en un array

	$files = array();

	if(file_exists($carpeta)){ //si existe la carpeta
	
		foreach(scandir($carpeta) as $f) {
		
			if(!$f || $f[0] == '.') {
				continue; // No mostrar ocultos
			}

			if(is_dir($carpeta . '/' . $f)) { // si es una carpeta
				$files[] = array(
					"name" => $f,
					"type" => "folder",
					"path" => $carpeta . '/' . $f,
					"items" => scan($carpeta . '/' . $f) // Miro recursivamentem, se podría mejorar no haciendolo si no se quieres, con un parametro en la funcion scan
				);
			}
			
			else { // es una carpeta
				$files[] = array(
					"name" => $f,//nombre de archivo con extension
					"type" => "file", //tipo
					"path" => $carpeta . '/' . $f, //ruta realativa con archivo incluido
					"size" => filesize($carpeta . '/' . $f) // tamaño de archivo
				);
			}
		}
	
	}

	return $files;
}

function muestraContenido($arraycarpeta,$recursivo,$vercarpetas,$nivel)
{
	
	foreach($arraycarpeta as $f) { // recorro el array
		if ($f["type"] !== "folder" or  $vercarpetas) //si no es carpeta o se quieren mostra carpetas
		{
			echo str_repeat("&nbsp;",$nivel*4); // indento segun el nivel
			if ($f["type"] === "folder")
				echo "[".$f["name"]."]"; // mostrar nombre de carpeta
			else
				echo $f["name"]; // mostrar nombre de archivo
			echo " :: ".$f["size"]." :: [".$f["path"]."]<hr>\n"; // mostrar info adicional
		}
		if ($f["items"] and $recursivo)
			muestraContenido($f["items"],true,$vercarpetas,$nivel+1); //si es carpeta y hay algo dentro y es recursivo muestro contenido también
	}
	
}

$arraycontenido = scan($carpeta); //obtengo un array con el contenido de la carpeta
ksort($arraycontenido); //ordeno el array

muestraContenido($arraycontenido,true,true,0); // ruta relativa a mostar , si queremos mostrar contenido de subcarpetas, mostrar carpetas si o no nivel es solo para identar segun el nivel de profundidad de carpeta

?>
