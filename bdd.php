<?php 

try {
	$bdd = new PDO('mysql:host=localhost;dbname=candidTc;charset=utf8', 'root', '');
	$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch (Exception $e) {
	die('Impossible de se connecter à la bdd');
}

 ?>