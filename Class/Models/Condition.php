<?php 

require('Model.php');

class Condition extends Model {

	public function __construct($bdd) {
		$this->pdo = $bdd;
	}

	public function edit($type) {
		if(empty($_POST['content'])) {
			return false;
		}
		$req = $this->pdo->prepare('UPDATE 
			candid_conditions 
			SET content=:content 
			WHERE rank=:rank'
		);
		$req->execute(array(
			'rank' 		=> $type,
			'content' 	=> $this->security($_POST['content'])
 		));

 		return true;
	}

	public function findByRank($rank, $nl = false) {
		$req = $this->pdo->prepare('SELECT * FROM candid_conditions WHERE rank=:rank');
		$req->execute([
			'rank' => $rank,
		]);
		$condition = $req->fetchAll();
		if(!isset($condition[0])) {
			return false;
		}

		if($nl) {
			$condition[0]->content = nl2br($condition[0]->content);
		}

		return $condition[0];
	}

	public function findAll() {
		$req = $this->pdo->query('SELECT * FROM candid_conditions');
		$conditions = $req->fetchAll();
		return $conditions;
	}

}