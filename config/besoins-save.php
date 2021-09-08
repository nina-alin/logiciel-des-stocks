<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// bibliothèques permettant d'envoyer des mails
require_once($_SERVER['DOCUMENT_ROOT'] . '/libs/class.email.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/libs/adaptationCaracteres.php');

// POST
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        // on récupère les données et on les stocke dans des variables
        $tcaracteristiquesproduitsFK = $_POST['tcaracteristiquesproduitsFK'];
        $lien = $_POST['lien'];
        $ttechnicienFK = $_POST['ttechnicienFK'];
        $tplateformeFK = $_POST['tplateformeFK'];
        $quantiteDemande = $_POST['quantiteDemande'];
        $reference = $_POST['reference'];

        // Encodage des guillemets / apostrophes
        $lien = addslashes($lien);
        $reference = addslashes($reference);

        $sql = "INSERT INTO `tbesoins`(`tcaracteristiquesproduitsFK`, `lien`, `ttechnicienFK`, `tplateformeFK`, `quantiteDemande`, `reference`) VALUES ('$tcaracteristiquesproduitsFK','$lien','$ttechnicienFK','$tplateformeFK','$quantiteDemande','$reference')";

        if (mysqli_query($conn, $sql)) {

            // on récupère l'entrée qu'on vient de faire dans la base de données avec les différentes données permettant d'envoyer le mail
            $result = mysqli_query($conn, "SELECT * FROM tbesoins JOIN ttechnicien ON tbesoins.ttechnicienFK = ttechnicien.ttechnicienPK JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = tbesoins.tcaracteristiquesproduitsFK JOIN tplateforme ON tplateforme.tplateformePK=tbesoins.tplateformeFK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE tbesoinsPK=LAST_INSERT_ID();");

            // si ça rate, on affiche l'erreur
            if (!$result) {
                printf("Error: %s\n", mysqli_error($conn));
                exit();
            } else {
                while ($row = mysqli_fetch_array($result)) {
                    $nomTechnicien = $row["nomTechnicien"];
                    $prenomTechnicien = $row["prenomTechnicien"];
                    $nomPlateforme = $row["nomPlateforme"];
                    $reference = $row["reference"];
                    $nomFabricant = $row["nomFabricant"];
                    $nomModele = $row["nomModele"];
                }
            }

            // on envoie un mail au chef de service pour signaler qu'une nouvelle demande de produit a été effectuée
            $sujet = '[logicieldesstocks.crous-lille.fr] : Nouvelle demande de produit';
            $msg = '<p>--Ceci est un message automatique--</p><p></p>';
            $msg .= suppr_accents($prenomTechnicien) . ' ' . suppr_accents($nomTechnicien) . ' a effectu&eacute; une nouvelle demande de ' . $quantiteDemande . ' exemplaires de ' . suppr_accents($nomFabricant) . ' ' . suppr_accents($nomModele) . '.</p><p></p>';
            $msg .= 'La r&eacute;f&eacute;rence du produit sur ' . suppr_accents($nomPlateforme) . ' est ' . $reference . '.</p><p></p>';
            $msg .= 'Lien : ' . suppr_accents($lien);
            $email = new email($sujet, $msg, "belkacem.cherik@crous-lille.fr");

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

        $tbesoinsPK = $_POST['tbesoinsPK'];

        $result = mysqli_query($conn, "SELECT * FROM tbesoins JOIN ttechnicien ON tbesoins.ttechnicienFK = ttechnicien.ttechnicienPK JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = tbesoins.tcaracteristiquesproduitsFK JOIN tplateforme ON tplateforme.tplateformePK=tbesoins.tplateformeFK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE tbesoinsPK=$tbesoinsPK");

        while ($row = mysqli_fetch_array($result)) {
            $nomTechnicien = $row["nomTechnicien"]; // on récupère la nouvelle quantité 
            $prenomTechnicien = $row["prenomTechnicien"];
            $nomFabricant = $row["nomFabricant"];
            $nomModele = $row["nomModele"];
        }

        // on envoie un mail
        $sujet = '[logicieldesstocks.crous-lille.fr] : Validation de votre demande';
        $msg = '<p>--Ceci est un message automatique--</p><p></p>';
        $msg .= "Votre demande de " . suppr_accents($nomFabricant) . " " . suppr_accents($nomModele) . " sur le logiciel des stocks a &eacute;t&eacute; accept&eacute;e.";
        $mail = suppr_accents($prenomTechnicien) . "." . suppr_accents($nomTechnicien) . "@crous-lille.fr";
        $email = new email($sujet, $msg, $mail);

        // on supprime la demande
        $sql = "DELETE FROM `tbesoins` WHERE tbesoinsPK=$tbesoinsPK";

        if (mysqli_query($conn, $sql)) {
            echo $tbesoinsPK;
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}

// REFUS
if (count($_POST) > 0) {

    if ($_POST['type'] == 4) {

        $tbesoinsPK = $_POST['tbesoinsPK'];

        $result = mysqli_query($conn, "SELECT * FROM tbesoins JOIN ttechnicien ON tbesoins.ttechnicienFK = ttechnicien.ttechnicienPK JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = tbesoins.tcaracteristiquesproduitsFK JOIN tplateforme ON tplateforme.tplateformePK=tbesoins.tplateformeFK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE tbesoinsPK=$tbesoinsPK");

        while ($row = mysqli_fetch_array($result)) {
            $nomTechnicien = $row["nomTechnicien"]; // on récupère la nouvelle quantité 
            $prenomTechnicien = $row["prenomTechnicien"];
            $nomFabricant = $row["nomFabricant"];
            $nomModele = $row["nomModele"];
        }

        // on envoie un mail
        $sujet = '[logicieldesstocks.crous-lille.fr] : Refus de votre demande';
        $msg = '<p>--Ceci est un message automatique--</p><p></p>';
        $msg .= "Votre demande de " . suppr_accents($nomFabricant) . " " . suppr_accents($nomModele) . " sur le logiciel des stocks a &eacute;t&eacute; refus&eacute;e.";
        $mail = suppr_accents($prenomTechnicien) . "." . suppr_accents($nomTechnicien) . "@crous-lille.fr";
        $email = new email($sujet, $msg, $mail);

        // on supprime la demande
        $sql = "DELETE FROM `tbesoins` WHERE tbesoinsPK=$tbesoinsPK";

        if (mysqli_query($conn, $sql)) {
            echo $tbesoinsPK;
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}
