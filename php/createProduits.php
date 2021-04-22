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
	if(isset($data->nom) && isset($data->lieu) && isset($data->categorie) && isset($data->marque) && isset($data->compatibilite) && isset($data->code) && isset($data->quantite) && isset($data->numeroSerie))
	{
	 // CHECK DATA VALUE IS EMPTY OR NOT
	 if(!empty($data->nom) ) {
	 $insert_query = "INSERT INTO produits(nom,lieu,categorie,marque,compatibilite,code,quantite,numeroSerie) VALUES(:nom,:lieu,:categorie,:marque,:compatibilite,:code,:quantite,:numeroSerie)";
	 $insert_stmt = $conn->prepare($insert_query);

	 // DATA BINDING
	 $insert_stmt->bindValue(':nom', htmlspecialchars(strip_tags($data->nom)), PDO::PARAM_STR);
	 $insert_stmt->bindValue(':lieu', htmlspecialchars(strip_tags($data->lieu)), PDO::PARAM_STR);
	 $insert_stmt->bindValue(':categorie', htmlspecialchars(strip_tags($data->categorie)), PDO::PARAM_STR);
	 $insert_stmt->bindValue(':marque', htmlspecialchars(strip_tags($data->marque)), PDO::PARAM_STR);
	 $insert_stmt->bindValue(':compatibilite', htmlspecialchars(strip_tags($data->compatibilite)), PDO::PARAM_STR);
	 $insert_stmt->bindValue(':code', htmlspecialchars(strip_tags($data->code)), PDO::PARAM_STR);
	 $insert_stmt->bindValue(':quantite', htmlspecialchars(strip_tags($data->quantite)), PDO::PARAM_STR);
	 $insert_stmt->bindValue(':numeroSerie', htmlspecialchars(strip_tags($data->numeroSerie)), PDO::PARAM_STR);

	 if($insert_stmt->execute()){
	 $msg['message'] = 'Data Inserted Successfully';
	 }else{
	 $msg['message'] = 'Data not Inserted';
	 }
	 }else
	 {
	 $msg['message'] = 'Oops! empty field detected. Please fill all the fields';
	 }
	}
	else
	{
	 $msg['message'] = 'Please fill all the fields';
	}
	//ECHO DATA IN JSON FORMAT
	echo json_encode($msg);
?>