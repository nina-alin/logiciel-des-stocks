<?php
/**
 * Description de la Classe bdd
 *
 * @author Sylvain PETIT
 * @date 24/09/10
 * @update 19/02/13
 */
if (file_exists("./config.php"))
	include_once("./config.php");
else if (file_exists("../libs/config.php"))
	include_once "../libs/config.php";
else if (file_exists("../../config.php"))
	include_once "../../config.php";
else if (file_exists("libs/config.php"))
	include_once "libs/config.php";
else if (file_exists('../config.php'))
	include_once "../config.php";
else die("Fichier config introuvable");

class bdd {
    private $host;
    private $user;
    private $mdp;
    private $port;
    private $cnx;
    private $result;
    private $bdd;

    /**
	 * Constructeur
	 * Instancie et créer une connexion à la base 
	 */
	public function __construct($base){

		global $BDD_host;
		global $BDD_user;
		global $BDD_password;

        $this->host = $BDD_host;
        $this->port = '3306';
        $this->cnx  = '';
        $this->user = $BDD_user;
        $this->mdp  = $BDD_password;
        $this->bdd  = $base;
        $this->result = '';
        
        /**
		 * Connexion
		 */
        $dsn = 'mysql:dbname='. $this->bdd . ';host=' . $this->host;
        try {
            $this->cnx = new PDO($dsn, $this->user, $this->mdp);
        }
        catch(Exception $e){
            echo "Echec : " . $e->getMessage();
        }
    }
	
	/**
	 * Request
	 */
    public function requete($req,$type){
        $this->cnx->prepare($req);
        if ($type == "select") {
            $this->result = $this->cnx->query($req);
            //var_dump($this->result);
            if ($this->result){
            	return $this->result->fetchAll(PDO::FETCH_OBJ);
            }else{
            	return FALSE;
            }
        }
        else {
            $result = $this->cnx->exec($req); //retourne le nb d'affectation
            if($result == false){
                return false;
            }elseif($type == "insert"){
                return $this->cnx->lastInsertId();
            }else
                return true;
        }
    }
	
    /**
	 * Constructeur
	 * Destruit l'instance et se deconnecte de la base 
	 */
	/*public function  __destruct() {
        $this->result->closeCursor();
        //echo 'Connexion à la base "' . $this->bdd . '" terminée';
    }*/
	
	/**
	 * Retourne l'identifiant généré dans d'un Insert
	 */
    public function lastInsertId() {
        return $this->cnx->lastInsertId();
    }
    
	/**
	 * Debute une transaction
	 */
    public function beginTransaction() {
        return $this->cnx->beginTransaction();
    }
    
    /**
	 * Annule une transaction
	 */
	public function rollBack() {
        return $this->cnx->rollBack();
    }  
}
?>
