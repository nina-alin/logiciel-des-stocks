<?php

	// SET HEADER
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: access");
	header("Access-Control-Allow-Methods: PUT");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	// INCLUDING DATABASE AND MAKING OBJECT
	require 'database.php';
	$db_connection = new Database('stocks','127.0.0.1','root','' );
	$conn = $db_connection->connect();
	
	// GET DATA FORM REQUEST
	$data = json_decode(file_get_contents("php://input"));
	
	//CHECKING, IF ID AVAILABLE ON $data
	if(isset($data->tLibellePK)) {
		$msg['message'] = '';
		$post_id = $data->tLibellePK;

		//GET POST BY ID FROM DATABASE
		$get_post = "SELECT * FROM tlibelle WHERE tLibellePK=:post_id";
		$get_stmt = $conn->prepare($get_post);
		$get_stmt->bindValue(':post_id', $post_id,PDO::PARAM_INT);
		$get_stmt->execute();
		
		//CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
		if($get_stmt->rowCount() > 0) {
			// FETCH POST FROM DATBASE
			$row = $get_stmt->fetch(PDO::FETCH_ASSOC);
			
			// CHECK, IF NEW UPDATE REQUEST DATA IS AVAILABLE THEN SET IT OTHERWISE SET OLD DATA
			$nom = isset($data->nom) ? $data->nom : $row['nom'];
			$tEmplacementFK = isset($data->tEmplacementFK) ? $data->tEmplacementFK : $row['tEmplacementFK'];
			$update_query = "UPDATE tlibelle SET nom = :nom, tEmplacementFK = :tEmplacementFK WHERE tLibellePK = :tLibellePK";
			$update_stmt = $conn->prepare($update_query);

			// DATA BINDING AND REMOVE SPECIAL CHARS AND REMOVE TAGS
			$update_stmt->bindValue(':nom', htmlspecialchars(strip_tags($nom)),PDO::PARAM_STR);
			$update_stmt->bindValue(':tEmplacementFK', htmlspecialchars(strip_tags($tEmplacementFK)),PDO::PARAM_STR);
			$update_stmt->bindValue(':tLibellePK', $post_id,PDO::PARAM_INT);

			if($update_stmt->execute()){
				$msg['message'] = 'Données modifiées avec succès';
			} else { 
				$msg['message'] = 'Données non modifiées';
			}
		}
		else{
			$msg['message'] = 'ID invalide';
		}
		echo json_encode($msg);
	}
	
?>