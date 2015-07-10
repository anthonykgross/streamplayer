<?php

class Bdd {

    static public function getConnect() {
        $pdo = new PDO(DB_DSN, DB_USER, DB_MDP);
        
	if(MODE_DEBUG){
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);	
	}
        return $pdo;
    }

}

?>
