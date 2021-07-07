<?php

include 'connect.php';


// POST
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        $nomModele = $_POST['nomModele'];
        $compatibilite = $_POST['compatibilite'];
        $ttypeproduitsFK = $_POST['ttypeproduitsFK'];
        $tfabricantsFK = $_POST['tfabricantsFK'];
        $tlibellesFK = $_POST['tlibellesFK'];

        // Encodage des guillemets / apostrophes
        $nomModele = addslashes($nomModele);
        $compatibilite = addslashes($compatibilite);

        // on envoie la requête
        $sql = "INSERT INTO `tcaracteristiquesproduits`(`nomModele`, `compatibilite`, `ttypeproduitsFK`, `tfabricantsFK`) VALUES ('$nomModele','$compatibilite','$ttypeproduitsFK','$tfabricantsFK')";;

        if (mysqli_query($conn, $sql)) {

            // on récupère l'id automatiquement créé par la dernière requête SQL
            $tcaracteristiquesproduitsFK = mysqli_insert_id($conn);

            // on insère dans la table tproduitsstockes une entrée avec quantite vide
            $sql = "INSERT INTO `tproduitsstockes`(`tlibellesFK`, `tcaracteristiquesproduitsFK`,`alerte`) VALUES ('$tlibellesFK','$tcaracteristiquesproduitsFK',1)";

            if (mysqli_query($conn, $sql)) {
                echo json_encode(array("statusCode" => 200));
            } else {
                echo mysqli_error($conn);
            }
            mysqli_close($conn);
        } else {
            echo mysqli_error($conn);
        }
    }
}

// UPDATE
if (count($_POST) > 0) {

    if ($_POST['type'] == 2) {

        $tcaracteristiquesproduitsPK = $_POST['tcaracteristiquesproduitsPK'];
        $tfabricantsFK = $_POST['tfabricantsFK'];
        $nomModele = $_POST['nomModele'];
        $ttypeproduitsFK = $_POST['ttypeproduitsFK'];
        $compatibilite = $_POST['compatibilite'];

        // Encodage des guillemets / apostrophes
        $nomModele = addslashes($nomModele);
        $compatibilite = addslashes($compatibilite);

        $sql = "UPDATE `tcaracteristiquesproduits` SET `nomModele`='$nomModele',`compatibilite`='$compatibilite',`ttypeproduitsFK`=$ttypeproduitsFK,`tfabricantsFK`=$tfabricantsFK WHERE `tcaracteristiquesproduitsPK`=$tcaracteristiquesproduitsPK;";

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

        $tcaracteristiquesproduitsPK = $_POST['tcaracteristiquesproduitsPK'];

        $sql = "DELETE FROM `tcaracteristiquesproduits` WHERE tcaracteristiquesproduitsPK=$tcaracteristiquesproduitsPK";

        if (mysqli_query($conn, $sql)) {
            echo $tcaracteristiquesproduitsPK;
        } else {
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}


// GET
if (count($_GET) > 0) {

    if ($_GET['type'] == 4) {

        $tcaracteristiquesproduitsPK = $_GET['tcaracteristiquesproduitsPK'];

        $sql = "SELECT * FROM tproduitsstockes JOIN tlibelles ON tproduitsstockes.tlibellesFK = tlibelles.tlibellesPK JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = tproduitsstockes.tcaracteristiquesproduitsFK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE tlibellesFK=$tcaracteristiquesproduitsPK ORDER BY nomFabricant, nomModele";

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
