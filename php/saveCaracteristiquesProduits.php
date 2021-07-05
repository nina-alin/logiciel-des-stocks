<?php

include 'connect.php';

// POST
if (count($_POST) > 0) {
    if ($_POST['type'] == 1) {
        $nomModele = $_POST['nomModele'];
        $compatibilite = $_POST['compatibilite'];
        $codeProduit = $_POST['codeProduit'];
        $ttypeproduitsFK = $_POST['ttypeproduitsFK'];
        $tfabricantsFK = $_POST['tfabricantsFK'];
        $tlibellesFK = $_POST['tlibellesFK'];
        $sql = "INSERT INTO `tcaracteristiquesproduits`(`nomModele`, `compatibilite`, `codeProduit`, `ttypeproduitsFK`, `tfabricantsFK`) VALUES ('$nomModele','$compatibilite','$codeProduit','$ttypeproduitsFK','$tfabricantsFK')";;
        // il faudrait que ça crée également une entrée dans la table tproduitsstockes avec quantite = 0 pour éviter que l'utilisateur n'ait à le faire
        if (mysqli_query($conn, $sql)) {
            $tcaracteristiquesproduitsFK = mysqli_insert_id($conn);
            $sql = "INSERT INTO `tproduitsstockes`(`tlibellesFK`, `tcaracteristiquesproduitsFK`,`alerte`) VALUES ('$tlibellesFK','$tcaracteristiquesproduitsFK',1)";
            if (mysqli_query($conn, $sql)) {

                echo json_encode(array("statusCode" => 200));
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
        $codeProduit = $_POST['codeProduit'];
        $sql = "UPDATE `tcaracteristiquesproduits` SET `nomModele`='$nomModele',`compatibilite`='$compatibilite',`codeProduit`='$codeProduit',`ttypeproduitsFK`=$ttypeproduitsFK,`tfabricantsFK`=$tfabricantsFK WHERE `tcaracteristiquesproduitsPK`=$tcaracteristiquesproduitsPK;";
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
        $tlibellesPK = $_POST['tlibellesPK'];
        $sql = "DELETE FROM `tlibelles` WHERE tlibellesPK=$tlibellesPK";
        if (mysqli_query($conn, $sql)) {
            echo $tlibellesPK;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// GET
if (count($_POST) > 0) {
    if ($_POST['type'] == 4) {
        $tlibellesPK = $_POST['tlibellesPK'];
        $sql = "SELECT * FROM tproduitsstockes JOIN tlibelles ON tproduitsstockes.tlibellesFK = tlibelles.tlibellesPK JOIN tproduits ON tproduits.tproduitsPK = tproduitsstockes.tproduitsFK JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = tproduits.tcaracteristiquesproduitsFK JOIN tmarques ON tcaracteristiquesproduits.tmarquesFK = tmarques.tmarquesPK WHERE tlibellesPK = $tlibellesPK";
        $stmt = $conn->prepare($sql);
        $stmt->execute(); {
            // CREATE POSTS ARRAY
            $posts_array = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $post_data = [
                    'tproduitsstockesPK' => $row['tproduitsstockesPK'],
                    'nomModele' => html_entity_decode($row['nomModele']),
                    'nomMarque' => html_entity_decode($row['nomMarque']),
                    'numeroSerie' => html_entity_decode($row['numeroSerie']),
                    'compatibilite' => html_entity_decode($row['compatibilite']),
                    'codeProduit' => html_entity_decode($row['codeProduit'])
                ];
                // PUSH POST DATA IN OUR $posts_array ARRAY
                array_push($posts_array, $post_data);
            }
            //SHOW POST/POSTS IN JSON FORMAT
            echo json_encode($posts_array);
        }
    }
}
