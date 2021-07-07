<?php

include 'connect.php';

// GET
if (count($_GET) > 0) {

    if ($_GET['type'] == 4) {

        $tcommandesFK = $_GET['tcommandesPK'];

        $sql = "SELECT * FROM tentrees JOIN tcommandes ON tcommandes.tcommandesPK = tentrees.tcommandesFK JOIN tproduitsstockes ON tentrees.tproduitsstockeFK = tproduitsstockes.tproduitsstockesPK JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = tproduitsstockes.tcaracteristiquesproduitsFK JOIN ttypeproduits ON tcaracteristiquesproduits.ttypeproduitsFK=ttypeproduits.ttypeproduitsPK JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK JOIN ttechnicien ON ttechnicien.ttechnicienPK = tentrees.ttechnicienFK WHERE tcommandesFK=$tcommandesFK";

        $result = mysqli_query($conn, $sql);
        $output = '';

        while ($row = mysqli_fetch_array($result)) {
            $output .= '  
                  <tr>  
                       <td>' . $row["nomFabricant"] . '</td>   
                       <td>' . $row["nomModele"] . '</td>   
                       <td>' . $row["quantiteEntree"] . '</td>   
                       <td>' . $row["prenomTechnicien"] . ' ' . $row["nomTechnicien"] . '</td>  
                  </tr> 
             ';
        }
        echo $output;
    }
}

// POST
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        $numeroCommande = $_POST['numeroCommande'];
        $dateCommande = $_POST['dateCommande'];
        $arrivee = $_POST['arrivee'];

        // Encodage des guillemets / apostrophes
        $numeroCommande = addslashes($numeroCommande);

        $sql = "INSERT INTO `tcommandes`(`numeroCommande`, `dateCommande`, `arrivee`) VALUES ($numeroCommande,'$dateCommande',$arrivee)";

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

        $tcommandesPK = $_POST['tcommandesPK'];
        $numeroCommande = $_POST['numeroCommande'];
        $dateCommande = $_POST['dateCommande'];
        $arrivee = $_POST['arrivee'];

        // Encodage des guillemets / apostrophes
        $numeroCommande = addslashes($numeroCommande);

        $sql = "UPDATE `tcommandes` SET `numeroCommande`=$numeroCommande,`dateCommande`='$dateCommande',`arrivee`=$arrivee WHERE `tcommandesPK`=$tcommandesPK";

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

        $tcommandesPK = $_POST['tcommandesPK'];

        $sql = "DELETE FROM `tcommandes` WHERE tcommandesPK=$tcommandesPK";

        if (mysqli_query($conn, $sql)) {
            echo $tcommandesPK;
        } else {
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}
