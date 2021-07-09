<?php

include 'connect.php';

// POST
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        $nomLieuSortie = $_POST['nomLieuSortie'];
        $tunitegestionFK = $_POST['tunitegestionFK'];

        // Encodage des guillemets / apostrophes
        $nomLieuSortie = addslashes($nomLieuSortie);

        $sql = "INSERT INTO `tlieusortie`(`nomLieuSortie`, `tunitegestionFK`) VALUES ('$nomLieuSortie','$tunitegestionFK')";

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

        $tlieusortiePK = $_POST['tlieusortiePK'];
        $nomLieuSortie = $_POST['nomLieuSortie'];
        $tunitegestionFK = $_POST['tunitegestionFK'];

        // Encodage des guillemets / apostrophes
        $nomLieuSortie = addslashes($nomLieuSortie);

        $sql = "UPDATE `tlieusortie` SET `nomLieuSortie`='$nomLieuSortie',`tunitegestionFK`='$tunitegestionFK' WHERE tlieusortiePK=$tlieusortiePK";

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

        $tlieusortiePK = $_POST['tlieusortiePK'];

        $sql = "DELETE FROM `tlieusortie` WHERE tlieusortiePK=$tlieusortiePK";

        if (mysqli_query($conn, $sql)) {
            echo $tlieusortiePK;
        } else {
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// GET
if (count($_GET) > 0) {

    if ($_GET['type'] == 4) {

        $tlieusortiePK = $_GET['tlieusortiePK'];

        $sql = "SELECT * FROM `tsorties` JOIN tcaracteristiquesproduits ON tsorties.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK JOIN ttechnicien ON tsorties.ttechnicienFK = ttechnicien.ttechnicienPK WHERE `tlieusortieFK`=$tlieusortiePK ORDER BY dateSortie DESC";

        $result = mysqli_query($conn, $sql);
        $output = '';

        while ($row = mysqli_fetch_array($result)) {
            $output .= '<tr>
                       <td>' . $row["nomFabricant"] . '&nbsp;' . $row["nomModele"] . '</td>  
                       <td>' . $row["nomTypeProduit"] . '</td>  
                       <td>' . $row["raisonSortie"] . '</td>    
                       <td>' . $row["quantiteSortie"] . '</td>  
                       <td>' . $row["prenomTechnicien"] . '&nbsp;' . $row["nomTechnicien"] . '</td>  
                  </tr> 
             ';
        }
        echo $output;
    }
}
