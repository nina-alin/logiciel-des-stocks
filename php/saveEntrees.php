<?php

include 'connect.php';

require_once('class.email.php');

$date = date('Y-m-d H:i:s', time());
$date_mdp = date("Y-m-d 01:00:00", strtotime(date("Y-m-d", strtotime($date)) . " +1 day"));
$mail = 'nina.alin@crous-lille.fr';

// GET
if (count($_GET) > 0) {

    if ($_GET['type'] == 4) {

        $tproduitsstockesPK = $_GET['tproduitsstockesPK'];

        $sql = "SELECT * FROM tproduitsstockes JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE tproduitsstockesPK=$tproduitsstockesPK";

        $result = mysqli_query($conn, $sql);
        $output = '';

        while ($row = mysqli_fetch_array($result)) {
            $output .= '  
                  <tr>  
                       <td>' . $row["nomFabricant"] . '</td>   
                       <td>' . $row["nomModele"] . '</td>   
                       <td>' . $row["nomTypeProduit"] . '</td>  
                       <td>' . $row["compatibilite"] . '</td>   
                  </tr> 
             ';
        }
        echo $output;
    }
}

// POST (SI COMMANDE)
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        $tproduitsstockesFK = $_POST['tproduitsstockesFK'];
        $quantiteEntree = $_POST['quantiteEntree'];
        $tcommandesFK = $_POST['tcommandesFK'];
        $ttechnicienFK = $_POST['ttechnicienFK'];


        $result = mysqli_query($conn, "SELECT * FROM `tproduitsstockes` JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK WHERE `tproduitsstockesPK`='$tproduitsstockesFK'");

        if ($row = mysqli_fetch_array($result)) {
            $quantite = $row["quantite"]; // on récupère la quantité déjà présente en base de données
        }

        $sql = "INSERT INTO `tentrees`(`quantiteEntree`, `tcommandesFK`, `ttechnicienFK`, `tproduitsstockeFK`) VALUES ('$quantiteEntree','$tcommandesFK','$ttechnicienFK','$tproduitsstockesFK')";

        if (mysqli_multi_query($conn, $sql)) {
            if ($quantite == null) {
                $sql = "UPDATE `tproduitsstockes` SET `quantite`=$quantiteEntree WHERE `tproduitsstockesPK`=$tproduitsstockesFK";
            } else {
                $sql = "UPDATE `tproduitsstockes` SET `quantite`=quantite+$quantiteEntree WHERE `tproduitsstockesPK`=$tproduitsstockesFK";
            }
            if (mysqli_multi_query($conn, $sql)) {
                echo json_encode(array("statusCode" => 200));
            } else {
                echo mysqli_error($conn);
            }
        } else {
            echo mysqli_error($conn);
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

        $sql = "UPDATE `tproduitsstockes` SET `tlibellesFK`=$tlibellesFK,`alerte`=$alerte WHERE `tproduitsstockesPK`=$tproduitsstockesPK";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// ADD SORTIE
if (count($_POST) > 0) {

    if ($_POST['type'] == 3) {

        $raisonSortie = $_POST['raisonSortie'];
        $quantiteSortie = $_POST['quantiteSortie'];
        $tlieusortieFK = $_POST['tlieusortieFK'];
        $ttechnicienFK = $_POST['ttechnicienFK'];
        $tproduitsstockesPK = $_POST['tproduitsstockesPK'];

        // Encodage des guillemets / apostrophes
        $raisonSortie = addslashes($raisonSortie);

        $result = mysqli_query($conn, "SELECT * FROM `tproduitsstockes` JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK WHERE `tproduitsstockesPK`=$tproduitsstockesPK");

        if ($row = mysqli_fetch_array($result)) {
            $tcaracteristiquesproduitsFK = $row["tcaracteristiquesproduitsFK"]; // on récupère l'id du modèle de produit qui va être relié à cette nouvelle sortie
        }

        $sql = "UPDATE `tproduitsstockes` SET `quantite`=quantite-$quantiteSortie WHERE `tproduitsstockesPK`=$tproduitsstockesPK;";

        if (mysqli_query($conn, $sql)) {

            $sql = "INSERT INTO `tsorties`(`raisonSortie`, `quantiteSortie`, `ttechnicienFK`, `tcaracteristiquesproduitsFK`, `tlieusortieFK`) VALUES ('$raisonSortie','$quantiteSortie',$ttechnicienFK,$tcaracteristiquesproduitsFK,$tlieusortieFK);";

            if (mysqli_query($conn, $sql)) {

                $sql = "SELECT * FROM `tproduitsstockes` JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK WHERE `tproduitsstockesPK`='$tproduitsstockesPK';";

                if (mysqli_query($conn, $sql)) {

                    // on envoie un mail si la quantité stockée est trop basse et si l'alerte est activée
                    // pour l'instant ça marche po
                    /*if ($row["quantite"] < 4 && $row["alerte"] = 1) {
                        $sujet = '[logicieldesstocks.crous-lille.fr] : Alerte :  ' . $row["nomFabricant"] . ' ' . $row["nomModele"] . '';
                        $msg = '<p>--Ceci est un message automatique--</p><p></p>';
                        $msg .= '<p>Il ne reste plus que ' . $row["quantite"] . ' exemplaires de ' . $row["nomFabricant"] . ' ' . $row["nomModele"] . '<br>Merci de bien vouloir en recommander.</p>';
                        $email = new email($sujet, $msg, "nina.alin@crous-lille.fr");
                    }*/
                    echo json_encode(array("statusCode" => 200));
                } else {
                    echo mysqli_error($conn);
                }
            } else {
                echo mysqli_error($conn);
            }

            mysqli_close($conn);
        }
    }
}

// TR COMMANDE
if (count($_GET) > 0) {

    if ($_GET['type'] == 5) {

        $sql = "SELECT * FROM tcommandes WHERE arrivee=1";

        $result = mysqli_query($conn, $sql);
        $output = '<th>Numéro de commande</th>
        <td>
            <select class="form-control" id="tcommandesFK_a" name="tcommandesFK_a" value="" required>';

        while ($row = mysqli_fetch_array($result)) {
            $output .= '  
                <option value=" ' . $row["tcommandesPK"] . '">' . $row["numeroCommande"] . '</option>
             ';
        }
        $output .= '</select></td></tr>';
        echo $output;
    }
}

// TR UG
if (count($_GET) > 0) {

    if ($_GET['type'] == 6) {

        $sql = "SELECT * FROM tlieusortie JOIN tunitegestion ON tlieusortie.tunitegestionFK = tunitegestion.tunitegestionPK";

        $result = mysqli_query($conn, $sql);
        $output = '<th>UG</th>
        <td>
            <select class="form-control" id="tlieusortieFK_a" name="tlieusortieFK_a" value="" required>';

        while ($row = mysqli_fetch_array($result)) {
            $output .= '  
                <option value=" ' . $row["tlieusortiePK"] . '">' . $row["nomUniteGestion"] . ' - ' . $row["nomLieuSortie"] . '</option>
             ';
        }
        $output .= '</select></td></tr>';
        echo $output;
    }
}

// TR TECHNICIEN
if (count($_GET) > 0) {

    if ($_GET['type'] == 7) {

        $sql = "SELECT * FROM ttechnicien WHERE toujoursService = 1";

        $result = mysqli_query($conn, $sql);
        $output = '<th>Technicien</th>
        <td>
            <select class="form-control" id="ttechnicienFK_a" name="ttechnicienFK_a" value="" required>';

        while ($row = mysqli_fetch_array($result)) {
            $output .= '  
                <option value=" ' . $row["ttechnicienPK"] . '">' . $row["prenomTechnicien"] . ' ' . $row["nomTechnicien"] . '</option>';
        }
        $output .= '</select></td></tr>';
        echo $output;
    }
}

// POST (SI UG)
if (count($_POST) > 0) {

    if ($_POST['type'] == 8) {

        $tproduitsstockesFK = $_POST['tproduitsstockesFK'];
        $quantiteEntree = $_POST['quantiteEntree'];
        $tlieusortieFK = $_POST['tlieusortieFK'];
        $ttechnicienFK = $_POST['ttechnicienFK'];


        $result = mysqli_query($conn, "SELECT * FROM `tproduitsstockes` JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK WHERE `tproduitsstockesPK`='$tproduitsstockesFK'");

        if ($row = mysqli_fetch_array($result)) {
            $quantite = $row["quantite"]; // on récupère la quantité déjà présente en base de données
        }

        $sql = "INSERT INTO `tentrees`(`quantiteEntree`, `tlieusortieFK`, `ttechnicienFK`, `tproduitsstockeFK`) VALUES ('$quantiteEntree','$tlieusortieFK','$ttechnicienFK','$tproduitsstockesFK')";

        if (mysqli_multi_query($conn, $sql)) {
            if ($quantite == null) {
                $sql = "UPDATE `tproduitsstockes` SET `quantite`=$quantiteEntree WHERE `tproduitsstockesPK`=$tproduitsstockesFK";
            } else {
                $sql = "UPDATE `tproduitsstockes` SET `quantite`=quantite+$quantiteEntree WHERE `tproduitsstockesPK`=$tproduitsstockesFK";
            }
            if (mysqli_multi_query($conn, $sql)) {
                echo json_encode(array("statusCode" => 200));
            } else {
                echo mysqli_error($conn);
            }
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}
