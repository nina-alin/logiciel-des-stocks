<?php
/**
 * Description de la Classe ad (Active Directory)
 *
 * @author Sylvain PETIT
 * @date 05/10/16
 * @update 06/10/16
 * @update 29/06/21
 */
if (file_exists("./config.php"))
	include_once("./config.php");
else if (file_exists("../config.php"))
	include_once "../config.php";
else if (file_exists("../../config.php"))
	include_once "../../config.php";
else die("Fichier config introuvable");

class ad {
	
	private $host;
	private $login;
	private $mdp;
	private $ldapconn;
	private $ldapbind;
	private $authenticate;
	private $nom;
	private $mail;
	private $uid;
	private $group;
	
	/**
	 * Constructeur
	 * Instancie et bind le serveur AD
	 */
	public function __construct(){
		global $LDAP_host;
		
		$this->host = $LDAP_host;
		$this->authenticate = FALSE;
		
		try {
			$this->ldapconn = @ldap_connect($this->host);
		}
		catch(Exception $e){
            echo "Echec de connexion au serveur AD : " . $e->getMessage();
        }
        
        
	}
	
	public function __destruct(){
		
		ldap_close($this->ldapconn);
	}

	/**
	 * @param String $samAccountName
	 * @param String $password
	 * @return bool
	 */
	public function bindUser(String $samAccountName, String $password): bool
	{
		if(@ldap_bind($this->ldapconn, $samAccountName . "@crous-lille.fr", $password))
			return true;

		return false;
	}
	
	
	/**
	 * Authentification au serveur AD
	 */
	public function authenticate(): bool
	{
		global $LDAP_user;
		global $LDAP_password;

		$this->login = $LDAP_user;
		$this->mdp = $LDAP_password;
		
		// Gestion des id en prenom.nom et prenom.nom@crous-lille.fr
		$l= explode("@", $this->login);
		$this->login = trim($l[0]);
		$this->mdp = trim($this->mdp);
		
		// Authentification au serveur AD
		$this->ldapbind = @ldap_bind($this->ldapconn, $this->login.'@crous-lille.fr', $this->mdp);
		
		if($this->ldapbind){
			return $this->authenticate = TRUE;
		}else{
			return $this->authenticate = FALSE;
		}
	}
	
	
	/**
	 * Recuperation des informations dans le serveur AD
	 */
	public function getEntries() {
		
		$attributes = array("displayname", "mail", "samaccountname", "memberof");
		
		if ($this->authenticate){
			$sr=ldap_search($this->ldapconn,"ou=SERVICES CENTRAUX,dc=crous-lille,dc=fr", "samaccountname=".$this->login, $attributes);

			$info = ldap_get_entries($this->ldapconn, $sr);
			//krumo($info);
			$this->nom = $info[0]["displayname"][0];
			$this->mail = $info[0]["mail"][0];
			$this->uid = $info[0]["samaccountname"][0];
			$this->group = $info[0]["memberof"];
		}else{
			return FALSE;
		}
		return true;
	}

	/**
	 * Authentification au serveur AD
	 */
	public function authenticate_o365() {
		global $LDAP_user;
		global $LDAP_password;

		$this->login = $LDAP_user;
		$this->mdp = $LDAP_password;
	
		// Gestion des id en prenom.nom et prenom.nom@crous-lille.fr
		$l= explode("@", $this->login);
		$this->login = trim($l[0]);
		$this->mdp = trim($this->mdp);
	
		// Authentification au serveur AD
		$this->ldapbind = @ldap_bind($this->ldapconn, $this->login.'@crous-lille.fr', $this->mdp);
	
		if($this->ldapbind){
			return $this->authenticate = TRUE;
		}else{
			return $this->authenticate = FALSE;
		}
	}

	
	/**
	 * Recuperation des informations dans le serveur AD
	 */
	public function getEntriesOf($login) {
		
		$l= explode("@", $login);
		$login = trim($l[0]);
		
		$attributes = array("displayname", "mail", "samaccountname", "memberof");
		
		//LISTE DES UGS DANS L'AD
		$ugs = array("ARTOIS", "inconnus","LILLE1","LILLE2","LILLE3","LITTORAL","SERVICES CENTRAUX","VALENCIENNES", "VEILLEURS", "GROUPES-DISTRIB", "CAISSES");
		
		if ($this->authenticate){
			
			//POUR CHAQUE UG ON RECHERCHE SI LA PERSONNE EXISTE
			foreach ($ugs as $line)
			{
				$sr=ldap_search($this->ldapconn,"ou=".$line.",dc=crous-lille,dc=fr", "mail=".$login."@crous-lille.fr", $attributes);
				
				$info = ldap_get_entries($this->ldapconn, $sr);
				//krumo($info);
				@$displayName = $info[0]["displayname"][0];
				//SI L'INFORMATION displayname ALORS ON PEUT ECRIRE TOUTE LES INFOS (Evite de réécrire du vide une fois trouvé)
				if($displayName)
				{
					$this->nom = $info[0]["displayname"][0];
					$this->mail = $info[0]["mail"][0];
					$this->uid = $info[0]["samaccountname"][0];
					$this->group = $info[0]["memberof"];
					break;
				}
			}
		}else{
			return FALSE;
		}

		return true;
	}

	
	/**
	 * Recuperation du Nom (displayname) dans le serveur AD
	 */
	public function getNom($j) {
		return $this->nom[$j];
	}
	
	/**
	 * Recuperation du Mail dans le serveur AD
	 */
	public function getMail($j) {
		return $this->mail[$j];
	}
	
	/**
	 * Recuperation du Login (samaccountname) dans le serveur AD
	 */
	public function getUId($j) {
		return $this->uid[$j];
	}
	
	/**
	 * Recuperation du (des) groupe(s) auquel(s) il appartient
	 */
	public function getGroup($j) {
		return $this->group[$j];
	}
	
	/**
	 * Verifie s'il appartient au groupe
	 */
	public function checkGroup($nom_group) {
		foreach ($this->group as $group)
		{
			if($group == $nom_group)
				return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Recuperation du Nom (displayname) dans le serveur AD
	 */
	public function getNomPrenom() {
		return $this->nom;
	}
	
	/**
	 * Recuperation du Nom (displayname) dans le serveur AD
	 */
	public function getMonGroupe() {
		return $this->group;
	}
	
	/**
	 * Recuperation du Mail dans le serveur AD
	 */
	public function getAdressMail() {
		return $this->mail;
	}

	/**
	 * Recuperation des groupes dans le serveur AD
	 */
	public function getGroupe() {		
		return $this->group;
	}
}
?>
