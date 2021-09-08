<?php

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

// pour envoyer des mails
require_once($_SERVER['DOCUMENT_ROOT'] . '/libs/class.email.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/libs/adaptationCaracteres.php');

// convertir la date en format fr
$date = date('Y-m-d H:i:s', time());
$date_mdp = date("Y-m-d 01:00:00", strtotime(date("Y-m-d", strtotime($date)) . " +1 day"));

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

        // on insère une nouvelle entrée dans tentrees
        $sql = "INSERT INTO `tentrees`(`quantiteEntree`, `tcommandesFK`, `ttechnicienFK`, `tproduitsstockeFK`) VALUES ('$quantiteEntree','$tcommandesFK','$ttechnicienFK','$tproduitsstockesFK')";

        if (mysqli_multi_query($conn, $sql)) {

            if ($quantite == null) {
                $sql = "UPDATE `tproduitsstockes` SET `quantite`=$quantiteEntree WHERE `tproduitsstockesPK`=$tproduitsstockesFK;";
            } else {
                $sql = "UPDATE `tproduitsstockes` SET `quantite`=quantite+$quantiteEntree WHERE `tproduitsstockesPK`=$tproduitsstockesFK;";
            }

            for ($i = 1; $i <= $quantiteEntree; $i++) {
                $sql .= "INSERT INTO `tnumerosseries`(`tproduitsstockesFK`) VALUES ($tproduitsstockesFK);";
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
            $quantite = $row["quantite"];
        }

        // la quantité ne peut pas être négative !
        if ($quantite < $quantiteSortie) {
            echo ("La quantité de sortie est plus grande que la quantité déjà présente en stocks. Opération impossible.");
            mysqli_close($conn);
        } else {

            $sql = "UPDATE `tproduitsstockes` SET `quantite`=quantite-$quantiteSortie WHERE `tproduitsstockesPK`=$tproduitsstockesPK;";
            $sql .= "INSERT INTO `tsorties`(`raisonSortie`, `quantiteSortie`, `ttechnicienFK`, `tcaracteristiquesproduitsFK`, `tlieusortieFK`) VALUES ('$raisonSortie','$quantiteSortie',$ttechnicienFK,$tcaracteristiquesproduitsFK,$tlieusortieFK);";

            if (mysqli_multi_query($conn, $sql)) {
                $conn->next_result();

                $result = mysqli_query($conn, "SELECT * FROM `tproduitsstockes` JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = tproduitsstockes.tcaracteristiquesproduitsFK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE `tproduitsstockesPK`=$tproduitsstockesPK");
                if (!$result) {
                    printf("Error: %s\n", mysqli_error($conn));
                    exit();
                } else {
                    while ($row = mysqli_fetch_array($result)) {
                        $quantite = $row["quantite"]; // on récupère la nouvelle quantité 
                        $alerte = $row["alerte"];
                        $nomFabricant = $row["nomFabricant"];
                        $nomModele = $row["nomModele"];
                    }
                }

                if ($quantite < 4 && $alerte == 1) {

                    // on envoie un mail si la quantité stockée est trop basse et si l'alerte est activée
                    $sujet = '[logicieldesstocks.crous-lille.fr] : Stocks de ' . suppr_accents($nomFabricant) . ' ' . suppr_accents($nomModele) . ' bas.';
                    $msg = '<p>--Ceci est un message automatique--</p><p></p>';
                    $msg .= 'Il reste ' . $quantite . ' exemplaires de ' . suppr_accents($nomFabricant) . ' ' . suppr_accents($nomModele) . '. Voir dans le logiciel des stocks : https://logicieldesstocks.crous-lille.fr';
                    $email = new email($sujet, $msg, "liste.informatique@crous-lille.fr");
                }

                echo json_encode(array("statusCode" => 200));
            } else {
                echo mysqli_error($conn);
            }

            mysqli_close($conn);
        }
    }
}

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

        $sql = "SELECT * FROM ttechnicien WHERE toujoursService = 1 ORDER BY nomTechnicien, prenomTechnicien ASC";

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
                $sql = "UPDATE `tproduitsstockes` SET `quantite`=$quantiteEntree WHERE `tproduitsstockesPK`=$tproduitsstockesFK;";
            } else {
                $sql = "UPDATE `tproduitsstockes` SET `quantite`=quantite+$quantiteEntree WHERE `tproduitsstockesPK`=$tproduitsstockesFK;";
            }

            for ($i = 1; $i <= $quantiteEntree; $i++) {
                $sql .= "INSERT INTO `tnumerosseries`(`tproduitsstockesFK`) VALUES ($tproduitsstockesFK);";
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

// GET NUMEROS DE SERIE
if (count($_GET) > 0) {

    if ($_GET['type'] == 9) {

        $tproduitsstockesPK = $_GET['tproduitsstockesPK'];

        $sql = "SELECT * FROM tnumerosseries JOIN tproduitsstockes ON tproduitsstockes.tproduitsstockesPK = tnumerosseries.tproduitsstockesFK WHERE tproduitsstockesFK=$tproduitsstockesPK AND reforme=0";

        $result = mysqli_query($conn, $sql);

        $output = '';
        $i = 0;

        while ($row = mysqli_fetch_array($result)) {
            $i++;

            $output .= ' 
                <tr>
                    <th>Numéro de série n°' . $i . '</th>
                    <td><input id="numeroSerie_u_' . $row["tnumerosseriesPK"] . '" name="numeroSerie_u" value="' . $row["numeroSerie"] . '"></td>
                    <td>
                        <button class="crayon-ns btn btn-primary" data-id="' . $row["tnumerosseriesPK"] . '" data-numero="' . $row["numeroSerie"] . '">
                            <i class="fas fa-pen"></i>
                        </button>&nbsp;
                        <button class="delete-ns btn btn-danger" data-id="' . $row["tnumerosseriesPK"] . '">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>';
        }

        echo $output;
    }
}

// UPDATE NUMERO SERIES
if (count($_POST) > 0) {

    if ($_POST['type'] == 10) {

        $tnumerosseriesPK = $_POST['tnumerosseriesPK'];
        $numeroSerie = $_POST['numeroSerie'];

        $sql = "UPDATE `tnumerosseries` SET `numeroSerie`='$numeroSerie' WHERE tnumerosseriesPK=$tnumerosseriesPK";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}

// DELETE NUMERO SERIES
if (count($_POST) > 0) {

    if ($_POST['type'] == 11) {

        $tnumerosseriesPK = $_POST['tnumerosseriesPK'];

        $sql = "DELETE FROM `tnumerosseries` WHERE tnumerosseriesPK=$tnumerosseriesPK";

        if (mysqli_query($conn, $sql)) {
            echo $tnumerosseriesPK;
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}

// POST NS
if (count($_POST) > 0) {

    if ($_POST['type'] == 12) {

        $numeroSerie = $_POST['numeroSerie'];
        $tproduitsstockesFK = $_POST['tproduitsstockesFK'];

        $sql = "INSERT INTO `tnumerosseries`(`numeroSerie`,`tproduitsstockesFK`,reforme) VALUES ('$numeroSerie',$tproduitsstockesFK,0)";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}
