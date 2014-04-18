<?php 

require('Condition.php');

class Candid extends Condition {

	private $opt = array(
		'invalid_age'	 => "Votre age n'est pas valide",
		'empty_contact'  => "Veuillez indiquez le champ Adresse email ou skype",
		'empty_content'	 => "Veuillez indiquez le champ Présentation",
		'empty_dispo'	 => "Veuillez indiquez le champ Disponibilité",
		'empty_required' => "Veuillez indiquez le champ Requis",
		'age_inferior'	 => "Vous n'avez pas l'age requis",
	);

	public $errors = array();

	protected $pdo;
	public $isConnected;
	private $cond;

	public function __construct($pdo) {
		$this->pdo = $pdo;
		$this->isConnected = $this->isConnected();
		$cond = new Condition($pdo);
	}

	/**
	*  Permet de sauvegarder une candidature
	**/
	public function save($options = array()) {
		if(preg_match("#[^0-9]#", $_POST['age'])) {
			$this->errors['invalid_age'] = $this->opt['invalid_age'];
		}
		if(empty($_POST['contact'])) {
			$this->errors['empty_contact'] = $this->opt['empty_contact'];
		}
		if(empty($_POST['age'])) {
			$this->errors['empty_age'] = $this->opt['empty_age'];
		}
		if($_POST['age'] < 16) {
			$this->errors['age_inferior'] = $this->opt['age_inferior'];
		}
		if(empty($_POST['content'])) {
			$this->errors['empty_content'] = $this->opt['empty_content'];
		}
		if(empty($_POST['dispo'])) {
			$this->errors['empty_dispo'] = $this->opt['empty_dispo'];
		}
		if(empty($_POST['required'])) {
			$this->errors['empty_required'] = $this->opt['empty_required'];
		}
		if(count($this->errors) > 0) {
			return false;
		}

		$vars = array(
			'contact' 	=> $this->security($_POST['contact']),
			'age'		=> $this->security(intval($_POST['age'])),
			'content'	=> $this->security($_POST['content']),
			'dispo'		=> $this->security($_POST['dispo']),
			'required'	=> $this->security($_POST['required']),
		);

		$req = $this->pdo->prepare('INSERT INTO
			candid_candids(contact, age, content, dispo, required)
			VALUES(?, ?, ?, ?, ?)
		');

		$req->execute([
			$vars['contact'],
			$vars['age'],
			$vars['content'],
			$vars['dispo'],
			$vars['required']
		]);
		return true;
	}

	public function editState($id, $state = 0) {

		$candid = $this->find(['where' => ['request' => 'id=:id', 'datas' => ['id' => $id]]]);

		if($candid[0]->contact == null) {
			return false;
		}

		$req = $this->pdo->prepare('UPDATE candid_candids SET state=:state WHERE id=:id');
		$req->execute([
			'state' => $state,
			'id' 	=> $id
		]);
		return true;
	}

	public function find($options = array()) {
		if(!isset($options['where'])) {
			$options['where']['request'] = "";
			$options['where']['datas'] = [];
		}
		$req = $this->pdo->prepare('SELECT * FROM candid_candids WHERE '. $options['where']['request']);
		$req->execute($options['where']['datas']);
		return $req->fetchAll();
	}

}

?>