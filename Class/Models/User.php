<?php 

require('Model.php');

class User extends Model {

	private $pdo;
	private $url;

	public function __construct($pdo, $sUrl, $adminPage = true) {
		$this->pdo = $pdo;
		if($adminPage && !$this->isConnected()) {
			header('Location: '.$sUrl.'/login.php');
			die();
		}
		$this->url = $sUrl;
	}


	public function find($options = array()) {
		if(!isset($options['where'])) {
			$options['where']['request'] = "";
			$options['where']['datas'] = [];
		}
		$req = $this->pdo->prepare('SELECT * FROM candid_users WHERE '. $options['where']['request']);
		$req->execute($options['where']['datas']);
		return $req->fetchAll();
	}

	public function findAll() {
		$req = $this->pdo->query('SELECT * FROM candid_users');
		return $req->fetchAll();
	}

	public function addUser($_POST) {
		if(empty($_POST['username'])) {
			return false;
		}

		$username = $this->security($_POST['username']);
		$rank = $this->security($_POST['rank']);
		$password = $this->generate();



		$req = $this->pdo->prepare('INSERT INTO
			candid_users(username, password, rank)
			VALUES(?, ?, ?)
		');

		$req->execute([
			$username,
			hash('sha256', $password),
			$rank,
		]);

		return $password;
	}

	public function login() {
		if(empty($_POST['username']) || empty($_POST['password'])) {
			return false;
		}

		$password = hash('sha256', $_POST['password']);

		$user = $this->find([
			'where' => [
				'request' => 'username=:username',
				'datas'   => [
					'username' => $_POST['username']
				]
			]
		]);

		if(!$user) {
			return false;
		} else if($user[0]->password != $password) {
			return false;
		}

		$_SESSION['user'] = $user[0];
		return true;
	}

	public function logout() {
		session_destroy();
		header('Location: '.$this->url);
		return true;
	}

	public function changePw() {
		if(empty($_POST['lastPassword']) || empty($_POST['password']) || empty($_POST['passConf'])) {
			return false;
		}

		if($_POST['password'] != $_POST['passConf']) {
			return false;
		}

		$lastPassword = hash('sha256', $_POST['lastPassword']);

		$user = $this->find([
			'where' => [
				'request' => 'id=:id',
				'datas'   => [
					'id' => $_SESSION['user']->id,
		]]]);

		if(!$user) {
			return false;
		} else if ($lastPassword != $user[0]->password) {
			return false;
		}

		$password = hash('sha256', $_POST['password']);

		$req = $this->pdo->prepare('UPDATE 
			candid_users 
			SET password=:password 
			WHERE id=:id'
		);

		$req->execute([
			'password'  => $password,
			'id'	 	=> $_SESSION['user']->id,
		]);

		$_SESSION['user']->password = $password;
		return true;
	}

	public function delete($id) {
		$user = $this->find([
			'where' => [
				'request' => 'id=:id',
				'datas'   => [
					'id' => $id
		]]]);

		if($user[0]->username == null) {
			return false;
		}

		$req = $this->pdo->prepare('DELETE FROM candid_users WHERE id=:id');
		$req->execute([
			'id' => $id
		]);
		return true;
	}

}


?>