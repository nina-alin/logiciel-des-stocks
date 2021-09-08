<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

// SUPPRIMER L'ALERTE
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        $tproduitsstockesPK = $_POST['tproduitsstockesPK'];

        $sql = "UPDATE `tproduitsstockes` SET `alerte`=0 WHERE `tproduitsstockesPK`=$tproduitsstockesPK";

        if (mysqli_query($conn, $sql)) {
            echo $tproduitsstockesPK;
        } else {
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// AFFICHER LES DATE CLÉS
if (count($_GET) > 0) {

    if ($_GET['type'] == 2) {

        $dateSortie = $_GET['dateSortie'];

        $sql = "SELECT * FROM `tsorties` JOIN tcaracteristiquesproduits ON tsorties.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE DATE(dateSortie) = '$dateSortie'";

        $result = mysqli_query($conn, $sql);
        $output = '';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '  
                <div class="col-lg-3">
                    <div class="panel">
                        <div class="panel-body">
                            <h3 class="text-center">&nbsp;' . $row["nomFabricant"] . '&nbsp;' . $row["nomModele"] . '<br />' . $row["quantiteSortie"] . ' équipés</h3>
                        </div>
                    </div>
                </div>
             ';
        }

        $sql = "SELECT * FROM `tentrees` JOIN tproduitsstockes ON tentrees.tproduitsstockeFK = tproduitsstockes.tproduitsstockesPK JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE DATE(dateEntree) = '$dateSortie'";

        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $output .= '  
                <div class="col-lg-3">
                    <div class="panel">
                        <div class="panel-body">
                            <h3 class="text-center">&nbsp;' . $row["nomFabricant"] . '&nbsp;' . $row["nomModele"] . '<br />' . $row["quantiteEntree"] . ' arrivés</h3>
                        </div>
                    </div>
                </div>
             ';
        }

        echo $output;
    }
}


// SUPPRIMER L'ALERTE TYPE PRODUIT
if (count($_POST) > 0) {

    if ($_POST['type'] == 3) {

        $ttypeproduitsPK = $_POST['ttypeproduitsPK'];

        $sql = "UPDATE `ttypeproduits` SET `alerteTypeProduit`=0 WHERE `ttypeproduitsPK`=$ttypeproduitsPK";

        if (mysqli_query($conn, $sql)) {
            echo $ttypeproduitsPK;
        } else {
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}
