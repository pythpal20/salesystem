<?php
	// koneksi 1 mysqli object
	$DB_HOST 	= 'localhost';
	$DB_USER 	= 'horek940_salsys';
	$DB_PASS	= 'Garuda752021';
	$DATABASE 	= 'horek940_salsys';
	$db1 		= new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DATABASE);
	// koneksi 2 mysqli
	$connect = mysqli_connect("localhost", "horek940_salsys", "Garuda752021", "horek940_salsys");
	// koneksi 3 PDO
	$host = 'localhost';
	$username = 'horek940_salsys';
	$password = 'Garuda752021'; 
	$database = 'horek940_salsys'; 
	$pdo = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);

?>