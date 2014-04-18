<?php 

require('../../bdd.php');
require('../../Config/config.php');
require('../../Class/Models/User.php');

$config = new Config();
$sUrl = $config->getSourceUrl();
$model = new User($bdd, $sUrl);

$model->logout();

?>