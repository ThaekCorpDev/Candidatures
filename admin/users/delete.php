<?php 

require('../../bdd.php');
require('../../Config/config.php');
require('../../Class/Helpers/Html.php');
require('../../Class/Models/User.php');

$config = new Config();
$sUrl = $config->getSourceUrl();
$html = new Html($sUrl);
$model = new User($bdd, $sUrl);

if(!isset($_GET['id'])) {
	header('Location: listadmins.php');
	die();
}

if(!$model->delete($_GET['id'])) {
	header('Location: listadmins.php');
	die();
}

$model->delete($_GET['id']);
header('Location: listadmins.php');

?>