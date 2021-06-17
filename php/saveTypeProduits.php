<?php

include 'connect.php';

// POST
if (count($_POST) > 0) {
    if ($_POST['type'] == 1) {
        $nomTypeProduit = $_POST['nomTypeProduit'];
        $sql = "INSERT INTO `ttypeproduits`(`nomTypeProduit`) 
		VALUES ('$nomTypeProduit')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// UPDATE
if (count($_POST) > 0) {
    if ($_POST['type'] == 2) {
        $ttypeproduitsPK = $_POST['ttypeproduitsPK'];
        $nomTypeProduit = $_POST['nomTypeProduit'];
        $sql = "UPDATE `ttypeproduits` SET `nomTypeProduit` = '$nomTypeProduit' WHERE `ttypeproduits`.`ttypeproduitsPK` = $ttypeproduitsPK;";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// DELETE
if (count($_POST) > 0) {
    if ($_POST['type'] == 3) {
        $ttypeproduitsPK = $_POST['ttypeproduitsPK'];
        $sql = "DELETE FROM `ttypeproduits` WHERE ttypeproduitsPK=$ttypeproduitsPK ";
        if (mysqli_query($conn, $sql)) {
            echo $ttypeproduitsPK;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// GET
if (count($_POST) > 0) {
    if ($_POST['type'] == 4) {
        $ttypeproduitsPK = $_POST['ttypeproduitsPK'];
        $sql = "SELECT * FROM tproduitsstockes JOIN tlibelles ON tproduitsstockes.tlibellesFK = tlibelles.tlibellesPK JOIN tproduits ON tproduitsstockes.tproduitsFK = tproduits.tproduitsPK JOIN tcaracteristiquesproduits ON tproduits.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN tmarques ON tmarques.tmarquesPK = tcaracteristiquesproduits.tmarquesFK JOIN templacements ON templacements.templacementsPK = tlibelles.templacementsFK WHERE ttypeproduitsPK=$ttypeproduitsPK ";
        if (mysqli_query($conn, $sql)) {
            $posts_array = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $post_data = [
                    'nomModele' => html_entity_decode($row['nomModele']),
                    'nomMarque' => html_entity_decode($row['nomMarque']),
                    'nomEmplacement' => html_entity_decode($row['nomEmplacement']),
                ];
                // PUSH POST DATA IN OUR $posts_array ARRAY
                array_push($posts_array, $post_data);
            }
            //SHOW POST/POSTS IN JSON FORMAT
            echo json_encode($posts_array);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}
