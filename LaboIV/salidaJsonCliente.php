<?php

	
	include 'datosConexionBase.inc';

	//realizo la conexión a la base de datos
	$mysqli = new mysqli(HOST,USUARIO,PASS,BASE,PORT);

	//en caso de error al intentar conectar, se graba en un archivo de errores
	if($mysqli->connect_errno<>0){
		$puntero = fopen("./errores.log","a");
		fwrite($puntero, "Falló conexión base de datos: " . HOST);
		fwrite($puntero, $mysqli->connect_errno . " ");
		$fecha=date("Y-m-d");
		fwrite($puntero, date("Y-m-d H-i") . " ");
		fwrite($puntero, "\n");
		fclose($puntero);
		die();
	}

	$sql = "select * from usuarios";

	

	
	//ejecuto el query guardado en la variable $sql. 
	if(!($resultado = $mysqli->query($sql))){
		$puntero = fopen("./errores.log","a");
		fwrite($puntero, "Error de sql: ");
		fwrite($puntero, $mysqli->sqlstate . " ");
		fwrite($puntero, "Sentencia: ");
		fwrite($puntero, $sql . " ");
		$fecha=date("Y-m-d");
		fwrite($puntero, date("Y-m-d H-i") . " ");
		fwrite($puntero, "\n");
		fclose($puntero);
		die();
	}

	

	//recorro el resultado y por cada fila, cargo los valores en el objeto objCliente y lo pusheo al vector clientes
	
	$fila=$resultado->fetch_assoc();
	$objCliente = new stdclass();
	$objCliente->nombre_usuario=$fila['nombre_usuario'];
	

	//genero un nuevo objeto para almacenar el array de clientes y la cantidad de registros, lo codifico como json y lo devuelvo al navegador

	$salidaJson = json_encode($objCliente);

	$mysqli->close();

	echo $salidaJson;


	
?>