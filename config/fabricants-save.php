<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

// POST
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        $nomFabricant = $_POST['nomFabricant'];

        // Encodage des guillemets / apostrophes
        $nomFabricant = addslashes($nomFabricant);

        $sql = "INSERT INTO `tfabricants`(`nomFabricant`) VALUES ('$nomFabricant')";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// UPDATE
if (count($_POST) > 0) {

    if ($_POST['type'] == 2) {

        $tfabricantsPK = $_POST['tfabricantsPK'];
        $nomFabricant = $_POST['nomFabricant'];

        // Encodage des guillemets / apostrophes
        $nomFabricant = addslashes($nomFabricant);

        $sql = "UPDATE `tfabricants` SET `nomFabricant` = '$nomFabricant' WHERE `tfabricants`.`tfabricantsPK` = $tfabricantsPK;";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// DELETE
if (count($_POST) > 0) {

    if ($_POST['type'] == 3) {

        $tfabricantsPK = $_POST['tfabricantsPK'];

        $sql = "DELETE FROM `tfabricants` WHERE tfabricantsPK=$tfabricantsPK ";

        if (mysqli_query($conn, $sql)) {
            echo $tfabricantsPK;
        } else {
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// GET
if (count($_GET) > 0) {

    if ($_GET['type'] == 4) {

        $tfabricantsPK = $_GET['tfabricantsPK'];

        $sql = "SELECT * FROM tproduitsstockes JOIN tlibelles ON tproduitsstockes.tlibellesFK = tlibelles.tlibellesPK JOIN templacements ON tlibelles.templacementsFK = templacements.templacementsPK JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = tproduitsstockes.tcaracteristiquesproduitsFK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE tfabricantsFK=$tfabricantsPK ORDER BY nomModele";

        $result = mysqli_query($conn, $sql);
        $output = '';

        while ($row = mysqli_fetch_array($result)) {
            if ($row["quantite"] < 4 && $row["quantite"] != null && $row["alerte"] == 1) { // on affiche la ligne en rouge si la quantité est trop basse
                $output .= '<tr style="background-color: #ffbdbd;">';
            } else {
                $output .= '<tr>';
            }

            $output .= '
                       <td>' . $row["nomModele"] . '</td>  
                       <td>' . $row["nomTypeProduit"] . '</td>   
                       <td>' . $row["quantite"] . '</td>  
                       <td>' . $row["nomLibelle"] . ' - ' . $row["nomEmplacement"] . '</td>    
                  </tr> 
             ';
        }

        echo $output;
    }
}
