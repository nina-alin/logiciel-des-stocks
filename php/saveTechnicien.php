<?php

include 'connect.php';

// GET
if (count($_GET) > 0) {
    if ($_GET['type'] == 4) {
        $ttechnicienFK = $_GET['ttechnicienPK'];
        $sql = "SELECT * FROM `tentrees` JOIN ttechnicien ON tentrees.ttechnicienFK = ttechnicien.ttechnicienPK JOIN tproduitsstockes ON tproduitsstockes.tproduitsstockesPK = tentrees.tproduitsstockeFK JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = tproduitsstockes.tcaracteristiquesproduitsFK JOIN ttypeproduits ON tcaracteristiquesproduits.ttypeproduitsFK = ttypeproduits.ttypeproduitsPK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK JOIN tlibelles ON tproduitsstockes.tlibellesFK = tlibelles.tlibellesPK JOIN templacements ON templacements.templacementsPK = tlibelles.templacementsFK JOIN tcommandes ON tentrees.tcommandesFK = tcommandes.tcommandesPK WHERE ttechnicienFK=$ttechnicienFK ORDER BY dateCommande";
        $result = mysqli_query($conn, $sql);
        $output = '';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '  
                  <tr>  
                       <td>' . $row["nomFabricant"] . '</td>   
                       <td>' . $row["nomModele"] . '</td> 
                       <td>' . $row["nomTypeProduit"] . '</td> 
                       <td>' . $row["quantiteEntree"] . '</td> 
                       <td>' . $row["nomEmplacement"] . ' - ' . $row["nomLibelle"] . '</td>   
                  </tr> 
             ';
        }
        echo $output;
    }
}

// POST
if (count($_POST) > 0) {
    if ($_POST['type'] == 1) {
        $nomTechnicien = $_POST['nomTechnicien'];
        $prenomTechnicien = $_POST['prenomTechnicien'];
        $fonction = $_POST['fonction'];
        $toujoursService = $_POST['toujoursService'];
        $sql = "INSERT INTO `ttechnicien`(`nomTechnicien`,`prenomTechnicien`,`fonction`,`toujoursService`) 
		VALUES ('$nomTechnicien','$prenomTechnicien','$fonction','$toujoursService')";
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
        $ttechnicienPK = $_POST['ttechnicienPK'];
        $nomTechnicien = $_POST['nomTechnicien'];
        $prenomTechnicien = $_POST['prenomTechnicien'];
        $fonction = $_POST['fonction'];
        $toujoursService = $_POST['toujoursService'];
        $sql = "UPDATE `ttechnicien` SET `nomTechnicien` = '$nomTechnicien', `prenomTechnicien` = '$prenomTechnicien',`fonction` = '$fonction',`toujoursService` = '$toujoursService' WHERE `ttechnicienPK` = $ttechnicienPK;";
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
        $ttechnicienPK = $_POST['ttechnicienPK'];
        $sql = "DELETE FROM `ttechnicien` WHERE ttechnicienPK=$ttechnicienPK ";
        if (mysqli_query($conn, $sql)) {
            echo $ttechnicienPK;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}
