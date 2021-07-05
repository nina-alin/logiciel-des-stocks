<?php

include 'connect.php';

// GET
if (count($_GET) > 0) {
    if ($_GET['type'] == 4) {
        $tproduitsstockesPK = $_GET['tproduitsstockesPK'];
        $sql = "SELECT * FROM tproduitsstockes JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE tproduitsstockesPK=$tproduitsstockesPK";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $output = '  
                  <tr>  
                       <td>' . $row["nomFabricant"] . '</td>   
                       <td>' . $row["nomModele"] . '</td>   
                       <td>' . $row["nomTypeProduit"] . '</td>  
                       <td>' . $row["compatibilite"] . '</td>   
                       <td>' . $row["codeProduit"] . '</td>  
                  </tr> 
             ';
        }
        echo $output;
    }
}

// POST
if (count($_POST) > 0) {
    if ($_POST['type'] == 1) {

        $codeProduit = $_POST['codeProduit'];
        $quantiteEntree = $_POST['quantiteEntree'];
        $tcommandesFK = $_POST['tcommandesFK'];
        $ttechnicienFK = $_POST['ttechnicienFK'];

        $result = mysqli_query($conn, "SELECT * FROM `tproduitsstockes` JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK WHERE `codeProduit`='$codeProduit'");
        if ($row = mysqli_fetch_array($result)) {
            $tproduitsstockeFK = $row["tproduitsstockesPK"];
            $quantite = $row["quantite"];
        }

        $sql = "INSERT INTO `tentrees`(`quantiteEntree`, `tcommandesFK`, `ttechnicienFK`, `tproduitsstockeFK`) VALUES ('$quantiteEntree','$tcommandesFK','$ttechnicienFK','$tproduitsstockeFK')";
        if (mysqli_multi_query($conn, $sql)) {
            if ($quantite == null) {
                $sql = "UPDATE `tproduitsstockes` SET `quantite`=$quantiteEntree WHERE `tproduitsstockesPK`=$tproduitsstockeFK";
            } else {
                $sql = "UPDATE `tproduitsstockes` SET `quantite`=quantite+$quantiteEntree WHERE `tproduitsstockesPK`=$tproduitsstockeFK";
            }
            if (mysqli_multi_query($conn, $sql)) {

                echo json_encode(array("statusCode" => 200));
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}

// UPDATE
if (count($_POST) > 0) {
    if ($_POST['type'] == 2) {
        $tproduitsstockesPK = $_POST['tproduitsstockesPK'];
        $tlibellesFK = $_POST['tlibellesFK'];
        $alerte = $_POST['alerte'];
        $sql = "UPDATE `tproduitsstockes` SET `tlibellesFK`=$tlibellesFK, `alerte`=$alerte WHERE `tproduitsstockesPK`=$tproduitsstockesPK";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// SORTIE
if (count($_POST) > 0) {
    if ($_POST['type'] == 3) {
        $raisonSortie = $_POST['raisonSortie'];
        $numeroSerie = $_POST['numeroSerie'];
        $tlieusortieFK = $_POST['tlieusortieFK'];
        $ttechnicienFK = $_POST['ttechnicienFK'];
        $quantite = $_POST['quantite'];
        $tproduitsstockesPK = $_POST['tproduitsstockesPK'];

        $result = mysqli_query($conn, "SELECT * FROM `tproduitsstockes` JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK WHERE `tproduitsstockesPK`=$tproduitsstockesPK");
        if ($row = mysqli_fetch_array($result)) {
            $tcaracteristiquesproduitsFK = $row["tcaracteristiquesproduitsFK"];
        }

        $sql = "UPDATE `tproduitsstockes` SET `quantite`=quantite-$quantite WHERE `tproduitsstockesPK`=$tproduitsstockesPK;";

        if (mysqli_multi_query($conn, $sql)) {
            $sql = "INSERT INTO `tsorties`(`raisonSortie`, `numeroSerie`, `ttechnicienFK`, `tcaracteristiquesproduitsFK`, `tlieusortieFK`) VALUES ('$raisonSortie','$numeroSerie',$ttechnicienFK,$tcaracteristiquesproduitsFK,$tlieusortieFK);";
            if (mysqli_multi_query($conn, $sql)) {
                echo json_encode(array("statusCode" => 200));
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
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
