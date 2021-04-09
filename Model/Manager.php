<?php

abstract class Manager {
	
	public function connectDB() {
		try { 
			$conn = new PDO( "sqlsrv:Server=LAPTOP-PHP8J8PN\SQLEXPRESS;Database=BDcamping", NULL, NULL);  #connection avec sql server
 			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			return $conn; 
 		} catch (Exception $e) { 
			die('Erreur : ' . $e->getMessage()); 
		}
	} 

	
}
		
}