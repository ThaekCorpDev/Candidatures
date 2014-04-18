<?php
require('../../bdd.php');
require('../../Config/config.php');
require('../../Class/Helpers/Html.php');
require('../../Class/Models/User.php');

$config = new Config();
$sUrl = $config->getSourceUrl();
$html = new Html($sUrl);
$model = new User($bdd, $sUrl);

if(!$model->isConnected()) {
	header('Location: ../login.php');
	die();
}

$users = json_encode($model->findAll());
?>

<html ng-app>
<head>
	<meta charset="UTF-8">
	<title>Liste des admins</title>
	<?= $html->load('bootstrap'); ?>
</head>
<body class="text-center container" ng-controller="UsersController">

	<br><div class="form-inline">
		<input 
			type="text" 
			placeholder="username" 
			class="form-control" 
			ng-model="search.username"
		>
		<select class="form-control" ng-model="search.rank">
			<option value="">rien</option>
			<option value="Builder">Builder</option>
			<option value="Terraformeur">Terraformeur</option>
			<option value="Redstoneur">Redstoneur</option>
			<option value="Graphiste">Graphiste</option>
			<option value="Dev">Dev</option>
			<option value="Scenariste">Scenariste</option>
			<option value="Admin">Admin</option>
		</select>
	</div><br>

	<div class="jumbotron" ng-repeat="user in users | filter:search">
		<li>{{user.username}}<span class="label label-danger">{{user.rank}}</span></li><br>
		<a href="delete.php?id={{user.id}}"><button class="btn btn-danger">Supprimer</button></a>
		<hr>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.min.js"></script>

	<script>
		function UsersController($scope) {
			$scope.users = <?= $users ?>;
		}
	</script>
</body>
</html>