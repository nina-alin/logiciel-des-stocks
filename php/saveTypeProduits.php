<?php

include 'connect.php';

// POST
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        $nomTypeProduit = $_POST['nomTypeProduit'];

        // Encodage des guillemets / apostrophes
        $nomTypeProduit = addslashes($nomTypeProduit);

        $sql = "INSERT INTO `ttypeproduits`(`nomTypeProduit`) VALUES ('$nomTypeProduit')";

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

        $ttypeproduitsPK = $_POST['ttypeproduitsPK'];
        $nomTypeProduit = $_POST['nomTypeProduit'];

        // Encodage des guillemets / apostrophes
        $nomTypeProduit = addslashes($nomTypeProduit);

        $sql = "UPDATE `ttypeproduits` SET `nomTypeProduit` = '$nomTypeProduit' WHERE `ttypeproduits`.`ttypeproduitsPK` = $ttypeproduitsPK;";

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

        $ttypeproduitsPK = $_POST['ttypeproduitsPK'];

        $sql = "DELETE FROM `ttypeproduits` WHERE ttypeproduitsPK=$ttypeproduitsPK ";

        if (mysqli_query($conn, $sql)) {
            echo $ttypeproduitsPK;
        } else {
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// GET
if (count($_GET) > 0) {

    if ($_GET['type'] == 4) {

        $ttypeproduitsFK = $_GET['ttypeproduitsPK'];

        $sql = "SELECT * FROM tproduitsstockes JOIN tlibelles ON tproduitsstockes.tlibellesFK = tlibelles.tlibellesPK JOIN templacements ON tlibelles.templacementsFK = templacements.templacementsPK JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = tproduitsstockes.tcaracteristiquesproduitsFK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE ttypeproduitsFK=$ttypeproduitsFK ORDER BY nomFabricant, nomModele";

        $result = mysqli_query($conn, $sql);
        $output = '';

        while ($row = mysqli_fetch_array($result)) {
            if ($row["quantite"] < 4 && $row["quantite"] != null && $row["alerte"] == 1) {
                $output .= '<tr style="background-color: #ffbdbd;">'; // on affiche les lignes du tableau en rouge si la quantité est trop basse
            } else {
                $output .= '<tr>';
            }
            $output .= '
                       <td>' . $row["nomFabricant"] . '</td>   
                       <td>' . $row["nomModele"] . '</td>  
                       <td>' . $row["quantite"] . '</td>  
                       <td>' . $row["nomLibelle"] . ' - ' . $row["nomEmplacement"] . '</td>    
                  </tr> 
             ';
        }
        echo $output;
    }
}
