
<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

// POST
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        $nomLibelle = $_POST['nomLibelle'];
        $templacementsFK = $_POST['templacementsFK'];

        // Encodage des guillemets / apostrophes
        $nomLibelle = addslashes($nomLibelle);

        $sql = "INSERT INTO `tlibelles`(`nomLibelle`, `templacementsFK`) VALUES ('$nomLibelle','$templacementsFK')";

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

        $tlibellesPK = $_POST['tlibellesPK'];
        $nomLibelle = $_POST['nomLibelle'];
        $templacementsFK = $_POST['templacementsFK'];

        // Encodage des guillemets / apostrophes
        $nomLibelle = addslashes($nomLibelle);

        $sql = "UPDATE `tlibelles` SET `nomLibelle`='$nomLibelle',`templacementsFK`='$templacementsFK' WHERE tlibellesPK=$tlibellesPK";

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

        $tlibellesPK = $_POST['tlibellesPK'];

        $sql = "DELETE FROM `tlibelles` WHERE tlibellesPK=$tlibellesPK";

        if (mysqli_query($conn, $sql)) {
            echo $tlibellesPK;
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}

// GET
if (count($_GET) > 0) {

    if ($_GET['type'] == 4) {

        $tlibellesFK = $_GET['tlibellesPK'];

        $sql = "SELECT * FROM tproduitsstockes JOIN tlibelles ON tproduitsstockes.tlibellesFK = tlibelles.tlibellesPK JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = tproduitsstockes.tcaracteristiquesproduitsFK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE tlibellesFK=$tlibellesFK ORDER BY nomFabricant, nomModele";

        $result = mysqli_query($conn, $sql);
        $output = '';

        while ($row = mysqli_fetch_array($result)) {
            if ($row["quantite"] < 4 && $row["quantite"] != null && $row["alerte"] == 1) { // si la quantité est trop basse, on affiche la ligne en rouge
                $output .= '<tr style="background-color: #ffbdbd;">';
            } else {
                $output .= '<tr>';
            }

            $output .= '
                       <td>' . $row["nomFabricant"] . '</td>   
                       <td>' . $row["nomModele"] . '</td>  
                       <td>' . $row["nomTypeProduit"] . '</td>    
                       <td>' . $row["quantite"] . '</td>  
                  </tr> 
             ';
        }

        echo $output;
    }
}
