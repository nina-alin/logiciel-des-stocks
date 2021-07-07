<?php

include 'connect.php';

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

// POST
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

        $tproduitsstockesPK = $_POST['tproduitsstockesPK_u'];
        $tlibellesFK = $_POST['tlibellesFK_u'];
        $alerte = $_POST['alerte_u'];

        $sql = "UPDATE `tproduitsstockes` SET `tlibellesFK`=$tlibellesFK, `alerte`=$alerte WHERE `tproduitsstockesPK`=$tproduitsstockesPK;";

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

                $sql = "SELECT quantite FROM `tproduitsstockes` WHERE `tproduitsstockesPK`='$tproduitsstockesPK';";

                if (mysqli_query($conn, $sql)) {

                    // on envoie un mail (pas encore fonctionnel) si la quantité stockée est trop basse
                    if ($row["quantite"] < 4) {
                        try {
                            // Plusieurs destinataires
                            $to  = 'alin.nina28@gmail.com, nina.alin@crous-lille.fr'; // notez la virgule

                            // Sujet
                            $subject = 'Calendrier des anniversaires pour Août';

                            // message
                            $message = '
                                        <html>
                                        <head>
                                        <title>Calendrier des anniversaires pour Août</title>
                                        </head>
                                        <body>
                                        <p>Voici les anniversaires à venir au mois d\'Août !</p>
                                        <table>
                                            <tr>
                                            <th>Personne</th><th>Jour</th><th>Mois</th><th>Année</th>
                                            </tr>
                                            <tr>
                                            <td>Josiane</td><td>3</td><td>Août</td><td>1970</td>
                                            </tr>
                                            <tr>
                                            <td>Emma</td><td>26</td><td>Août</td><td>1973</td>
                                            </tr>
                                        </table>
                                        </body>
                                        </html>
                                        ';

                            // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
                            $headers[] = 'MIME-Version: 1.0';
                            $headers[] = 'Content-type: text/html; charset=iso-8859-1';

                            // En-têtes additionnels
                            $headers[] = 'To: Alin N <alin.nina28@gmail.com>, Nina Alin <nina.alin@crous-lille.fr>';
                            $headers[] = 'From: informatique <informatique@crous-lille.fr>';
                            // Envoi
                            mail($to, $subject, $message, implode("\r\n", $headers));
                        } catch (Exception $e) {
                            echo 'Exception reçue : ',  $e->getMessage(), "\n";
                        }
                    }
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
