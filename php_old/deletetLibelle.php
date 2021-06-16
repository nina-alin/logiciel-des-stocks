<?php

	// SET HEADER
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: access");
	header("Access-Control-Allow-Methods: DELETE");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	// INCLUDING DATABASE AND MAKING OBJECT
	require 'database.php';
	$db_connection = new Database('stocks','127.0.0.1','root','' );
	$conn = $db_connection->connect();
	
	// GET DATA FORM REQUEST
	$data = json_decode(file_get_contents("php://input"));
			
	if(isset($data->tLibellePK))
	{
		$msg['message'] = '';
		$post_id = $data->tLibellePK;
		 

		$delete_query = "DELETE FROM tlibelle WHERE tLibellePK = :tLibellePK";
		$delete_stmt = $conn->prepare($delete_query);
		$delete_stmt->bindValue(':tLibellePK', $post_id,PDO::PARAM_INT);
		 
		 

		if($delete_stmt->execute()){
			$msg['message'] = 'Données modifiées avec succès';
		} else {
			$msg['message'] = 'Données non modifiées';
		}
	} else {
		$msg['message'] = 'ID invalide';
	}
	echo json_encode($msg);
	
?>