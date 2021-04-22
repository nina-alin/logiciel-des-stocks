<?php
	// SET HEADER
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: access");
	header("Access-Control-Allow-Methods: GET");
	header("Access-Control-Allow-Credentials: true");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	// INCLUDING DATABASE AND MAKING OBJECT
	require 'database.php';
	$db_connection = new Database('stocks','127.0.0.1','root','' );
	$conn = $db_connection->connect();
	
	// CHECK GET ID PARAMETER OR NOT
	if(isset($_GET['id']))
	{
		 //IF HAS ID PARAMETER
		 $post_id = filter_var($_GET['id'], FILTER_VALIDATE_INT,[
			 'options' => [
				 'default' => 'all_posts',
				 'min_range' => 1
		 	]
		 ]);
		}
	else{
		$post_id = 'all_posts';
	}
	
	// MAKE SQL QUERY
	// IF GET POSTS ID, THEN SHOW POSTS BY ID OTHERWISE SHOW ALL POSTS
	if( is_numeric($post_id))
		$sql = "SELECT * FROM tlibelle INNER JOIN templacement ON tlibelle.tEmplacementFK = templacement.tEmplacementPK WHERE tLibellePK='$post_id'" ;
	else
		$sql = "SELECT * FROM tlibelle INNER JOIN templacement ON tlibelle.tEmplacementFK = templacement.tEmplacementPK"; // cas pour lequel : $post_id = 'all_posts';
	
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	
	//CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
	if($stmt->rowCount() > 0){
		 // CREATE POSTS ARRAY
		 $posts_array = [];
		 while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			 $post_data = [
			 'tLibellePK' => $row['tLibellePK'],
			 'nom' => html_entity_decode($row['nom']),
			 'tEmplacementFK' => html_entity_decode($row['tEmplacementFK']),
			 'nomEmplacement' => html_entity_decode($row['nomEmplacement'])
			 ];
			 // PUSH POST DATA IN OUR $posts_array ARRAY
			 array_push($posts_array, $post_data);
		 }
		 //SHOW POST/POSTS IN JSON FORMAT
		 echo json_encode($posts_array);
	}
	else{
	 //IF THER IS NO POST IN OUR DATABASE
	 echo json_encode(['message'=>'No post found']);
	}
?>