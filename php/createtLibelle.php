<?php
	// SET HEADER
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: access");
	header("Access-Control-Allow-Methods: POST");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	// INCLUDING DATABASE AND MAKING OBJECT
	require 'database.php';
	$db_connection = new Database('stocks','127.0.0.1','root','' );
	$conn = $db_connection->connect();
	
	// GET DATA FORM REQUEST
	$data = json_decode(file_get_contents("php://input"));
	
	//CREATE MESSAGE ARRAY AND SET EMPTY
	$msg['message'] = '';
	
	// CHECK IF RECEIVED DATA FROM THE REQUEST
	if(isset($data->nom) && isset($data->tEmplacementFK))
	{
		 // CHECK DATA VALUE IS EMPTY OR NOT
		 if(!empty($data->nom)&&!empty($data->tEmplacementFK)){
			 $insert_query = "INSERT INTO tlibelle(nom,tEmplacementFK) VALUES(:nom,:tEmplacementFK)";
			 $insert_stmt = $conn->prepare($insert_query);
			 
			 // DATA BINDING
			 $insert_stmt->bindValue(':nom', htmlspecialchars(strip_tags($data->nom)),PDO::PARAM_STR);
			 $insert_stmt->bindValue(':tEmplacementFK', htmlspecialchars(strip_tags($data->tEmplacementFK)),PDO::PARAM_STR);
			 if($insert_stmt->execute()){
				$msg['message'] = 'Data Inserted Successfully';
			 }else{
				$msg['message'] = 'Data not Inserted';
			 }
		 }else{
			$msg['message'] = 'Oops! empty field detected. Please fill all the fields';
		 }
	}
	else{
	 $msg['message'] = 'Please fill all the fields | title, body, author';
	}
	//ECHO DATA IN JSON FORMAT
	echo json_encode($msg);
?>
