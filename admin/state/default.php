<?php 

require('../../bdd.php');
require('../../Config/config.php');
require('../../Class/Helpers/Html.php');
require('../../Class/Models/Candid.php');

$config = new Config();
$sUrl = $config->getSourceUrl();
$html = new Html($sUrl);
$model = new Candid($bdd);

if(!isset($_GET['id'])) {
	header('Location: ../');
	die();
}

if(!$model->editState($_GET['id'], 0)) {
	header('Location: ../');
	die();
}

$model->editState($_GET['id'], 0);
header('Location: ../');

?>